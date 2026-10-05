<?php
/* START: DrawerHelpComponent — Flowbite off-canvas drawer for user login support */
?>
<div
    id="drawer-help"
    class="fixed top-0 right-0 z-50 h-screen p-6 overflow-y-auto transition-transform translate-x-full bg-white w-80 sm:w-96 border-s border-ink-200 shadow-2xl"
    tabindex="-1"
    aria-labelledby="drawer-help-title"
>
    <!-- Drawer Header -->
    <div id="drawer-help-header" class="flex items-center justify-between pb-4 mb-4 border-b border-ink-200">
        <h3 id="drawer-help-title" class="inline-flex items-center text-lg font-bold text-ink-950">
            <svg class="size-5 me-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            </svg>
            Help & Assistance
        </h3>
        <button
            type="button"
            id="drawer-help-btn-close"
            data-drawer-hide="drawer-help"
            aria-controls="drawer-help"
            class="text-ink-400 bg-transparent hover:bg-ink-100 hover:text-ink-900 rounded-lg text-sm size-8 inline-flex items-center justify-center cursor-pointer transition"
        >
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span class="sr-only">Close help drawer</span>
        </button>
    </div>

    <!-- Drawer Body -->
    <div id="drawer-help-body" class="space-y-6 text-sm text-ink-700">
        <!-- Section: How to Sign In -->
        <div id="drawer-help-section-signin" class="space-y-2">
            <h4 id="drawer-help-heading-signin" class="font-bold text-ink-900 text-base flex items-center gap-2">
                <span class="size-6 rounded-full bg-primary-100 text-primary-800 flex items-center justify-center font-bold text-xs">1</span>
                How to Sign In
            </h4>
            <p>
                1. Input your 11-digit registered Philippine mobile number (starting with <strong>09...</strong>).<br>
                2. Enter your 4 to 6 digit security PIN using either your physical keyboard or the on-screen numeric keypad.<br>
                3. Click the <strong>Sign In</strong> button to access your dashboard.
            </p>
        </div>

        <!-- Section: Forgotten PIN -->
        <div id="drawer-help-section-forgot" class="space-y-2">
            <h4 id="drawer-help-heading-forgot" class="font-bold text-ink-900 text-base flex items-center gap-2">
                <span class="size-6 rounded-full bg-primary-100 text-primary-800 flex items-center justify-center font-bold text-xs">2</span>
                Forgot your PIN?
            </h4>
            <p>
                If you have forgotten your PIN or your account is locked due to multiple failed attempts, please coordinate with your designated DOLE regional officer or program supervisor.
            </p>
        </div>

        <!-- Section: Default Demo Credentials -->
        <div id="drawer-help-section-demo" class="p-4 rounded-xl bg-accent-50 border border-accent-300 text-ink-900 space-y-1.5">
            <h5 id="drawer-help-heading-demo" class="font-extrabold text-sm uppercase tracking-wider text-accent-800">
                Demo Administrator Credentials
            </h5>
            <p class="text-xs">
                <strong>Phone:</strong> 0917 123 4567<br>
                <strong>Security PIN:</strong> 1234<br>
                <strong>Role:</strong> Administrator
            </p>
        </div>

        <!-- Section: Technical Support Contact -->
        <div id="drawer-help-section-contact" class="space-y-2 pt-2 border-t border-ink-200">
            <h4 id="drawer-help-heading-contact" class="font-bold text-ink-900">Contact DOLE DILP Support</h4>
            <ul class="space-y-1 text-xs text-ink-600">
                <li><strong>Hotline:</strong> 1349 (DOLE Hotline)</li>
                <li><strong>Email:</strong> support@dole.gov.ph</li>
                <li><strong>Service Hours:</strong> Mon - Fri, 8:00 AM - 5:00 PM</li>
            </ul>
        </div>
    </div>
</div>
<?php
/* END: DrawerHelpComponent */
