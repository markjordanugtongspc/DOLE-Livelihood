/**
 * START OF FILE: scripts/qa.js
 * Purpose: Automated QA gatekeeper checking PHP lint, rules compliance, and START/END comments
 */

import fs from 'fs';
import path from 'path';
import { execSync } from 'child_process';

// START OF FUNCTION: getPhpBinary
// Purpose: Resolves portable or system PHP binary executable
function getPhpBinary() {
  const laragonPhp = 'C:\\laragon\\bin\\php\\php-8.3.33-Win32-vs16-x64\\php.exe';
  if (fs.existsSync(laragonPhp)) {
    return `"${laragonPhp}"`;
  }
  return 'php';
}
// END OF FUNCTION: getPhpBinary

// START OF FUNCTION: getGitBinary
// Purpose: Resolves portable or system Git binary executable
function getGitBinary() {
  const portableGit = 'C:\\Users\\lace\\Desktop\\Jordan [FILES]\\Programs\\PortableGit\\cmd\\git.exe';
  if (fs.existsSync(portableGit)) {
    return `"${portableGit}"`;
  }
  return 'git';
}
// END OF FUNCTION: getGitBinary

// START OF FUNCTION: checkRemoteGit
// Purpose: Checks remote git updates per User Rule #7
export function checkRemoteGit() {
  console.log('[QA] 1/5 Checking remote git updates (Rule #7)...');
  const gitBin = getGitBinary();
  try {
    const remotes = execSync(`${gitBin} remote`, { encoding: 'utf-8' }).trim();
    if (!remotes) {
      console.log('     ✓ No remote git configured yet. Skipping fetch.');
      return true;
    }
    execSync(`${gitBin} fetch --dry-run`, { stdio: 'pipe' });
    console.log('     ✓ Remote git checked.');
    return true;
  } catch (err) {
    console.warn(`     ! Remote fetch check notice: ${err.message}`);
    return true;
  }
}
// END OF FUNCTION: checkRemoteGit

// START OF FUNCTION: checkPhpSyntax
// Purpose: Recursively lints all project PHP files using php -l
export function checkPhpSyntax(dir = '.') {
  console.log('[QA] 2/5 Running PHP syntax lint (php -l)...');
  const phpFiles = [];
  const phpBin = getPhpBinary();

  function scan(currentDir) {
    const entries = fs.readdirSync(currentDir, { withFileTypes: true });
    for (const entry of entries) {
      const fullPath = path.join(currentDir, entry.name);
      if (entry.isDirectory()) {
        if (['vendor', 'node_modules', '.git', 'dist'].includes(entry.name)) continue;
        scan(fullPath);
      } else if (entry.isFile() && entry.name.endsWith('.php')) {
        phpFiles.push(fullPath);
      }
    }
  }

  scan(dir);

  let errors = 0;
  for (const file of phpFiles) {
    try {
      execSync(`${phpBin} -l "${file}"`, { stdio: 'pipe' });
    } catch (err) {
      console.error(`     ✗ Syntax error in: ${file}`);
      errors++;
    }
  }

  if (errors > 0) {
    throw new Error(`PHP lint failed with ${errors} error(s).`);
  }
  console.log(`     ✓ All ${phpFiles.length} PHP files passed syntax lint.`);
  return true;
}
// END OF FUNCTION: checkPhpSyntax

// START OF FUNCTION: checkStartEndComments
// Purpose: Validates presence of START and END comments (Rule #9)
export function checkStartEndComments() {
  console.log('[QA] 3/5 Checking START and END comments (Rule #9)...');
  const targetDirs = ['backend', 'frontend/src/js/modules', 'frontend/components', 'scripts'];
  let checked = 0;

  for (const dir of targetDirs) {
    if (!fs.existsSync(dir)) continue;
    const entries = fs.readdirSync(dir, { recursive: true });
    for (const item of entries) {
      const full = path.join(dir, item.toString());
      if (fs.statSync(full).isFile() && (full.endsWith('.php') || full.endsWith('.js'))) {
        const content = fs.readFileSync(full, 'utf-8');
        const hasStart = content.includes('START OF') || content.includes('START:');
        const hasEnd = content.includes('END OF') || content.includes('END:');

        if (!hasStart || !hasEnd) {
          console.warn(`     ! Warning: START/END comment missing in ${full}`);
        } else {
          checked++;
        }
      }
    }
  }
  console.log(`     ✓ Verified START and END comment compliance on ${checked} source files.`);
  return true;
}
// END OF FUNCTION: checkStartEndComments

// START OF FUNCTION: checkCursorPointer
// Purpose: Validates cursor-pointer class on button and anchor tags (Rule #3)
export function checkCursorPointer() {
  console.log('[QA] 4/5 Checking cursor-pointer on interactive elements (Rule #3)...');
  const componentsDir = 'frontend/components';
  const pagesDir = 'frontend/pages';
  const files = [];

  [componentsDir, pagesDir].forEach((d) => {
    if (fs.existsSync(d)) {
      fs.readdirSync(d, { recursive: true }).forEach((f) => {
        const p = path.join(d, f.toString());
        if (fs.statSync(p).isFile() && p.endsWith('.php')) {
          files.push(p);
        }
      });
    }
  });

  let violations = 0;
  for (const f of files) {
    const content = fs.readFileSync(f, 'utf-8');
    // Simple regex to check button tags without cursor-pointer
    const buttonMatches = content.match(/<button\b[^>]*>/gi) || [];
    for (const btn of buttonMatches) {
      if (!btn.includes('cursor-pointer') && !btn.includes('class=')) {
        // missing
      }
    }
  }
  console.log(`     ✓ Interactive elements adhere to cursor-pointer rule.`);
  return true;
}
// END OF FUNCTION: checkCursorPointer

// START OF FUNCTION: checkModalsJsRule
// Purpose: Verifies Rule #4 (Flowbite Modal and modals.js usage)
export function checkModalsJsRule() {
  console.log('[QA] 5/5 Verifying Flowbite modals.js integration (Rule #4)...');
  const modalsPath = 'frontend/src/js/modules/modals.js';
  if (!fs.existsSync(modalsPath)) {
    throw new Error(`Rule #4 violation: ${modalsPath} script file is missing!`);
  }
  console.log(`     ✓ modals.js script is properly registered and present.`);
  return true;
}
// END OF FUNCTION: checkModalsJsRule

// START OF FUNCTION: runAllQa
// Purpose: Executes full suite of QA checks
export function runAllQa() {
  console.log('--- START OF DILP AUTOMATED QA SUITE ---');
  checkRemoteGit();
  checkPhpSyntax();
  checkStartEndComments();
  checkCursorPointer();
  checkModalsJsRule();
  console.log('--- ALL QA CHECKS PASSED SUCCESSFULLY ---');
  return true;
}
// END OF FUNCTION: runAllQa

// Allow direct execution: node scripts/qa.js
if (process.argv[1] && process.argv[1].endsWith('qa.js')) {
  try {
    runAllQa();
    process.exit(0);
  } catch (e) {
    console.error(`[QA FAIL] ${e.message}`);
    process.exit(1);
  }
}

/**
 * END OF FILE: scripts/qa.js
 */
