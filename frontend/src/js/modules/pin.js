/**
 * START OF FILE: frontend/src/js/modules/pin.js
 * Purpose: Interactive PIN keypad controller handling on-screen keys, physical typing, and dot slots
 */

import { shakePinSlotsElement } from './animations.js';

// START OF CLASS: PinInput - Manages numeric PIN direct keyboard entry, visual slots, and events
export class PinInput {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes PIN state, target elements, and default configs
   */
  constructor(options = {}) {
    this.containerId = options.containerId || 'pin-container';
    this.hiddenInputId = options.hiddenInputId || 'login-form-pin-input';
    this.dotsContainerId = options.dotsContainerId || 'pin-dots';
    this.minLength = options.minLength || 4;
    this.maxLength = options.maxLength || 6;
    this.onComplete = options.onComplete || null;
    this.onChange = options.onChange || null;

    this.container = document.getElementById(this.containerId);
    this.hiddenInput = document.getElementById(this.hiddenInputId);
    this.dotsContainer = document.getElementById(this.dotsContainerId);
    this.toggleVisBtn = document.getElementById('pin-toggle-visibility-btn');
    this.clearBtn = document.getElementById('pin-clear-btn');

    this.pin = '';
    this.isVisible = false;
    this.isBound = false;
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Sets up initial slots and binds keyboard and focus listeners
   */
  init() {
    this.dotsContainer = document.getElementById(this.dotsContainerId);
    this.hiddenInput = document.getElementById(this.hiddenInputId);
    this.toggleVisBtn = document.getElementById('pin-toggle-visibility-btn');
    this.clearBtn = document.getElementById('pin-clear-btn');

    if (!this.dotsContainer) {
      return this;
    }

    this.renderSlots();

    if (!this.isBound) {
      this.bindKeyboard();
      this.bindVisibilityToggle();
      this.bindClearButton();
      this.bindContainerClick();
      this.isBound = true;
    }

    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: renderSlots
   * Purpose: Renders the 6 dot slots for visual feedback
   */
  renderSlots() {
    if (!this.dotsContainer) return;

    this.dotsContainer.innerHTML = '';
    for (let i = 0; i < this.maxLength; i++) {
      const slot = document.createElement('div');
      slot.id = `pin-dot-slot-${i}`;
      slot.setAttribute('data-slot-index', i.toString());
      slot.className = 'flex-1 h-14 sm:h-16 flex items-center justify-center rounded-xl border-2 border-slate-300 bg-white text-xl font-extrabold text-slate-900 transition-all duration-200 shadow-xs select-none';
      slot.setAttribute('aria-label', `Digit slot ${i + 1}`);
      this.dotsContainer.appendChild(slot);
    }
    this.updateSlots();
  }
  // END OF FUNCTION: renderSlots

  /**
   * START OF FUNCTION: updateSlots
   * Purpose: Synchronizes slot appearance with current PIN string
   */
  updateSlots() {
    if (!this.dotsContainer) return;
    const slots = this.dotsContainer.querySelectorAll('[data-slot-index]');

    slots.forEach((slot, index) => {
      if (index < this.pin.length) {
        slot.classList.remove('border-slate-300', 'bg-white', 'border-dashed');
        slot.classList.add('border-emerald-600', 'bg-emerald-50/50', 'scale-105', 'shadow-sm');

        if (this.isVisible) {
          slot.innerHTML = `<span class="text-emerald-950 font-black text-2xl animate-fade-in">${this.pin[index]}</span>`;
        } else {
          slot.innerHTML = '<span class="inline-block w-4 h-4 rounded-full bg-emerald-800 shadow-xs animate-scale-up"></span>';
        }
      } else if (index === this.pin.length) {
        // Active next slot indicator with standard blinking cursor
        slot.classList.remove('border-emerald-600', 'bg-emerald-50/50', 'scale-105', 'shadow-sm');
        slot.classList.add('border-slate-400', 'bg-white', 'ring-2', 'ring-emerald-500/20');
        slot.innerHTML = '<span class="pin-cursor-blink inline-block w-1.5 h-6 bg-emerald-600 rounded-full"></span>';
      } else {
        slot.classList.remove('border-emerald-600', 'bg-emerald-50/50', 'scale-105', 'shadow-sm', 'border-slate-400', 'ring-2', 'ring-emerald-500/20');
        slot.classList.add('border-slate-200', 'bg-white');
        slot.innerHTML = '';
      }
    });

    if (this.hiddenInput) {
      this.hiddenInput.value = this.pin;
    }

    if (typeof this.onChange === 'function') {
      this.onChange(this.pin);
    }

    if (this.pin.length >= this.minLength && typeof this.onComplete === 'function') {
      this.onComplete(this.pin);
    }
  }
  // END OF FUNCTION: updateSlots

  /**
   * START OF FUNCTION: appendDigit
   * Purpose: Appends single numeric digit to PIN if length limit not reached
   */
  appendDigit(digit) {
    if (this.pin.length >= this.maxLength) return;
    if (!/^\d$/.test(digit)) return;

    this.pin += digit;
    this.updateSlots();
  }
  // END OF FUNCTION: appendDigit

  /**
   * START OF FUNCTION: backspace
   * Purpose: Removes last digit from PIN string
   */
  backspace() {
    if (this.pin.length === 0) return;
    this.pin = this.pin.slice(0, -1);
    this.updateSlots();
  }
  // END OF FUNCTION: backspace

  /**
   * START OF FUNCTION: clear
   * Purpose: Resets PIN to empty state
   */
  clear() {
    this.pin = '';
    this.updateSlots();
  }
  // END OF FUNCTION: clear

  /**
   * START OF FUNCTION: getValue
   * Purpose: Returns current PIN string
   */
  getValue() {
    return this.pin;
  }
  // END OF FUNCTION: getValue

  /**
   * START OF FUNCTION: isValid
   * Purpose: Checks if PIN meets minimum and maximum length requirements
   */
  isValid() {
    return this.pin.length >= this.minLength && this.pin.length <= this.maxLength;
  }
  // END OF FUNCTION: isValid

  /**
   * START OF FUNCTION: shake
   * Purpose: Triggers visual shake animation with red highlight on error and clears PIN after animation
   */
  shake() {
    if (this.dotsContainer) {
      shakePinSlotsElement(this.dotsContainer);
    }
    setTimeout(() => {
      this.clear();
    }, 800);
  }
  // END OF FUNCTION: shake

  /**
   * START OF FUNCTION: bindKeyboard
   * Purpose: Listens to physical keyboard numeric keys, backspace, and escape
   */
  bindKeyboard() {
    document.addEventListener('keydown', (e) => {
      // Don't capture when typing inside another active input (like phone input)
      if (document.activeElement && document.activeElement.tagName === 'INPUT' && document.activeElement.id !== this.hiddenInputId) {
        return;
      }

      // Check if login PIN view is currently visible
      const pinView = document.getElementById('login-view-pin');
      if (pinView && pinView.classList.contains('hidden')) {
        return;
      }

      if (/^[0-9]$/.test(e.key)) {
        this.appendDigit(e.key);
      } else if (e.key === 'Backspace') {
        this.backspace();
      } else if (e.key === 'Escape') {
        this.clear();
      }
    });
  }
  // END OF FUNCTION: bindKeyboard

  /**
   * START OF FUNCTION: bindVisibilityToggle
   * Purpose: Toggles visible digits vs masked dots
   */
  bindVisibilityToggle() {
    if (!this.toggleVisBtn) return;

    this.toggleVisBtn.addEventListener('click', (e) => {
      e.preventDefault();
      this.isVisible = !this.isVisible;
      const toggleText = document.getElementById('pin-toggle-text');
      if (toggleText) {
        toggleText.textContent = this.isVisible ? 'Mask Digits' : 'Show Digits';
      }
      this.updateSlots();
      this.toggleVisBtn.setAttribute('aria-pressed', this.isVisible ? 'true' : 'false');
    });
  }
  // END OF FUNCTION: bindVisibilityToggle

  /**
   * START OF FUNCTION: bindClearButton
   * Purpose: Binds quick Clear button
   */
  bindClearButton() {
    if (!this.clearBtn) return;
    this.clearBtn.addEventListener('click', (e) => {
      e.preventDefault();
      this.clear();
    });
  }
  // END OF FUNCTION: bindClearButton

  /**
   * START OF FUNCTION: bindContainerClick
   * Purpose: Focuses container when user clicks on slots
   */
  bindContainerClick() {
    if (!this.dotsContainer) return;
    this.dotsContainer.addEventListener('click', () => {
      this.dotsContainer.focus();
    });
  }
  // END OF FUNCTION: bindContainerClick
}
// END OF CLASS: PinInput
// END OF CLASS: PinInput

/**
 * END OF FILE: frontend/src/js/modules/pin.js
 */
