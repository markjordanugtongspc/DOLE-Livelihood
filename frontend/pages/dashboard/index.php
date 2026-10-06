<?php
/**
 * START OF FILE: frontend/pages/dashboard/index.php
 * Purpose: DOLE Integrated Livelihood System (DILP) management dashboard
 */

require_once __DIR__ . '/../../../backend/bootstrap.php';

use App\Core\Session;
use App\Middleware\AuthGuard;

// Enforce authentication guard
AuthGuard::requireAuth();

$currentUser = Session::get('user');
$pageTitle = 'Dashboard - DOLE Integrated Livelihood System (DILP)';

require_once __DIR__ . '/../../components/head.php';
?>

<!-- START OF ELEMENT: dashboard-page-root -->
<div id="dashboard-page-root" class="min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 flex flex-col">

    <!-- Top Navigation Bar -->
    <header id="dashboard-topbar" class="sticky top-0 z-30 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 h-16 flex items-center justify-between px-4 sm:px-6">
        
        <!-- Left: Sidebar toggles & Brand -->
        <div id="dashboard-topbar-left" class="flex items-center space-x-3">
            <!-- Mobile Sidebar Toggle -->
            <button
                type="button"
                id="sidebar-mobile-toggle-btn"
                class="cursor-pointer lg:hidden p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                aria-label="Toggle mobile menu"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>

            <!-- Desktop Sidebar Toggle -->
            <button
                type="button"
                id="sidebar-toggle-btn"
                class="cursor-pointer hidden lg:inline-flex p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                aria-label="Collapse or expand sidebar"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"></path></svg>
            </button>

            <!-- Brand Info -->
            <div id="dashboard-topbar-brand" class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-700 flex items-center justify-center p-1 text-white font-bold text-xs shadow-xs">
                    DILP
                </div>
                <div class="hidden sm:block">
                    <span id="dashboard-topbar-brand-title" class="text-sm font-bold text-slate-900 dark:text-white">DOLE Livelihood MIS</span>
                    <span class="text-xs text-emerald-700 dark:text-emerald-400 font-medium ml-2 px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800">BWSC</span>
                </div>
            </div>
        </div>

        <!-- Right: Actions & User Info -->
        <div id="dashboard-topbar-right" class="flex items-center space-x-3">
            <button
                type="button"
                id="dashboard-help-btn"
                data-drawer-show="drawer-help-right"
                class="cursor-pointer p-2 rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                title="Help & System Info"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </button>

            <!-- User Chip -->
            <div id="dashboard-topbar-user" class="flex items-center space-x-3 pl-3 border-l border-slate-200 dark:border-slate-700">
                <div class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-900/60 border border-emerald-300 dark:border-emerald-700 flex items-center justify-center text-emerald-800 dark:text-emerald-200 font-bold text-sm">
                    <?php echo strtoupper(substr($currentUser['first_name'] ?? 'A', 0, 1)); ?>
                </div>
                <div class="hidden md:block text-left">
                    <p id="dashboard-topbar-user-name" class="text-xs font-semibold text-slate-800 dark:text-slate-200">
                        <?php echo htmlspecialchars(($currentUser['first_name'] ?? 'Admin') . ' ' . ($currentUser['last_name'] ?? 'User'), ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <p id="dashboard-topbar-user-role" class="text-2xs text-slate-400">
                        <?php echo htmlspecialchars($currentUser['role'] ?? 'Administrator', ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>
                <!-- Logout Button -->
                <button
                    type="button"
                    id="dashboard-topbar-logout-btn"
                    data-action="logout"
                    class="cursor-pointer ml-2 p-2 rounded-lg text-rose-600 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition"
                    title="Sign Out"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Layout Container: Sidebar + Main Content -->
    <div id="dashboard-layout-body" class="flex-1 flex overflow-hidden relative">

        <!-- Sidebar Partial -->
        <?php require_once __DIR__ . '/../../components/sidebar.php'; ?>

        <!-- Main Content Area -->
        <main id="dashboard-main-content" class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-all duration-300">
            
            <!-- Welcome Header Banner -->
            <div id="dashboard-welcome-banner" class="mb-8 p-6 rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-800 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-emerald-600/60 border border-emerald-400/30 text-emerald-100 mb-2">
                        Kabuhayan Management Portal
                    </span>
                    <h1 id="dashboard-welcome-heading" class="text-2xl sm:text-3xl font-bold tracking-tight">
                        Welcome back, <?php echo htmlspecialchars($currentUser['first_name'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?>!
                    </h1>
                    <p id="dashboard-welcome-subheading" class="text-emerald-100/90 text-sm mt-1">
                        DOLE Integrated Livelihood System (DILP) real-time project indicators, beneficiary records, and fund allocations.
                    </p>
                </div>
                <div class="absolute -right-8 -bottom-10 w-48 h-48 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            </div>

            <!-- KPI Metric Cards Grid -->
            <div id="dashboard-kpi-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
                
                <!-- KPI 1: Beneficiaries Assisted -->
                <div id="dashboard-kpi-beneficiaries" class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Total Beneficiaries</span>
                        <span class="p-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <span id="dashboard-kpi-beneficiaries-val" class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">1,248</span>
                        <div class="flex items-center text-xs text-emerald-600 font-semibold mt-1">
                            <span>&uarr; 14.2%</span>
                            <span class="text-slate-400 font-normal ml-1.5">vs last quarter</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 2: Active Projects -->
                <div id="dashboard-kpi-projects" class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Active Projects</span>
                        <span class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <span id="dashboard-kpi-projects-val" class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">84</span>
                        <div class="flex items-center text-xs text-emerald-600 font-semibold mt-1">
                            <span>8 completed this month</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 3: Livelihood Grants -->
                <div id="dashboard-kpi-grants" class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Total Funds Disbursed</span>
                        <span class="p-2 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <span id="dashboard-kpi-grants-val" class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">₱14.85M</span>
                        <div class="flex items-center text-xs text-slate-500 font-medium mt-1">
                            <span>98.2% liquidation rate</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 4: Sustainability Rate -->
                <div id="dashboard-kpi-success" class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Sustainability Rate</span>
                        <span class="p-2 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <span id="dashboard-kpi-success-val" class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">94.6%</span>
                        <div class="flex items-center text-xs text-emerald-600 font-semibold mt-1">
                            <span>&uarr; 3.2% vs target</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Charts Section Grid -->
            <div id="dashboard-charts-grid" class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <!-- Chart 1: Monthly Beneficiaries Trend (2 Cols) -->
                <div id="dashboard-chart-trend-card" class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 id="dashboard-chart-trend-title" class="text-base font-bold text-slate-900 dark:text-white">Beneficiaries Assisted (2026)</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Monthly breakdown of livelihood grants released</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                            Monthly Report
                        </span>
                    </div>
                    <div id="chart-beneficiaries-trend" class="w-full"></div>
                </div>

                <!-- Chart 2: Category Distribution (1 Col) -->
                <div id="dashboard-chart-category-card" class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs">
                    <div class="mb-4">
                        <h2 id="dashboard-chart-category-title" class="text-base font-bold text-slate-900 dark:text-white">Project Categories</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Distribution by industry sector</p>
                    </div>
                    <div id="chart-category-donut" class="w-full flex justify-center"></div>
                </div>

            </div>

            <!-- Recent Applications & Beneficiaries Table -->
            <div id="dashboard-recent-table-card" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 id="dashboard-recent-table-title" class="text-base font-bold text-slate-900 dark:text-white">Recent Livelihood Grant Applications</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Latest beneficiary submissions and field evaluations</p>
                    </div>
                    <button
                        type="button"
                        id="dashboard-new-application-btn"
                        class="cursor-pointer inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl shadow-xs transition"
                    >
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>New Application</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table id="dashboard-table-applications" class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Beneficiary / Org</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Project Type</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Region / Field Office</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Amount</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">San Jose Farmers Cooperative</td>
                                <td class="px-6 py-4">Agri-Processing Starter Kit</td>
                                <td class="px-6 py-4">Region IV-A (Laguna)</td>
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">₱250,000</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">Approved</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="cursor-pointer text-xs font-semibold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400">View</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Maria Santos (Displaced Worker)</td>
                                <td class="px-6 py-4">Sewing & Garments Production</td>
                                <td class="px-6 py-4">NCR (Quezon City)</td>
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">₱30,000</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300">Under Review</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="cursor-pointer text-xs font-semibold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400">View</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Samahang Mangingisda ng Calauag</td>
                                <td class="px-6 py-4">Motorized Fiberglass Boat Kit</td>
                                <td class="px-6 py-4">Region IV-A (Quezon)</td>
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">₱500,000</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300">Fund Allocated</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="cursor-pointer text-xs font-semibold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400">View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</div>
<!-- END OF ELEMENT: dashboard-page-root -->

<!-- Generic Parent Components -->
<?php require_once __DIR__ . '/../../components/drawer.php'; ?>
<?php require_once __DIR__ . '/../../components/modal.php'; ?>
<?php require_once __DIR__ . '/../../components/toast.php'; ?>
<?php require_once __DIR__ . '/../../components/scripts.php'; ?>

<?php
/**
 * END OF FILE: frontend/pages/dashboard/index.php
 */
?>
