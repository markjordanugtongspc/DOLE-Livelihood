/**
 * START OF FILE: frontend/src/js/main.js
 * Purpose: Application entry point bundling CSS, Flowbite, ApexCharts, and OOP page controllers
 */

import '@fontsource/poppins/400.css';
import '@fontsource/poppins/500.css';
import '@fontsource/poppins/600.css';
import '@fontsource/poppins/700.css';
import '../css/app.css';
import 'flowbite';

import { apiClient } from './modules/api.js';
import { toast } from './modules/toast.js';
import { modals } from './modules/modals.js';
import { LoginCarousel } from './modules/carousel.js';
import { PinInput } from './modules/pin.js';
import { OtpController } from './modules/otp.js';
import { AuthController } from './modules/auth.js';
import { DrawerManager } from './modules/drawer.js';
import { SidebarManager } from './modules/sidebar.js';
import { charts } from './modules/charts.js';

// START OF FUNCTION: initApp
// Purpose: Discovers active page from data-page attribute and initializes respective modules
function initApp() {
  const page = document.body.getAttribute('data-page') || 'login';

  // Initialize universal modules
  modals.init();

  // Expose global debug / helper registry
  window.dilp = {
    api: apiClient,
    toast: toast,
    modals: modals,
    charts: charts
  };

  if (page === 'login') {
    initLoginPage();
  } else if (page === 'dashboard') {
    initDashboardPage();
  }
}
// END OF FUNCTION: initApp

// START OF FUNCTION: initLoginPage
// Purpose: Sets up PIN keypad, login carousel, OTP controls, and login submission
function initLoginPage() {
  const carousel = new LoginCarousel('login-hero-carousel').init();
  const drawer = new DrawerManager('app-drawer').init();
  const otp = new OtpController().init();

  const pin = new PinInput({
    containerId: 'pin-container',
    hiddenInputId: 'login-form-pin-input',
    dotsContainerId: 'pin-dots',
    keypadId: 'pin-keypad',
    minLength: 4,
    maxLength: 6,
    onComplete: (pinValue) => {
      document.getElementById('login-form-submit-btn')?.focus();
    }
  }).init();

  const auth = new AuthController({
    formId: 'login-form',
    submitBtnId: 'login-form-submit-btn',
    pinInput: pin
  }).init();

  window.dilp.carousel = carousel;
  window.dilp.drawer = drawer;
  window.dilp.pin = pin;
  window.dilp.otp = otp;
  window.dilp.auth = auth;
}
// END OF FUNCTION: initLoginPage

// START OF FUNCTION: initDashboardPage
// Purpose: Sets up expandable sidebar, ApexCharts, and dashboard actions
function initDashboardPage() {
  const sidebar = new SidebarManager().init();
  const auth = new AuthController().init();
  const drawer = new DrawerManager('app-drawer').init();

  // Initialize charts after DOM layout settles
  setTimeout(() => {
    charts.init();
  }, 100);

  window.dilp.sidebar = sidebar;
  window.dilp.auth = auth;
  window.dilp.drawer = drawer;
}
// END OF FUNCTION: initDashboardPage

// Bootstrap once DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initApp);
} else {
  initApp();
}

/**
 * END OF FILE: frontend/src/js/main.js
 */
