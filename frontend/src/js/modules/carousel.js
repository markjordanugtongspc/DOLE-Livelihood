/**
 * START OF FILE: frontend/src/js/modules/carousel.js
 * Purpose: Login image carousel wrapper using Flowbite Carousel API or auto-cycling
 */

// START OF CLASS: LoginCarousel - Manages the hero background image carousel
export class LoginCarousel {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes carousel state and DOM references
   */
  constructor(carouselElementId = 'login-carousel') {
    this.container = document.getElementById(carouselElementId);
    this.items = this.container ? Array.from(this.container.querySelectorAll('[data-carousel-item]')) : [];
    this.indicators = this.container ? Array.from(this.container.querySelectorAll('[data-carousel-slide-to]')) : [];
    this.prevBtn = this.container ? this.container.querySelector('[data-carousel-prev]') : null;
    this.nextBtn = this.container ? this.container.querySelector('[data-carousel-next]') : null;
    this.currentIndex = 0;
    this.intervalMs = 6000;
    this.timer = null;
    this.isPlaying = true;
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Binds carousel events and starts auto-advance
   */
  init() {
    if (!this.container || this.items.length === 0) {
      return this;
    }

    this.showSlide(0);
    this.bindEvents();
    this.startAutoPlay();
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: bindEvents
   * Purpose: Attaches click listeners to next, prev, and indicator dots
   */
  bindEvents() {
    if (this.prevBtn) {
      this.prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        this.prev();
        this.restartAutoPlay();
      });
    }

    if (this.nextBtn) {
      this.nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        this.next();
        this.restartAutoPlay();
      });
    }

    this.indicators.forEach((indicator, index) => {
      indicator.addEventListener('click', (e) => {
        e.preventDefault();
        this.showSlide(index);
        this.restartAutoPlay();
      });
    });

    // Pause on hover
    this.container.addEventListener('mouseenter', () => this.pauseAutoPlay());
    this.container.addEventListener('mouseleave', () => this.startAutoPlay());
  }
  // END OF FUNCTION: bindEvents

  /**
   * START OF FUNCTION: showSlide
   * Purpose: Shows active slide by index and updates indicators
   */
  showSlide(index) {
    if (index < 0) {
      index = this.items.length - 1;
    } else if (index >= this.items.length) {
      index = 0;
    }

    this.currentIndex = index;

    this.items.forEach((item, i) => {
      if (i === index) {
        item.classList.remove('hidden', 'opacity-0');
        item.classList.add('block', 'opacity-100');
        item.setAttribute('aria-hidden', 'false');
      } else {
        item.classList.remove('block', 'opacity-100');
        item.classList.add('hidden', 'opacity-0');
        item.setAttribute('aria-hidden', 'true');
      }
    });

    this.indicators.forEach((ind, i) => {
      if (i === index) {
        ind.classList.remove('bg-white/40');
        ind.classList.add('bg-white', 'w-8');
        ind.setAttribute('aria-current', 'true');
      } else {
        ind.classList.remove('bg-white', 'w-8');
        ind.classList.add('bg-white/40', 'w-3');
        ind.setAttribute('aria-current', 'false');
      }
    });
  }
  // END OF FUNCTION: showSlide

  /**
   * START OF FUNCTION: next
   * Purpose: Advances carousel to the next slide
   */
  next() {
    this.showSlide(this.currentIndex + 1);
  }
  // END OF FUNCTION: next

  /**
   * START OF FUNCTION: prev
   * Purpose: Reverses carousel to the previous slide
   */
  prev() {
    this.showSlide(this.currentIndex - 1);
  }
  // END OF FUNCTION: prev

  /**
   * START OF FUNCTION: startAutoPlay
   * Purpose: Starts interval timer for automatic slide progression
   */
  startAutoPlay() {
    this.pauseAutoPlay();
    this.timer = setInterval(() => {
      this.next();
    }, this.intervalMs);
  }
  // END OF FUNCTION: startAutoPlay

  /**
   * START OF FUNCTION: pauseAutoPlay
   * Purpose: Clears auto-advance timer
   */
  pauseAutoPlay() {
    if (this.timer) {
      clearInterval(this.timer);
      this.timer = null;
    }
  }
  // END OF FUNCTION: pauseAutoPlay

  /**
   * START OF FUNCTION: restartAutoPlay
   * Purpose: Resets and restarts auto-play timer after user interaction
   */
  restartAutoPlay() {
    this.pauseAutoPlay();
    this.startAutoPlay();
  }
  // END OF FUNCTION: restartAutoPlay
}
// END OF CLASS: LoginCarousel

/**
 * END OF FILE: frontend/src/js/modules/carousel.js
 */
