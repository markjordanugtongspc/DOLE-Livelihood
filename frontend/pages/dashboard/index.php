<?php
/**
 * START OF FILE: frontend/pages/dashboard/index.php
 * Purpose: DOLE Integrated Livelihood System (DILP) management dashboard
 */

require_once __DIR__ . '/../../../backend/bootstrap.php';

use App\core\Session;
use App\middleware\AuthGuard;
use App\core\Vite;

// Enforce authentication guard
AuthGuard::requireAuth(Vite::asset(''));

$currentUser = [
    'id'         => Session::get('user_id'),
    'name'       => Session::get('user_name', 'Administrator'),
    'first_name' => explode(' ', Session::get('user_name', 'Admin'))[0],
    'last_name'  => explode(' ', Session::get('user_name', 'Admin'))[1] ?? '',
    'role'       => Session::get('role_slug', 'Administrator'),
    'phone'      => Session::get('user_phone', '+639171234567'),
];
$pageTitle = 'Dashboard - DOLE Integrated Livelihood System (DILP)';

require_once __DIR__ . '/../../components/head.php';
?>

<!-- START OF ELEMENT: dashboard-page-root -->
<div id="dashboard-page-root" data-page="dashboard" class="min-h-screen bg-stone-100 dark:bg-slate-900 text-stone-800 dark:text-slate-100 flex flex-col">

    <!-- Layout Container: Sidebar + Main Content -->
    <div id="dashboard-layout-body" class="flex-1 flex overflow-hidden relative">

        <!-- Sidebar Partial -->
        <?php require_once __DIR__ . '/../../components/sidebar.php'; ?>

        <!-- Main Content Area -->
        <main id="dashboard-main-content" class="flex-1 lg:ml-72 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-all duration-300">

            <!-- Mobile Drawer Floating / Top Button -->
            <div class="lg:hidden flex items-center justify-between mb-4 pb-3 border-b border-stone-200 dark:border-slate-800">
                <button
                    type="button"
                    id="sidebar-mobile-toggle-btn"
                    data-drawer-target="drawer-navigation"
                    data-drawer-show="drawer-navigation"
                    aria-controls="drawer-navigation"
                    class="cursor-pointer p-2 rounded-lg text-stone-600 dark:text-slate-300 hover:bg-stone-200 dark:hover:bg-slate-700 transition"
                    aria-label="Toggle mobile menu"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-bold text-emerald-700 dark:text-emerald-400">DOLE Livelihood</span>
                </div>
            </div>
            
            <!-- Welcome Header Banner -->
            <div
                id="dashboard-welcome-banner"
                class="mb-8 p-6 rounded-2xl text-white shadow-lg relative overflow-hidden bg-cover bg-no-repeat"
                style="background-image: linear-gradient(to right, rgba(2, 44, 34, 0.92) 0%, rgba(6, 78, 59, 0.75) 45%, rgba(6, 78, 59, 0.35) 100%), url('<?= Vite::asset('frontend/src/public/images/assets/img1.jpg') ?>'), url('../../src/public/images/assets/img1.jpg'); background-position: center 25%; background-size: cover;"
            >
                <div class="relative z-10 max-w-2xl">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-emerald-800/80 border border-emerald-400/50 text-emerald-100 mb-2 backdrop-blur-xs shadow-xs">
                        Kabuhayan Management Portal
                    </span>
                    <h1 id="dashboard-welcome-heading" class="text-2xl sm:text-3xl font-bold tracking-tight drop-shadow-md">
                        Welcome back, <?php echo htmlspecialchars($currentUser['first_name'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?>!
                    </h1>
                    <p id="dashboard-welcome-subheading" class="text-white text-sm sm:text-base mt-1 drop-shadow-sm leading-relaxed font-medium">
                        DOLE Integrated Livelihood System (DILP) real-time project indicators, beneficiary records, and fund allocations.
                    </p>
                </div>
                <div class="absolute -right-8 -bottom-10 w-48 h-48 rounded-full bg-emerald-400/10 blur-xl pointer-events-none z-10"></div>
            </div>

            <!-- KPI Metric Cards Grid (DOLE Livelihood Program Statistics - Sharp / Non-rounded with Smooth Card Zoom Animation) -->
            <div id="dashboard-kpi-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
                
                <!-- KPI 1: Total Proponent (Primary Emerald Scale: --color-primary-700 / --color-primary-800) -->
                <div id="dashboard-kpi-proponent" class="relative overflow-hidden p-5 rounded-none bg-gradient-to-br from-emerald-700 via-emerald-800 to-emerald-950 text-white shadow-md hover:shadow-xl transition-all duration-300 ease-out hover:scale-[1.03] hover:-translate-y-1 cursor-pointer">
                    <!-- Medium Background SVG Watermark (Static) -->
                    <div class="absolute -right-3 -bottom-4 text-white/10 pointer-events-none select-none">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>

                    <!-- Top Bar: Glass Icon & Card Index -->
                    <div class="flex items-center justify-between relative z-10">
                        <div class="w-9 h-9 rounded-none bg-white/15 border border-white/20 backdrop-blur-xs flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-3xs font-mono font-bold tracking-widest text-emerald-200/70">01</span>
                    </div>

                    <!-- Main Metrics -->
                    <div class="mt-4 relative z-10">
                        <span class="block text-3xs sm:text-2xs font-extrabold uppercase tracking-wider text-emerald-100/90">Total Proponent</span>
                        <div id="dashboard-kpi-proponent-val" class="text-2xl sm:text-[1.7rem] font-extrabold tracking-tight mt-0.5 whitespace-nowrap drop-shadow-xs">
                            1,248
                        </div>
                    </div>

                    <!-- Bottom Subtext & Status -->
                    <div class="mt-3 pt-2.5 border-t border-white/15 flex items-center justify-between text-xs relative z-10">
                        <span class="font-medium text-emerald-100">vs last quarter</span>
                        <span class="inline-flex items-center text-3xs font-bold text-emerald-100 bg-white/10 px-2 py-0.5 rounded-none">
                            &uarr; 14.2%
                        </span>
                    </div>
                </div>

                <!-- KPI 2: Active Projects (Accent Amber Scale: --color-accent-600 / --color-accent-700 / --color-accent-900) -->
                <div id="dashboard-kpi-projects" class="relative overflow-hidden p-5 rounded-none bg-gradient-to-br from-amber-600 via-amber-700 to-amber-900 text-white shadow-md hover:shadow-xl transition-all duration-300 ease-out hover:scale-[1.03] hover:-translate-y-1 cursor-pointer">
                    <!-- Medium Background SVG Watermark (Static) -->
                    <div class="absolute -right-3 -bottom-4 text-white/10 pointer-events-none select-none">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                    </div>

                    <!-- Top Bar: Glass Icon & Card Index -->
                    <div class="flex items-center justify-between relative z-10">
                        <div class="w-9 h-9 rounded-none bg-white/15 border border-white/20 backdrop-blur-xs flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <span class="text-3xs font-mono font-bold tracking-widest text-amber-200/70">02</span>
                    </div>

                    <!-- Main Metrics -->
                    <div class="mt-4 relative z-10">
                        <span class="block text-3xs sm:text-2xs font-extrabold uppercase tracking-wider text-amber-100/90">Active Livelihood Projects</span>
                        <div id="dashboard-kpi-projects-val" class="text-2xl sm:text-[1.7rem] font-extrabold tracking-tight mt-0.5 whitespace-nowrap drop-shadow-xs">
                            84
                        </div>
                    </div>

                    <!-- Bottom Subtext & Status -->
                    <div class="mt-3 pt-2.5 border-t border-white/15 flex items-center justify-between text-xs relative z-10">
                        <span class="font-medium text-amber-100">Across Lanao del Norte</span>
                        <span class="inline-flex items-center text-3xs font-bold text-amber-100 bg-white/10 px-2 py-0.5 rounded-none">
                            8 Completed
                        </span>
                    </div>
                </div>

                <!-- KPI 3: Total Funds Disbursed (Primary Deep Scale: --color-primary-800 / --color-primary-900 / --color-primary-950) -->
                <div id="dashboard-kpi-grants" class="relative overflow-hidden p-5 rounded-none bg-gradient-to-br from-emerald-800 via-emerald-900 to-teal-950 text-white shadow-md hover:shadow-xl transition-all duration-300 ease-out hover:scale-[1.03] hover:-translate-y-1 cursor-pointer">
                    <!-- Medium Background SVG Watermark (Static) -->
                    <div class="absolute -right-3 -bottom-4 text-white/10 pointer-events-none select-none">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <text x="3" y="19" font-size="20" font-family="Poppins, sans-serif" font-weight="bold" fill="currentColor">₱</text>
                        </svg>
                    </div>

                    <!-- Top Bar: Glass Icon & Card Index -->
                    <div class="flex items-center justify-between relative z-10">
                        <div class="w-9 h-9 rounded-none bg-white/15 border border-white/20 backdrop-blur-xs flex items-center justify-center font-bold text-sm shadow-xs">
                            ₱
                        </div>
                        <span class="text-3xs font-mono font-bold tracking-widest text-emerald-200/70">03</span>
                    </div>

                    <!-- Main Metrics -->
                    <div class="mt-4 relative z-10">
                        <span class="block text-3xs sm:text-2xs font-extrabold uppercase tracking-wider text-emerald-100/90">Total Funds Disbursed</span>
                        <div id="dashboard-kpi-grants-val" class="text-2xl sm:text-[1.7rem] font-extrabold tracking-tight mt-0.5 whitespace-nowrap drop-shadow-xs">
                            ₱14.85M
                        </div>
                    </div>

                    <!-- Bottom Subtext & Status -->
                    <div class="mt-3 pt-2.5 border-t border-white/15 flex items-center justify-between text-xs relative z-10">
                        <span class="font-medium text-emerald-100">Liquidation Rate</span>
                        <span class="inline-flex items-center text-3xs font-bold text-emerald-100 bg-white/10 px-2 py-0.5 rounded-none">
                            98.2% Disbursed
                        </span>
                    </div>
                </div>

                <!-- KPI 4: Sustainability / Success Rate (Slate Neutral Scale: --color-slate-700 / --color-slate-800 / --color-slate-900) -->
                <div id="dashboard-kpi-success" class="relative overflow-hidden p-5 rounded-none bg-gradient-to-br from-slate-700 via-slate-800 to-slate-900 text-white shadow-md hover:shadow-xl transition-all duration-300 ease-out hover:scale-[1.03] hover:-translate-y-1 cursor-pointer">
                    <!-- Medium Background SVG Watermark (Static) -->
                    <div class="absolute -right-3 -bottom-4 text-white/10 pointer-events-none select-none">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <!-- Top Bar: Glass Icon & Card Index -->
                    <div class="flex items-center justify-between relative z-10">
                        <div class="w-9 h-9 rounded-none bg-white/15 border border-white/20 backdrop-blur-xs flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-3xs font-mono font-bold tracking-widest text-slate-300/70">04</span>
                    </div>

                    <!-- Main Metrics -->
                    <div class="mt-4 relative z-10">
                        <span class="block text-3xs sm:text-2xs font-extrabold uppercase tracking-wider text-slate-200/90">Sustainability Rate</span>
                        <div id="dashboard-kpi-success-val" class="text-2xl sm:text-[1.7rem] font-extrabold tracking-tight mt-0.5 whitespace-nowrap drop-shadow-xs">
                            94.6%
                        </div>
                    </div>

                    <!-- Bottom Subtext & Status -->
                    <div class="mt-3 pt-2.5 border-t border-white/15 flex items-center justify-between text-xs relative z-10">
                        <span class="font-medium text-slate-200">Target Benchmark</span>
                        <span class="inline-flex items-center text-3xs font-bold text-emerald-300 bg-white/10 px-2 py-0.5 rounded-none">
                            &uarr; 3.2% Target
                        </span>
                    </div>
                </div>

            </div>

            <!-- START OF SECTION: dashboard-charts-container (Rendered via OOP charts.js) -->
            <div id="dashboard-charts-container" class="mb-8"></div>
            <!-- END OF SECTION: dashboard-charts-container -->

            <!-- Recent Applications & Proponent Table -->
            <div id="dashboard-recent-table-card" class="bg-stone-50 dark:bg-slate-800 rounded-2xl border border-stone-200 dark:border-slate-700 shadow-xs overflow-hidden">
                <div class="p-6 border-b border-stone-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 id="dashboard-recent-table-title" class="text-base font-bold text-stone-900 dark:text-white">Recent Livelihood Grant Applications</h2>
                        <p class="text-xs text-stone-500 dark:text-slate-400">Latest beneficiary submissions and field evaluations</p>
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
                    <table id="dashboard-table-applications" class="w-full text-left text-sm text-stone-600 dark:text-slate-300">
                        <thead class="text-xs uppercase bg-stone-100 dark:bg-slate-700/50 text-stone-500 dark:text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Beneficiary / Org</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Project Type</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Region / Field Office</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Amount</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200 dark:divide-slate-700">
                            <tr class="hover:bg-stone-100/60 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 font-semibold text-stone-900 dark:text-white">San Jose Farmers Cooperative</td>
                                <td class="px-6 py-4">Agri-Processing Starter Kit</td>
                                <td class="px-6 py-4">Region IV-A (Laguna)</td>
                                <td class="px-6 py-4 font-medium text-stone-900 dark:text-white">₱250,000</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">Approved</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="cursor-pointer text-xs font-semibold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400">View</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-stone-100/60 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 font-semibold text-stone-900 dark:text-white">Maria Santos (Displaced Worker)</td>
                                <td class="px-6 py-4">Sewing & Garments Production</td>
                                <td class="px-6 py-4">NCR (Quezon City)</td>
                                <td class="px-6 py-4 font-medium text-stone-900 dark:text-white">₱30,000</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300">Under Review</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="cursor-pointer text-xs font-semibold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400">View</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-stone-100/60 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 font-semibold text-stone-900 dark:text-white">Samahang Mangingisda ng Calauag</td>
                                <td class="px-6 py-4">Motorized Fiberglass Boat Kit</td>
                                <td class="px-6 py-4">Region IV-A (Quezon)</td>
                                <td class="px-6 py-4 font-medium text-stone-900 dark:text-white">₱500,000</td>
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
