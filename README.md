# DOLE Integrated Livelihood System (DILP) Management Information System


> Official web portal for the Department of Labor and Employment (DOLE) – Bureau of Workers with Special Concerns (BWSC) Kabuhayan System.

---

## 📌 Table of Contents
1. [Overview & Tech Stack](#overview--tech-stack)
2. [Folder & Directory Structure](#folder--directory-structure)
3. [Prerequisites & System Requirements](#prerequisites--system-requirements)
4. [Installation & Setup](#installation--setup)
5. [Database Setup & Seeded Credentials](#database-setup--seeded-credentials)
6. [Running the Application](#running-the-application)
7. [Automated Build & QA Pipeline](#automated-build--qa-pipeline)
8. [API Endpoints Reference](#api-endpoints-reference)
9. [Development Rules & Architectural Standards](#development-rules--architectural-standards)

---

## 🚀 Overview & Tech Stack

The DILP Management System is an enterprise-grade government portal designed to manage community livelihood grants, beneficiary tracking, and fund allocations across regional field offices.

- **Backend:** PHP 8.2+ OOP Architecture (PSR-4 `App\` namespace, PDO MySQL, CSRF protection, Session authentication guards, Activity logging, Pluggable SMS OTP and Supabase SSO interfaces).
- **Database:** MySQL 8.4.3 / MariaDB via Laragon (`127.0.0.1:3306`, Database: `livelihood_db`).
- **Frontend Core:** Vite 8.3+ bundling with vanilla JavaScript OOP modules.
- **Styling:** Tailwind CSS v4.2+ featuring responsive layout utilities, semantic color tokens (Forest Green `#237D2C`, Sunflower `#F29C38`, Deep Slate, Paper White), and Acer laptop (1080p @ 125% DPI scale / 1366x768 / 1536x864) optimizations.
- **UI Components:** Flowbite v4.0.2 (Drawers, Modals via `modals.js`, Dropdowns, Tabs, Carousels).
- **Data Visualization:** ApexCharts 3.46.0 (Monthly proponent trend area chart and livelihood project categories donut chart).

---

## 📂 Folder & Directory Structure

```text
c:\laragon\www\Livelihood\
├── backend/                        # PHP 8.2+ OOP Application Core
│   ├── api/                        # API Entry point
│   │   └── index.php               # Front controller routing /api/* requests
│   ├── controllers/                # Request Controllers
│   │   ├── BaseController.php      # JSON response helpers & CSRF verification
│   │   └── AuthController.php      # Login, PIN auth, OTP, and session management
│   ├── core/                       # Framework Primitives
│   │   ├── Database.php            # Singleton PDO database connector
│   │   ├── Session.php             # Secure session management & regeneration
│   │   ├── Csrf.php                # Anti-CSRF token generator & validator
│   │   ├── Request.php             # HTTP request parser (JSON body, headers, queries)
│   │   ├── Response.php            # Standardized JSON response emitter
│   │   ├── Router.php              # Lightweight regex route dispatcher
│   │   └── Vite.php                # Vite manifest asset resolver (dev vs production)
│   ├── middleware/                 # Route & Page Guards
│   │   ├── AuthGuard.php           # Enforces active user session
│   │   └── RoleGuard.php           # Enforces role permissions (e.g. admin)
│   ├── models/                     # Eloquent-style Active Record Models
│   │   ├── BaseModel.php           # PDO query builder & CRUD abstractions
│   │   ├── User.php                # User entity & credentials
│   │   ├── Role.php                # System roles & permissions
│   │   └── ActivityLog.php         # Audit trail and event logger
│   ├── routes/                     # Route Definitions
│   │   └── api.php                 # Registered RESTful endpoints
│   ├── services/                   # Business Logic & Integrations
│   │   ├── AuthService.php         # Authentication and session handling
│   │   ├── PhoneService.php        # Philippine mobile number normalization (09XX)
│   │   ├── ActivityLogger.php      # Audit logging to activity_logs table
│   │   ├── OtpService.php          # 6-digit OTP generation and expiry checking
│   │   ├── sms/                    # SMS Gateway drivers (Interface & Mock API)
│   │   └── sso/                    # Supabase SSO adapter for cloud sync
│   └── bootstrap.php               # Environment loader, DB init, & timezone config
│
├── config/                         # Configuration Files
│   └── database.php                # Laragon MySQL connection credentials
│
├── database/                       # Database Migrations & Seeds
│   ├── migrations/                 # Sequential SQL schemas
│   │   ├── 001_create_roles_table.sql
│   │   ├── 002_create_users_table.sql
│   │   ├── 003_create_activity_logs_table.sql
│   │   └── 004_create_otp_codes_table.sql
│   ├── migrate.php                 # CLI migration runner
│   └── seed.php                    # CLI database seeder (seeds Admin ID 0)
│
├── frontend/                       # User Interface Presentation Layer
│   ├── components/                 # Reusable PHP UI Partials
│   │   ├── head.php                # HTML <head>, meta tags, and Vite assets
│   │   ├── scripts.php             # Vite JS script bundles
│   │   ├── logo.php                # DOLE DILP brand logo component
│   │   ├── login-carousel.php      # Hero slider with 4 livelihood slides
│   │   ├── pin-pad.php             # On-screen 4-6 digit keypad & dot slots
│   │   ├── drawer-help.php         # Flowbite off-canvas help drawer
│   │   ├── toast.php               # Toast notification container
│   │   ├── modal-alert.php         # Flowbite alert/confirmation dialog (Rule #4)
│   │   └── sidebar.php             # Expandable/collapsible dashboard sidebar
│   ├── pages/                      # Application Page Views
│   │   ├── login/                  # Login landing page
│   │   │   └── index.php           # Split hero carousel + PIN card
│   │   └── dashboard/              # Protected management portal
│   │       └── index.php           # KPIs, ApexCharts, & application tables
│   └── src/                        # Frontend Assets Source
│       ├── css/                    # Modular Tailwind v4.2 CSS
│       │   ├── base/               # theme.css & typography.css
│       │   ├── components/         # pin-pad.css, carousel.css, sidebar.css
│       │   ├── pages/              # login.css, dashboard.css
│       │   ├── utilities/          # custom.css (@utility pin-dot, card-elevated)
│       │   └── app.css             # Main stylesheet importing Tailwind v4
│       ├── js/                     # Object-Oriented ES6 Modules
│       │   ├── modules/            # Isolated OOP classes
│       │   │   ├── api.js          # Fetch wrapper with CSRF & error handling
│       │   │   ├── animations.js   # Keypad press & shake micro-animations
│       │   │   ├── carousel.js     # LoginCarousel class
│       │   │   ├── pin.js          # PinInput class (keypad, dots, visibility)
│       │   │   ├── otp.js          # OtpController class (cooldown timer)
│       │   │   ├── drawer.js       # DrawerManager class (Flowbite Drawer)
│       │   │   ├── toast.js        # ToastManager class (alert notifications)
│       │   │   ├── modals.js       # ModalManager class (Flowbite Modal - Rule #4)
│       │   │   ├── auth.js         # AuthController class (login & logout)
│       │   │   ├── sidebar.js      # SidebarManager class (collapse & storage)
│       │   │   └── charts.js       # ChartManager class (ApexCharts instances)
│       │   └── main.js             # Application entry point & router
│       └── public/                 # Static Assets
│           └── images/             # Carousel slides and official logo
│
├── scripts/                        # Automation & Build Scripts
│   ├── backup.js                   # Git stash automated snapshot (Rule #8)
│   ├── qa.js                       # Pre-build QA test suite (Rule #3, #4, #7, #9)
│   ├── version.js                  # Semantic version bumper (Rule #10)
│   └── build.js                    # Master build pipeline runner
│
├── tests/                          # Test Suites
│   └── js/                         # JavaScript Unit Tests
│       └── pin.test.js             # Vitest test suite for PIN & phone formats
│
├── .htaccess                       # Apache URL rewriting & security rules
├── composer.json                   # PHP dependencies & PSR-4 autoloader
├── package.json                    # NPM dependencies, scripts, & version tracking
├── vite.config.js                  # Vite configuration & asset output
└── index.php                       # Root entry point delegating to login
```

---

## ⚙️ Prerequisites & System Requirements

- **Laragon:** Full or WAMP stack with Apache / Nginx and MySQL 8.0+.
- **PHP:** Version 8.2 or 8.3+ with `pdo_mysql`, `mbstring`, `zip`, `openssl` enabled.
- **Node.js:** v18+ (tested on Node v24.7.0 and npm 11.12.1).
- **Composer:** v2.x.
- **Git:** Installed and available in PATH.

---

## 🛠️ Installation & Setup

1. **Clone or Navigate to the Workspace:**
   ```powershell
   cd c:\laragon\www\Livelihood
   ```

2. **Install PHP Dependencies:**
   ```powershell
   composer install
   ```

3. **Install Node.js Dependencies:**
   ```powershell
   npm install
   ```

4. **Environment File Configuration:**
   Create a `.env` file in the root directory (or use default Laragon settings):
   ```ini
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost/Livelihood

   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=livelihood_db
   DB_USERNAME=root
   DB_PASSWORD=

   SESSION_LIFETIME=7200
   ```

---

## 🗄️ Database Setup & Seeded Credentials

1. **Run Migrations:**
   Creates tables `roles`, `users`, `activity_logs`, and `otp_codes`:
   ```powershell
   php database/migrate.php
   ```

2. **Run Seeder:**
   Seeds the Administrator role and default Admin user:
   ```powershell
   php database/seed.php
   ```

### 🔑 Default Credentials (Laragon MySQL)
- **Role:** Administrator (DILP System Admin)
- **Mobile Number:** `0917 123 4567` (or `09171234567` / `+639171234567`)
- **Security PIN:** `1234`
- **User ID:** `0` (Configured with `NO_AUTO_VALUE_ON_ZERO`)

---

## 💻 Running the Application

### Option A: Using Laragon Apache (Recommended for Production / Staging)
1. Start Laragon services (Apache + MySQL).
2. Open your web browser and visit:
   - **Login Page:** [http://localhost/Livelihood/](http://localhost/Livelihood/)
   - **Dashboard Page:** [http://localhost/Livelihood/dashboard/](http://localhost/Livelihood/dashboard/)

### Option B: Using Vite Development Server (Hot Reloading for CSS / JS)
1. In a terminal, run:
   ```powershell
   npm run dev
   ```
2. Vite will serve assets on `http://localhost:5173`. When running, `backend/core/Vite.php` automatically connects to the Vite HMR server!

---

## 🏗️ Automated Build & QA Pipeline

Per project specifications and User Rule #10, the build command executes an end-to-end QA pipeline:

```powershell
npm run build
```

This single command automatically:
1. **Creates a Pre-Build Git Stash Backup** (safeguarding your work per Rule #8).
2. **Runs Automated QA Suite (`scripts/qa.js`):**
   - Remote git fetch check (Rule #7).
   - PHP syntax lint on all project files via `php -l`.
   - Checks presence of `START` and `END` comments (Rule #9).
   - Verifies `cursor-pointer` on clickable buttons and links (Rule #3).
   - Verifies Flowbite modal usage via `modals.js` (Rule #4).
3. **Compiles Production Assets via Vite** into the `dist/` directory.
4. **Synchronizes Public Images** into `dist/images/`.
5. **Increments Semantic Version Control** in `package.json` (`v1.0.0` &rarr; `v1.0.1`).
6. **Creates a Post-Build Git Stash Backup**.

To run unit tests independently:
```powershell
npx vitest run
```

---

## 📡 API Endpoints Reference

All API requests return standardized JSON and require a valid CSRF token header (`X-CSRF-Token`) on POST requests.

| Method | Endpoint | Description | Request Payload | Response |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/api/csrf-token` | Fetches active CSRF token | None | `{"token": "..."}` |
| `POST` | `/api/auth/login` | PIN and phone login | `{"phone": "09171234567", "pin": "1234"}` | `{"success": true, "data": {"redirect_url": "/dashboard/"}}` |
| `POST` | `/api/auth/otp/send` | Dispatches SMS OTP | `{"phone": "09171234567"}` | `{"success": true, "message": "OTP sent..."}` |
| `POST` | `/api/auth/otp/verify` | Verifies phone OTP | `{"phone": "09171234567", "otp": "123456"}`| `{"success": true, "data": {...}}` |
| `GET` | `/api/auth/user` | Current authenticated user | Session Cookie | `{"success": true, "data": {"user": {...}}}` |
| `POST` | `/api/auth/logout` | Destroys user session | None | `{"success": true, "message": "Logged out"}` |

---

## 📐 Development Rules & Architectural Standards

1. **Tailwind CSS v4.2+:** Use official v4 classes. Custom utilities are declared in `frontend/src/css/utilities/custom.css`.
2. **Responsive Design:** Optimized for mobile, desktop, and specifically tuned for Acer laptops (1080p @ 125% DPI scale, 1366x768 / 1536x864).
3. **Cursor Pointer (Rule #3):** Every clickable button, link, tab, and keypad element must include the `cursor-pointer` class.
4. **Flowbite Modals (Rule #4):** All pop-ups use Flowbite Modals orchestrated through `frontend/src/js/modules/modals.js`.
5. **Strict Hierarchical IDs:** Every container and element follows the `{parent}-{child}-{grandchild}` naming convention for reliable test automation and QA.
6. **START and END Comments (Rule #9):** Every function, class, and PHP partial is demarcated with explicit `START OF` and `END OF` comments.
7. **Version Control Build Hook (Rule #10):** Always run `npm run build` to update assets and bump version control.

---
---
*Developed for the DOLE Bureau of Workers with Special Concerns (BWSC).*
