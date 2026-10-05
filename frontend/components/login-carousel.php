<?php
/* START: LoginCarouselComponent — left-side hero image slider with solid primary background */
?>
<section id="login-hero" class="relative overflow-hidden bg-primary-800 text-white min-h-[22rem] lg:min-h-full flex flex-col justify-between p-8 sm:p-12 lg:p-16">
    <!-- Carousel Background Container (Flowbite carousel) -->
    <div id="login-hero-carousel" class="absolute inset-0 size-full" data-carousel="slide" data-carousel-interval="6000">
        <!-- Slide 1: Agriculture / Farming -->
        <div id="login-hero-carousel-item-1" class="hidden duration-1000 ease-in-out size-full" data-carousel-item="active">
            <img
                id="login-hero-img-1"
                src="/frontend/src/public/images/carousel/slide-1.jpg"
                alt="Agricultural Livelihood"
                class="carousel-slide-img"
            >
            <div id="login-hero-overlay-1" class="carousel-overlay"></div>
        </div>

        <!-- Slide 2: Sari-sari Store / Micro Business -->
        <div id="login-hero-carousel-item-2" class="hidden duration-1000 ease-in-out size-full" data-carousel-item>
            <img
                id="login-hero-img-2"
                src="/frontend/src/public/images/carousel/slide-2.jpg"
                alt="Micro Business Enterprise"
                class="carousel-slide-img"
            >
            <div id="login-hero-overlay-2" class="carousel-overlay"></div>
        </div>

        <!-- Slide 3: Fisherfolk Community -->
        <div id="login-hero-carousel-item-3" class="hidden duration-1000 ease-in-out size-full" data-carousel-item>
            <img
                id="login-hero-img-3"
                src="/frontend/src/public/images/carousel/slide-3.jpg"
                alt="Fisherfolk Livelihood"
                class="carousel-slide-img"
            >
            <div id="login-hero-overlay-3" class="carousel-overlay"></div>
        </div>

        <!-- Slide 4: Tailoring and Handicrafts -->
        <div id="login-hero-carousel-item-4" class="hidden duration-1000 ease-in-out size-full" data-carousel-item>
            <img
                id="login-hero-img-4"
                src="/frontend/src/public/images/carousel/slide-4.jpg"
                alt="Community Tailoring & Crafts"
                class="carousel-slide-img"
            >
            <div id="login-hero-overlay-4" class="carousel-overlay"></div>
        </div>

        <!-- Slide Indicators -->
        <div id="login-hero-carousel-indicators" class="absolute z-20 flex -translate-x-1/2 bottom-8 left-12 sm:left-16 space-x-3 rtl:space-x-reverse">
            <button id="login-hero-carousel-indicator-1" type="button" class="size-3.5 rounded-full cursor-pointer transition-all bg-accent-400 hover:scale-125" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button id="login-hero-carousel-indicator-2" type="button" class="size-3.5 rounded-full cursor-pointer transition-all bg-white/50 hover:bg-accent-400 hover:scale-125" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button id="login-hero-carousel-indicator-3" type="button" class="size-3.5 rounded-full cursor-pointer transition-all bg-white/50 hover:bg-accent-400 hover:scale-125" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button id="login-hero-carousel-indicator-4" type="button" class="size-3.5 rounded-full cursor-pointer transition-all bg-white/50 hover:bg-accent-400 hover:scale-125" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        </div>

        <!-- Carousel Slider Controls -->
        <button id="login-hero-carousel-btn-prev" type="button" class="absolute top-1/2 -translate-y-1/2 start-4 z-20 flex items-center justify-center size-12 rounded-full bg-black/25 hover:bg-black/50 text-white cursor-pointer focus:outline-hidden transition" data-carousel-prev>
            <svg class="size-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </button>
        <button id="login-hero-carousel-btn-next" type="button" class="absolute top-1/2 -translate-y-1/2 end-4 z-20 flex items-center justify-center size-12 rounded-full bg-black/25 hover:bg-black/50 text-white cursor-pointer focus:outline-hidden transition" data-carousel-next>
            <svg class="size-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </button>
    </div>

    <!-- Foreground Content: Top Badge & Hero Title -->
    <div id="login-hero-header" class="relative z-20">
        <div id="login-hero-agency-badge" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-900/60 border border-primary-500/40 text-accent-300 text-xs sm:text-sm font-bold tracking-wide uppercase shadow-xs backdrop-blur-xs">
            <span class="size-2 rounded-full bg-accent-400 animate-pulse"></span>
            Republic of the Philippines &bull; DOLE
        </div>
    </div>

    <!-- Foreground Content: Main Headline & Program Description -->
    <div id="login-hero-content" class="relative z-20 my-auto py-12 max-w-2xl">
        <h2 id="login-hero-heading" class="text-3xl sm:text-4xl lg:text-5xl 3xl:text-6xl font-extrabold tracking-tight text-white leading-tight">
            DOLE Integrated Livelihood Program
        </h2>
        <p id="login-hero-description" class="mt-4 text-lg sm:text-xl text-primary-100 font-medium leading-relaxed">
            Empowering working individuals, micro-entrepreneurs, and livelihood beneficiaries across the nation with accessible public assistance.
        </p>

        <div id="login-hero-features" class="mt-8 flex flex-wrap gap-4 sm:gap-6 text-sm sm:text-base font-semibold text-primary-100">
            <div id="login-hero-feature-1" class="flex items-center gap-2">
                <span class="flex items-center justify-center size-6 rounded-full bg-accent-400 text-ink-950 font-bold text-xs">&check;</span>
                Secure PIN Authentication
            </div>
            <div id="login-hero-feature-2" class="flex items-center gap-2">
                <span class="flex items-center justify-center size-6 rounded-full bg-accent-400 text-ink-950 font-bold text-xs">&check;</span>
                Mobile Phone Verified
            </div>
            <div id="login-hero-feature-3" class="flex items-center gap-2">
                <span class="flex items-center justify-center size-6 rounded-full bg-accent-400 text-ink-950 font-bold text-xs">&check;</span>
                Real-Time Auditing
            </div>
        </div>
    </div>

    <!-- Foreground Content: Footer Note -->
    <div id="login-hero-footer" class="relative z-20 text-xs sm:text-sm text-primary-200/80 font-medium">
        &copy; <?= date('Y') ?> Department of Labor and Employment. All rights reserved.
    </div>
</section>
<?php
/* END: LoginCarouselComponent */
