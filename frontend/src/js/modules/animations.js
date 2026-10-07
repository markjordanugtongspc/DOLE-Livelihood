/* START: Animations — micro-animations and UI visual state helpers */
export default class Animations {
  /* START: shake — triggers error shake animation on target element */
  static shake(element) {
    if (!element) return;
    element.classList.remove('animate-shake');
    // Force reflow
    void element.offsetWidth;
    element.classList.add('animate-shake');
    setTimeout(() => {
      element.classList.remove('animate-shake');
    }, 600);
  }
  /* END: shake */

  /* START: animateButtonFeedback — applies smooth color & state transitions to action buttons */
  static animateButtonFeedback(button, state = 'default') {
    if (!button) return;

    if (state === 'loading') {
      button.classList.remove('bg-emerald-700', 'hover:bg-transparent', 'text-white', 'hover:text-emerald-700', 'bg-red-600', 'border-red-600');
      button.classList.add('bg-emerald-800', 'border-emerald-800', 'text-white', 'cursor-wait', 'opacity-90');
    } else if (state === 'success') {
      button.classList.remove('bg-emerald-700', 'hover:bg-transparent', 'hover:text-emerald-700', 'bg-red-600', 'border-red-600', 'cursor-wait', 'opacity-90');
      button.classList.add('bg-emerald-600', 'border-emerald-600', 'text-white');
    } else if (state === 'error') {
      button.classList.remove('bg-emerald-700', 'hover:bg-transparent', 'hover:text-emerald-700', 'cursor-wait', 'opacity-90');
      button.classList.add('bg-red-600', 'border-red-600', 'text-white');
    } else {
      button.classList.remove('bg-emerald-800', 'border-emerald-800', 'bg-red-600', 'border-red-600', 'cursor-wait', 'opacity-90');
      button.classList.add('bg-emerald-700', 'border-emerald-700', 'text-white');
    }
  }
  /* END: animateButtonFeedback */

