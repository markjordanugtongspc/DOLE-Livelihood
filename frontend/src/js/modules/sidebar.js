/**
 * START OF FILE: frontend/src/js/modules/sidebar.js
 * Purpose: Manages expandable and collapsable dashboard sidebar with localStorage persistence
 */

// START OF CLASS: SidebarManager - Controls desktop collapse and mobile drawer states
export class SidebarManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes DOM references and stored collapse state
   */
  constructor(options = {}) {
    this.sidebarId = options.sidebarId || 'dashboard-sidebar';
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

    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1024) {
        this.closeMobile();
      }
    });
  }
  // END OF FUNCTION: bindEvents

  /**
   * START OF FUNCTION: toggleCollapse
   * Purpose: Switches between expanded and collapsed state for desktop
   */
  toggleCollapse() {
    this.isCollapsed = !this.isCollapsed;
    localStorage.setItem(this.storageKey, this.isCollapsed ? 'true' : 'false');
    this.applyState();
  }
  // END OF FUNCTION: toggleCollapse

  /**
   * START OF FUNCTION: applyState
   * Purpose: Updates CSS classes and widths based on current collapse state
   */
  applyState() {
    if (!this.sidebar) return;

    const labelElements = this.sidebar.querySelectorAll('[data-sidebar-label]');

    if (this.isCollapsed) {
      this.sidebar.classList.remove('lg:w-64');
      this.sidebar.classList.add('lg:w-20');

      if (this.content) {
        this.content.classList.remove('lg:ml-64');
        this.content.classList.add('lg:ml-20');
      }

      labelElements.forEach((el) => {
        el.classList.add('lg:hidden');
      });
    } else {
      this.sidebar.classList.remove('lg:w-20');
      this.sidebar.classList.add('lg:w-64');

      if (this.content) {
        this.content.classList.remove('lg:ml-20');
        this.content.classList.add('lg:ml-64');
      }

      labelElements.forEach((el) => {
        el.classList.remove('lg:hidden');
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
