<?php
/* START: PinPadComponent — PIN entry pad with mobile input, interactive dots and on-screen keypad */
?>
<div id="login-card" class="card-elevated p-6 sm:p-10 w-full max-w-md 3xl:max-w-xl mx-auto shadow-2xl">
    <!-- Form Heading -->
    <div id="login-card-header" class="mb-8">
        <h2 id="login-card-title" class="text-2xl sm:text-3xl font-extrabold text-ink-950 tracking-tight">
            Sign In to Your Account
        </h2>
        <p id="login-card-subtitle" class="mt-2 text-base text-ink-600 font-medium">
            Enter your registered mobile phone number and security PIN to proceed.
        </p>
    </div>

    <!-- Alert / Error Banner -->
    <div id="login-card-error" class="hidden mb-6 p-4 rounded-xl border border-danger-500 bg-danger-50 text-danger-800 text-sm font-semibold transition-all">
        <div class="flex items-center gap-2">
            <svg class="size-5 text-danger-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span id="login-card-error-text">Incorrect credentials entered.</span>
        </div>
    </div>

    <!-- Login Form -->
    <form id="login-card-form" class="space-y-6" onsubmit="return false;" novalidate>
        <!-- Phone Input Field -->
        <div id="login-card-field-phone" class="space-y-2">
            <label id="login-card-label-phone" for="login-card-input-phone" class="block text-sm sm:text-base font-semibold text-ink-800">
                Registered Mobile Number <span class="text-danger-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-ink-400 font-bold">
                    🇵🇭 +63
                </div>
                <input
                    type="tel"
                    id="login-card-input-phone"
                    name="phone"
                    placeholder="917 123 4567"
                    maxlength="13"
                    autocomplete="tel"
                    class="block w-full h-14 ps-20 pe-4 text-lg font-semibold text-ink-900 bg-white rounded-xl border border-ink-300 focus:ring-4 focus:ring-primary-200 focus:border-primary-600 transition"
                    required
                >
            </div>
            <p id="login-card-phone-hint" class="text-xs text-ink-500 font-medium">
                Example: 0917 123 4567 or 917 123 4567
            </p>
        </div>

        <!-- PIN Display Slots -->
        <div id="login-card-field-pin" class="space-y-3 pt-2">
            <div class="flex items-center justify-between">
                <label id="login-card-label-pin" class="block text-sm sm:text-base font-semibold text-ink-800">
                    Security PIN (4–6 Digits) <span class="text-danger-500">*</span>
                </label>
                <button
                    type="button"
                    id="login-card-btn-pin-visibility"
                    class="text-xs sm:text-sm font-semibold text-info-600 hover:text-info-800 cursor-pointer transition focus:outline-hidden"
                >
                    Show PIN
                </button>
            </div>

            <!-- Hidden actual PIN input to support hardware typing & screen readers -->
            <input
                type="password"
                id="login-card-input-pin"
                name="pin"
                maxlength="6"
                inputmode="numeric"
                autocomplete="current-password"
                class="sr-only"
                aria-label="Security PIN Input"
            >

            <!-- 6 Visual Dot Indicator Slots -->
            <div id="login-card-pin-dots" class="flex justify-between gap-2 sm:gap-3 py-2">
                <div id="login-card-pin-slot-1" class="pin-dot-slot active" data-index="1">
                    <span class="pin-dot bg-transparent"></span>
                </div>
                <div id="login-card-pin-slot-2" class="pin-dot-slot" data-index="2">
                    <span class="pin-dot bg-transparent"></span>
                </div>
                <div id="login-card-pin-slot-3" class="pin-dot-slot" data-index="3">
                    <span class="pin-dot bg-transparent"></span>
                </div>
                <div id="login-card-pin-slot-4" class="pin-dot-slot" data-index="4">
                    <span class="pin-dot bg-transparent"></span>
                </div>
                <div id="login-card-pin-slot-5" class="pin-dot-slot" data-index="5">
                    <span class="pin-dot bg-transparent"></span>
                </div>
                <div id="login-card-pin-slot-6" class="pin-dot-slot" data-index="6">
                    <span class="pin-dot bg-transparent"></span>
                </div>
            </div>
        </div>

        <!-- On-Screen Numeric Keypad -->
        <div id="login-card-keypad" class="grid grid-cols-3 gap-3 pt-2">
            <button type="button" id="login-card-keypad-btn-1" class="keypad-btn" data-key="1">1</button>
            <button type="button" id="login-card-keypad-btn-2" class="keypad-btn" data-key="2">2<span class="keypad-subtext">ABC</span></button>
            <button type="button" id="login-card-keypad-btn-3" class="keypad-btn" data-key="3">3<span class="keypad-subtext">DEF</span></button>
            <button type="button" id="login-card-keypad-btn-4" class="keypad-btn" data-key="4">4<span class="keypad-subtext">GHI</span></button>
            <button type="button" id="login-card-keypad-btn-5" class="keypad-btn" data-key="5">5<span class="keypad-subtext">JKL</span></button>
            <button type="button" id="login-card-keypad-btn-6" class="keypad-btn" data-key="6">6<span class="keypad-subtext">MNO</span></button>
            <button type="button" id="login-card-keypad-btn-7" class="keypad-btn" data-key="7">7<span class="keypad-subtext">PQRS</span></button>
            <button type="button" id="login-card-keypad-btn-8" class="keypad-btn" data-key="8">8<span class="keypad-subtext">TUV</span></button>
            <button type="button" id="login-card-keypad-btn-9" class="keypad-btn" data-key="9">9<span class="keypad-subtext">WXYZ</span></button>
            <button type="button" id="login-card-keypad-btn-clear" class="keypad-btn text-base font-bold text-ink-500 hover:text-danger-600 hover:bg-danger-50" data-action="clear">Clear</button>
            <button type="button" id="login-card-keypad-btn-0" class="keypad-btn" data-key="0">0</button>
            <button type="button" id="login-card-keypad-btn-back" class="keypad-btn text-ink-600 hover:text-danger-600 hover:bg-danger-50" data-action="back" aria-label="Backspace">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l7-7h11a2 2 0 012 2v10a2 2 0 01-2 2H10l-7-7z"/>
                </svg>
            </button>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            id="login-card-btn-submit"
            class="w-full h-14 mt-4 text-lg font-bold rounded-xl text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer focus:ring-4 focus:ring-primary-200 transition shadow-md flex items-center justify-center gap-3"
            disabled
        >
            <span id="login-card-btn-submit-text">Sign In</span>
            <svg id="login-card-btn-submit-spinner" class="hidden size-6 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>

        <!-- Secondary Action: OTP Placeholder & Help Trigger -->
        <div id="login-card-actions" class="pt-4 border-t border-ink-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm">
            <button
                type="button"
                id="login-card-btn-otp"
                class="font-semibold text-ink-500 hover:text-ink-700 cursor-pointer transition flex items-center gap-1.5"
                title="Phone OTP login is scheduled for an upcoming release"
            >
                <svg class="size-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                </svg>
                Sign in with OTP <span class="text-xs px-2 py-0.5 rounded-full bg-ink-200 text-ink-700 font-bold">Soon</span>
            </button>

            <button
                type="button"
                id="login-card-btn-help"
                class="font-bold text-info-600 hover:text-info-800 cursor-pointer transition"
                data-drawer-target="drawer-help"
                data-drawer-show="drawer-help"
                data-drawer-placement="right"
                aria-controls="drawer-help"
            >
                Need Help?
            </button>
        </div>
    </form>
</div>
<?php
/* END: PinPadComponent */
