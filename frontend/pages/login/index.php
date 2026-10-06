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
<div id="login-page-root" data-page="login" class="min-h-screen w-full flex flex-col lg:flex-row bg-slate-50 text-slate-800 overflow-x-hidden font-sans">

    <!-- START OF ELEMENT: login-hero-section (Left 60% Panel) -->
    <section id="login-hero-section" class="relative hidden lg:flex lg:w-3/5 bg-emerald-950 text-white flex-col justify-between p-8 sm:p-10 xl:p-12 overflow-hidden select-none">
        
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

        <!-- Left-Panel Soft Overlay Tint (Transparent so slider photos are sharp and clear) -->
        <div class="absolute inset-0 bg-emerald-950/15 bg-gradient-to-t from-emerald-950/60 via-emerald-950/20 to-emerald-950/40 pointer-events-none z-10"></div>

        <!-- Top Header Overlay (Trimmed compact padding & balanced logo) -->
        <header id="login-hero-header" class="relative z-20 flex items-center justify-between">
            <div id="login-hero-brand" class="flex items-center space-x-3.5">
                <img
                    id="login-hero-logo"
                    src="<?= Vite::asset('frontend/src/public/images/logo/logo.png') ?>"
                    alt="DOLE Logo"
                    class="h-11 sm:h-12 w-auto object-contain drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]"
                >
                <div class="flex flex-col">
                    <h2 id="login-hero-agency-title" class="text-xs sm:text-sm font-bold tracking-wider uppercase text-emerald-100 leading-tight whitespace-nowrap drop-shadow-sm">
                        Department of Labor and Employment
                    </h2>
                    <span class="text-2xs sm:text-xs font-semibold text-amber-300 drop-shadow-xs tracking-normal">
                        Republic of the Philippines
                    </span>
                </div>
            </div>
        </header>

        <!-- Center Hero Text & Highlights -->
        <div id="login-hero-body" class="relative z-20 my-auto py-10 w-full flex flex-col items-center text-center px-6">
            <h1 id="login-hero-title" class="text-2xl sm:text-3xl xl:text-4xl font-extrabold tracking-tight leading-tight drop-shadow-md">
                <span class="text-white">DOLE</span> <span class="text-emerald-300">Integrated Livelihood System</span>
            </h1>

            <p id="login-hero-tagline" class="mt-3.5 text-sm sm:text-base text-white/95 font-medium leading-relaxed max-w-lg mx-auto drop-shadow-sm">
                Empowering Filipino workers through sustainable community livelihood enterprises.
            </p>
        </div>

        <!-- Footer Hero Info -->
        <footer id="login-hero-footer" class="relative z-20 flex items-center justify-between text-xs text-emerald-100/90 border-t border-white/15 pt-5">
            <p id="login-hero-copyright">&copy; <?= date('Y') ?> DOLE Integrated Livelihood System. All rights reserved.</p>
            <span id="login-hero-credits" class="text-emerald-200 font-semibold">By @Mark Jordan C. Ugtong</span>
        </footer>
    </section>
    <!-- END OF ELEMENT: login-hero-section -->

    <!-- START OF ELEMENT: login-form-section (Right 40% Panel - Dirty-White Background) -->
    <main id="login-form-section" class="w-full lg:w-2/5 flex flex-col justify-center items-center p-8 sm:p-12 xl:p-16 relative min-h-screen lg:min-h-0 bg-slate-100/95">
        
        <!-- Mobile Header (Visible on smaller screens) -->
        <div id="login-mobile-header" class="lg:hidden flex flex-col items-center mb-8 text-center">
            <img
                id="login-mobile-logo"
                src="<?= Vite::asset('frontend/src/public/images/logo/logo.png') ?>"
                alt="DOLE Logo"
                class="h-16 w-auto object-contain mb-3 drop-shadow-[0_8px_16px_rgba(0,0,0,0.35)]"
            >
            <h1 id="login-mobile-title" class="text-xl font-extrabold text-slate-900">DOLE Livelihood System</h1>
            <p id="login-mobile-subtitle" class="text-sm text-slate-500 mt-1">Sign in to your account</p>
        </div>

        <!-- Login Container -->
        <div id="login-card-container" class="w-full max-w-md mx-auto space-y-7">

            <!-- ========================================== -->
            <!-- VIEW 1: METHOD SELECTION (Choice Screen)   -->
            <!-- ========================================== -->
            <div id="login-view-selection" class="space-y-7">
                <div id="login-selection-header" class="text-left">
                    <h2 id="login-selection-title" class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Sign In</h2>
                    <p id="login-selection-subtitle" class="text-base text-slate-600 mt-2 font-normal">Choose your preferred login method to access your account.</p>
                </div>

                <!-- Modern Full-Width Solid Buttons with Transparent Inverted Hover -->
                <div id="login-choices-container" class="grid grid-cols-1 gap-4 pt-3">
                    <!-- Choice 1: PIN Code (Solid Emerald Button -> Transparent Hover with Emerald Text) -->
                    <button
                        type="button"
                        id="login-btn-choice-pin"
                        class="cursor-pointer group relative w-full py-4.5 px-6 rounded-2xl bg-emerald-700 hover:bg-transparent border-2 border-emerald-700 text-white hover:text-emerald-700 transition-all duration-200 shadow-md hover:shadow-xl flex items-center justify-center gap-3.5 font-bold text-lg select-none"
                    >
                        <svg class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span id="login-choice-pin-title" class="tracking-wide">Sign in with Security PIN</span>
                    </button>

                    <!-- Choice 2: Phone OTP (Solid Blue Button -> Transparent Hover with Blue Text) -->
                    <button
                        type="button"
                        id="login-btn-choice-otp"
                        class="cursor-pointer group relative w-full py-4.5 px-6 rounded-2xl bg-blue-600 hover:bg-transparent border-2 border-blue-600 text-white hover:text-blue-600 transition-all duration-200 shadow-md hover:shadow-xl flex items-center justify-center gap-3.5 font-bold text-lg select-none"
                    >
                        <svg class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span id="login-choice-otp-title" class="tracking-wide">Sign in with Phone OTP</span>
                    </button>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- VIEW 2: PIN LOGIN FORM (DIRECT TYPING)     -->
            <!-- ========================================== -->
            <div id="login-view-pin" class="hidden space-y-6">
                <!-- Back Button & Header -->
                <div id="login-pin-header" class="text-left">
                    <button type="button" id="login-pin-back-btn" class="login-btn-back cursor-pointer inline-flex items-center text-sm font-semibold text-slate-500 hover:text-emerald-700 transition mb-3.5 gap-1.5">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                        <span>Change sign in method</span>
                    </button>
                    <h2 id="login-pin-title" class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Security PIN Sign In</h2>
                    <p id="login-pin-subtitle" class="text-base text-slate-600 mt-2 font-normal">Enter your 4 to 6 digit security PIN using your keyboard or numpad.</p>
                </div>

                <!-- Form -->
                <form id="login-form" method="POST" action="/api/auth/login" class="space-y-6" novalidate>
                    <input type="hidden" id="login-form-csrf-token" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="login-form-pin-input" name="pin" value="">

                    <!-- PIN Slots Display & Controls -->
                    <div id="login-form-pin-group" class="space-y-3 pt-1">
                        <div class="flex items-center justify-between">
                            <label id="login-form-pin-label" class="block text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-700">
                                Security PIN (4–6 Digits)
                            </label>
                            <button
                                type="button"
                                id="pin-clear-btn"
                                class="cursor-pointer text-xs sm:text-sm font-semibold text-red-700 hover:text-red-800 transition-colors"
                            >
                                Clear
                            </button>
                        </div>

                        <!-- 6 Visual Dot Indicator Slots (Direct Typing Target) -->
                        <div id="pin-dots" class="flex justify-between items-center gap-2.5 sm:gap-3 py-2 cursor-pointer" tabindex="0" role="textbox" aria-label="Security PIN entry slots"></div>

                        <!-- Left-below toggle control -->
                        <div class="flex items-center justify-start pt-0.5">
                            <button
                                type="button"
                                id="pin-toggle-visibility-btn"
                                class="cursor-pointer text-xs sm:text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition-colors flex items-center gap-1.5"
                                aria-label="Toggle PIN Visibility"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span id="pin-toggle-text">Show Digits</span>
                            </button>
                        </div>
                    </div>

                    <!-- Action Button: Sign In (Solid Emerald Button -> Transparent Hover with Emerald Text) -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="login-form-submit-btn"
                            class="cursor-pointer w-full py-4 px-6 rounded-2xl bg-emerald-700 hover:bg-transparent border-2 border-emerald-700 text-white hover:text-emerald-700 font-bold shadow-md hover:shadow-xl transition-all duration-200 flex items-center justify-center text-lg tracking-wide select-none"
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
