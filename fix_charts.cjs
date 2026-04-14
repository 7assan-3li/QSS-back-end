const fs = require('fs');
const path = require('path');
function walkDir(dir) {
    let results = [];
    let list = fs.readdirSync(dir);
    list.forEach(function(file) {
        file = path.join(dir, file);
        let stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { results = results.concat(walkDir(file)); }
        else { if (file.endsWith('.blade.php')) results.push(file); }
    });
    return results;
}
const files = walkDir('resources/views');
let count = 0;
files.forEach(f => {
    let content = fs.readFileSync(f, 'utf8');
    let orig = content;

    content = content.replace(/color:\s*'currentColor'/g, "color: '#94a3b8'");
    content = content.replace(/color:\s*\"currentColor\"/g, "color: '#94a3b8'");

    content = content.replace(/rgba\(226,\s*232,\s*240,\s*0\.4\)/g, 'rgba(148, 163, 184, 0.1)');
    content = content.replace(/rgba\(148,\s*163,\s*184,\s*0\.05\)/g, 'rgba(148, 163, 184, 0.1)');

    if(content !== orig) {
        fs.writeFileSync(f, content);
        count++;
    }
});
console.log('Fixed charts in ' + count + ' files');
