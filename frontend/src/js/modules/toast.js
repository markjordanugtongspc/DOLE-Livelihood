/**
 * START OF FILE: frontend/src/js/modules/toast.js
 * Purpose: Toast notification manager for feedback alerts
 */

// START OF CLASS: ToastManager - Controls toast notifications
export class ToastManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes toast container reference
   */
  constructor(containerId = 'toast-container') {
    this.containerId = containerId;
    this.container = document.getElementById(containerId);
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Creates container if not already in DOM
   */
  init() {
    if (!this.container) {
      this.container = document.createElement('div');
      this.container.id = this.containerId;
      this.container.className = 'fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none';
      document.body.appendChild(this.container);
    }
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: show
   * Purpose: Displays a styled toast message with auto-dismiss
   */
  show(message, type = 'info', duration = 4000) {
    this.init();

    const toastId = `toast-${Date.now()}`;
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `pointer-events-auto flex items-center w-full p-4 rounded-xl shadow-lg border text-sm font-medium transition-all duration-300 transform translate-x-5 opacity-0 ${this.getTypeStyles(type)}`;
    toast.setAttribute('role', 'alert');

    const iconHtml = this.getTypeIcon(type);

    toast.innerHTML = `
      <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg mr-3">
        ${iconHtml}
      </div>
      <div class="flex-1 text-slate-800 dark:text-slate-200">${message}</div>
      <button type="button" class="cursor-pointer ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-700 transition" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
      </button>
    `;

    const closeBtn = toast.querySelector('button');
    closeBtn.addEventListener('click', () => {
      this.dismiss(toast);
    });

    this.container.appendChild(toast);

    // Animate in
    requestAnimationFrame(() => {
      toast.classList.remove('translate-x-5', 'opacity-0');
      toast.classList.add('translate-x-0', 'opacity-100');
    });

    if (duration > 0) {
      setTimeout(() => {
        this.dismiss(toast);
      }, duration);
    }

    return toast;
  }
  // END OF FUNCTION: show

  /**
   * START OF FUNCTION: dismiss
   * Purpose: Animates toast out and removes it from DOM
   */
  dismiss(toast) {
    if (!toast) return;
    toast.classList.remove('translate-x-0', 'opacity-100');
    toast.classList.add('translate-x-5', 'opacity-0');
    setTimeout(() => {
      if (toast.parentElement) {
        toast.remove();
      }
    }, 300);
  }
  // END OF FUNCTION: dismiss

  /**
   * START OF FUNCTION: getTypeStyles
   * Purpose: Returns Tailwind classes for given toast type
   */
  getTypeStyles(type) {
    switch (type) {
      case 'success':
        return 'bg-emerald-50 dark:bg-emerald-950/80 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-100';
      case 'error':
        return 'bg-rose-50 dark:bg-rose-950/80 border-rose-300 dark:border-rose-700 text-rose-900 dark:text-rose-100';
      case 'warning':
        return 'bg-amber-50 dark:bg-amber-950/80 border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-100';
      default:
        return 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white';
    }
  }
  // END OF FUNCTION: getTypeStyles

  /**
   * START OF FUNCTION: getTypeIcon
   * Purpose: Returns SVG icon markup for given toast type
   */
  getTypeIcon(type) {
    switch (type) {
      case 'success':
        return '<svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
      case 'error':
        return '<svg class="w-5 h-5 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
      case 'warning':
        return '<svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
      default:
        return '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';
    }
  }
  // END OF FUNCTION: getTypeIcon
}
// END OF CLASS: ToastManager

export const toast = new ToastManager();

/**
 * END OF FILE: frontend/src/js/modules/toast.js
 */
