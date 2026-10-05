/**
 * START OF FILE: frontend/src/js/modules/drawer.js
 * Purpose: Universal Flowbite off-canvas Drawer controller with dynamic content injection
 */

// START OF CLASS: DrawerManager - Controls off-canvas drawers
export class DrawerManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes drawer target element and backdrop references
   */
  constructor(drawerId = 'app-drawer') {
    this.drawerId = drawerId;
    this.drawerEl = document.getElementById(drawerId);
    this.backdropEl = null;
    this.isOpen = false;
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Binds show, hide, and backdrop click handlers
   */
  init() {
    if (!this.drawerEl) {
      this.drawerEl = document.getElementById(this.drawerId);
    }
    if (!this.drawerEl) return this;

    const showTriggers = document.querySelectorAll(`[data-drawer-show="${this.drawerId}"], [data-drawer-target="${this.drawerId}"]`);
    const hideTriggers = document.querySelectorAll(`[data-drawer-hide="${this.drawerId}"]`);

    showTriggers.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        this.show();
      });
    });

    hideTriggers.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        this.hide();
      });
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.isOpen) {
        this.hide();
      }
    });

    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: setContent
   * Purpose: Dynamically injects title and HTML body into drawer placeholder
   */
  setContent(title, htmlContent) {
    if (!this.drawerEl) return;
    const titleEl = this.drawerEl.querySelector(`#${this.drawerId}-heading`) || this.drawerEl.querySelector('h3 span');
    const contentEl = this.drawerEl.querySelector(`#${this.drawerId}-content`);

    if (titleEl && title) {
      titleEl.textContent = title;
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
    if (options.title || options.content) {
      this.setContent(options.title, options.content);
    }
    this.show();
  }
  // END OF FUNCTION: open

  /**
   * START OF FUNCTION: show
   * Purpose: Slides drawer into view and creates backdrop
   */
  show() {
    if (!this.drawerEl) return;

    this.createBackdrop();
    this.drawerEl.classList.remove('translate-x-full');
    this.drawerEl.classList.add('translate-x-0');
    this.drawerEl.setAttribute('aria-hidden', 'false');
    this.isOpen = true;
    document.body.classList.add('overflow-hidden');
  }
  // END OF FUNCTION: show

  /**
   * START OF FUNCTION: hide
   * Purpose: Slides drawer out of view and removes backdrop
   */
  hide() {
    if (!this.drawerEl) return;

    this.drawerEl.classList.remove('translate-x-0');
    this.drawerEl.classList.add('translate-x-full');
    this.drawerEl.setAttribute('aria-hidden', 'true');
    this.removeBackdrop();
    this.isOpen = false;
    document.body.classList.remove('overflow-hidden');
  }
  // END OF FUNCTION: hide

  /**
   * START OF FUNCTION: toggle
   * Purpose: Toggles drawer open/closed state
   */
  toggle() {
    if (this.isOpen) {
      this.hide();
    } else {
      this.show();
    }
  }
  // END OF FUNCTION: toggle

  /**
   * START OF FUNCTION: createBackdrop
   * Purpose: Appends darkened backdrop element
   */
  createBackdrop() {
    if (this.backdropEl) return;

    this.backdropEl = document.createElement('div');
    this.backdropEl.id = `${this.drawerId}-backdrop`;
    this.backdropEl.className = 'fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-xs transition-opacity duration-300';
    this.backdropEl.addEventListener('click', () => this.hide());
    document.body.appendChild(this.backdropEl);
  }
  // END OF FUNCTION: createBackdrop

  /**
   * START OF FUNCTION: removeBackdrop
   * Purpose: Removes backdrop element from DOM
   */
  removeBackdrop() {
    if (this.backdropEl) {
      this.backdropEl.remove();
      this.backdropEl = null;
    }
  }
  // END OF FUNCTION: removeBackdrop
}
// END OF CLASS: DrawerManager

export const drawer = new DrawerManager('app-drawer');

/**
 * END OF FILE: frontend/src/js/modules/drawer.js
 */
