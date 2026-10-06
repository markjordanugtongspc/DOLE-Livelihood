/**
 * START OF FILE: frontend/src/js/modules/toast.js
 * Purpose: Toast notification manager for feedback alerts
 */

// START OF CLASS: ToastManager - Controls toast notifications
export class ToastManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes toast container reference and stack array
   */
  constructor(containerId = 'toast-container') {
    this.containerId = containerId;
    this.container = document.getElementById(containerId);
    this.stack = [];
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Creates container if not already in DOM
   */
  init() {
    if (!this.container) {
      this.container = document.getElementById(this.containerId);
    }
    if (!this.container) {
      this.container = document.createElement('div');
      this.container.id = this.containerId;
      this.container.className = 'fixed bottom-6 right-6 z-50 pointer-events-none w-full max-w-sm flex flex-col items-end';
      document.body.appendChild(this.container);
    }
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: show
   * Purpose: Displays a stacked/decked toast notification grouped by alert type
   */
  show(message, type = 'info', duration = 4000) {
    this.init();

    const toastId = `toast-${Date.now()}-${Math.random().toString(36).substring(2, 5)}`;
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `pointer-events-auto relative flex items-center w-full p-4 rounded-2xl shadow-2xl text-white text-sm font-semibold transition-all duration-300 ease-out origin-bottom transform translate-y-8 opacity-0 ${this.getTypeStyles(type)}`;
    toast.setAttribute('role', 'alert');

    const iconHtml = this.getTypeIcon(type);

    toast.innerHTML = `
      <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-xl mr-3 bg-white/20 backdrop-blur-xs shadow-inner">
        ${iconHtml}
      </div>
      <div class="flex-1 text-white leading-snug font-medium drop-shadow-xs select-none">${message}</div>
      <button type="button" class="cursor-pointer ml-auto -mr-1 -my-1 rounded-xl p-1.5 inline-flex h-8 w-8 text-white/70 hover:text-white hover:bg-white/20 transition" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
      </button>
    `;

    const closeBtn = toast.querySelector('button');
    closeBtn.addEventListener('click', () => {
      this.dismiss(toast);
    });

    this.container.appendChild(toast);

    const toastObj = { id: toastId, message, type, element: toast, timer: null };
    this.stack.push(toastObj);

    // Limit overall stack depth to maximum 3 toasts
    while (this.stack.length > 3) {
      const oldest = this.stack[0];
      this.dismiss(oldest.element);
    }

    // Recompute visual deck layers grouped by type
    this.updateDeck();

    // Trigger entrance animation
    requestAnimationFrame(() => {
      toast.classList.remove('translate-y-8', 'opacity-0');
      this.updateDeck();
    });

    if (duration > 0) {
      toastObj.timer = setTimeout(() => {
        this.dismiss(toast);
      }, duration);
    }

    return toast;
  }
  // END OF FUNCTION: show

  /**
   * START OF FUNCTION: updateDeck
   * Purpose: Updates transform scales and offsets so same-type alerts deck behind each other, while different types sit in separated groups
   */
  updateDeck() {
    // Group toasts into consecutive type clusters or type stacks
    // Determine the last occurrence index for each toast's group
    const total = this.stack.length;

    // Group indices by type
    const typeGroups = {};
    this.stack.forEach((item, index) => {
      if (!typeGroups[item.type]) {
        typeGroups[item.type] = [];
      }
      typeGroups[item.type].push({ item, globalIndex: index });
    });

    // Check which type is the newest active type (from top of the stack)
    const activeType = total > 0 ? this.stack[total - 1].type : null;

    this.stack.forEach((item, index) => {
      const el = item.element;
      const group = typeGroups[item.type];
      const positionInGroup = group.findIndex(g => g.globalIndex === index);
      const depthFromFrontInGroup = group.length - 1 - positionInGroup;

      const isCurrentType = item.type === activeType;

      // If this toast belongs to a previous / different type group than the newest one,
      // give the first item of the newer group an extra margin gap (12px) instead of overlapping negative margin.
      const isFirstOfDifferentGroup = index > 0 && this.stack[index - 1].type !== item.type;

      let marginTop = '0px';
      if (index > 0) {
        if (isFirstOfDifferentGroup) {
          marginTop = '12px'; // Distinct separation between different error types
        } else {
          marginTop = '-48px'; // Stacked overlapping behind for same error type
        }
      }

      el.style.marginTop = marginTop;

      if (depthFromFrontInGroup === 0) {
        // Frontmost card of this alert type
        el.style.zIndex = isCurrentType ? 50 : 35;
        el.style.transform = 'translateY(0px) scale(1)';
        el.style.opacity = isCurrentType ? '1' : '0.95';
        el.style.pointerEvents = 'auto';
      } else if (depthFromFrontInGroup === 1) {
        // 1st card behind in this alert type
        el.style.zIndex = isCurrentType ? 40 : 25;
        el.style.transform = 'translateY(-12px) scale(0.96)';
        el.style.opacity = '0.90';
        el.style.pointerEvents = 'none';
      } else if (depthFromFrontInGroup === 2) {
        // 2nd card behind in this alert type
        el.style.zIndex = isCurrentType ? 30 : 15;
        el.style.transform = 'translateY(-24px) scale(0.92)';
        el.style.opacity = '0.75';
        el.style.pointerEvents = 'none';
      } else {
        // 3rd+ card behind in this alert type
        el.style.zIndex = isCurrentType ? 20 : 10;
        el.style.transform = 'translateY(-34px) scale(0.88)';
        el.style.opacity = '0.50';
        el.style.pointerEvents = 'none';
      }
    });
  }
  // END OF FUNCTION: updateDeck

  /**
   * START OF FUNCTION: dismiss
   * Purpose: Dismisses a toast 1-by-1, sliding out and advancing the deck
   */
  dismiss(toast) {
    if (!toast) return;

    const index = this.stack.findIndex(t => t.element === toast);
    if (index !== -1) {
      const [removed] = this.stack.splice(index, 1);
      if (removed.timer) clearTimeout(removed.timer);
    }

    toast.classList.add('translate-y-4', 'opacity-0', 'scale-95');
    setTimeout(() => {
      if (toast.parentElement) {
        toast.remove();
      }
      this.updateDeck();
    }, 250);
  }
  // END OF FUNCTION: dismiss

  /**
   * START OF FUNCTION: getTypeStyles
   * Purpose: Returns solid filled Tailwind background classes with rich shadow
   */
  getTypeStyles(type) {
    switch (type) {
      case 'error':
        return 'bg-red-700 border border-red-600 text-white shadow-red-700/30';
      case 'success':
        return 'bg-emerald-600 border border-emerald-500/80 text-white shadow-emerald-600/30';
      case 'warning':
        return 'bg-amber-600 border border-amber-500/80 text-white shadow-amber-600/30';
      default:
        return 'bg-slate-800 border border-slate-700 text-white shadow-slate-900/30';
    }
  }
  // END OF FUNCTION: getTypeStyles

  /**
   * START OF FUNCTION: getTypeIcon
   * Purpose: Returns crisp white SVG icon markup for given toast type
   */
  getTypeIcon(type) {
    switch (type) {
      case 'error':
        return '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
      case 'success':
        return '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
      case 'warning':
        return '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
      default:
        return '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';
    }
  }
  // END OF FUNCTION: getTypeIcon
}
// END OF CLASS: ToastManager

export const toast = new ToastManager();

/**
 * END OF FILE: frontend/src/js/modules/toast.js
 */
