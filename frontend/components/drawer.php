<?php
/**
 * START OF FILE: frontend/components/drawer.php
 * Purpose: Generic Flowbite off-canvas drawer parent template with dynamic subchild injection
 */
$drawerId = $drawerId ?? 'app-drawer';
$drawerTitle = $drawerTitle ?? 'Help & System Information';
$drawerSubtitle = $drawerSubtitle ?? '';
$drawerWidth = $drawerWidth ?? 'w-80 sm:w-96';
$drawerSlot = $drawerSlot ?? null;
?>
<!-- START OF ELEMENT: <?= htmlspecialchars($drawerId) ?> -->
<div
    id="<?= htmlspecialchars($drawerId) ?>"
    class="fixed top-0 right-0 z-50 h-screen transition-transform translate-x-full bg-white dark:bg-slate-900 <?= htmlspecialchars($drawerWidth) ?> max-w-full border-s border-stone-200 dark:border-slate-800 shadow-2xl flex flex-col overflow-hidden"
    tabindex="-1"
    aria-labelledby="<?= htmlspecialchars($drawerId) ?>-label"
>
    <!-- Drawer Header -->
    <div class="px-5 sm:px-7 pt-5 sm:pt-6 pb-4 flex items-center justify-between border-b border-stone-200 dark:border-slate-800 shrink-0">
        <div>
            <h5 id="<?= htmlspecialchars($drawerId) ?>-label" class="inline-flex items-center text-lg sm:text-xl font-extrabold text-stone-900 dark:text-white">
                <svg class="w-5 h-5 mr-2 text-emerald-700 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span id="<?= htmlspecialchars($drawerId) ?>-heading"><?= htmlspecialchars($drawerTitle) ?></span>
            </h5>
            <?php if (!empty($drawerSubtitle)): ?>
                <p id="<?= htmlspecialchars($drawerId) ?>-subtitle" class="text-xs sm:text-sm text-stone-500 dark:text-slate-400 mt-1">
                    <?= htmlspecialchars($drawerSubtitle) ?>
                </p>
            <?php endif; ?>
        </div>
        <button
            type="button"
            data-drawer-hide="<?= htmlspecialchars($drawerId) ?>"
            aria-controls="<?= htmlspecialchars($drawerId) ?>"
            class="text-stone-400 hover:text-stone-700 dark:hover:text-white rounded-xl p-2 inline-flex items-center cursor-pointer transition hover:bg-stone-100 dark:hover:bg-slate-800"
            aria-label="Close drawer"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span class="sr-only">Close drawer</span>
        </button>
    </div>

    <!-- Drawer Content Slot with Slim Scrollbar & Expanded Width -->
    <div id="<?= htmlspecialchars($drawerId) ?>-content" class="flex-1 overflow-y-auto ps-5 pe-3.5 sm:ps-7 sm:pe-4 py-5 space-y-5 text-sm text-stone-700 dark:text-slate-300 custom-scrollbar">
        <?php if ($drawerSlot): ?>
            <?= $drawerSlot ?>
        <?php else: ?>
            <!-- Default Help Content -->
            <div class="space-y-1.5">
                <h4 class="font-bold text-stone-900 dark:text-white text-sm flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center font-bold text-xs">1</span>
                    How to Sign In
                </h4>
                <p class="text-xs leading-relaxed text-stone-600 dark:text-slate-400">
                    Enter your 11-digit registered mobile number (e.g. 0917 123 4567) and your 4 to 6 digit security PIN using the on-screen keypad or physical keyboard.
                </p>
            </div>

            <div class="space-y-1.5">
                <h4 class="font-bold text-stone-900 dark:text-white text-sm flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center font-bold text-xs">2</span>
                    Forgot PIN or Locked Account?
                </h4>
                <p class="text-xs leading-relaxed text-stone-600 dark:text-slate-400">
                    Request an instant SMS OTP to verify your identity, or contact your assigned DOLE regional field officer for credential reset.
                </p>
            </div>

            <div class="p-3.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-stone-900 dark:text-slate-200 space-y-1">
                <h5 class="font-bold text-xs uppercase tracking-wider text-amber-900 dark:text-amber-300">Default Demo Credentials</h5>
                <p class="text-xs text-stone-700 dark:text-slate-300">
                    <strong>Phone:</strong> 0917 123 4567<br>
                    <strong>PIN:</strong> 1234 (Administrator)
                </p>
            </div>

            <div class="pt-3 border-t border-stone-200 dark:border-slate-800 space-y-1 text-xs text-stone-500 dark:text-slate-400">
                <p class="font-bold text-stone-800 dark:text-slate-200">DOLE Support Hotline: 1349</p>
                <p>Email: livelihood-support@dole.gov.ph</p>
                <p>Hours: Mon - Fri, 8:00 AM - 5:00 PM PST</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- END OF ELEMENT: <?= htmlspecialchars($drawerId) ?> -->
<?php
/**
 * END OF FILE: frontend/components/drawer.php
 */
?>
