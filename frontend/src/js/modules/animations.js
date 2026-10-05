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
  /* END: setLoading */
}
/* END: Animations */

export const shakeElement = (el) => Animations.shake(el);
export const setButtonLoading = (btn, isLoading, text) => Animations.setLoading(btn, isLoading, text);
export { Animations };

