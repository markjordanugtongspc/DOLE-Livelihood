/**
 * START OF FILE: frontend/src/js/modules/auth.js
 * Purpose: Authentication controller handling phone formatting, PIN submission, login, and logout
 */

import { apiClient } from './api.js';
import { toast } from './toast.js';
import { modals } from './modals.js';
import { Animations } from './animations.js';

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

    this.setButtonState('loading');

    // Introduce a minimum delay for spinner visibility so UX feels intentional
    const minLoadingTime = new Promise((resolve) => setTimeout(resolve, 800));

    try {
      const payload = { pin };
      if (phoneRaw && phoneRaw.length >= 10) {
        payload.phone = phoneRaw;
      }

      const [response] = await Promise.all([
        apiClient.post('/api/auth/login', payload),
        minLoadingTime,
      ]);

      if (response && response.success) {
        this.playSuccessAudio();
        this.setButtonState('success', 'Verified');
        toast.show(response.message || 'Login successful! Redirecting...', 'success');
        const redirectUrl = response.data?.redirect_url || response.data?.redirect || './frontend/pages/dashboard/';
        setTimeout(() => {
          window.location.href = redirectUrl;
        }, 1400);
      } else {
        this.setButtonState('default');
        const errorMsg = response?.message || response?.error || 'Invalid credentials. Please verify your PIN.';
        toast.show(errorMsg, 'error');
        this.pinInput?.shake();
      }
    } catch (err) {
      this.setButtonState('default');
      toast.show(err.message || 'An error occurred during login. Please try again.', 'error');
      this.pinInput?.shake();
    }
  }
  // END OF FUNCTION: handleLogin

  /**
   * START OF FUNCTION: setButtonState
   * Purpose: Updates submit button with Flowbite loading spinner, success checkmark, or failure cross with smooth colors
   */
  setButtonState(state = 'default', text = '') {
    if (!this.submitBtn) return;

    // Apply color-filled background & border transitions via Animations module
    Animations.animateButtonFeedback(this.submitBtn, state);

    if (state === 'loading') {
      this.isSubmitting = true;
      this.submitBtn.disabled = true;
      this.submitBtn.innerHTML = `
        <div role="status" class="inline-flex items-center justify-center gap-2.5 transition-all duration-300">
          <svg aria-hidden="true" class="w-5 h-5 text-emerald-200/50 animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
          </svg>
          <span class="font-bold tracking-wide">Signing In...</span>
        </div>
      `;
    } else if (state === 'success') {
      this.isSubmitting = true;
      this.submitBtn.disabled = true;
      this.submitBtn.innerHTML = `
        <div class="inline-flex items-center justify-center gap-2 text-white transition-all duration-300">
          <svg class="w-6 h-6 shrink-0 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
          </svg>
          <span class="font-bold tracking-wide">${text || 'Verified'}</span>
        </div>
      `;
    } else if (state === 'error') {
      this.isSubmitting = false;
      this.submitBtn.disabled = false;
      this.submitBtn.innerHTML = `
        <div class="inline-flex items-center justify-center gap-2 text-white transition-all duration-300">
          <svg class="w-6 h-6 shrink-0 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="font-bold tracking-wide text-white">${text || 'Invalid PIN'}</span>
        </div>
      `;
    } else {
      this.isSubmitting = false;
      this.submitBtn.disabled = false;
      this.submitBtn.innerHTML = `<span>Sign In</span>`;
    }
  }

  /**
   * START OF FUNCTION: setLoading
   * Purpose: Backwards compatibility wrapper calling setButtonState
   */
  setLoading(isLoading) {
    this.setButtonState(isLoading ? 'loading' : 'default');
  }
  // END OF FUNCTION: setLoading

  /**
   * START OF FUNCTION: playSuccessAudio
   * Purpose: Plays success login audio chime at 100% volume
   */
  playSuccessAudio() {
    try {
      const baseUrl = apiClient.getBaseUrl ? apiClient.getBaseUrl() : '';
      const audioPath = `${baseUrl}/frontend/src/public/audio/login/login.mp3`;
      const audio = new Audio(audioPath);
      audio.volume = 1.0; // 100% volume
      audio.play().catch(() => {
        // Fallback for strict browser autoplay permissions
      });
    } catch (e) {
      // Graceful fallback if audio device not available
    }
  }
  // END OF FUNCTION: playSuccessAudio

  /**
   * START OF FUNCTION: bindLogoutButtons
   * Purpose: Attaches click handler to logout buttons across application
   */
  bindLogoutButtons() {
    const logoutBtns = document.querySelectorAll('[data-action="logout"]');
    logoutBtns.forEach((btn) => {
      btn.addEventListener('click', async (e) => {
        e.preventDefault();
        btn.disabled = true;

        // Resolve absolute project root URL (e.g. /DOLE-Livelihood/ or /)
        const baseUrl = apiClient.getBaseUrl ? apiClient.getBaseUrl() : '';
        const targetUrl = baseUrl ? `${baseUrl}/` : '/';

        try {
          const res = await apiClient.post('/api/auth/logout', {});
          toast.show('Logged out successfully.', 'info');
          const redirect = res?.data?.redirect_url || res?.data?.redirect || targetUrl;
          setTimeout(() => {
            window.location.href = redirect;
          }, 400);
        } catch (err) {
          setTimeout(() => {
            window.location.href = targetUrl;
          }, 400);
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
