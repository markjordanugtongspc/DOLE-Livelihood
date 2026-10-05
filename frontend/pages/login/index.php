<?php
/**
 * START OF FILE: frontend/pages/login/index.php
 * Purpose: DOLE Integrated Livelihood Program (DILP) unified PIN and Phone OTP login page (Light Mode)
 */

require_once __DIR__ . '/../../../backend/bootstrap.php';

use App\core\Session;
use App\core\Csrf;
use App\core\Vite;

// If user already authenticated, redirect to dashboard
if (Session::has('user')) {
    header('Location: ' . Vite::asset('dashboard/'));
    exit;
}

$pageTitle = 'Sign In - DOLE Integrated Livelihood Program (DILP)';
$csrfToken = Csrf::token();

require_once __DIR__ . '/../../components/head.php';
?>

<!-- START OF ELEMENT: login-page-root -->
<div id="login-page-root" class="min-h-screen w-full flex flex-col lg:flex-row bg-slate-50 text-slate-800 overflow-x-hidden font-sans">

    <!-- START OF ELEMENT: login-hero-section (Left Side 55%–60% on desktop) -->
    <section id="login-hero-section" class="relative hidden lg:flex lg:w-7/12 xl:w-3/5 bg-emerald-800 text-white flex-col justify-between p-10 xl:p-14 overflow-hidden select-none">
        
        <!-- Background Carousel Slider Container -->
        <div id="login-carousel" class="absolute inset-0 size-full overflow-hidden" data-carousel="slide">
            <!-- Slide 1: Agriculture / Agri-business -->
            <div id="login-carousel-item-1" class="absolute inset-0 size-full duration-1000 ease-in-out transition-opacity" data-carousel-item>
                <img
                    id="login-carousel-img-1"
                    src="<?= Vite::asset('frontend/src/public/images/carousel/slide-1.jpg') ?>"
                    alt="Agricultural Livelihood"
                    class="w-full h-full object-cover opacity-25 scale-105 transition-transform duration-10000 ease-linear"
                >
            </div>
            <!-- Slide 2: Micro Enterprise -->
            <div id="login-carousel-item-2" class="hidden absolute inset-0 size-full duration-1000 ease-in-out transition-opacity" data-carousel-item>
                <img
                    id="login-carousel-img-2"
                    src="<?= Vite::asset('frontend/src/public/images/carousel/slide-2.jpg') ?>"
                    alt="Micro Business Enterprise"
                    class="w-full h-full object-cover opacity-25 scale-105 transition-transform duration-10000 ease-linear"
                >
            </div>
            <!-- Slide 3: Fisherfolk Community -->
            <div id="login-carousel-item-3" class="hidden absolute inset-0 size-full duration-1000 ease-in-out transition-opacity" data-carousel-item>
                <img
                    id="login-carousel-img-3"
                    src="<?= Vite::asset('frontend/src/public/images/carousel/slide-3.jpg') ?>"
                    alt="Fisherfolk Livelihood"
                    class="w-full h-full object-cover opacity-25 scale-105 transition-transform duration-10000 ease-linear"
                >
            </div>
            <!-- Slide 4: Skills & Crafts -->
            <div id="login-carousel-item-4" class="hidden absolute inset-0 size-full duration-1000 ease-in-out transition-opacity" data-carousel-item>
                <img
                    id="login-carousel-img-4"
                    src="<?= Vite::asset('frontend/src/public/images/carousel/slide-4.jpg') ?>"
                    alt="Community Crafts"
                    class="w-full h-full object-cover opacity-25 scale-105 transition-transform duration-10000 ease-linear"
                >
            </div>

            <!-- Soft Gradient Vignette Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-900/40 to-emerald-950/60 pointer-events-none"></div>
        </div>

        <!-- Top Header Overlay -->
        <header id="login-hero-header" class="relative z-20 flex items-center justify-between">
            <div id="login-hero-brand" class="flex items-center space-x-3.5">
                <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md flex items-center justify-center p-2 shadow-lg">
                    <img src="<?= Vite::asset('frontend/src/public/images/logo/logo.png') ?>" alt="DOLE Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <h2 class="text-xs font-bold tracking-widest uppercase text-emerald-200">Department of Labor and Employment</h2>
                    <p class="text-2xs text-emerald-100/80 font-medium">Bureau of Workers with Special Concerns (BWSC)</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-2xs font-bold uppercase tracking-wider bg-white/10 border border-white/20 text-emerald-100 backdrop-blur-xs">
                Official Portal
            </span>
        </header>

        <!-- Center Hero Text & Highlights -->
        <div id="login-hero-body" class="relative z-20 my-auto py-10 max-w-xl">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-950/60 border border-emerald-400/30 text-amber-300 text-xs font-semibold tracking-wide uppercase shadow-sm mb-5 backdrop-blur-xs">
                <span class="size-2 rounded-full bg-amber-400 animate-pulse"></span>
                <span>Kabuhayan Management System</span>
            </div>
            <h1 class="text-3xl sm:text-4xl xl:text-5xl font-extrabold tracking-tight text-white leading-tight">
                DOLE Integrated <br><span class="text-emerald-200">Livelihood Program</span>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-emerald-100/90 font-normal leading-relaxed">
                Empowering displaced, vulnerable, and marginalized Filipino workers through sustainable community-driven livelihood enterprises.
            </p>

            <!-- Feature Badges -->
            <div class="mt-8 flex flex-wrap gap-3 text-xs font-medium text-emerald-100">
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white/10 border border-white/15 backdrop-blur-xs">
                    <span class="text-amber-300 font-bold">&check;</span>
                    <span>Secure PIN Authentication</span>
                </div>
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white/10 border border-white/15 backdrop-blur-xs">
                    <span class="text-amber-300 font-bold">&check;</span>
                    <span>Direct SMS OTP Verification</span>
                </div>
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white/10 border border-white/15 backdrop-blur-xs">
                    <span class="text-amber-300 font-bold">&check;</span>
                    <span>Real-Time Program Tracking</span>
                </div>
            </div>

            <!-- Slide Indicators & Controls -->
            <div class="flex items-center space-x-4 mt-10">
                <div id="login-carousel-indicators" class="flex items-center space-x-2">
                    <button type="button" class="cursor-pointer h-2 w-8 rounded-full bg-white transition-all duration-300" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                    <button type="button" class="cursor-pointer h-2 w-2.5 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                    <button type="button" class="cursor-pointer h-2 w-2.5 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                    <button type="button" class="cursor-pointer h-2 w-2.5 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
                </div>
                <div class="flex items-center space-x-1.5 ml-4">
                    <button type="button" id="login-carousel-prev" data-carousel-prev class="cursor-pointer p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition" aria-label="Previous">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button" id="login-carousel-next" data-carousel-next class="cursor-pointer p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition" aria-label="Next">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer Hero Info -->
        <footer id="login-hero-footer" class="relative z-20 flex items-center justify-between text-xs text-emerald-200/80 border-t border-white/10 pt-5">
            <p>&copy; <?= date('Y') ?> DOLE Integrated Livelihood Program. All rights reserved.</p>
            <div class="flex items-center space-x-4">
                <button type="button" data-drawer-target="app-drawer" data-drawer-show="app-drawer" class="cursor-pointer hover:text-white transition">Assistance</button>
                <span class="text-emerald-400">&bull;</span>
                <span class="text-emerald-200/60">256-Bit Encrypted</span>
            </div>
        </footer>
    </section>
    <!-- END OF ELEMENT: login-hero-section -->

    <!-- START OF ELEMENT: login-form-section (Right Side Form Card - Light Mode) -->
    <main id="login-form-section" class="w-full lg:w-5/12 xl:w-2/5 flex flex-col justify-center items-center p-6 sm:p-10 xl:p-12 relative min-h-screen lg:min-h-0 bg-white">
        
        <!-- Mobile Header (Visible on smaller screens) -->
        <div id="login-mobile-header" class="lg:hidden flex flex-col items-center mb-6 text-center">
            <div class="w-14 h-14 rounded-2xl bg-emerald-700 flex items-center justify-center p-2.5 shadow-md mb-3">
                <img src="<?= Vite::asset('frontend/src/public/images/logo/logo.png') ?>" alt="DOLE Logo" class="w-full h-full object-contain">
            </div>
            <h1 class="text-xl font-bold text-slate-900">DOLE Livelihood Program</h1>
            <p class="text-xs text-slate-500">Sign in to your account</p>
        </div>

        <!-- Login Card Container -->
        <div id="login-card-container" class="w-full max-w-sm sm:max-w-md mx-auto space-y-6">

            <!-- Card Header -->
            <div id="login-card-header" class="hidden lg:block text-left">
                <h2 id="login-card-title" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Sign In</h2>
                <p id="login-card-description" class="text-sm text-slate-500 mt-1.5">Enter your registered mobile number and security PIN to access the portal.</p>
            </div>

            <!-- Form -->
            <form id="login-form" method="POST" action="/api/auth/login" class="space-y-4" novalidate>
                <input type="hidden" id="login-form-csrf-token" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" id="login-form-pin-input" name="pin" value="">

                <!-- Field 1: Mobile Phone Number Input -->
                <div id="login-form-phone-group" class="space-y-1.5">
                    <label id="login-form-phone-label" for="login-form-phone-input" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                        Mobile Phone Number
                    </label>
                    <div id="login-form-phone-input-wrapper" class="relative rounded-xl shadow-xs">
                        <div id="login-form-phone-prefix-icon" class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <span class="text-sm font-semibold text-slate-700">🇵🇭 +63</span>
                        </div>
                        <input
                            type="tel"
                            id="login-form-phone-input"
                            name="phone"
                            placeholder="0917 123 4567"
                            autocomplete="tel"
                            maxlength="13"
                            class="block w-full pl-22 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-base font-semibold placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 transition-all duration-200"
                            required
                        >
                    </div>
                </div>

                <!-- Field 2: PIN Slots Display & Keypad -->
                <div id="login-form-pin-group" class="space-y-3 pt-1">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                            Security PIN (4–6 Digits)
                        </label>
                        <button
                            type="button"
                            id="pin-toggle-visibility-btn"
                            class="cursor-pointer text-xs font-medium text-emerald-700 hover:text-emerald-800 transition-colors flex items-center gap-1"
                            aria-label="Toggle PIN Visibility"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span>Toggle Peek</span>
                        </button>
                    </div>

                    <!-- 6 Visual Dot Indicator Slots (Light Mode) -->
                    <div id="pin-dots" class="flex justify-between items-center gap-2 sm:gap-2.5 py-1" role="status" aria-label="PIN entry slots">
                        <div id="pin-dot-slot-0" data-slot-index="0" class="flex-1 h-12 sm:h-13 flex items-center justify-center rounded-xl border border-slate-300 bg-slate-50 text-lg font-bold text-slate-900 transition-all duration-200 shadow-xs"></div>
                        <div id="pin-dot-slot-1" data-slot-index="1" class="flex-1 h-12 sm:h-13 flex items-center justify-center rounded-xl border border-slate-300 bg-slate-50 text-lg font-bold text-slate-900 transition-all duration-200 shadow-xs"></div>
                        <div id="pin-dot-slot-2" data-slot-index="2" class="flex-1 h-12 sm:h-13 flex items-center justify-center rounded-xl border border-slate-300 bg-slate-50 text-lg font-bold text-slate-900 transition-all duration-200 shadow-xs"></div>
                        <div id="pin-dot-slot-3" data-slot-index="3" class="flex-1 h-12 sm:h-13 flex items-center justify-center rounded-xl border border-slate-300 bg-slate-50 text-lg font-bold text-slate-900 transition-all duration-200 shadow-xs"></div>
                        <div id="pin-dot-slot-4" data-slot-index="4" class="flex-1 h-12 sm:h-13 flex items-center justify-center rounded-xl border border-slate-300 bg-slate-50 text-lg font-bold text-slate-900 transition-all duration-200 shadow-xs"></div>
                        <div id="pin-dot-slot-5" data-slot-index="5" class="flex-1 h-12 sm:h-13 flex items-center justify-center rounded-xl border border-slate-300 bg-slate-50 text-lg font-bold text-slate-900 transition-all duration-200 shadow-xs"></div>
                    </div>

                    <!-- On-Screen Numeric Keypad (Light Mode) -->
                    <div id="pin-keypad" class="grid grid-cols-3 gap-2 sm:gap-2.5 select-none pt-1">
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="1">
                            <span>1</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="2">
                            <span>2</span>
                            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">ABC</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="3">
                            <span>3</span>
                            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">DEF</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="4">
                            <span>4</span>
                            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">GHI</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="5">
                            <span>5</span>
                            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">JKL</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="6">
                            <span>6</span>
                            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">MNO</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="7">
                            <span>7</span>
                            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">PQRS</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="8">
                            <span>8</span>
                            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">TUV</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="9">
                            <span>9</span>
                            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">WXYZ</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex items-center justify-center rounded-xl bg-rose-50 hover:bg-rose-100 hover:border-rose-300 text-rose-600 font-semibold text-xs transition duration-150 border border-rose-200" data-action="clear" aria-label="Clear PIN">
                            <span>Clear</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-100 active:bg-emerald-50 active:border-emerald-600 border border-slate-200 text-slate-900 font-bold text-base transition duration-150 shadow-xs" data-key="0">
                            <span>0</span>
                        </button>
                        <button type="button" class="cursor-pointer h-11 sm:h-12 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition duration-150 border border-slate-200" data-action="backspace" aria-label="Backspace">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l7-7h11a2 2 0 012 2v10a2 2 0 01-2 2H10l-7-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- OTP Resend & Options -->
                <div id="login-form-otp-row" class="flex items-center justify-between text-xs pt-1">
                    <span id="otp-countdown-timer" class="text-slate-500">OTP enabled</span>
                    <button
                        type="button"
                        id="otp-resend-btn"
                        class="cursor-pointer font-semibold text-emerald-700 hover:text-emerald-800 transition"
                    >
                        Send Phone OTP
                    </button>
                </div>

                <!-- Action Button: Sign In -->
                <div id="login-form-actions" class="pt-2">
                    <button
                        type="submit"
                        id="login-form-submit-btn"
                        class="cursor-pointer w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center text-base"
                    >
                        <span>Sign In</span>
                    </button>
                </div>
            </form>

            <!-- Card Footer -->
            <div id="login-card-footer" class="pt-4 border-t border-slate-200 text-center">
                <button
                    type="button"
                    data-drawer-target="app-drawer"
                    data-drawer-show="app-drawer"
                    class="cursor-pointer text-xs font-medium text-slate-600 hover:text-emerald-700 transition inline-flex items-center gap-1.5"
                >
                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Need help signing in or forgot your PIN?</span>
                </button>
            </div>

        </div>
    </main>
    <!-- END OF ELEMENT: login-form-section -->

</div>
<!-- END OF ELEMENT: login-page-root -->

<!-- Generic Parent Components -->
<?php require_once __DIR__ . '/../../components/drawer.php'; ?>
<?php require_once __DIR__ . '/../../components/modal.php'; ?>
<?php require_once __DIR__ . '/../../components/toast.php'; ?>
<?php require_once __DIR__ . '/../../components/scripts.php'; ?>

<?php
/**
 * END OF FILE: frontend/pages/login/index.php
 */
?>