  /* START: setLoading — toggles loading spinner and disabled state on button */
  static setLoading(button, isLoading, loadingText = 'Processing...') {
    if (!button) return;

    const textEl = button.querySelector('[id$="-text"]');
    const spinnerEl = button.querySelector('[id$="-spinner"]');

    if (isLoading) {
      button.disabled = true;
      if (textEl) {
        button.dataset.originalText = textEl.textContent;
        textEl.textContent = loadingText;
      }
      if (spinnerEl) spinnerEl.classList.remove('hidden');
    } else {
      button.disabled = false;
      if (textEl && button.dataset.originalText) {
        textEl.textContent = button.dataset.originalText;
      }
      if (spinnerEl) spinnerEl.classList.add('hidden');
    }
  }
  /* START: slideLeft — triggers smooth slide left transition on carousel slide element */
  static slideLeft(element, duration = 700) {
    if (!element) return;
    element.style.transition = `transform ${duration}ms cubic-bezier(0.4, 0, 0.2, 1), opacity ${duration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
    element.style.transform = 'translateX(0%)';
    element.style.opacity = '1';
  }
  /* END: slideLeft */

  /* START: slideRight — triggers smooth slide right transition on carousel slide element */
  static slideRight(element, duration = 700) {
    if (!element) return;
    element.style.transition = `transform ${duration}ms cubic-bezier(0.4, 0, 0.2, 1), opacity ${duration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
    element.style.transform = 'translateX(0%)';
    element.style.opacity = '1';
  }
  /* END: slideRight */
  /* START: pause — pauses automatic progression on target controller or element */
  static pause(target) {
    if (!target) return;
    if (typeof target.pauseAutoPlay === 'function') {
      target.pauseAutoPlay();
    }
  }
  /* END: pause */

  /* START: play — resumes automatic progression on target controller or element */
  static play(target) {
    if (!target) return;
    if (typeof target.startAutoPlay === 'function') {
      target.startAutoPlay();
    }
  }
  /* END: play */
  /* START: shakePinSlots — applies shake animation and highlighted red border to PIN dot slots */
  static shakePinSlots(container) {
    if (!container) return;

    container.classList.remove('animate-shake');
    void container.offsetWidth; // Force reflow
    container.classList.add('animate-shake');

    const slots = container.querySelectorAll('[data-slot-index]');
    slots.forEach(slot => {
      slot.classList.remove('border-emerald-600', 'bg-emerald-50/50', 'border-slate-300', 'border-slate-400', 'ring-emerald-500/20');
      slot.classList.add('border-red-600', 'bg-red-50', 'ring-4', 'ring-red-400/30', 'border-2');

      // Make inner dots red
      const innerDot = slot.querySelector('span.rounded-full');
      if (innerDot) {
        innerDot.classList.remove('bg-emerald-800', 'bg-emerald-600');
        innerDot.classList.add('bg-red-600');
      }

      // Make inner text digits red
      const innerText = slot.querySelector('span:not(.rounded-full)');
      if (innerText) {
        innerText.classList.remove('text-emerald-950', 'text-emerald-800');
        innerText.classList.add('text-red-600');
      }
    });

    setTimeout(() => {
      container.classList.remove('animate-shake');
      slots.forEach(slot => {
        slot.classList.remove('border-red-600', 'bg-red-50', 'ring-4', 'ring-red-400/30');
      });
    }, 800);
  }
  /* END: shakePinSlots */

  /* START: toggleDropdownAccordion — smoothly animates dropdown opening/closing with pop effect */
  static toggleDropdownAccordion(targetMenu, isOpening = true, duration = 220) {
    if (!targetMenu) return;

    if (isOpening) {
      targetMenu.classList.remove('hidden');
      targetMenu.style.overflow = 'hidden';
      targetMenu.style.maxHeight = '0px';
      targetMenu.style.opacity = '0';
      targetMenu.style.transform = 'translateY(-6px) scale(0.97)';
      targetMenu.style.transformOrigin = 'top center';
      targetMenu.style.transition = `max-height ${duration}ms cubic-bezier(0.16, 1, 0.3, 1), opacity ${duration}ms cubic-bezier(0.16, 1, 0.3, 1), transform ${duration}ms cubic-bezier(0.34, 1.56, 0.64, 1)`;

      // Force layout reflow
      void targetMenu.offsetHeight;

      const fullHeight = targetMenu.scrollHeight;
      targetMenu.style.maxHeight = `${fullHeight + 10}px`;
      targetMenu.style.opacity = '1';
      targetMenu.style.transform = 'translateY(0) scale(1)';

      setTimeout(() => {
        targetMenu.style.maxHeight = '';
        targetMenu.style.overflow = '';
        targetMenu.style.transition = '';
        targetMenu.style.transform = '';
        targetMenu.style.transformOrigin = '';
      }, duration + 30);
    } else {
      targetMenu.style.overflow = 'hidden';
      targetMenu.style.maxHeight = `${targetMenu.scrollHeight}px`;
      targetMenu.style.opacity = '1';
      targetMenu.style.transform = 'translateY(0) scale(1)';
      targetMenu.style.transformOrigin = 'top center';
      targetMenu.style.transition = `max-height ${duration}ms cubic-bezier(0.4, 0, 0.2, 1), opacity ${duration}ms cubic-bezier(0.4, 0, 0.2, 1), transform ${duration}ms cubic-bezier(0.4, 0, 0.2, 1)`;

      // Force layout reflow
      void targetMenu.offsetHeight;

      targetMenu.style.maxHeight = '0px';
      targetMenu.style.opacity = '0';
      targetMenu.style.transform = 'translateY(-6px) scale(0.97)';

      setTimeout(() => {
        targetMenu.classList.add('hidden');
        targetMenu.style.maxHeight = '';
        targetMenu.style.opacity = '';
        targetMenu.style.overflow = '';
        targetMenu.style.transition = '';
        targetMenu.style.transform = '';
        targetMenu.style.transformOrigin = '';
      }, duration);
    }
  }
  /* END: toggleDropdownAccordion */
}
/* END: Animations */

export const shakeElement = (el) => Animations.shake(el);
export const shakePinSlotsElement = (el) => Animations.shakePinSlots(el);
export const setButtonLoading = (btn, isLoading, text) => Animations.setLoading(btn, isLoading, text);
export const animateButtonFeedback = (btn, state) => Animations.animateButtonFeedback(btn, state);
export const slideLeftElement = (el, duration) => Animations.slideLeft(el, duration);
export const slideRightElement = (el, duration) => Animations.slideRight(el, duration);
export const pauseAnimation = (target) => Animations.pause(target);
export const playAnimation = (target) => Animations.play(target);
export const toggleDropdownAccordion = (el, isOpening, duration) => Animations.toggleDropdownAccordion(el, isOpening, duration);
export { Animations };

