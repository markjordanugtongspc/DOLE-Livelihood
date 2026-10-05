<?php
/**
 * START OF FILE: frontend/components/drawer.php
 * Purpose: Generic Flowbite off-canvas drawer parent template (Light Mode)
 */
$drawerId = $drawerId ?? 'app-drawer';
$drawerTitle = $drawerTitle ?? 'Help & System Information';
?>
<!-- START OF ELEMENT: <?= htmlspecialchars($drawerId) ?> -->
<div
    id="<?= htmlspecialchars($drawerId) ?>"
    class="fixed top-0 right-0 z-50 h-screen p-6 overflow-y-auto transition-transform translate-x-full bg-white w-80 sm:w-96 border-s border-slate-200 shadow-2xl"
    tabindex="-1"
    aria-labelledby="<?= htmlspecialchars($drawerId) ?>-title"
>
    <!-- Drawer Header -->
    <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-200">
        <h3 id="<?= htmlspecialchars($drawerId) ?>-title" class="inline-flex items-center text-base font-bold text-slate-900">
            <svg class="w-5 h-5 mr-2 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span id="<?= htmlspecialchars($drawerId) ?>-heading"><?= htmlspecialchars($drawerTitle) ?></span>
        </h3>
        <button
            type="button"
            data-drawer-hide="<?= htmlspecialchars($drawerId) ?>"
            class="text-slate-400 hover:text-slate-700 rounded-lg p-1.5 inline-flex items-center cursor-pointer transition"
            aria-label="Close drawer"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Drawer Content Slot -->
    <div id="<?= htmlspecialchars($drawerId) ?>-content" class="space-y-5 text-sm text-slate-700">
        <!-- Default Help Content -->
        <div class="space-y-1.5">
            <h4 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">1</span>
                How to Sign In
            </h4>
            <p class="text-xs leading-relaxed text-slate-600">
                Enter your 11-digit registered mobile number (e.g. 0917 123 4567) and your 4 to 6 digit security PIN using the on-screen keypad or physical keyboard.
            </p>
        </div>

        <div class="space-y-1.5">
            <h4 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">2</span>
                Forgot PIN or Locked Account?
            </h4>
            <p class="text-xs leading-relaxed text-slate-600">
                Request an instant SMS OTP to verify your identity, or contact your assigned DOLE regional field officer for credential reset.
            </p>
        </div>

        <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-slate-900 space-y-1">
            <h5 class="font-bold text-xs uppercase tracking-wider text-amber-900">Default Demo Credentials</h5>
            <p class="text-xs text-slate-700">
                <strong>Phone:</strong> 0917 123 4567<br>
                <strong>PIN:</strong> 1234 (Administrator)
            </p>
        </div>

        <div class="pt-3 border-t border-slate-200 space-y-1 text-xs text-slate-500">
            <p class="font-bold text-slate-800">DOLE Support Hotline: 1349</p>
            <p>Email: livelihood-support@dole.gov.ph</p>
            <p>Hours: Mon - Fri, 8:00 AM - 5:00 PM PST</p>
        </div>
    </div>
</div>
<!-- END OF ELEMENT: <?= htmlspecialchars($drawerId) ?> -->
<?php
/**
 * END OF FILE: frontend/components/drawer.php
 */
?>
