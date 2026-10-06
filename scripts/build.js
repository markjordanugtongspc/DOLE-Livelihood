/**
 * START OF FILE: scripts/build.js
 * Purpose: Master build pipeline executing backup, QA, Vite bundle, versioning, and post-backup (Rule #10)
 */

import { execSync } from 'child_process';
import fs from 'fs';
import path from 'path';
import { runBackup } from './backup.js';
import { runAllQa } from './qa.js';
import { bumpVersion } from './version.js';

// START OF FUNCTION: copyDirRecursive
// Purpose: Recursively copies directories for build asset publication
function copyDirRecursive(src, dest) {
  if (!fs.existsSync(src)) return;
  if (!fs.existsSync(dest)) {
    fs.mkdirSync(dest, { recursive: true });
  }

  const entries = fs.readdirSync(src, { withFileTypes: true });
  for (const entry of entries) {
    const srcPath = path.join(src, entry.name);
    const destPath = path.join(dest, entry.name);

    if (entry.isDirectory()) {
      copyDirRecursive(srcPath, destPath);
    } else {
      fs.copyFileSync(srcPath, destPath);
    }
  }
}
// END OF FUNCTION: copyDirRecursive

// START OF FUNCTION: buildProject
// Purpose: Executes full build workflow
export function buildProject() {
  console.log('========================================================');
  console.log('   DOLE INTEGRATED LIVELIHOOD System (DILP) BUILD      ');
  console.log('========================================================');

  // Step 1: Pre-build backup
  console.log('\n[Step 1/5] Creating pre-build backup snapshot...');
  runBackup('pre-build');

  // Step 2: Automated QA
  console.log('\n[Step 2/5] Running automated QA checks...');
  runAllQa();

  // Step 3: Vite production build
  console.log('\n[Step 3/5] Compiling Vite production assets...');
  try {
    execSync('npx vite build', { stdio: 'inherit' });
    console.log('     ✓ Vite build completed successfully.');
  } catch (err) {
    console.error('     ✗ Vite compilation failed.');
    throw err;
  }

  // Copy public images into dist/images if needed
  try {
    const publicImages = path.resolve('frontend/src/public/images');
    const distImages = path.resolve('dist/images');
    if (fs.existsSync(publicImages)) {
      copyDirRecursive(publicImages, distImages);
      console.log('     ✓ Public images synchronized to dist/images.');
    }
  } catch (copyErr) {
    console.warn(`     ! Notice copying images: ${copyErr.message}`);
  }

  // Step 4: Semantic version bump
  console.log('\n[Step 4/5] Incrementing semantic version control...');
  const newVer = bumpVersion();

  // Step 5: Post-build backup
  console.log('\n[Step 5/5] Creating post-build backup snapshot...');
  runBackup('post-build');

  console.log('\n========================================================');
  console.log(`   BUILD SUCCESSFUL — VERSION v${newVer || '1.0.0'}`);
  console.log('========================================================\n');
}
// END OF FUNCTION: buildProject

// Execute build
try {
  buildProject();
  process.exit(0);
} catch (error) {
  console.error(`\n[BUILD FAILED] ${error.message}`);
  process.exit(1);
}

/**
 * END OF FILE: scripts/build.js
 */
