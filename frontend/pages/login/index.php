<?php
/**
 * START OF FILE: frontend/pages/login/index.php
 * Purpose: DOLE Integrated Livelihood Program (DILP) unified PIN and Phone OTP login page
 */

require_once __DIR__ . '/../../../backend/bootstrap.php';

use App\Core\Session;
use App\Core\Csrf;

// If user already authenticated, redirect to dashboard
if (Session::has('user')) {
    header('Location: /dashboard/');
    exit;
}

$pageTitle = 'Sign In - DOLE Integrated Livelihood Program (DILP)';
$csrfToken = Csrf::token();

require_once __DIR__ . '/../../components/head.php';
?>

<!-- START OF ELEMENT: login-page-root -->
<div id="login-page-root" class="min-h-screen w-full flex flex-col lg:flex-row bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 overflow-x-hidden">

    <!-- START OF ELEMENT: login-hero-section (Left Side 50% - 60% on Acer 1080p 125% DPI) -->
    <section id="login-hero-section" class="relative hidden lg:flex lg:w-7/12 xl:w-3/5 bg-emerald-800 dark:bg-emerald-950 text-white flex-col justify-between p-10 xl:p-14 overflow-hidden select-none">
        
        <!-- Header Branding Overlay -->
        <header id="login-hero-header" class="relative z-20 flex items-center justify-between">
            <div id="login-hero-header-brand" class="flex items-center space-x-4">
                <div id="login-hero-header-logo-container" class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center p-2 shadow-lg">
                    <img id="login-hero-header-logo" src="<?= \App\core\Vite::asset('frontend/src/public/images/logo/logo.png') ?>" alt="DOLE DILP Logo" class="w-full h-full object-contain">
                </div>
                <div id="login-hero-header-text">
                    <h2 id="login-hero-header-agency" class="text-sm font-semibold tracking-wider uppercase text-emerald-200">Department of Labor and Employment</h2>
                    <p id="login-hero-header-program" class="text-xs font-medium text-emerald-100/80">Bureau of Workers with Special Concerns (BWSC)</p>
                </div>
            </div>
            <span id="login-hero-header-badge" class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-700/80 border border-emerald-500/40 text-emerald-100">
                Official Portal
            </span>
        </header>

        <!-- Carousel Background & Slides Component -->
        <?php require_once __DIR__ . '/../../components/login-carousel.php'; ?>

        <!-- Footer Hero Info Overlay -->
        <footer id="login-hero-footer" class="relative z-20 flex items-center justify-between text-xs text-emerald-200/90 border-t border-emerald-700/40 pt-6">
            <p id="login-hero-footer-copyright">&copy; <?php echo date('Y'); ?> DOLE Integrated Livelihood Program. All rights reserved.</p>
            <div id="login-hero-footer-links" class="flex items-center space-x-4">
                <a id="login-hero-footer-link-help" href="#drawer-help-right" data-drawer-show="drawer-help-right" class="cursor-pointer hover:text-white transition-colors duration-200">Help & Support</a>
                <span class="text-emerald-500">&bull;</span>
                <span id="login-hero-footer-security">256-bit Encrypted</span>
            </div>
        </footer>
    </section>
    <!-- END OF ELEMENT: login-hero-section -->

    <!-- START OF ELEMENT: login-form-section (Right Side Card) -->
    <main id="login-form-section" class="w-full lg:w-5/12 xl:w-2/5 flex flex-col justify-center items-center p-6 sm:p-10 xl:p-12 relative min-h-screen lg:min-h-0 bg-white dark:bg-slate-900">
        
        <!-- Mobile Logo and Header (visible on < lg) -->
        <header id="login-mobile-header" class="lg:hidden flex flex-col items-center mb-8 text-center">
            <div id="login-mobile-logo-container" class="w-16 h-16 rounded-2xl bg-emerald-700 flex items-center justify-center p-3 shadow-md mb-3">
                <img id="login-mobile-logo" src="<?= \App\core\Vite::asset('frontend/src/public/images/logo/logo.png') ?>" alt="DOLE Logo" class="w-full h-full object-contain">
            </div>
            <h1 id="login-mobile-title" class="text-xl font-bold text-slate-900 dark:text-white">DOLE Livelihood Program</h1>
            <p id="login-mobile-subtitle" class="text-xs text-slate-500 dark:text-slate-400">Sign in to your account</p>
        </header>

        <!-- Login Card Container -->
        <div id="login-card-container" class="w-full max-w-md mx-auto space-y-6">

            <!-- Card Header -->
            <div id="login-card-header" class="hidden lg:block text-left mb-6">
                <h1 id="login-card-title" class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Sign In</h1>
                <p id="login-card-description" class="text-sm text-slate-500 dark:text-slate-400 mt-1">Enter your registered mobile number and PIN to access the portal.</p>
            </div>

            <!-- Form -->
            <form id="login-form" method="POST" action="/api/auth/login" class="space-y-5" novalidate>
                <input type="hidden" id="login-form-csrf-token" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" id="login-form-pin-input" name="pin" value="">

                <!-- Field 1: Mobile Phone Number Input -->
                <div id="login-form-phone-group" class="space-y-1.5">
                    <label id="login-form-phone-label" for="login-form-phone-input" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Mobile Phone Number
                    </label>
                    <div id="login-form-phone-input-wrapper" class="relative rounded-xl shadow-xs">
                        <div id="login-form-phone-prefix-icon" class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">🇵🇭 +63</span>
                        </div>
                        <input
                            type="tel"
                            id="login-form-phone-input"
                            name="phone"
                            placeholder="0917 123 4567"
                            autocomplete="tel"
                            maxlength="13"
                            class="block w-full pl-24 pr-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-300 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-base font-medium placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all duration-200"
                            required
                        >
                    </div>
                    <p id="login-form-phone-hint" class="text-xs text-slate-400 dark:text-slate-500">Format: 09XX XXX XXXX (or tap for OTP verification)</p>
                </div>

                <!-- Field 2: PIN Slots Display & Keypad Component -->
                <div id="login-form-pin-group" class="space-y-2">
                    <div id="login-form-pin-header" class="flex items-center justify-between">
                        <label id="login-form-pin-label" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Security PIN (4–6 Digits)
                        </label>
                        <button
                            type="button"
                            id="pin-toggle-visibility-btn"
                            class="cursor-pointer text-xs font-medium text-emerald-700 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 transition-colors flex items-center gap-1"
                            aria-label="Toggle PIN Visibility"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span>Toggle Peek</span>
                        </button>
                    </div>

                    <!-- On-Screen Keypad Component (includes dots slots and keys) -->
                    <?php require_once __DIR__ . '/../../components/pin-pad.php'; ?>
                </div>

                <!-- OTP Resend Cooldown and Quick Links -->
                <div id="login-form-otp-row" class="flex items-center justify-between text-xs pt-1">
                    <span id="otp-countdown-timer" class="text-slate-500 dark:text-slate-400 font-medium">OTP enabled</span>
                    <button
                        type="button"
                        id="otp-resend-btn"
                        class="cursor-pointer font-semibold text-emerald-700 dark:text-emerald-400 hover:underline transition"
                    >
                        Send Phone OTP
                    </button>
                </div>

                <!-- Action Button: Sign In -->
                <div id="login-form-actions" class="pt-2">
                    <button
                        type="submit"
                        id="login-form-submit-btn"
                        class="cursor-pointer w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-semibold rounded-xl shadow-md hover:shadow-lg focus:outline-hidden focus:ring-4 focus:ring-emerald-300 dark:focus:ring-emerald-900 transition-all duration-200 flex items-center justify-center text-base"
                    >
                        <span>Sign In</span>
                    </button>
                </div>

            </form>

            <!-- Card Footer: Quick Assistance & Info -->
            <div id="login-card-footer" class="pt-4 border-t border-slate-200 dark:border-slate-800 text-center">
                <button
                    type="button"
                    id="login-help-trigger-btn"
                    data-drawer-show="drawer-help-right"
                    class="cursor-pointer text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition inline-flex items-center gap-1.5"
                >
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Need help signing in or forgot your PIN?</span>
                </button>
            </div>

        </div>
    </main>
    <!-- END OF ELEMENT: login-form-section -->

</div>
<!-- END OF ELEMENT: login-page-root -->

<!-- Help Drawer Partial -->
<?php require_once __DIR__ . '/../../components/drawer-help.php'; ?>

<!-- Toast Container Partial -->
<?php require_once __DIR__ . '/../../components/toast.php'; ?>

<!-- Modal Alert Partial (Flowbite Rule #4) -->
<?php require_once __DIR__ . '/../../components/modal-alert.php'; ?>

<!-- Script Assets Bundler Partial -->
<?php require_once __DIR__ . '/../../components/scripts.php'; ?>

<?php
/**
 * END OF FILE: frontend/pages/login/index.php
 */
?>
