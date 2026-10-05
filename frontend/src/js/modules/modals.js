/**
 * START OF FILE: frontend/src/js/modules/modals.js
 * Purpose: Central Flowbite modal manager implementing Rule #4 with dynamic content injection
 */

// START OF CLASS: ModalManager - Controls Flowbite pop-up modals
export class ModalManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes modal registry and DOM observation
   */
  constructor(defaultModalId = 'app-modal') {
    this.defaultModalId = defaultModalId;
    this.modals = new Map();
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Finds and registers all elements with data-modal-target or data-modal-toggle
   */
  init() {
    this.bindGlobalTriggers();
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: bindGlobalTriggers
   * Purpose: Attaches click listeners to modal toggle/hide/show triggers
   */
  bindGlobalTriggers() {
    document.addEventListener('click', (e) => {
      const showBtn = e.target.closest('[data-modal-show], [data-modal-target]');
      const hideBtn = e.target.closest('[data-modal-hide]');
      const toggleBtn = e.target.closest('[data-modal-toggle]');

      if (showBtn) {
        e.preventDefault();
        const targetId = showBtn.getAttribute('data-modal-show') || showBtn.getAttribute('data-modal-target');
        this.show(targetId);
      } else if (hideBtn) {
        e.preventDefault();
        const targetId = hideBtn.getAttribute('data-modal-hide');
        this.hide(targetId);
      } else if (toggleBtn) {
        e.preventDefault();
        const targetId = toggleBtn.getAttribute('data-modal-toggle');
        this.toggle(targetId);
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.hideAll();
      }
    });
  }
  // END OF FUNCTION: bindGlobalTriggers

  /**
   * START OF FUNCTION: show
   * Purpose: Displays a Flowbite modal by ID and displays its backdrop
   */
  show(modalId = this.defaultModalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modal.setAttribute('aria-hidden', 'false');

    this.createBackdrop(modalId);
    document.body.classList.add('overflow-hidden');
  }
  // END OF FUNCTION: show

  /**
   * START OF FUNCTION: hide
   * Purpose: Hides a Flowbite modal by ID and removes backdrop
   */
  hide(modalId = this.defaultModalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.classList.remove('flex');
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');

    this.removeBackdrop(modalId);
    if (document.querySelectorAll('[role="dialog"]:not(.hidden)').length === 0) {
      document.body.classList.remove('overflow-hidden');
    }
  }
  // END OF FUNCTION: hide

  /**
   * START OF FUNCTION: toggle
   * Purpose: Toggles modal visible/hidden state
   */
  toggle(modalId = this.defaultModalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    if (modal.classList.contains('hidden')) {
      this.show(modalId);
    } else {
      this.hide(modalId);
    }
  }
  // END OF FUNCTION: toggle

  /**
   * START OF FUNCTION: hideAll
   * Purpose: Closes all currently visible modals
   */
  hideAll() {
    const openModals = document.querySelectorAll('[role="dialog"]:not(.hidden)');
    openModals.forEach((m) => {
      this.hide(m.id);
    });
  }
  // END OF FUNCTION: hideAll

  /**
   * START OF FUNCTION: createBackdrop
   * Purpose: Adds a darkened backdrop for the modal
   */
  createBackdrop(modalId) {
    const backdropId = `${modalId}-backdrop`;
    if (document.getElementById(backdropId)) return;

    const backdrop = document.createElement('div');
    backdrop.id = backdropId;
    backdrop.className = 'fixed inset-0 z-40 bg-slate-950/70 backdrop-blur-xs transition-opacity duration-300';
    backdrop.setAttribute('modal-backdrop', '');
    backdrop.addEventListener('click', () => this.hide(modalId));
    document.body.appendChild(backdrop);
  }
  // END OF FUNCTION: createBackdrop

  /**
   * START OF FUNCTION: removeBackdrop
   * Purpose: Removes modal backdrop element from DOM
   */
  removeBackdrop(modalId) {
    const backdropId = `${modalId}-backdrop`;
    const backdrop = document.getElementById(backdropId);
    if (backdrop) {
      backdrop.remove();
    }
  }
  // END OF FUNCTION: removeBackdrop

  /**
   * START OF FUNCTION: openAlert
   * Purpose: Programmatically open alert modal with custom title, body, and confirm handler
   */
  openAlert(title, message, onConfirm = null, modalId = this.defaultModalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    const titleEl = modal.querySelector(`#${modalId}-title`) || modal.querySelector('h3');
    const msgEl = modal.querySelector(`#${modalId}-message`) || modal.querySelector('p');
    const confirmBtn = modal.querySelector(`#${modalId}-btn-confirm`) || modal.querySelector('button[data-modal-hide]');

    if (titleEl && title) titleEl.textContent = title;
    if (msgEl && message) msgEl.textContent = message;

    if (confirmBtn) {
      const newBtn = confirmBtn.cloneNode(true);
      confirmBtn.parentNode.replaceChild(newBtn, confirmBtn);

      newBtn.addEventListener('click', () => {
        this.hide(modalId);
        if (typeof onConfirm === 'function') {
          onConfirm();
        }
      });
    }

    this.show(modalId);
  }
  // END OF FUNCTION: openAlert
}
// END OF CLASS: ModalManager

export const modals = new ModalManager();

/**
 * END OF FILE: frontend/src/js/modules/modals.js
 */
