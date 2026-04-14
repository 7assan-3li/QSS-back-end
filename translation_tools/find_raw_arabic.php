<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
$untranslated_lines = [];

foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $lines = file($file->getPathname());
        foreach ($lines as $index => $line) {
            // Check if line contains Arabic characters
            if (preg_match('/[\x{0600}-\x{06FF}]/u', $line)) {
                // If the Arabic text is already wrapped in __('...'), or inside a comment {{-- --}}
                // We do a simple check: if line has Arabic but NOT "__(" and NOT "@lang("
                // OR if it has "__(" but there's STILL other loose Arabic text outside.
                
                // Let's strip out all valid translation wrappers first to see what's left
                $cleaned_line = preg_replace('/__\(\s*[\'"].*?[\'"]\s*\)/u', '', $line);
                $cleaned_line = preg_replace('/@lang\(\s*[\'"].*?[\'"]\s*\)/u', '', $cleaned_line);
                $cleaned_line = preg_replace('/\{\{--.*?--\}\}/u', '', $cleaned_line); // remove blade comments
                
                // If there are still Arabic characters in the cleaned line, it's untranslated!
                if (preg_match('/[a-zA-Z0-9]*[\x{0600}-\x{06FF}]+[a-zA-Z0-9]*/u', $cleaned_line, $m)) {
                    $untranslated_lines[] = [
                        'file' => $file->getPathname(),
                        'line_num' => $index + 1,
                        'text' => trim($line),
                        'raw_arabic' => $m[0]
                    ];
                }
            }
        }
    }
}

file_put_contents('untranslated_raw_arabic.json', json_encode($untranslated_lines, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Found " . count($untranslated_lines) . " lines with potentially raw uncovered Arabic text.\n";
