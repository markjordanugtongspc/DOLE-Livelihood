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

  // START OF SUBCHILD: Flowbite Searchable Dropdowns Handler for Add Proponent Drawer
  const setupSearchableDropdown = (searchId, listId, hiddenInputId, labelId, dropdownMenuId, buttonId) => {
    const searchInput = document.getElementById(searchId);
    const listEl = document.getElementById(listId);
    const hiddenInput = document.getElementById(hiddenInputId);
    const labelEl = document.getElementById(labelId);
    const dropdownMenu = document.getElementById(dropdownMenuId);
    const buttonEl = document.getElementById(buttonId);

    if (!listEl || !hiddenInput || !labelEl) return;

    // Dynamically match dropdown menu width to the button trigger width
    const syncMenuWidth = () => {
      if (buttonEl && dropdownMenu) {
        const btnWidth = buttonEl.getBoundingClientRect().width;
        if (btnWidth > 0) {
          dropdownMenu.style.width = `${btnWidth}px`;
          dropdownMenu.style.minWidth = `${btnWidth}px`;
        }
      }
    };

    if (buttonEl) {
      buttonEl.addEventListener('click', () => {
        syncMenuWidth();
        // Focus search input on open
        setTimeout(() => {
          if (searchInput && !dropdownMenu.classList.contains('hidden')) {
            searchInput.focus();
          }
        }, 50);
      });
      window.addEventListener('resize', syncMenuWidth);
    }

    // Filter list options on search typing
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        const optionButtons = listEl.querySelectorAll('button[data-value]');
        let matchFound = false;

        optionButtons.forEach((btn) => {
          const text = btn.textContent.toLowerCase();
          if (text.includes(query)) {
            btn.parentElement.style.display = '';
            matchFound = true;
          } else {
            btn.parentElement.style.display = 'none';
          }
        });

        // Allow pressing Enter or typing custom value
        if (query && !matchFound) {
          hiddenInput.value = e.target.value;
          labelEl.textContent = e.target.value;
        }
      });

      searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault();
          if (searchInput.value.trim()) {
            hiddenInput.value = searchInput.value.trim();
            labelEl.textContent = searchInput.value.trim();
            if (dropdownMenu) dropdownMenu.classList.add('hidden');
          }
        }
      });
    }

    // Select option on button click
    listEl.querySelectorAll('button[data-value]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const val = btn.getAttribute('data-value');
        hiddenInput.value = val;
        labelEl.textContent = val;
        if (dropdownMenu) dropdownMenu.classList.add('hidden');
      });
    });
  };

  setupSearchableDropdown('search-beneficiary', 'beneficiary-options-list', 'proponent-beneficiary-type', 'selected-beneficiary-label', 'dropdownBeneficiaryMenu', 'dropdownBeneficiaryBtn');
  setupSearchableDropdown('search-project-type', 'project-type-options-list', 'proponent-project-type', 'selected-project-type-label', 'dropdownProjectTypeMenu', 'dropdownProjectTypeBtn');
  setupSearchableDropdown('search-status', 'status-options-list', 'proponent-status-text', 'selected-status-label', 'dropdownStatusMenu', 'dropdownStatusBtn');
  setupSearchableDropdown('search-evaluator', 'evaluator-options-list', 'proponent-evaluator-name', 'selected-evaluator-label', 'dropdownEvaluatorMenu', 'dropdownEvaluatorBtn');
  // END OF SUBCHILD: Flowbite Searchable Dropdowns Handler

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
// Purpose: Sets up expandable sidebar, ApexCharts, gender KPI card breakdown dropdowns, and dashboard actions
function initDashboardPage() {
  if (document.getElementById('drawer-navigation')) {
    window.dilp.sidebar = new SidebarManager().init();
  }
  window.dilp.auth = new AuthController().init();

  if (document.getElementById('app-drawer')) {
    window.dilp.drawer = new DrawerManager('app-drawer').init();
  }

  // Handle Male and Female KPI category dropdown filters (General / SR / PWD)
  document.querySelectorAll('[data-filter-gender]').forEach((item) => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
      const gender = item.getAttribute('data-filter-gender');
      const label = item.getAttribute('data-label');
      const val = item.getAttribute('data-val');
      const pct = item.getAttribute('data-pct');

      const titleEl = document.getElementById(`dashboard-kpi-${gender}-title`);
      const valEl = document.getElementById(`dashboard-kpi-${gender}-val`);
      const pctEl = document.getElementById(`dashboard-kpi-${gender}-pct`);
      const selectedLabelEl = document.getElementById(`dashboard-kpi-${gender}-selected-label`);
      const dropdownEl = document.getElementById(`dashboard-kpi-${gender}-dropdown`);

      if (titleEl) titleEl.textContent = label;
      if (valEl) valEl.textContent = val;
      if (pctEl) pctEl.textContent = pct;
      if (selectedLabelEl) selectedLabelEl.textContent = label;

      // Close dropdown
      if (dropdownEl) {
        dropdownEl.classList.add('hidden');
      }
    });
  });

  // Global click to dismiss KPI dropdowns when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('#dashboard-kpi-male-dropdown') && !e.target.closest('#dashboard-kpi-male-filter-btn')) {
      document.getElementById('dashboard-kpi-male-dropdown')?.classList.add('hidden');
    }
    if (!e.target.closest('#dashboard-kpi-female-dropdown') && !e.target.closest('#dashboard-kpi-female-filter-btn')) {
      document.getElementById('dashboard-kpi-female-dropdown')?.classList.add('hidden');
    }
  });

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
