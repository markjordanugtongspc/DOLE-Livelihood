# <!-- START OF FILE: DEV_LOGS.md -->
# DILP Development Logs & Change History

## Overview of Recent Updates & Refactoring

---

### 1. Authentication & Session Routing
- **Dynamic Logout Redirection**:
  - Refactored `AuthController.php` (`/api/auth/logout`) and `auth.js` (`bindLogoutButtons`) to dynamically resolve the base URL path (`/DOLE-Livelihood/` or `/`) via `Vite::getBaseDir()` and `apiClient.getBaseUrl()`.
  - Resolves localhost subdirectory routing issues on Laragon, properly returning logged-out users to `http://localhost/DOLE-Livelihood/` (login entrypoint).

---

### 2. Dashboard Sidebar Navigation & Layout
- **Toggle Button Visibility & Positioning**:
  - Removed `overflow-y-auto` from root `<aside id="drawer-navigation">` and replaced with `overflow-visible` to prevent clipping and eliminate horizontal scrollbars.
  - Repositioned `#sidebar-toggle-btn` to `top-3 -right-3.5 z-[70]`, floating directly on top of the sidebar-content boundary.
- **Brand Logo Centering**:
  - Added `#sidebar-brand-wrapper` and `#sidebar-brand-link` with automated flex centering (`justify-center w-full`) in `sidebar.js` when the sidebar is in collapsed state (`w-20`), restoring left-aligned layout when expanded (`w-72`).
- **Tree-Branch Submenu Design**:
  - Implemented a structured tree-branch hierarchy for `#dropdown-beneficiaries`:
    - Vertical spine guideline (`border-l-2 border-stone-200 dark:border-slate-700/80`)
    - Horizontal branch connector lines (`w-2.5 h-0.5 bg-stone-200 dark:bg-slate-700/80`)
    - Interactive node bullets transitioning to emerald green on hover.
    - Added `data-sidebar-label` to cleanly hide submenu branches in collapsed rail mode.

---

### 3. OOP ApexCharts Module Architecture
- **Extraction from Dashboard View**:
  - Removed static chart card markup from `frontend/pages/dashboard/index.php` and replaced with mount container `<div id="dashboard-charts-container"></div>`.
- **OOP Hierarchy in `charts.js`**:
  - **`BaseChart` (Parent)**: Provides card shell rendering (`mountCard`), lifecycle management (`render`, `destroy`, `resize`, `update`), and container registration.
  - **`BeneficiariesTrendChart` (Subchild 1)**: Generates 2-column card markup and renders monthly beneficiaries area chart with smooth emerald gradients and 100% responsive width.
  - **`CategoryDistributionChart` (Subchild 2)**: Generates 1-column card markup and renders project categories donut chart with corrected sizing, center label metrics, and non-overlapping bottom legends.
  - **`ChartManager`**: Coordinates grid generation and lifecycle of all subchild chart instances.
- **Responsive Auto-Redraw**:
  - Integrated `requestAnimationFrame` resize dispatch during mount and after sidebar collapse/expand transitions (`toggleCollapse`), eliminating squished/cut-off chart canvas bugs.

---

### 4. Build System, Automation & QA
- **Automated QA Suite (`scripts/qa.js`)**:
  - Verified 100% compliance across PHP syntax linting, Rule #9 START/END comments, Rule #3 `cursor-pointer` checks, and Flowbite modal integration across 47 source files.
- **Portable Build Workflow (`scripts/build.js`)**:
  - Updated production Vite compilation to use localized `node_modules/vite/bin/vite.js` directly with active Node executable, supporting portable execution across Laragon and Windows environments.
- **Version Bump**: Incrementing project build to `v1.0.63`.

<!-- END OF FILE: DEV_LOGS.md -->
