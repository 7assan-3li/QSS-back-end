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

    // Regex to only modify inside class attributes
    content = content.replace(/class="([^"]+)"/g, function(match, classes) {
        // Remove dark specific overrides that fight with the CSS variables
        classes = classes.replace(/dark:text-slate-\d00/g, ' ');
        classes = classes.replace(/dark:text-gray-\d00/g, ' ');
        classes = classes.replace(/dark:bg-slate-\d00/g, ' ');
        classes = classes.replace(/dark:border-slate-\d00/g, ' ');
        
        // Remove text-slate-800 dark:text-white explicitly if they exist together
        classes = classes.replace(/dark:text-white/g, ' ');

        // Main text
        classes = classes.replace(/\btext-slate-900\b/g, 'text-[var(--main-text)]');
        classes = classes.replace(/\btext-slate-800\b/g, 'text-[var(--main-text)]');
        classes = classes.replace(/\btext-slate-700\b/g, 'text-[var(--main-text)]');
        classes = classes.replace(/\btext-gray-900\b/g, 'text-[var(--main-text)]');
        classes = classes.replace(/\btext-gray-800\b/g, 'text-[var(--main-text)]');
        classes = classes.replace(/\btext-gray-700\b/g, 'text-[var(--main-text)]');
        
        // Muted text
        classes = classes.replace(/\btext-slate-600\b/g, 'text-[var(--text-muted)]');
        classes = classes.replace(/\btext-slate-500\b/g, 'text-[var(--text-muted)]');
        classes = classes.replace(/\btext-slate-400\b/g, 'text-[var(--text-muted)]');
        classes = classes.replace(/\btext-gray-600\b/g, 'text-[var(--text-muted)]');
        classes = classes.replace(/\btext-gray-500\b/g, 'text-[var(--text-muted)]');
        classes = classes.replace(/\btext-gray-400\b/g, 'text-[var(--text-muted)]');
        
        // Backgrounds leftover (mostly cards or containers!)
        classes = classes.replace(/\bbg-slate-50\b/g, 'bg-[var(--glass-bg)]');
        classes = classes.replace(/\bbg-slate-100\b/g, 'bg-[var(--glass-bg)]');
        // Let's replace bg-white carefully? Wait, if they are cards, bg-white should be var(--glass-bg).
        // bg-white is often used as background. I will replace it.
        classes = classes.replace(/\bbg-white\b/g, 'bg-[var(--glass-bg)]');

        // Borders leftover
        classes = classes.replace(/\bborder-slate-50\b/g, 'border-[var(--glass-border)]');
        classes = classes.replace(/\bborder-slate-100\b/g, 'border-[var(--glass-border)]');
        classes = classes.replace(/\bborder-slate-200\b/g, 'border-[var(--glass-border)]');
        classes = classes.replace(/\bborder-slate-300\b/g, 'border-[var(--glass-border)]');
        
        // Fix weird spacing from replacement
        classes = classes.replace(/\s{2,}/g, ' ').trim();
        
        return 'class="' + classes + '"';
    });
    
    // Some tags without explicit class parsing might need replacing. Let's do a few safe global ones:
    content = content.replace(/dark:border-white\/5/g, 'border-[var(--glass-border)]');

    if (content !== orig) {
        fs.writeFileSync(f, content);
        changedFiles++;
    }
});

console.log('Processed and cleaned leftover card and text colors in', changedFiles, 'files');
