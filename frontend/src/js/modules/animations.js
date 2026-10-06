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
}
/* END: Animations */

export const shakeElement = (el) => Animations.shake(el);
export const setButtonLoading = (btn, isLoading, text) => Animations.setLoading(btn, isLoading, text);
export const slideLeftElement = (el, duration) => Animations.slideLeft(el, duration);
export const slideRightElement = (el, duration) => Animations.slideRight(el, duration);
export const pauseAnimation = (target) => Animations.pause(target);
export const playAnimation = (target) => Animations.play(target);
export { Animations };

