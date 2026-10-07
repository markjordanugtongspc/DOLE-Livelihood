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
  } else if (page === 'proponent') {
    initProponentPage();
  }
}
// END OF FUNCTION: initApp

// START OF FUNCTION: initProponentPage
// Purpose: Sets up expandable sidebar, table search/filters, select-all checkboxes, and drawer registration
function initProponentPage() {
  if (document.getElementById('drawer-navigation')) {
    window.dilp.sidebar = new SidebarManager().init();
  }
  window.dilp.auth = new AuthController().init();

  // Initialize drawers
  let addProponentDrawer = null;
  if (document.getElementById('drawer-add-proponent')) {
    addProponentDrawer = new DrawerManager('drawer-add-proponent').init();
    window.dilp.addProponentDrawer = addProponentDrawer;
  }
  if (document.getElementById('app-drawer')) {
    window.dilp.drawer = new DrawerManager('app-drawer').init();
  }

  // Table Search Filter
  const searchInput = document.getElementById('proponent-table-search');
  const tableRows = document.querySelectorAll('.proponent-row');
  if (searchInput && tableRows.length) {
    searchInput.addEventListener('input', (e) => {
      const query = e.target.value.toLowerCase().trim();
      tableRows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
      });
    });
  }

  // Table Filter Dropdown
  const filterButtons = document.querySelectorAll('[data-filter-type]');
  if (filterButtons.length && tableRows.length) {
    filterButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const filterType = btn.getAttribute('data-filter-type');
        tableRows.forEach((row) => {
          const rowType = row.getAttribute('data-type');
          if (filterType === 'all' || rowType === filterType) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
        // Close dropdown menu if open
        const dropdownMenu = document.getElementById('dropdown-filter-menu');
        if (dropdownMenu) dropdownMenu.classList.add('hidden');
      });
    });
  }

  // Table Checkbox Select All Toggle
  const checkboxAll = document.getElementById('table-checkbox-all');
  const rowCheckboxes = document.querySelectorAll('.table-row-checkbox');
  if (checkboxAll && rowCheckboxes.length) {
    checkboxAll.addEventListener('change', () => {
      rowCheckboxes.forEach((cb) => {
        cb.checked = checkboxAll.checked;
      });
    });

    rowCheckboxes.forEach((cb) => {
      cb.addEventListener('change', () => {
        const allChecked = Array.from(rowCheckboxes).every((c) => c.checked);
        const someChecked = Array.from(rowCheckboxes).some((c) => c.checked);
        checkboxAll.checked = allChecked;
        checkboxAll.indeterminate = !allChecked && someChecked;
      });
    });
  }

  // Proponent Form Submission
  const proponentForm = document.getElementById('proponent-registration-form');
  if (proponentForm) {
    proponentForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const submitBtn = document.getElementById('proponent-submit-btn');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75');
      }
      setTimeout(() => {
        toast.show('Proponent record has been successfully registered!', 'success');
        proponentForm.reset();
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.classList.remove('opacity-75');
        }
        if (addProponentDrawer) {
          addProponentDrawer.hide();
        }
      }, 500);
    });
  }
}
// END OF FUNCTION: initProponentPage

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
  if (document.getElementById('dashboard-charts-container') || document.getElementById('chart-proponent-trend')) {
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
