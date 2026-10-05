/**
 * START OF FILE: frontend/src/js/modules/pin.js
 * Purpose: Interactive PIN keypad controller handling on-screen keys, physical typing, and dot slots
 */

import { shakeElement } from './animations.js';

// START OF CLASS: PinInput - Manages numeric PIN entry, visual slots, and events
export class PinInput {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes PIN state, target elements, and default configs
   */
  constructor(options = {}) {
    this.containerId = options.containerId || 'pin-container';
    this.hiddenInputId = options.hiddenInputId || 'login-form-pin-input';
    this.dotsContainerId = options.dotsContainerId || 'pin-dots';
    this.keypadId = options.keypadId || 'pin-keypad';
    this.minLength = options.minLength || 4;
    this.maxLength = options.maxLength || 6;
    this.onComplete = options.onComplete || null;
    this.onChange = options.onChange || null;

    this.container = document.getElementById(this.containerId);
    this.hiddenInput = document.getElementById(this.hiddenInputId);
    this.dotsContainer = document.getElementById(this.dotsContainerId);
    this.keypad = document.getElementById(this.keypadId);
    this.toggleVisBtn = document.getElementById('pin-toggle-visibility-btn');

    this.pin = '';
    this.isVisible = false;
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Sets up initial slots and binds keypad and keyboard event listeners
   */
  init() {
    if (!this.container) {
      return this;
    }

    this.renderSlots();
    this.bindKeypad();
    this.bindKeyboard();
    this.bindVisibilityToggle();
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
      slot.className = 'w-11 h-12 sm:w-12 sm:h-14 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-lg font-bold text-slate-800 dark:text-white transition-all duration-200 shadow-xs';
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
        slot.classList.remove('border-slate-200', 'dark:border-slate-700');
        slot.classList.add('border-emerald-600', 'bg-emerald-50/50', 'dark:bg-emerald-950/30', 'scale-105');

        if (this.isVisible) {
          slot.textContent = this.pin[index];
        } else {
          slot.innerHTML = '<span class="inline-block w-3.5 h-3.5 rounded-full bg-emerald-600 shadow-xs"></span>';
        }
      } else {
        slot.classList.remove('border-emerald-600', 'bg-emerald-50/50', 'dark:bg-emerald-950/30', 'scale-105');
        slot.classList.add('border-slate-200', 'dark:border-slate-700');
        slot.textContent = '';
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
   * Purpose: Triggers visual shake animation on error and clears PIN
   */
  shake() {
    if (this.dotsContainer) {
      shakeElement(this.dotsContainer);
    }
    this.clear();
  }
  // END OF FUNCTION: shake

  /**
   * START OF FUNCTION: bindKeypad
   * Purpose: Attaches click listeners to on-screen keypad buttons
   */
  bindKeypad() {
    if (!this.keypad) return;

    this.keypad.addEventListener('click', (e) => {
      const button = e.target.closest('button[data-key], button[data-action]');
      if (!button) return;

      const key = button.getAttribute('data-key');
      const action = button.getAttribute('data-action');

      if (key !== null) {
        this.appendDigit(key);
      } else if (action === 'backspace') {
        this.backspace();
      } else if (action === 'clear') {
        this.clear();
      }
    });
  }
  // END OF FUNCTION: bindKeypad

  /**
   * START OF FUNCTION: bindKeyboard
   * Purpose: Listens to physical keyboard numeric keys, backspace, and escape
   */
  bindKeyboard() {
    document.addEventListener('keydown', (e) => {
      // Don't capture when typing inside another active input (like phone number input)
      if (document.activeElement && document.activeElement.tagName === 'INPUT' && document.activeElement.id !== this.hiddenInputId) {
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
      this.updateSlots();
      this.toggleVisBtn.setAttribute('aria-pressed', this.isVisible ? 'true' : 'false');
    });
  }
  // END OF FUNCTION: bindVisibilityToggle
}
// END OF CLASS: PinInput

/**
 * END OF FILE: frontend/src/js/modules/pin.js
 */
