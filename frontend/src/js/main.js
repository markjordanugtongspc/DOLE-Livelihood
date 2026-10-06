/**
 * START OF FILE: frontend/src/js/main.js
 * Purpose: Application entry point bundling CSS, Flowbite, ApexCharts, and OOP page controllers
 */

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

// START OF FUNCTION: ensureFavicon
// Purpose: Dynamically guarantees favicon link tags exist and point to valid favicon.png
function ensureFavicon() {
  const existingIcon = document.querySelector("link[rel*='icon']");
  if (!existingIcon) {
    const link = document.createElement('link');
    link.type = 'image/png';
    link.rel = 'shortcut icon';
    link.href = `${window.location.origin}/DOLE-Livelihood/frontend/src/public/images/icons/favicon.png`;
    document.head.appendChild(link);
  }
}
// END OF FUNCTION: ensureFavicon

// START OF FUNCTION: initApp
// Purpose: Discovers active page from data-page attribute and initializes respective modules
function initApp() {
  ensureFavicon();
  const pageRoot = document.querySelector('[data-page]');
  const page = pageRoot ? pageRoot.getAttribute('data-page') : (document.body.getAttribute('data-page') || 'login');

  // Initialize universal modules only when matching elements exist in DOM
  if (document.getElementById('app-modal') || document.querySelector('[data-modal-target]')) {
    modals.init();
  }

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
  if (document.getElementById('login-hero-carousel')) {
    window.dilp.carousel = new LoginCarousel('login-hero-carousel').init();
  }
  if (document.getElementById('app-drawer')) {
    window.dilp.drawer = new DrawerManager('app-drawer').init();
  }
  if (document.getElementById('login-form-otp-group')) {
    window.dilp.otp = new OtpController().init();
  }

  const pinGroup = document.getElementById('login-form-pin-group');
  let pin = null;
  if (pinGroup) {
    pin = new PinInput({
      containerId: 'login-form-pin-group',
      hiddenInputId: 'login-form-pin-input',
      dotsContainerId: 'pin-dots',
      minLength: 4,
      maxLength: 6,
      onComplete: () => {
        document.getElementById('login-form-submit-btn')?.focus();
      }
    }).init();
    window.dilp.pin = pin;
  }

  if (document.getElementById('login-form')) {
    window.dilp.auth = new AuthController({
      formId: 'login-form',
      submitBtnId: 'login-form-submit-btn',
      pinInput: pin
    }).init();
  }
}
// END OF FUNCTION: initLoginPage

// START OF FUNCTION: initDashboardPage
// Purpose: Sets up expandable sidebar, ApexCharts, and dashboard actions
function initDashboardPage() {
  if (document.getElementById('drawer-navigation')) {
    window.dilp.sidebar = new SidebarManager().init();
  }
  window.dilp.auth = new AuthController().init();

  if (document.getElementById('app-drawer')) {
    window.dilp.drawer = new DrawerManager('app-drawer').init();
  }

  // Initialize charts after DOM layout settles
  if (document.getElementById('dashboard-charts-container') || document.getElementById('chart-beneficiaries-trend')) {
    setTimeout(() => {
      charts.init();
    }, 100);
  }
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
