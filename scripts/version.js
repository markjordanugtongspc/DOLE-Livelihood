/**
 * START OF FILE: scripts/version.js
 * Purpose: Automated semantic version incrementer for package.json (Rule #10)
 */

import fs from 'fs';
import path from 'path';

// START OF FUNCTION: bumpVersion
// Purpose: Reads package.json, increments patch version, writes back to disk
export function bumpVersion() {
  const pkgPath = path.resolve('package.json');
  if (!fs.existsSync(pkgPath)) {
    console.warn('[Version] package.json not found, skipping version bump.');
    return null;
  }

  const pkg = JSON.parse(fs.readFileSync(pkgPath, 'utf-8'));
  const current = pkg.version || '1.0.0';
  const parts = current.split('.').map(Number);

  if (parts.length === 3 && !parts.some(isNaN)) {
    parts[2] += 1;
    pkg.version = parts.join('.');
  } else {
    pkg.version = '1.0.1';
  }

  fs.writeFileSync(pkgPath, JSON.stringify(pkg, null, 2) + '\n', 'utf-8');
  console.log(`[Version] Bumped version: v${current} -> v${pkg.version}`);
  return pkg.version;
}
// END OF FUNCTION: bumpVersion

// Allow direct execution: node scripts/version.js
if (process.argv[1] && process.argv[1].endsWith('version.js')) {
  bumpVersion();
}

/**
 * END OF FILE: scripts/version.js
 */
