/**
 * START OF FILE: frontend/src/js/modules/carousel.js
 * Purpose: Login image carousel wrapper using Flowbite Carousel API or auto-cycling
 */

// START OF CLASS: LoginCarousel - Manages the hero background image carousel with smooth left sliding
export class LoginCarousel {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes carousel state and DOM references
   */
  constructor(carouselElementId = 'login-hero-carousel') {
    this.container = document.getElementById(carouselElementId) || document.getElementById('login-carousel');
    this.items = this.container ? Array.from(this.container.querySelectorAll('[data-hero-slide], [data-carousel-item]')) : [];
    this.currentIndex = 0;
    this.intervalMs = 5000;
    this.timer = null;
    this.isAnimating = false;
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Sets up initial positioning, binds hover pause/play, and starts auto-advance
   */
  init() {
    if (!this.container || this.items.length === 0) {
      return this;
    }

    this.setupSlides();
    this.bindHoverEvents();
    this.startAutoPlay();
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: bindHoverEvents
   * Purpose: Pauses carousel on LEFT-PANEL hover and resumes on leave
   */
  bindHoverEvents() {
    const leftPanel = document.getElementById('login-hero-section') || this.container;
    if (leftPanel) {
      leftPanel.addEventListener('mouseenter', () => {
        this.pauseAutoPlay();
      });
      leftPanel.addEventListener('mouseleave', () => {
        this.startAutoPlay();
      });
    }
  }
  // END OF FUNCTION: bindHoverEvents

  /**
   * START OF FUNCTION: setupSlides
   * Purpose: Prepares slide classes and initial transform positioning
   */
  setupSlides() {
    this.items.forEach((item, index) => {
      item.classList.remove('hidden');
      if (index === 0) {
        item.style.transform = 'translateX(0%)';
        item.style.opacity = '1';
        item.style.zIndex = '2';
        item.setAttribute('aria-hidden', 'false');
      } else {
        item.style.transform = 'translateX(100%)';
        item.style.opacity = '0';
        item.style.zIndex = '1';
        item.setAttribute('aria-hidden', 'true');
      }
      item.style.transition = 'transform 1000ms cubic-bezier(0.4, 0, 0.2, 1), opacity 1000ms cubic-bezier(0.4, 0, 0.2, 1)';
    });
  }
  // END OF FUNCTION: setupSlides

  /**
   * START OF FUNCTION: showSlide
   * Purpose: Transitions current slide out to the left and incoming slide in from the right to left
   */
  showSlide(nextIndex) {
    if (this.isAnimating || this.items.length <= 1) return;
    this.isAnimating = true;

    if (nextIndex >= this.items.length) {
      nextIndex = 0;
    } else if (nextIndex < 0) {
      nextIndex = this.items.length - 1;
    }

    const currentSlide = this.items[this.currentIndex];
    const nextSlide = this.items[nextIndex];

    // Position next slide on the right before animating in towards the left
    nextSlide.style.transition = 'none';
    nextSlide.style.transform = 'translateX(100%)';
    nextSlide.style.opacity = '0';
    nextSlide.style.zIndex = '2';
    void nextSlide.offsetWidth; // Force reflow

    // Animate both slides to the left
    const transitionStyle = 'transform 1000ms cubic-bezier(0.4, 0, 0.2, 1), opacity 1000ms cubic-bezier(0.4, 0, 0.2, 1)';
    currentSlide.style.transition = transitionStyle;
    nextSlide.style.transition = transitionStyle;

    currentSlide.style.zIndex = '1';
    currentSlide.style.transform = 'translateX(-100%)';
    currentSlide.style.opacity = '0';
    currentSlide.setAttribute('aria-hidden', 'true');

    nextSlide.style.transform = 'translateX(0%)';
    nextSlide.style.opacity = '1';
    nextSlide.setAttribute('aria-hidden', 'false');

    this.currentIndex = nextIndex;

    setTimeout(() => {
      this.isAnimating = false;
    }, 1000);
  }
  // END OF FUNCTION: showSlide

  /**
   * START OF FUNCTION: next
   * Purpose: Advances carousel to next slide going leftwards
   */
  next() {
    this.showSlide(this.currentIndex + 1);
  }
  // END OF FUNCTION: next

  /**
   * START OF FUNCTION: prev
   * Purpose: Reverses carousel to previous slide
   */
  prev() {
    this.showSlide(this.currentIndex - 1);
  }
  // END OF FUNCTION: prev

  /**
   * START OF FUNCTION: startAutoPlay
   * Purpose: Starts interval timer for automatic rightward slide progression
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
