const fs = require('fs');
const path = require('path');

function walkDir(dir) {
    let list = fs.readdirSync(dir);
    let results = [];
    list.forEach(function(file) {
        file = path.join(dir, file);
        let stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walkDir(file));
        } else { 
            if (file.endsWith('.blade.php')) results.push(file);
        }
    });
    return results;
}

const files = walkDir('resources/views');
let changedFiles = 0;

files.forEach(f => {
    let content = fs.readFileSync(f, 'utf8');
    let orig = content;

    // Regex to find status-like spans and add whitespace-nowrap
    // We target spans with padding and rounding commonly used for badges
    content = content.replace(/<span\s+class="([^"]*(?:px-[345]|py-[12](?:\.5)?|rounded-(?:xl|2xl))[^\"]*)"/g, function(match, classes) {
        if (!classes.includes('whitespace-nowrap')) {
            // Add whitespace-nowrap and inline-flex to ensure it doesn't wrap and stays centered
            classes = classes + ' whitespace-nowrap inline-flex items-center justify-center';
        }
        // Remove text-start if it exists as it can sometimes interfere with centering in these badges
        classes = classes.replace(/\btext-start\b/g, '');
        
        return '<span class="' + classes.replace(/\s+/g, ' ').trim() + '"';
    });

    if (content !== orig) {
        fs.writeFileSync(f, content);
        changedFiles++;
    }
});

console.log('Fixed badge wrapping in ' + changedFiles + ' files');
