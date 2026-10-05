/**
 * START OF FILE: frontend/src/js/modules/otp.js
 * Purpose: Manages SMS OTP request countdown timer, input slots, and resend mechanics
 */

import { apiClient } from './api.js';

// START OF CLASS: OtpController - Controls OTP timer and verification flow
export class OtpController {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes OTP timer state and DOM element references
   */
  constructor(options = {}) {
    this.timerElementId = options.timerElementId || 'otp-countdown-timer';
    this.resendButtonId = options.resendButtonId || 'otp-resend-btn';
    this.phoneInputId = options.phoneInputId || 'login-form-phone-input';
    this.countdownSeconds = options.countdownSeconds || 60;
    this.remainingSeconds = 0;
    this.timerInterval = null;

    this.timerEl = document.getElementById(this.timerElementId);
    this.resendBtn = document.getElementById(this.resendButtonId);
    this.phoneInput = document.getElementById(this.phoneInputId);
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Binds resend button event and sets initial UI state
   */
  init() {
    if (this.resendBtn) {
      this.resendBtn.addEventListener('click', (e) => {
        e.preventDefault();
        this.requestOtp();
      });
    }
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: startTimer
   * Purpose: Starts countdown timer for OTP resend cooldown
   */
  startTimer(seconds = this.countdownSeconds) {
    this.remainingSeconds = seconds;
    this.updateTimerUI();

    if (this.resendBtn) {
      this.resendBtn.disabled = true;
      this.resendBtn.classList.add('opacity-50', 'cursor-not-allowed');
      this.resendBtn.classList.remove('cursor-pointer');
    }

    if (this.timerInterval) {
      clearInterval(this.timerInterval);
    }

    this.timerInterval = setInterval(() => {
      this.remainingSeconds--;
      this.updateTimerUI();

      if (this.remainingSeconds <= 0) {
        this.stopTimer();
      }
    }, 1000);
  }
  // END OF FUNCTION: startTimer

  /**
   * START OF FUNCTION: stopTimer
   * Purpose: Stops countdown timer and re-enables resend button
   */
  stopTimer() {
    if (this.timerInterval) {
      clearInterval(this.timerInterval);
      this.timerInterval = null;
    }

    if (this.resendBtn) {
      this.resendBtn.disabled = false;
      this.resendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
      this.resendBtn.classList.add('cursor-pointer');
    }

    if (this.timerEl) {
      this.timerEl.textContent = 'Resend available';
    }
  }
  // END OF FUNCTION: stopTimer

  /**
   * START OF FUNCTION: updateTimerUI
   * Purpose: Formats remaining seconds to mm:ss display
   */
  updateTimerUI() {
    if (!this.timerEl) return;
    const mins = Math.floor(this.remainingSeconds / 60);
    const secs = this.remainingSeconds % 60;
    this.timerEl.textContent = `Resend in ${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
  }
  // END OF FUNCTION: updateTimerUI

  /**
   * START OF FUNCTION: requestOtp
   * Purpose: Calls backend OTP send API for the current phone number
   */
  async requestOtp() {
    const phone = this.phoneInput ? this.phoneInput.value.trim() : '';
    if (!phone) {
      return { success: false, message: 'Please enter a valid phone number.' };
    }

    try {
      const response = await apiClient.post('/api/auth/otp/send', { phone });
      if (response && response.success) {
        this.startTimer(response.data?.expires_in || 60);
        return { success: true, message: response.message || 'OTP sent successfully.' };
      }
      return { success: false, message: response?.error || 'Failed to send OTP.' };
    } catch (err) {
      return { success: false, message: err.message || 'Network error while requesting OTP.' };
    }
  }
  // END OF FUNCTION: requestOtp
}
// END OF CLASS: OtpController

/**
 * END OF FILE: frontend/src/js/modules/otp.js
 */
