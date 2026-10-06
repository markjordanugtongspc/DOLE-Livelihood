<?php
/**
 * START OF FILE: frontend/pages/login/index.php
 * Purpose: DOLE Integrated Livelihood System (DILP) 50/50 split login with Method Selection, PIN, and Phone OTP
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

$pageTitle = 'Sign In - DOLE Integrated Livelihood System (DILP)';
$csrfToken = Csrf::token();

// Dynamically discover all .jpg, .jpeg, and .png images in carousel directory
$carouselDir = __DIR__ . '/../../src/public/images/carousel';
$carouselImages = [];
if (is_dir($carouselDir)) {
    $files = scandir($carouselDir);
    foreach ($files as $file) {
        if (preg_match('/\.(jpg|jpeg|png)$/i', $file)) {
            $carouselImages[] = 'frontend/src/public/images/carousel/' . $file;
        }
    }
}
// Natural sorting so slide-1, slide-2, slide-10 sort logically
natsort($carouselImages);

require_once __DIR__ . '/../../components/head.php';
?>

<!-- START OF ELEMENT: login-page-root -->
<div id="login-page-root" class="min-h-screen w-full flex flex-col lg:flex-row bg-slate-50 text-slate-800 overflow-x-hidden font-sans">

    <!-- START OF ELEMENT: login-hero-section (Left 50% Panel) -->
    <section id="login-hero-section" class="relative hidden lg:flex lg:w-1/2 bg-emerald-950 text-white flex-col justify-between p-6 sm:p-8 xl:p-10 overflow-hidden select-none">
        
        <!-- Hero Background Carousel Slider -->
        <div id="login-hero-carousel" class="absolute inset-0 w-full h-full pointer-events-none overflow-hidden z-0">
            <div id="login-hero-carousel-track" class="relative w-full h-full overflow-hidden">
                <?php if (!empty($carouselImages)): ?>
                    <?php $slideIdx = 1; foreach ($carouselImages as $imgPath): ?>
                        <div class="carousel-slide-item absolute inset-0 w-full h-full" data-hero-slide>
                            <img src="<?= Vite::asset($imgPath) ?>" class="w-full h-full object-cover object-center pointer-events-none select-none" alt="DOLE Livelihood Slide <?= $slideIdx ?>">
                        </div>
                    <?php $slideIdx++; endforeach; ?>
                <?php else: ?>
                    <div class="carousel-slide-item absolute inset-0 w-full h-full" data-hero-slide>
                        <img src="<?= Vite::asset('frontend/src/public/images/carousel/slide-1.jpg') ?>" class="w-full h-full object-cover object-center pointer-events-none select-none" alt="DOLE Livelihood Slide">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Left-Panel Overlapping Solid Emerald Tint (approx 30%-40% balanced opacity so slider images are clearly visible) -->
        <div class="absolute inset-0 bg-emerald-950/30 bg-gradient-to-t from-emerald-950/80 via-emerald-900/35 to-emerald-950/60 pointer-events-none z-10"></div>

        <!-- Top Header Overlay (Trimmed compact padding & balanced logo) -->
        <header id="login-hero-header" class="relative z-20 flex items-center justify-between">
            <div id="login-hero-brand" class="flex items-center space-x-2.5">
                <img
                    id="login-hero-logo"
                    src="<?= Vite::asset('frontend/src/public/images/logo/logo.png') ?>"
                    alt="DOLE Logo"
                    class="h-9 sm:h-10 w-auto object-contain drop-shadow-[0_4px_10px_rgba(0,0,0,0.35)]"
                >
                <div class="flex flex-col">
                    <h2 id="login-hero-agency-title" class="text-[9.5px] sm:text-[11px] font-bold tracking-wider uppercase text-emerald-200/95 leading-tight whitespace-nowrap">
                        Department of Labor and Employment
                    </h2>
                    <span class="text-[8px] sm:text-[9px] font-semibold text-emerald-300/80 tracking-normal">
                        Republic of the Philippines
                    </span>
                </div>
            </div>
        </header>

        <!-- Center Hero Text & Highlights -->
        <div id="login-hero-body" class="relative z-20 my-auto py-8 w-full flex flex-col items-center text-center px-4">
            <!-- Combined Hero Title: Balanced font size, non-wrapping on desktop -->
            <h1 id="login-hero-title" class="text-xl sm:text-2xl xl:text-3xl font-extrabold tracking-tight leading-tight">
                <span class="text-white">DOLE</span> <span class="text-emerald-300">Integrated Livelihood System</span>
            </h1>

            <p id="login-hero-tagline" class="mt-2.5 text-xs sm:text-sm text-emerald-100/90 font-medium leading-relaxed max-w-md mx-auto">
                Empowering Filipino workers through sustainable community livelihood enterprises.
            </p>
        </div>

        <!-- Footer Hero Info -->
        <footer id="login-hero-footer" class="relative z-20 flex items-center justify-between text-2xs text-emerald-200/80 border-t border-white/10 pt-4">
            <p id="login-hero-copyright">&copy; <?= date('Y') ?> DOLE Integrated Livelihood System. All rights reserved.</p>
            <span id="login-hero-credits" class="text-emerald-200/90 font-semibold">By @Mark Jordan C. Ugtong</span>
        </footer>
    </section>
    <!-- END OF ELEMENT: login-hero-section -->

    <!-- START OF ELEMENT: login-form-section (Right 50% Panel - Dirty-White Background) -->
    <main id="login-form-section" class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-10 xl:p-12 relative min-h-screen lg:min-h-0 bg-slate-100/90">
        
        <!-- Mobile Header (Visible on smaller screens) -->
        <div id="login-mobile-header" class="lg:hidden flex flex-col items-center mb-6 text-center">
            <img
                id="login-mobile-logo"
                src="<?= Vite::asset('frontend/src/public/images/logo/logo.png') ?>"
                alt="DOLE Logo"
                class="h-14 w-auto object-contain mb-2 drop-shadow-[0_8px_16px_rgba(0,0,0,0.35)]"
            >
            <h1 id="login-mobile-title" class="text-lg font-bold text-slate-900">DOLE Livelihood System</h1>
            <p id="login-mobile-subtitle" class="text-xs text-slate-500">Sign in to your account</p>
        </div>

        <!-- Login Container -->
        <div id="login-card-container" class="w-full max-w-sm sm:max-w-md mx-auto space-y-6">

            <!-- ========================================== -->
            <!-- VIEW 1: METHOD SELECTION (Choice Screen)   -->
            <!-- ========================================== -->
            <div id="login-view-selection" class="space-y-6">
                <div id="login-selection-header" class="text-left">
                    <h2 id="login-selection-title" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Sign In</h2>
                    <p id="login-selection-subtitle" class="text-sm text-slate-500 mt-1.5">Choose your preferred login method to access your account.</p>
                </div>

                <!-- Modern Full-Width Solid Buttons with Transparent Inverted Hover -->
                <div id="login-choices-container" class="grid grid-cols-1 gap-3.5 pt-2">
                    <!-- Choice 1: PIN Code (Solid Emerald Button -> Transparent Hover with Emerald Text) -->
                    <button
                        type="button"
                        id="login-btn-choice-pin"
                        class="cursor-pointer group relative w-full py-4 px-6 rounded-xl bg-emerald-700 hover:bg-transparent border-2 border-emerald-700 text-white hover:text-emerald-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-3 font-bold text-base select-none"
                    >
                        <svg class="w-5 h-5 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span id="login-choice-pin-title" class="tracking-wide">Sign in with Security PIN</span>
                    </button>

                    <!-- Choice 2: Phone OTP (Solid Blue Button -> Transparent Hover with Blue Text) -->
                    <button
                        type="button"
                        id="login-btn-choice-otp"
                        class="cursor-pointer group relative w-full py-4 px-6 rounded-xl bg-blue-600 hover:bg-transparent border-2 border-blue-600 text-white hover:text-blue-600 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-3 font-bold text-base select-none"
                    >
                        <svg class="w-5 h-5 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span id="login-choice-otp-title" class="tracking-wide">Sign in with Phone OTP</span>
                    </button>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- VIEW 2: PIN LOGIN FORM (PIN-ONLY FOCUS)     -->
            <!-- ========================================== -->
            <div id="login-view-pin" class="hidden space-y-5">
                <!-- Back Button & Header -->
                <div id="login-pin-header" class="text-left">
                    <button type="button" id="login-pin-back-btn" class="login-btn-back cursor-pointer inline-flex items-center text-xs font-semibold text-slate-500 hover:text-emerald-700 transition mb-3 gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        <span>Change sign in method</span>
                    </button>
                    <h2 id="login-pin-title" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Security PIN Sign In</h2>
                    <p id="login-pin-subtitle" class="text-sm text-slate-500 mt-1">Enter your 4 to 6 digit security PIN to access the system.</p>
                </div>

                <!-- Form -->
                <form id="login-form" method="POST" action="/api/auth/login" class="space-y-4" novalidate>
                    <input type="hidden" id="login-form-csrf-token" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="login-form-pin-input" name="pin" value="">

                    <!-- PIN Slots Display & Keypad -->
                    <div id="login-form-pin-group" class="space-y-2.5 pt-1">
                        <div class="flex items-center justify-between">
                            <label id="login-form-pin-label" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                                Security PIN (4–6 Digits)
                            </label>
                            <button
                                type="button"
                                id="pin-toggle-visibility-btn"
                                class="cursor-pointer text-xs font-medium text-emerald-700 hover:text-emerald-800 transition-colors flex items-center gap-1 hover:opacity-70"
                                aria-label="Toggle PIN Visibility"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span>Toggle Peek</span>
                            </button>
                        </div>

                        <!-- 6 Visual Dot Indicator Slots (Rounded-xl) -->
                        <div id="pin-dots" class="flex justify-between items-center gap-2 sm:gap-2.5 py-1" role="status" aria-label="PIN entry slots"></div>

                        <!-- On-Screen Numeric Keypad (Rounded-xl Buttons) -->
                        <div id="pin-keypad" class="grid grid-cols-3 gap-2 sm:gap-2.5 select-none pt-1">
                            <button type="button" id="pin-btn-1" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="1"><span>1</span></button>
                            <button type="button" id="pin-btn-2" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="2"><span>2</span><span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">ABC</span></button>
                            <button type="button" id="pin-btn-3" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="3"><span>3</span><span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">DEF</span></button>
                            <button type="button" id="pin-btn-4" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="4"><span>4</span><span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">GHI</span></button>
                            <button type="button" id="pin-btn-5" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="5"><span>5</span><span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">JKL</span></button>
                            <button type="button" id="pin-btn-6" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="6"><span>6</span><span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">MNO</span></button>
                            <button type="button" id="pin-btn-7" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="7"><span>7</span><span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">PQRS</span></button>
                            <button type="button" id="pin-btn-8" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="8"><span>8</span><span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">TUV</span></button>
                            <button type="button" id="pin-btn-9" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="9"><span>9</span><span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">WXYZ</span></button>
                            <button type="button" id="pin-btn-clear" class="cursor-pointer h-12 flex items-center justify-center rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition-all duration-150 border-2 border-rose-200 active:scale-95" data-action="clear" aria-label="Clear PIN"><span>Clear</span></button>
                            <button type="button" id="pin-btn-0" class="cursor-pointer h-12 flex flex-col items-center justify-center rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold text-base transition-all duration-150 shadow-xs active:scale-95" data-key="0"><span>0</span></button>
                            <button type="button" id="pin-btn-backspace" class="cursor-pointer h-12 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-all duration-150 border-2 border-slate-200 active:scale-95" data-action="backspace" aria-label="Backspace">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l7-7h11a2 2 0 012 2v10a2 2 0 01-2 2H10l-7-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Action Button: Sign In (Solid Emerald Button -> Transparent Hover with Emerald Text) -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="login-form-submit-btn"
                            class="cursor-pointer w-full py-3.5 px-4 rounded-xl bg-emerald-700 hover:bg-transparent border-2 border-emerald-700 text-white hover:text-emerald-700 font-bold shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center text-base tracking-wide"
                        >
                            <span>Sign In</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- ========================================== -->
            <!-- VIEW 3: PHONE OTP LOGIN FORM               -->
            <!-- ========================================== -->
            <div id="login-view-otp" class="hidden space-y-5">
                <!-- Back Button & Header -->
                <div id="login-otp-header" class="text-left">
                    <button type="button" id="login-otp-back-btn" class="login-btn-back cursor-pointer inline-flex items-center text-xs font-semibold text-slate-500 hover:text-emerald-700 transition mb-3 gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        <span>Change sign in method</span>
                    </button>
                    <h2 id="login-otp-title" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Phone OTP Sign In</h2>
                    <p id="login-otp-subtitle" class="text-sm text-slate-500 mt-1">We will send a 6-digit verification code to your phone.</p>
                </div>

                <form id="otp-login-form" class="space-y-4" onsubmit="return false;" novalidate>
                    <!-- Phone Input -->
                    <div id="otp-phone-group" class="space-y-1.5">
                        <label id="otp-phone-label" for="otp-phone-input" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                            Registered Mobile Phone Number
                        </label>
                        <div class="relative shadow-xs">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <span class="text-sm font-semibold text-slate-700">🇵🇭 +63</span>
                            </div>
                            <input
                                type="tel"
                                id="otp-phone-input"
                                name="phone"
                                placeholder="0917 123 4567"
                                autocomplete="tel"
                                maxlength="13"
                                class="block w-full pl-22 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-base font-semibold placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 transition-all duration-200"
                                required
                            >
                        </div>
                    </div>

                    <!-- OTP Send Action (Solid Emerald Button -> Transparent Hover) -->
                    <div id="otp-send-section" class="pt-1">
                        <button
                            type="button"
                            id="otp-request-btn"
                            class="cursor-pointer w-full py-3 px-4 rounded-xl bg-emerald-700 hover:bg-transparent border-2 border-emerald-700 text-white hover:text-emerald-700 font-semibold transition-all duration-200 shadow-xs"
                        >
                            Send Verification Code (SMS)
                        </button>
                    </div>

                    <!-- OTP Code Input (Appears after code is requested) -->
                    <div id="otp-code-section" class="hidden space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <label id="otp-code-label" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                                Enter 6-Digit SMS Code
                            </label>
                            <span id="otp-countdown-timer" class="text-xs text-slate-500 font-medium"></span>
                        </div>
                        <input
                            type="text"
                            id="otp-code-input"
                            maxlength="6"
                            placeholder="&bull; &bull; &bull; &bull; &bull; &bull;"
                            class="block w-full text-center tracking-widest text-2xl font-black py-3 bg-slate-50 border-2 border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 transition"
                        >
                        <div class="flex items-center justify-between text-xs pt-1">
                            <span class="text-slate-400">Didn't receive code?</span>
                            <button type="button" id="otp-resend-btn" class="cursor-pointer font-bold text-emerald-700 hover:underline">Resend SMS</button>
                        </div>

                        <button
                            type="button"
                            id="otp-verify-submit-btn"
                            class="cursor-pointer w-full py-3.5 px-4 mt-2 rounded-xl bg-emerald-700 hover:bg-transparent border-2 border-emerald-700 text-white hover:text-emerald-700 font-bold shadow-md transition-all duration-200"
                        >
                            Verify & Sign In
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>
    <!-- END OF ELEMENT: login-form-section -->

</div>
<!-- END OF ELEMENT: login-page-root -->

<!-- Generic Modal & Toast Components -->
<?php require_once __DIR__ . '/../../components/modal.php'; ?>
<?php require_once __DIR__ . '/../../components/toast.php'; ?>
<?php require_once __DIR__ . '/../../components/scripts.php'; ?>

<?php
/**
 * END OF FILE: frontend/pages/login/index.php
 */
?>
