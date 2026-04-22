<?php
$files = glob('app/Http/Controllers/*.php');
foreach($files as $file) {
    $lines = file($file);
    $in_block = false;
    $changed = false;
    foreach($lines as $k => $line) {
        if(preg_match('/^\s*\/\/\s*\$this->notificationService->/', $line)) {
            $in_block = true;
        }
        
        if($in_block) {
            $lines[$k] = preg_replace('/^(\s*)\/\/\s?/', '$1', $line);
            $changed = true;
            if(preg_match('/\);\s*$/', $lines[$k])) {
                $in_block = false;
            }
        }
    }
    if($changed) {
        file_put_contents($file, implode('', $lines));
        echo "Updated $file\n";
    }
}
