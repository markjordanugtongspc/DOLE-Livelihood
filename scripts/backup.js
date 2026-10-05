/**
 * START OF FILE: scripts/backup.js
 * Purpose: Automated git backup/stash manager maintaining up to 2 rotating snapshots (Rule #8)
 */

import { execSync } from 'child_process';

// START OF FUNCTION: runBackup
// Purpose: Creates a timestamped git stash backup and keeps max 2 stash entries
export function runBackup(label = 'auto-backup') {
  console.log(`[Backup] Creating snapshot label: ${label}...`);
  try {
    const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
    const stashMsg = `dilp-${label}-${timestamp}`;

    // Create stash snapshot including untracked files
    try {
      execSync(`git stash push -u -m "${stashMsg}"`, { stdio: 'pipe' });
      // Immediately re-apply so working directory remains intact
      execSync('git stash apply stash@{0}', { stdio: 'pipe' });
      console.log(`[Backup] Snapshot "${stashMsg}" created and working tree kept intact.`);
    } catch (e) {
      console.log(`[Backup] Note: Nothing new to stash or working tree clean.`);
    }

    // Prune stashes older than 2
    try {
      const list = execSync('git stash list', { encoding: 'utf-8' }).trim();
      const lines = list ? list.split('\n') : [];
      if (lines.length > 2) {
        console.log(`[Backup] Stash count is ${lines.length}. Pruning stashes older than 2...`);
        for (let i = lines.length - 1; i >= 2; i--) {
          try {
            execSync(`git stash drop stash@{${i}}`, { stdio: 'pipe' });
          } catch (dropErr) {
            // ignore
          }
        }
      }
    } catch (listErr) {
      // ignore
    }

    return true;
  } catch (error) {
    console.warn(`[Backup] Stash warning (non-fatal): ${error.message}`);
    return false;
  }
}
// END OF FUNCTION: runBackup

// Allow direct execution: node scripts/backup.js
if (process.argv[1] && process.argv[1].endsWith('backup.js')) {
  runBackup('manual');
}

/**
 * END OF FILE: scripts/backup.js
 */
