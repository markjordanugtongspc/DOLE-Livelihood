/**
 * START OF FILE: frontend/src/js/modules/auth.js
 * Purpose: Authentication controller handling phone formatting, PIN submission, login, and logout
 */

import { apiClient } from './api.js';
import { toast } from './toast.js';
import { modals } from './modals.js';

// START OF CLASS: AuthController - Manages login form and user authentication
export class AuthController {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes form element references and dependencies
   */
  constructor(options = {}) {
    this.formId = options.formId || 'login-form';
    this.phoneInputId = options.phoneInputId || 'login-form-phone-input';
    this.submitBtnId = options.submitBtnId || 'login-form-submit-btn';
    this.pinInput = options.pinInput || null;

    this.form = document.getElementById(this.formId);
    this.phoneInput = document.getElementById(this.phoneInputId);
    this.submitBtn = document.getElementById(this.submitBtnId);
    this.isSubmitting = false;
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Sets up phone formatting, form submission, view switching, and logout handlers
   */
  init() {
    this.bindViewSwitcher();
    this.bindPhoneInput();
    this.bindFormSubmit();
    this.bindOtpVerification();
    this.bindLogoutButtons();
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: bindViewSwitcher
   * Purpose: Handles seamless switching between method selection, PIN keypad form, and OTP form
   */
  bindViewSwitcher() {
    const viewSelection = document.getElementById('login-view-selection');
    const viewPin = document.getElementById('login-view-pin');
    const viewOtp = document.getElementById('login-view-otp');
    const btnChoicePin = document.getElementById('login-btn-choice-pin');
    const btnChoiceOtp = document.getElementById('login-btn-choice-otp');
    const backButtons = document.querySelectorAll('.login-btn-back');

    if (btnChoicePin) {
      btnChoicePin.addEventListener('click', (e) => {
        e.preventDefault();
        if (viewSelection) viewSelection.classList.add('hidden');
        if (viewOtp) viewOtp.classList.add('hidden');
        if (viewPin) {
          viewPin.classList.remove('hidden');
          if (this.pinInput) {
            this.pinInput.init();
          }
          const phoneInput = document.getElementById('login-form-phone-input');
          if (phoneInput && !phoneInput.value) {
            phoneInput.focus();
          }
        }
      });
    }

    if (btnChoiceOtp) {
      btnChoiceOtp.addEventListener('click', (e) => {
        e.preventDefault();
        if (viewSelection) viewSelection.classList.add('hidden');
        if (viewPin) viewPin.classList.add('hidden');
        if (viewOtp) {
          viewOtp.classList.remove('hidden');
          const otpPhoneInput = document.getElementById('otp-phone-input');
          if (otpPhoneInput && !otpPhoneInput.value) {
            otpPhoneInput.focus();
          }
        }
      });
    }

    backButtons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        if (viewPin) viewPin.classList.add('hidden');
        if (viewOtp) viewOtp.classList.add('hidden');
        if (viewSelection) viewSelection.classList.remove('hidden');
      });
    });
  }
  // END OF FUNCTION: bindViewSwitcher

  /**
   * START OF FUNCTION: bindPhoneInput
   * Purpose: Auto-formats Philippine mobile numbers (e.g. 0917 123 4567)
   */
  bindPhoneInput() {
    const formatPhone = (inputEl) => {
      if (!inputEl) return;
      inputEl.addEventListener('input', (e) => {
        let val = e.target.value.replace(/\D/g, '');
        if (val.startsWith('63')) {
          val = '0' + val.substring(2);
        }
        if (val.length > 11) {
          val = val.substring(0, 11);
        }

        // Format as 09XX 123 4567
        let formatted = val;
        if (val.length > 4 && val.length <= 7) {
          formatted = `${val.slice(0, 4)} ${val.slice(4)}`;
        } else if (val.length > 7) {
          formatted = `${val.slice(0, 4)} ${val.slice(4, 7)} ${val.slice(7)}`;
        }

        e.target.value = formatted;
      });
    };

    formatPhone(this.phoneInput);
    formatPhone(document.getElementById('otp-phone-input'));
  }
  // END OF FUNCTION: bindPhoneInput

  /**
   * START OF FUNCTION: bindFormSubmit
   * Purpose: Intercepts form submission and sends payload to login API
   */
  bindFormSubmit() {
    if (!this.form) return;

    this.form.addEventListener('submit', async (e) => {
      e.preventDefault();
      await this.handleLogin();
    });
  }
  // END OF FUNCTION: bindFormSubmit

  /**
   * START OF FUNCTION: bindOtpVerification
   * Purpose: Handles OTP SMS request and OTP verification submission
   */
  bindOtpVerification() {
    const otpRequestBtn = document.getElementById('otp-request-btn');
    const otpVerifyBtn = document.getElementById('otp-verify-submit-btn');
    const otpPhoneInput = document.getElementById('otp-phone-input');
    const otpCodeInput = document.getElementById('otp-code-input');
    const otpCodeSection = document.getElementById('otp-code-section');

    if (otpRequestBtn) {
      otpRequestBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        const phoneRaw = otpPhoneInput ? otpPhoneInput.value.replace(/\s+/g, '') : '';
        if (!phoneRaw || phoneRaw.length < 10) {
          toast.show('Please enter a valid mobile number (e.g. 09171234567)', 'warning');
          otpPhoneInput?.focus();
          return;
        }

        otpRequestBtn.disabled = true;
        otpRequestBtn.classList.add('opacity-75');
        otpRequestBtn.textContent = 'Sending OTP...';

        try {
          const res = await apiClient.post('/api/auth/otp/send', { phone: phoneRaw });
          if (res && res.success) {
            toast.show(res.message || 'OTP verification code sent!', 'success');
            if (otpCodeSection) {
              otpCodeSection.classList.remove('hidden');
            }
            if (otpCodeInput) {
              otpCodeInput.focus();
            }
          } else {
            toast.show(res?.error || 'Failed to send OTP code.', 'error');
          }
        } catch (err) {
          toast.show(err.message || 'Error requesting OTP.', 'error');
        } finally {
          otpRequestBtn.disabled = false;
          otpRequestBtn.classList.remove('opacity-75');
          otpRequestBtn.textContent = 'Send Verification Code (SMS)';
        }
      });
    }

    if (otpVerifyBtn) {
      otpVerifyBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        const phoneRaw = otpPhoneInput ? otpPhoneInput.value.replace(/\s+/g, '') : '';
        const code = otpCodeInput ? otpCodeInput.value.trim() : '';

        if (!code || code.length < 4) {
          toast.show('Please enter the 6-digit verification code.', 'warning');
          otpCodeInput?.focus();
          return;
        }

        otpVerifyBtn.disabled = true;
        otpVerifyBtn.classList.add('opacity-75');
        otpVerifyBtn.textContent = 'Verifying...';

        try {
          const res = await apiClient.post('/api/auth/otp/verify', { phone: phoneRaw, code });
          if (res && res.success) {
            toast.show('Verification successful! Redirecting...', 'success');
            setTimeout(() => {
              window.location.href = res.data?.redirect_url || '/dashboard/';
            }, 600);
          } else {
            toast.show(res?.error || 'Invalid or expired OTP code.', 'error');
          }
        } catch (err) {
          toast.show(err.message || 'Error verifying OTP code.', 'error');
        } finally {
          otpVerifyBtn.disabled = false;
          otpVerifyBtn.classList.remove('opacity-75');
          otpVerifyBtn.textContent = 'Verify & Sign In';
        }
      });
    }
  }
  // END OF FUNCTION: bindOtpVerification

  /**
   * START OF FUNCTION: handleLogin
   * Purpose: Validates input, sends POST to /api/auth/login, redirects on success
   */
  async handleLogin() {
    if (this.isSubmitting) return;

    const phoneRaw = this.phoneInput ? this.phoneInput.value.replace(/\s+/g, '') : '';
    const pin = this.pinInput ? this.pinInput.getValue() : '';

    if (!pin || pin.length < 4) {
      toast.show('Please enter your 4 to 6 digit security PIN', 'warning');
      this.pinInput?.shake();
      return;
    }

    this.setLoading(true);

    try {
      const payload = { pin };
      if (phoneRaw && phoneRaw.length >= 10) {
        payload.phone = phoneRaw;
      }

      const response = await apiClient.post('/api/auth/login', payload);

      if (response && response.success) {
        toast.show(response.message || 'Login successful! Redirecting...', 'success');
        const redirectUrl = response.data?.redirect_url || '/dashboard/';
        setTimeout(() => {
          window.location.href = redirectUrl;
        }, 600);
      } else {
        const errorMsg = response?.error || 'Invalid credentials. Please verify your PIN.';
        toast.show(errorMsg, 'error');
        this.pinInput?.shake();
      }
    } catch (err) {
      toast.show(err.message || 'An error occurred during login. Please try again.', 'error');
      this.pinInput?.shake();
    } finally {
      this.setLoading(false);
    }
  }
  // END OF FUNCTION: handleLogin

  /**
   * START OF FUNCTION: setLoading
   * Purpose: Toggles submit button loading state and spinner
   */
  setLoading(isLoading) {
    this.isSubmitting = isLoading;
    if (!this.submitBtn) return;

    if (isLoading) {
      this.submitBtn.disabled = true;
      this.submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Signing in...</span>
      `;
      this.submitBtn.classList.add('opacity-75');
    } else {
      this.submitBtn.disabled = false;
      this.submitBtn.innerHTML = `<span>Sign In</span>`;
      this.submitBtn.classList.remove('opacity-75');
    }
  }
  // END OF FUNCTION: setLoading

  /**
   * START OF FUNCTION: bindLogoutButtons
   * Purpose: Attaches click handler to logout buttons across application
   */
  bindLogoutButtons() {
    const logoutBtns = document.querySelectorAll('[data-action="logout"]');
    logoutBtns.forEach((btn) => {
      btn.addEventListener('click', async (e) => {
        e.preventDefault();
        try {
          await apiClient.post('/api/auth/logout', {});
          toast.show('Logged out successfully.', 'info');
          setTimeout(() => {
            window.location.href = '/';
          }, 400);
        } catch (err) {
          window.location.href = '/';
        }
      });
    });
  }
  // END OF FUNCTION: bindLogoutButtons
}
// END OF CLASS: AuthController

/**
 * END OF FILE: frontend/src/js/modules/auth.js
 */
