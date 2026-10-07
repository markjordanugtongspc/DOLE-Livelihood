import { Animations } from './animations.js';

// START OF CLASS: SidebarManager - Controls desktop collapse and mobile drawer states
export class SidebarManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes DOM references and stored collapse state
   */
  constructor(options = {}) {
    this.sidebarId = options.sidebarId || 'drawer-navigation';
    this.contentId = options.contentId || 'dashboard-main-content';
    this.toggleBtnId = options.toggleBtnId || 'sidebar-toggle-btn';
    this.mobileToggleBtnId = options.mobileToggleBtnId || 'sidebar-mobile-toggle-btn';
    this.storageKey = 'dilp_sidebar_collapsed';

    this.sidebar = document.getElementById(this.sidebarId);
    this.content = document.getElementById(this.contentId);
    this.toggleBtn = document.getElementById(this.toggleBtnId);
    this.mobileToggleBtn = document.getElementById(this.mobileToggleBtnId);
    this.mobileBackdrop = null;

    this.isCollapsed = localStorage.getItem(this.storageKey) === 'true';
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Applies stored state and attaches click event handlers
   */
  init() {
    if (!this.sidebar) return this;

    this.applyState();
    this.bindEvents();
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: bindEvents
   * Purpose: Attaches listeners for desktop collapse and mobile toggle
   */
  bindEvents() {
    if (this.toggleBtn) {
      this.toggleBtn.addEventListener('click', (e) => {
        e.preventDefault();
        this.toggleCollapse();
      });
    }

    if (this.mobileToggleBtn) {
      this.mobileToggleBtn.addEventListener('click', (e) => {
        e.preventDefault();
        this.toggleMobile();
      });
    }

    this.bindDropdownToggles();

    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1024) {
        this.closeMobile();
      }
    });
  }
  // END OF FUNCTION: bindEvents

  /**
   * START OF FUNCTION: bindDropdownToggles
   * Purpose: Manages submenu accordion collapse, pop animation, and chevron SVG rotation
   */
  bindDropdownToggles() {
    if (!this.sidebar) return;

    const toggleButtons = this.sidebar.querySelectorAll('[data-collapse-toggle]');
    toggleButtons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = btn.getAttribute('data-collapse-toggle') || btn.getAttribute('aria-controls');
        const targetMenu = targetId ? document.getElementById(targetId) : null;
        const chevron = btn.querySelector('svg.transition-transform') || btn.querySelector('[data-sidebar-label] svg');

        if (!targetMenu) return;

        const isHidden = targetMenu.classList.contains('hidden');
        if (isHidden) {
          Animations.toggleDropdownAccordion(targetMenu, true, 220);
          btn.setAttribute('aria-expanded', 'true');
          if (chevron) {
            chevron.classList.add('rotate-180');
          }
        } else {
          Animations.toggleDropdownAccordion(targetMenu, false, 200);
          btn.setAttribute('aria-expanded', 'false');
          if (chevron) {
            chevron.classList.remove('rotate-180');
          }
        }
      });
    });
  }
  // END OF FUNCTION: bindDropdownToggles

  /**
   * START OF FUNCTION: toggleCollapse
   * Purpose: Switches between expanded and collapsed state for desktop
   */
  toggleCollapse() {
    this.isCollapsed = !this.isCollapsed;
    localStorage.setItem(this.storageKey, this.isCollapsed ? 'true' : 'false');
    this.applyState();
    setTimeout(() => {
      window.dispatchEvent(new Event('resize'));
    }, 320);
  }
  // END OF FUNCTION: toggleCollapse

  /**
   * START OF FUNCTION: applyState
   * Purpose: Updates CSS classes and widths based on current collapse state
   */
  applyState() {
    if (!this.sidebar) return;

    const labelElements = this.sidebar.querySelectorAll('[data-sidebar-label]');
    const collapseIcons = this.sidebar.querySelectorAll('.sidebar-icon-collapse');
    const expandIcons = this.sidebar.querySelectorAll('.sidebar-icon-expand');
    const brandContainer = this.sidebar.querySelector('#sidebar-brand-wrapper');
    const brandLink = this.sidebar.querySelector('#sidebar-brand-link');

    if (this.isCollapsed) {
      this.sidebar.classList.remove('lg:w-72');
      this.sidebar.classList.add('lg:w-20');

      if (brandContainer) {
        brandContainer.classList.add('justify-center');
      }
      if (brandLink) {
        brandLink.classList.add('w-full', 'justify-center');
      }

      if (this.content) {
        this.content.classList.remove('lg:ml-72');
        this.content.classList.add('lg:ml-20');
      }

      labelElements.forEach((el) => {
        el.classList.add('lg:hidden');
      });

      collapseIcons.forEach((el) => {
        el.classList.add('hidden');
        el.classList.remove('inline-flex');
      });

      expandIcons.forEach((el) => {
        el.classList.remove('hidden');
        el.classList.add('inline-flex');
      });
    } else {
      this.sidebar.classList.remove('lg:w-20');
      this.sidebar.classList.add('lg:w-72');

      if (brandContainer) {
        brandContainer.classList.remove('justify-center');
      }
      if (brandLink) {
        brandLink.classList.remove('w-full', 'justify-center');
      }

      if (this.content) {
        this.content.classList.remove('lg:ml-20');
        this.content.classList.add('lg:ml-72');
      }

      labelElements.forEach((el) => {
        el.classList.remove('lg:hidden');
      });

      collapseIcons.forEach((el) => {
        el.classList.remove('hidden');
        el.classList.add('inline-flex');
      });

      expandIcons.forEach((el) => {
        el.classList.add('hidden');
        el.classList.remove('inline-flex');
      });
    }
  }
  // END OF FUNCTION: applyState

  /**
   * START OF FUNCTION: toggleMobile
   * Purpose: Toggles mobile off-canvas drawer visibility
   */
  toggleMobile() {
    if (!this.sidebar) return;

    if (this.sidebar.classList.contains('-translate-x-full')) {
      this.openMobile();
    } else {
      this.closeMobile();
    }
  }
  // END OF FUNCTION: toggleMobile

  /**
   * START OF FUNCTION: openMobile
   * Purpose: Slides mobile sidebar into view and creates backdrop
   */
  openMobile() {
    this.sidebar.classList.remove('-translate-x-full');
    this.sidebar.classList.add('translate-x-0');
    this.createMobileBackdrop();
  }
  // END OF FUNCTION: openMobile

  /**
   * START OF FUNCTION: closeMobile
   * Purpose: Slides mobile sidebar out of view and removes backdrop
   */
  closeMobile() {
    this.sidebar.classList.remove('translate-x-0');
    this.sidebar.classList.add('-translate-x-full');
    this.removeMobileBackdrop();
  }
  // END OF FUNCTION: closeMobile

  /**
   * START OF FUNCTION: createMobileBackdrop
   * Purpose: Creates backdrop for mobile sidebar overlay
   */
  createMobileBackdrop() {
    if (this.mobileBackdrop) return;

    this.mobileBackdrop = document.createElement('div');
    this.mobileBackdrop.id = 'sidebar-mobile-backdrop';
    this.mobileBackdrop.className = 'fixed inset-0 z-20 bg-slate-900/50 backdrop-blur-xs lg:hidden';
    this.mobileBackdrop.addEventListener('click', () => this.closeMobile());
    document.body.appendChild(this.mobileBackdrop);
  }
  // END OF FUNCTION: createMobileBackdrop

  /**
   * START OF FUNCTION: removeMobileBackdrop
   * Purpose: Removes mobile sidebar backdrop from DOM
   */
  removeMobileBackdrop() {
    if (this.mobileBackdrop) {
      this.mobileBackdrop.remove();
      this.mobileBackdrop = null;
    }
  }
  // END OF FUNCTION: removeMobileBackdrop
}
// END OF CLASS: SidebarManager

/**
 * END OF FILE: frontend/src/js/modules/sidebar.js
 */
