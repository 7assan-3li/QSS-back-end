<?php

function fixMojibake($content) {
    // This function converts strings that were corrupted by being read as CP1252
    // and then saved as UTF-8 back to their original UTF-8 form.
    
    // We want to take the UTF-8 string, convert it to CP1252 bytes, 
    // and then treat those bytes as a UTF-8 string.
    
    // However, some characters might not be in CP1252. 
    // The most common mojibake in Arabic (from UTF-8 to CP1252) uses characters like:
    // ط, ¥, ©, ¯, etc.
    
    try {
        // Step 1: Convert UTF-8 string to ISO-8859-1 (which is close to CP1252) bytes
        // We use @ to ignore notices if a character can't be converted.
        $bytes = mb_convert_encoding($content, 'ISO-8859-1', 'UTF-8');
        
        // Step 2: Interpret those bytes as UTF-8
        $fixed = mb_convert_encoding($bytes, 'UTF-8', 'UTF-8');
        
        // If the result is valid UTF-8 and different from original, it might be fixed.
        // But we need to be careful not to break already correct text.
        // A better way is to detect if the string contains the tell-tale "ط" sequences.
        return $bytes; // Wait, mb_convert_encoding returns a string which is basically the byte sequence.
    } catch (Exception $e) {
        return $content;
    }
}

// More robust approach using iconv or custom mapping
function fixArabicMojibake($text) {
    // The pattern is: UTF-8 bytes of Arabic char -> interpreted as CP1252 characters -> saved as UTF-8.
    // Example: 'إ' (U+0625) -> UTF-8 [0xD8, 0xA5] -> CP1252 'ط' (0xD8) and '¥' (0xA5) -> Saved as UTF-8 'ط¥'
    
    // To reverse:
    // 1. Convert the (now UTF-8) garbled text back to CP1252 bytes.
    // 2. Treat those bytes as the original UTF-8 sequence.
    
    $original_encoding = 'UTF-8';
    $mojibake_encoding = 'Windows-1252';
    
    // We use iconv to get the raw bytes that represent the garbled characters in CP1252
    $raw_bytes = @iconv($original_encoding, $mojibake_encoding . '//IGNORE', $text);
    
    if ($raw_bytes === false) return $text;
    
    // Now treat these bytes as UTF-8
    $fixed = @iconv('UTF-8', 'UTF-8//IGNORE', $raw_bytes);
    
    return $fixed ?: $text;
}

$directory = __DIR__ . '/../resources/views';
$it = new RecursiveDirectoryIterator($directory);
foreach (new RecursiveIteratorIterator($it) as $file) {
    if ($file->getExtension() == 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        // Check if file contains "ط¥" or "ط§" or other common mojibake starters
        if (strpos($content, 'ط¥') !== false || strpos($content, 'ط§') !== false || strpos($content, 'ظ„') !== false) {
            echo "Fixing $path...\n";
            $fixed = fixArabicMojibake($content);
            if ($fixed !== $content) {
                file_put_contents($path, $fixed);
                echo "  Fixed!\n";
            } else {
                echo "  Could not fix or no changes needed.\n";
            }
        }
    }
}
