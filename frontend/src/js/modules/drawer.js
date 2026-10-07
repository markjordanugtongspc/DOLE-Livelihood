/**
 * START OF FILE: frontend/src/js/modules/drawer.js
 * Purpose: Universal Flowbite off-canvas Drawer controller wrapping Flowbite Drawer API with dynamic content injection
 */

import { Drawer } from 'flowbite';

// START OF CLASS: DrawerManager - Controls off-canvas drawers using Flowbite Drawer API
export class DrawerManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes Flowbite drawer target element and options
   */
  constructor(drawerId = 'app-drawer', options = {}) {
    this.drawerId = drawerId;
    this.drawerEl = document.getElementById(drawerId);
    this.flowbiteDrawer = null;
    this.options = {
      placement: 'right',
      backdrop: true,
      bodyScrolling: false,
      edge: false,
      edgeOffset: '',
      backdropClasses: 'bg-stone-950/60 dark:bg-slate-950/80 fixed inset-0 z-40 backdrop-blur-xs',
      ...options
    };
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Instantiates Flowbite Drawer component and ensures clean integration
   */
  init() {
    if (!this.drawerEl) {
      this.drawerEl = document.getElementById(this.drawerId);
    }
    if (!this.drawerEl) return this;

    try {
      this.flowbiteDrawer = new Drawer(this.drawerEl, this.options);
    } catch (err) {
      console.warn('Flowbite Drawer initialization:', err);
    }

    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: setContent
   * Purpose: Dynamically injects title, subtitle, and HTML subchild body into drawer placeholder
   */
  setContent(title, htmlContent, subtitle = '') {
    if (!this.drawerEl) {
      this.drawerEl = document.getElementById(this.drawerId);
    }
    if (!this.drawerEl) return;
    const titleEl = this.drawerEl.querySelector(`#${this.drawerId}-heading`) || this.drawerEl.querySelector('h5 span') || this.drawerEl.querySelector('h3 span');
    const subtitleEl = this.drawerEl.querySelector(`#${this.drawerId}-subtitle`);
    const contentEl = this.drawerEl.querySelector(`#${this.drawerId}-content`);

    if (titleEl && title) {
      titleEl.textContent = title;
    }
    if (subtitleEl && subtitle) {
      subtitleEl.textContent = subtitle;
    }
    if (contentEl && htmlContent) {
      contentEl.innerHTML = htmlContent;
    }
  }
  // END OF FUNCTION: setContent

  /**
   * START OF FUNCTION: open
   * Purpose: Sets dynamic content if provided and opens drawer
   */
  open(options = {}) {
    if (options.title || options.content || options.subtitle) {
      this.setContent(options.title, options.content, options.subtitle || '');
    }
    this.show();
  }
  // END OF FUNCTION: open

  /**
   * START OF FUNCTION: show
   * Purpose: Slides drawer smoothly into view using Flowbite API
   */
  show() {
    if (this.flowbiteDrawer) {
      this.flowbiteDrawer.show();
    } else {
      if (!this.drawerEl) this.drawerEl = document.getElementById(this.drawerId);
      if (this.drawerEl) {
        this.drawerEl.classList.remove('translate-x-full');
        this.drawerEl.classList.add('translate-x-0');
      }
    }
  }
  // END OF FUNCTION: show

  /**
   * START OF FUNCTION: hide
   * Purpose: Slides drawer out of view using Flowbite API
   */
  hide() {
    if (this.flowbiteDrawer) {
      this.flowbiteDrawer.hide();
    } else {
      if (!this.drawerEl) this.drawerEl = document.getElementById(this.drawerId);
      if (this.drawerEl) {
        this.drawerEl.classList.remove('translate-x-0');
        this.drawerEl.classList.add('translate-x-full');
      }
    }
  }
  // END OF FUNCTION: hide

  /**
   * START OF FUNCTION: toggle
   * Purpose: Toggles drawer open/closed state
   */
  toggle() {
    if (this.flowbiteDrawer) {
      this.flowbiteDrawer.toggle();
    }
  }
  // END OF FUNCTION: toggle

  /**
   * START OF FUNCTION: isVisible
   * Purpose: Returns current visibility status
   */
  isVisible() {
    return this.flowbiteDrawer ? this.flowbiteDrawer.isVisible() : false;
  }
  // END OF FUNCTION: isVisible
}
// END OF CLASS: DrawerManager

export const drawer = new DrawerManager('app-drawer');

/**
 * END OF FILE: frontend/src/js/modules/drawer.js
 */
