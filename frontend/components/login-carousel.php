<?php
/**
 * START OF FILE: frontend/components/login-carousel.php
 * Purpose: Left-side hero background image slider with solid primary overlay
 */
?>
<!-- Carousel Background Container (Flowbite carousel) -->
<div id="login-carousel" class="absolute inset-0 size-full overflow-hidden pointer-events-none" data-carousel="slide">
    <!-- Slide 1: Agriculture / Farming -->
    <div id="login-carousel-item-1" class="hidden duration-1000 ease-in-out size-full transition-opacity" data-carousel-item>
        <img
            id="login-carousel-img-1"
            src="<?= \App\core\Vite::asset('frontend/src/public/images/carousel/slide-1.jpg') ?>"
            alt="Agricultural Livelihood"
            class="w-full h-full object-cover opacity-25"
        >
    </div>

    <!-- Slide 2: Micro Business -->
    <div id="login-carousel-item-2" class="hidden duration-1000 ease-in-out size-full transition-opacity" data-carousel-item>
        <img
            id="login-carousel-img-2"
            src="<?= \App\core\Vite::asset('frontend/src/public/images/carousel/slide-2.jpg') ?>"
            alt="Micro Business Enterprise"
            class="w-full h-full object-cover opacity-25"
        >
    </div>

    <!-- Slide 3: Fisherfolk Community -->
    <div id="login-carousel-item-3" class="hidden duration-1000 ease-in-out size-full transition-opacity" data-carousel-item>
        <img
            id="login-carousel-img-3"
            src="<?= \App\core\Vite::asset('frontend/src/public/images/carousel/slide-3.jpg') ?>"
            alt="Fisherfolk Livelihood"
            class="w-full h-full object-cover opacity-25"
        >
    </div>

    <!-- Slide 4: Tailoring and Crafts -->
    <div id="login-carousel-item-4" class="hidden duration-1000 ease-in-out size-full transition-opacity" data-carousel-item>
        <img
            id="login-carousel-img-4"
            src="<?= \App\core\Vite::asset('frontend/src/public/images/carousel/slide-4.jpg') ?>"
            alt="Community Tailoring & Crafts"
            class="w-full h-full object-cover opacity-25"
        >
    </div>
</div>

<!-- Hero Content Overlay (Placed in middle) -->
<div id="login-hero-center-content" class="relative z-20 my-auto py-8 max-w-xl">
    <div id="login-hero-badge" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-900/80 border border-emerald-400/30 text-amber-300 text-xs font-bold tracking-wide uppercase shadow-xs mb-4">
        <span class="size-2 rounded-full bg-amber-400 animate-pulse"></span>
        <span>Republic of the Philippines &bull; DOLE</span>
    </div>
    <h2 id="login-hero-heading" class="text-3xl sm:text-4xl xl:text-5xl font-extrabold tracking-tight text-white leading-tight">
        DOLE Integrated Livelihood Program
    </h2>
    <p id="login-hero-description" class="mt-4 text-base sm:text-lg text-emerald-100/90 font-medium leading-relaxed">
        Empowering working individuals, micro-entrepreneurs, and livelihood beneficiaries across the nation with accessible public assistance.
    </p>

    <!-- Key Highlights -->
    <div id="login-hero-features" class="mt-6 flex flex-wrap gap-4 text-xs sm:text-sm font-semibold text-emerald-100">
        <div class="flex items-center gap-1.5">
            <span class="flex items-center justify-center size-5 rounded-full bg-amber-400 text-slate-900 font-bold text-2xs">&check;</span>
            <span>Secure PIN Access</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="flex items-center justify-center size-5 rounded-full bg-amber-400 text-slate-900 font-bold text-2xs">&check;</span>
            <span>Mobile OTP Verification</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="flex items-center justify-center size-5 rounded-full bg-amber-400 text-slate-900 font-bold text-2xs">&check;</span>
            <span>Real-Time Auditing</span>
        </div>
    </div>

    <!-- Slide Indicators & Controls -->
    <div id="login-hero-controls" class="flex items-center space-x-4 mt-8">
        <div id="login-carousel-indicators" class="flex items-center space-x-2">
            <button type="button" class="cursor-pointer h-2.5 w-8 rounded-full bg-white transition-all duration-300" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="cursor-pointer h-2.5 w-3 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="cursor-pointer h-2.5 w-3 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="cursor-pointer h-2.5 w-3 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        </div>
        <div class="flex items-center space-x-2 ml-4">
            <button type="button" id="login-carousel-prev" data-carousel-prev class="cursor-pointer p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition" aria-label="Previous slide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button type="button" id="login-carousel-next" data-carousel-next class="cursor-pointer p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition" aria-label="Next slide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>
</div>
<?php
/**
 * END OF FILE: frontend/components/login-carousel.php
 */
?>
