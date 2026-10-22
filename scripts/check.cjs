const {spawnSync} = require('node:child_process');
const {readdirSync} = require('node:fs');
const {join} = require('node:path');
let count = 0;
function walk(dir) {
  for (const entry of readdirSync(dir, {withFileTypes:true})) {
    if (entry.name.startsWith('.') || entry.name === 'node_modules') continue;
    const path = join(dir, entry.name);
    if (entry.isDirectory()) walk(path);
    else if (/\.(php|js)$/.test(path)) {
      const php = path.endsWith('.php');
      const result = spawnSync(php ? 'php' : process.execPath, [php ? '-l' : '--check', path], {encoding:'utf8'});
      if (result.status !== 0) { console.error(result.stdout, result.stderr); process.exitCode = 1; }
      count++;
    }
  }
}
walk('.');
console.log(`Checked ${count} PHP and JavaScript files.`);
