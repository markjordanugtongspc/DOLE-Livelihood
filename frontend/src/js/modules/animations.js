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

  /* START: animateButtonFeedback — applies animated colored states to buttons */
  static animateButtonFeedback(button, state = 'default') {
    if (!button) return;

    // Remove previous dynamic state styling classes
    button.classList.remove(
      'bg-emerald-600', 'bg-emerald-700', 'bg-emerald-800',
      'bg-red-600', 'bg-red-700', 'bg-rose-600', 'bg-rose-700',
      'border-emerald-600', 'border-emerald-700', 'border-red-600', 'border-red-700', 'border-rose-600', 'border-rose-700',
      'text-white', 'text-red-100', 'text-rose-100', 'hover:bg-transparent', 'hover:text-emerald-700'
    );

    if (state === 'loading') {
      button.classList.add('bg-emerald-800', 'border-emerald-800', 'text-white');
    } else if (state === 'success') {
      button.classList.add('bg-emerald-600', 'border-emerald-600', 'text-white');
    } else {
      // Default rest state on both default and error
      button.classList.add('bg-emerald-700', 'border-emerald-700', 'text-white', 'hover:bg-transparent', 'hover:text-emerald-700');
    }
  }
  /* END: animateButtonFeedback */
}
/* END: Animations */

export const shakeElement = (el) => Animations.shake(el);
export const shakePinSlotsElement = (el) => Animations.shakePinSlots(el);
export const setButtonLoading = (btn, isLoading, text) => Animations.setLoading(btn, isLoading, text);
export const slideLeftElement = (el, duration) => Animations.slideLeft(el, duration);
export const slideRightElement = (el, duration) => Animations.slideRight(el, duration);
export const pauseAnimation = (target) => Animations.pause(target);
export const playAnimation = (target) => Animations.play(target);
export { Animations };

