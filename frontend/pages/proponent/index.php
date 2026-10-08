<?php
/**
 * START OF FILE: frontend/pages/proponent/index.php
 * Purpose: DOLE Integrated Livelihood System (DILP) Proponent Management & Directory Page
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
$pageTitle = 'Proponent Directory - DOLE Integrated Livelihood System (DILP)';

require_once __DIR__ . '/../../components/head.php';
?>

<!-- START OF ELEMENT: proponent-page-root -->
<div id="proponent-page-root" data-page="proponent" class="min-h-screen bg-stone-100 dark:bg-slate-900 text-stone-800 dark:text-slate-100 flex flex-col">

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

            <!-- Page Header Breadcrumbs & Action Bar -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <!-- Breadcrumbs -->
                    <nav class="flex text-xs font-semibold text-stone-500 dark:text-slate-400 mb-1" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                            <li class="inline-flex items-center">
                                <a href="<?= Vite::asset('dashboard/') ?>" class="hover:text-emerald-700 dark:hover:text-emerald-400 inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-stone-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                                    <span>User Management</span>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-stone-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                                    <span class="text-emerald-700 dark:text-emerald-400 font-bold">Proponents</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-stone-900 dark:text-white tracking-tight">
                        Proponent Directory
                    </h1>
                    <p class="text-sm sm:text-base text-stone-600 dark:text-slate-400 mt-0.5">
                        Manage accredited partner organizations, community associations, and individual livelihood proponents.
                    </p>
                </div>

                <!-- Add Proponent Drawer Trigger Action Button -->
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        id="btn-add-proponent-drawer"
                        data-drawer-target="drawer-add-proponent"
                        data-drawer-show="drawer-add-proponent"
                        data-drawer-placement="right"
                        aria-controls="drawer-add-proponent"
                        class="cursor-pointer inline-flex items-center gap-2 px-5 py-3 text-sm sm:text-base font-bold text-white bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 rounded-xl shadow-sm transition hover:shadow-md select-none"
                    >
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add Proponent</span>
                    </button>
                </div>
            </div>

            <!-- START OF TABLE CONTAINER: Flowbite Striped Columns Table with Search, Filter & Pagination -->
            <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-stone-200 dark:border-slate-700 overflow-hidden">
                
                <!-- Table Action Bar: Search Input & Filter Dropdown (Fixed at top of card) -->
                <div class="p-4 sm:p-5 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 border-b border-stone-200 dark:border-slate-700 bg-stone-50/50 dark:bg-slate-850">
                    <!-- Search Input -->
                    <div class="relative flex-1 max-w-md">
                        <label for="proponent-table-search" class="sr-only">Search Proponents</label>
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-stone-400 dark:text-slate-400">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="proponent-table-search"
                            class="block w-full ps-10 pe-4 py-2.5 bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-600 text-stone-900 dark:text-white text-sm sm:text-base rounded-xl focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 placeholder:text-stone-400 dark:placeholder:text-slate-500 shadow-2xs transition"
                            placeholder="Search by proponent name, contact person, or location..."
                        />
                    </div>

                    <!-- Filter Dropdown Button & Menu -->
                    <div class="relative flex items-center gap-2 shrink-0">
                        <button
                            id="dropdownFilterButton"
                            data-dropdown-toggle="dropdown-filter-menu"
                            class="shrink-0 inline-flex items-center justify-center gap-2 text-stone-700 dark:text-slate-200 bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-600 hover:bg-stone-100 dark:hover:bg-slate-800 focus:ring-2 focus:ring-emerald-500 shadow-2xs font-semibold rounded-xl text-sm sm:text-base px-4 py-2.5 transition cursor-pointer"
                            type="button"
                        >
                            <svg class="w-4 h-4 text-stone-500 dark:text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                            </svg>
                            <span>Filter by</span>
                            <svg class="w-3.5 h-3.5 text-stone-500 dark:text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdown-filter-menu" class="z-20 hidden bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 rounded-xl shadow-lg w-56 py-1.5 text-sm font-medium text-stone-700 dark:text-slate-300">
                            <div class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-slate-500 border-b border-stone-100 dark:border-slate-700">
                                Proponent Type
                            </div>
                            <ul class="py-1">
                                <li><button type="button" data-filter-type="all" class="w-full text-left px-3.5 py-2 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-700 dark:hover:text-emerald-400 transition cursor-pointer">All Proponents</button></li>
                                <li><button type="button" data-filter-type="association" class="w-full text-left px-3.5 py-2 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-700 dark:hover:text-emerald-400 transition cursor-pointer">Workers Association</button></li>
                                <li><button type="button" data-filter-type="acp" class="w-full text-left px-3.5 py-2 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-700 dark:hover:text-emerald-400 transition cursor-pointer">Accredited Co-Partner (ACP)</button></li>
                                <li><button type="button" data-filter-type="individual" class="w-full text-left px-3.5 py-2 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-700 dark:hover:text-emerald-400 transition cursor-pointer">Individual Entrepreneur</button></li>
                                <li><button type="button" data-filter-type="lgu" class="w-full text-left px-3.5 py-2 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-700 dark:hover:text-emerald-400 transition cursor-pointer">Local Government Unit (LGU)</button></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Table Horizontal Scroll Container -->
                <div class="relative overflow-x-auto">
                    <!-- Main Data Table with Striped Columns & Hover State -->
                    <table id="proponents-data-table" class="w-full text-left rtl:text-right text-stone-700 dark:text-slate-300">
                    <thead class="text-xs sm:text-sm uppercase tracking-wider text-stone-700 dark:text-slate-300 bg-stone-100/90 dark:bg-slate-750 border-b border-stone-200 dark:border-slate-700 select-none">
                        <tr>
                            <th scope="col" class="p-4 w-4 bg-stone-100/80 dark:bg-slate-800">
                                <div class="flex items-center">
                                    <input
                                        id="table-checkbox-all"
                                        type="checkbox"
                                        class="w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer"
                                    />
                                    <label for="table-checkbox-all" class="sr-only">Select All</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white">
                                Full Name
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white bg-stone-100/60 dark:bg-slate-750">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white">
                                Project Name
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white bg-stone-100/60 dark:bg-slate-750">
                                Location
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white">
                                Type of Beneficiary / Project
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white text-right bg-stone-100/60 dark:bg-slate-750">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm sm:text-base divide-y divide-stone-200/80 dark:divide-slate-700/70">
                        <!-- Row 1 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-1" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-1" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        1
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="1"
                                                title="Click to view full proponent details"
                                            >
                                                Haidee L. Cañada
                                            </button>
                                            <svg class="w-4 h-4 text-pink-600 dark:text-pink-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Female"><circle cx="12" cy="9" r="5"></circle><line x1="12" y1="14" x2="12" y2="21"></line><line x1="9" y1="18" x2="15" y2="18"></line></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">(063) 228-7992</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-700 text-white dark:bg-amber-600 dark:text-amber-50 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    Subject for Re-Evaluation Upon Compliance
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Rice with Frozen Products Retailer
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Prk 1 Sapphire, Hinaplanon, Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-rose-50 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300 border border-rose-200 dark:border-rose-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Low Income Earner
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Formation)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-2" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-2" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        2
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="2"
                                                title="Click to view full proponent details"
                                            >
                                                Juanito M. Dela Cruz
                                            </button>
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Male"><circle cx="10" cy="14" r="5"></circle><line x1="19" y1="5" x2="13.5" y2="10.5"></line><polyline points="15 5 19 5 19 9"></polyline></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0917-234-5678</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Agricultural Grains Retailing
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Tipanoy, Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Small Farmer
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Enhancement)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-3" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-3" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        3
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="3"
                                                title="Click to view full proponent details"
                                            >
                                                Elena S. Mendoza
                                            </button>
                                            <svg class="w-4 h-4 text-pink-600 dark:text-pink-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Female"><circle cx="12" cy="9" r="5"></circle><line x1="12" y1="14" x2="12" y2="21"></line><line x1="9" y1="18" x2="15" y2="18"></line></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0928-876-5432</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                    Fund Released
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Fish Drying & Smoked Fish Kit
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Poblacion, Kapatagan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-cyan-50 text-cyan-700 dark:bg-cyan-950/50 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                                    Fisherfolk (Woman)
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Formation)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-4" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-4" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        4
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="4"
                                                title="Click to view full proponent details"
                                            >
                                                Marites A. Rosal
                                            </button>
                                            <svg class="w-4 h-4 text-pink-600 dark:text-pink-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Female"><circle cx="12" cy="9" r="5"></circle><line x1="12" y1="14" x2="12" y2="21"></line><line x1="9" y1="18" x2="15" y2="18"></line></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0919-555-1234</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Native Handloom Weaving Production
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Maranding, Lala
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-fuchsia-50 text-fuchsia-700 dark:bg-fuchsia-950/50 dark:text-fuchsia-300 border border-fuchsia-200 dark:border-fuchsia-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-fuchsia-500"></span>
                                    Self-Employed (Woman)
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Restoration)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 5 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-5" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-5" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        5
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="5"
                                                title="Click to view full proponent details"
                                            >
                                                Rodrigo P. Tan
                                            </button>
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Male"><circle cx="10" cy="14" r="5"></circle><line x1="19" y1="5" x2="13.5" y2="10.5"></line><polyline points="15 5 19 5 19 9"></polyline></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0939-112-9988</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-900 dark:bg-amber-950/70 dark:text-amber-200 border border-amber-300 dark:border-amber-700 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                    Subject for Approval
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Solar Dryer & Grain Handling Kit
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Tubod, Lanao del Norte
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-teal-50 text-teal-700 dark:bg-teal-950/50 dark:text-teal-300 border border-teal-200 dark:border-teal-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                                    Agrarian Reform Beneficiary
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Enhancement)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 6 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-6" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-6" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        6
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="6"
                                                title="Click to view full proponent details"
                                            >
                                                Maria Clara Santos
                                            </button>
                                            <svg class="w-4 h-4 text-pink-600 dark:text-pink-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Female"><circle cx="12" cy="9" r="5"></circle><line x1="12" y1="14" x2="12" y2="21"></line><line x1="9" y1="18" x2="15" y2="18"></line></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0917-889-3344</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Sewing & Garments Production
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Saray, Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300 border border-amber-200 dark:border-amber-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Displaced Worker
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Formation)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 7 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-7" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-7" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        7
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="7"
                                                title="Click to view full proponent details"
                                            >
                                                Danilo G. Reyes
                                            </button>
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Male"><circle cx="10" cy="14" r="5"></circle><line x1="19" y1="5" x2="13.5" y2="10.5"></line><polyline points="15 5 19 5 19 9"></polyline></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0920-776-5544</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                    Fund Released
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Virgin Coconut Oil Processing Kit
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Baroy, Lanao del Norte
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-sky-50 text-sky-700 dark:bg-sky-950/50 dark:text-sky-300 border border-sky-200 dark:border-sky-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                    Senior Citizen (SR)
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Enhancement)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 8 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-8" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-8" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        8
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="8"
                                                title="Click to view full proponent details"
                                            >
                                                Nestor V. Villanueva
                                            </button>
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Male"><circle cx="10" cy="14" r="5"></circle><line x1="19" y1="5" x2="13.5" y2="10.5"></line><polyline points="15 5 19 5 19 9"></polyline></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0927-665-4433</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-700 text-white dark:bg-amber-600 dark:text-amber-50 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    Subject for Re-Evaluation Upon Compliance
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Small Engine & Motorboat Repair
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Kolambugan, Lanao del Norte
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                    Displaced / OFW Returnee
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Formation)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 9 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-9" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-9" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        9
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="9"
                                                title="Click to view full proponent details"
                                            >
                                                Francisco B. Ramos
                                            </button>
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Male"><circle cx="10" cy="14" r="5"></circle><line x1="19" y1="5" x2="13.5" y2="10.5"></line><polyline points="15 5 19 5 19 9"></polyline></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0917-332-1100</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Food Processing & Native Delicacies
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Tubod, Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-violet-50 text-violet-700 dark:bg-violet-950/50 dark:text-violet-300 border border-violet-200 dark:border-violet-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                                    Self-Employed Worker
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Enhancement)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 10 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="individual">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-10" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-10" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        10
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <button
                                                type="button"
                                                class="proponent-view-trigger font-bold text-stone-900 dark:text-white leading-tight border-b border-dashed border-stone-400 dark:border-slate-500 hover:border-emerald-600 dark:hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 cursor-pointer text-left transition-colors"
                                                data-proponent-id="10"
                                                title="Click to view full proponent details"
                                            >
                                                Josephina M. Alcantara
                                            </button>
                                            <svg class="w-4 h-4 text-pink-600 dark:text-pink-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Female"><circle cx="12" cy="9" r="5"></circle><line x1="12" y1="14" x2="12" y2="21"></line><line x1="9" y1="18" x2="15" y2="18"></line></svg>
                                        </div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">0930-998-7766</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Commercial Baking Starter Kit
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                San Roque, Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-purple-50 text-purple-700 dark:bg-purple-950/50 dark:text-purple-300 border border-purple-200 dark:border-purple-900/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                    Person with Disability (PWD)
                                </div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-1 pl-1">Individual (Formation)</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>

                <!-- Table Navigation & Pagination Bar (Fixed at bottom of card) -->
                <nav class="flex flex-col md:flex-row items-center justify-between p-4 sm:p-5 gap-4 border-t border-stone-200 dark:border-slate-700 bg-stone-50/50 dark:bg-slate-850 select-none" aria-label="Table navigation">
                    <span class="text-sm sm:text-base font-normal text-stone-600 dark:text-slate-400">
                        Showing <span class="font-bold text-stone-900 dark:text-white">1–10</span> of <span class="font-bold text-stone-900 dark:text-white">48</span> Proponents
                    </span>
                    <ul class="inline-flex items-center -space-x-px text-sm sm:text-base font-semibold shadow-2xs">
                        <li>
                            <a href="#" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-stone-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-700 rounded-s-xl hover:bg-stone-100 dark:hover:bg-slate-800 hover:text-stone-900 dark:hover:text-white transition">
                                Previous
                            </a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="flex items-center justify-center px-4 h-10 text-white bg-emerald-700 border border-emerald-700 hover:bg-emerald-800 transition font-bold">
                                1
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-stone-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-700 hover:bg-stone-100 dark:hover:bg-slate-800 hover:text-stone-900 dark:hover:text-white transition">
                                2
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-stone-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-700 hover:bg-stone-100 dark:hover:bg-slate-800 hover:text-stone-900 dark:hover:text-white transition">
                                3
                            </a>
                        </li>
                        <li>
                            <span class="flex items-center justify-center px-4 h-10 leading-tight text-stone-400 dark:text-slate-500 bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-700">
                                ...
                            </span>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-stone-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-700 hover:bg-stone-100 dark:hover:bg-slate-800 hover:text-stone-900 dark:hover:text-white transition">
                                5
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-stone-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-700 rounded-e-xl hover:bg-stone-100 dark:hover:bg-slate-800 hover:text-stone-900 dark:hover:text-white transition">
                                Next
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
            <!-- END OF TABLE CONTAINER -->

        </main>
    </div>

</div>
<!-- END OF ELEMENT: proponent-page-root -->

<!-- Inject Add Proponent Drawer via reusable components/drawer.php partial -->
<?php
$drawerId = 'drawer-add-proponent';
$drawerTitle = 'Add Proponent';
$drawerSubtitle = 'Fill in the proponent registration details in the straight form below.';
$drawerWidth = 'w-full sm:w-[34rem] md:w-[40rem] lg:w-[44rem]';

ob_start();
?>
<form id="proponent-registration-form" class="space-y-6">

    <!-- START OF SECTION: Personal & Contact Information -->
    <div class="space-y-4 pb-4 border-b border-stone-200 dark:border-slate-800">
        <h4 class="text-sm sm:text-base font-bold text-emerald-800 dark:text-emerald-400 flex items-center gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center text-xs font-black">1</span>
            Personal & Proponent Identification
        </h4>

        <!-- Field: Full Name (Last Name, First Name, Middle Name) -->
        <div class="space-y-1.5">
            <label for="proponent-name" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                Full Name (Last Name, First Name, Middle Name) <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="proponent-name"
                name="proponent_name"
                required
                placeholder="e.g. Cañada, Haidee Lucaybo"
                class="block w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition shadow-2xs"
            />
        </div>

        <!-- Row: Sex / Gender & Birthdate & Age -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="space-y-1.5">
                <label for="proponent-gender" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Sex / Gender <span class="text-red-500">*</span>
                </label>
                <select
                    id="proponent-gender"
                    name="gender"
                    required
                    class="block w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition cursor-pointer shadow-2xs"
                >
                    <option value="">Select Gender</option>
                    <option value="female">Female (F)</option>
                    <option value="male">Male (M)</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label for="proponent-birthdate" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Birthdate
                </label>
                <input
                    type="date"
                    id="proponent-birthdate"
                    name="birthdate"
                    class="block w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition shadow-2xs"
                />
            </div>

            <div class="space-y-1.5">
                <label for="proponent-age" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Age
                </label>
                <input
                    type="number"
                    id="proponent-age"
                    name="age"
                    min="15"
                    max="100"
                    placeholder="e.g. 36"
                    class="block w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition shadow-2xs"
                />
            </div>
        </div>

        <!-- Field: Beneficiary Category (Flowbite Dropdown with Search & Select) -->
        <div class="space-y-1.5 relative">
            <label class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                Type of Beneficiaries <span class="text-red-500">*</span>
            </label>
            <input type="hidden" id="proponent-beneficiary-type" name="type_of_beneficiaries" required value="Low Income Earner" />
            <button
                id="dropdownBeneficiaryBtn"
                data-dropdown-toggle="dropdownBeneficiaryMenu"
                data-dropdown-placement="bottom-start"
                type="button"
                class="w-full inline-flex items-center justify-between px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white hover:bg-stone-100 dark:hover:bg-slate-750 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer text-left"
            >
                <span id="selected-beneficiary-label" class="truncate font-semibold">Low Income Earner</span>
                <svg class="w-4 h-4 text-stone-500 dark:text-slate-400 shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdownBeneficiaryMenu" class="z-30 hidden bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 rounded-xl shadow-xl w-full min-w-full">
                <div class="p-2 border-b border-stone-200 dark:border-slate-700 bg-stone-50/70 dark:bg-slate-850 rounded-t-xl">
                    <label for="search-beneficiary" class="sr-only">Search beneficiary type</label>
                    <div class="relative">
                        <input
                            type="text"
                            id="search-beneficiary"
                            class="bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-600 text-stone-900 dark:text-white text-xs rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full px-2.5 py-1.5 placeholder-stone-400"
                            placeholder="Search or type custom category..."
                        />
                    </div>
                </div>
                <ul class="h-44 p-1.5 text-xs text-stone-700 dark:text-slate-300 font-medium overflow-y-auto space-y-0.5 custom-scrollbar" id="beneficiary-options-list">
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Low Income Earner">Low Income Earner</button></li>
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Senior Citizen">Senior Citizen</button></li>
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Farmers / Agricultural Worker">Farmers / Agricultural Worker</button></li>
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Fisherfolk (Woman)">Fisherfolk (Woman)</button></li>
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Persons with Disability (PWD)">Persons with Disability (PWD)</button></li>
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Displaced Worker">Displaced Worker</button></li>
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Self-Employed (Woman)">Self-Employed (Woman)</button></li>
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Agrarian Reform Beneficiary">Agrarian Reform Beneficiary</button></li>
                    <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Youth / Next Gen Beneficiary">Youth / Next Gen Beneficiary</button></li>
                </ul>
            </div>
        </div>

        <!-- Row: Contact Person / Contact # -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1.5">
                <label for="contact-phone" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Contact Person / Contact # <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="contact-phone"
                    name="contact_person"
                    required
                    placeholder="e.g. 0917-123-4567 or (063) 228-7992"
                    class="block w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition shadow-2xs"
                />
            </div>

            <div class="space-y-1.5">
                <label for="proponent-location" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Project Location / Barangay <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="proponent-location"
                    name="location"
                    required
                    placeholder="e.g. Prk 1 Sapphire, Hinaplanon, Iligan City"
                    class="block w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition shadow-2xs"
                />
            </div>
        </div>
    </div>
    <!-- END OF SECTION: Personal & Contact Information -->

    <!-- START OF SECTION: Project Identity & Capital Breakdown -->
    <div class="space-y-4 pb-4 border-b border-stone-200 dark:border-slate-800">
        <h4 class="text-sm sm:text-base font-bold text-emerald-800 dark:text-emerald-400 flex items-center gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center text-xs font-black">2</span>
            Project Details & Capital Scheme
        </h4>

        <!-- Field: Project Name -->
        <div class="space-y-1.5">
            <label for="project-name" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                Project Name <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="project-name"
                name="project_name"
                required
                placeholder="e.g. Rice with Frozen Products Retailer"
                class="block w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition shadow-2xs"
            />
        </div>

        <!-- Row: Type of Project & Initial Status (Flowbite Dropdowns with Search) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <!-- Type of Project Dropdown -->
            <div class="space-y-1.5 relative">
                <label class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Type of Project <span class="text-red-500">*</span>
                </label>
                <input type="hidden" id="proponent-project-type" name="type_of_project" required value="Individual (Formation)" />
                <button
                    id="dropdownProjectTypeBtn"
                    data-dropdown-toggle="dropdownProjectTypeMenu"
                    data-dropdown-placement="bottom-start"
                    type="button"
                    class="w-full inline-flex items-center justify-between px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white hover:bg-stone-100 dark:hover:bg-slate-750 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer text-left"
                >
                    <span id="selected-project-type-label" class="truncate font-semibold">Individual (Formation)</span>
                    <svg class="w-4 h-4 text-stone-500 dark:text-slate-400 shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                </button>

                <div id="dropdownProjectTypeMenu" class="z-30 hidden bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 rounded-xl shadow-xl w-full min-w-full">
                    <div class="p-2 border-b border-stone-200 dark:border-slate-700 bg-stone-50/70 dark:bg-slate-850 rounded-t-xl">
                        <input
                            type="text"
                            id="search-project-type"
                            class="bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-600 text-stone-900 dark:text-white text-xs rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full px-2.5 py-1.5 placeholder-stone-400"
                            placeholder="Search project type..."
                        />
                    </div>
                    <ul class="h-36 p-1.5 text-xs text-stone-700 dark:text-slate-300 font-medium overflow-y-auto space-y-0.5 custom-scrollbar" id="project-type-options-list">
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Individual (Formation)">Individual (Formation)</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Individual (Enhancement)">Individual (Enhancement)</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Individual (Restoration)">Individual (Restoration)</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Group / Association Project">Group / Association Project</button></li>
                    </ul>
                </div>
            </div>

            <!-- Status Dropdown -->
            <div class="space-y-1.5 relative">
                <label class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Status <span class="text-red-500">*</span>
                </label>
                <input type="hidden" id="proponent-status-text" name="status_text" required value="Subject for Approval" />
                <button
                    id="dropdownStatusBtn"
                    data-dropdown-toggle="dropdownStatusMenu"
                    data-dropdown-placement="bottom-start"
                    type="button"
                    class="w-full inline-flex items-center justify-between px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white hover:bg-stone-100 dark:hover:bg-slate-750 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer text-left"
                >
                    <span id="selected-status-label" class="truncate font-semibold">Subject for Approval</span>
                    <svg class="w-4 h-4 text-stone-500 dark:text-slate-400 shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                </button>

                <div id="dropdownStatusMenu" class="z-30 hidden bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 rounded-xl shadow-xl w-full min-w-full">
                    <div class="p-2 border-b border-stone-200 dark:border-slate-700 bg-stone-50/70 dark:bg-slate-850 rounded-t-xl">
                        <input
                            type="text"
                            id="search-status"
                            class="bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-600 text-stone-900 dark:text-white text-xs rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full px-2.5 py-1.5 placeholder-stone-400"
                            placeholder="Search status..."
                        />
                    </div>
                    <ul class="h-36 p-1.5 text-xs text-stone-700 dark:text-slate-300 font-medium overflow-y-auto space-y-0.5 custom-scrollbar" id="status-options-list">
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Subject for Approval">Subject for Approval</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Subject for Re-Evaluation Upon Compliance">Subject for Re-Evaluation Upon Compliance</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Approved">Approved</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="Fund Released">Fund Released</button></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 3-Column Capital Breakdown (DOLE Request, Equity, Total Amount) -->
        <div class="p-3.5 rounded-xl bg-stone-50 dark:bg-slate-800/60 border border-stone-200/90 dark:border-slate-700/80 space-y-3">
            <span class="block text-xs font-black uppercase tracking-wider text-stone-700 dark:text-slate-300">
                Capital Breakdown (Optional Financials)
            </span>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                <div class="space-y-1">
                    <label for="dole-request-amount" class="block text-[11px] font-bold text-emerald-800 dark:text-emerald-400 uppercase">
                        DOLE Request Amount
                    </label>
                    <input
                        type="text"
                        id="dole-request-amount"
                        name="dole_request_amount"
                        placeholder="₱ 30,000.00"
                        class="block w-full px-2.5 py-1.5 text-xs rounded-lg border border-stone-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 shadow-2xs"
                    />
                </div>
                <div class="space-y-1">
                    <label for="proponent-equity" class="block text-[11px] font-bold text-amber-800 dark:text-amber-400 uppercase">
                        Proponent Equity
                    </label>
                    <input
                        type="text"
                        id="proponent-equity"
                        name="proponent_equity"
                        placeholder="₱ 5,500.00"
                        class="block w-full px-2.5 py-1.5 text-xs rounded-lg border border-stone-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-amber-500 shadow-2xs"
                    />
                </div>
                <div class="space-y-1">
                    <label for="total-amount" class="block text-[11px] font-bold text-blue-800 dark:text-blue-400 uppercase">
                        Total Amount
                    </label>
                    <input
                        type="text"
                        id="total-amount"
                        name="total_amount"
                        placeholder="₱ 35,500.00"
                        class="block w-full px-2.5 py-1.5 text-xs rounded-lg border border-stone-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-2xs"
                    />
                </div>
            </div>
        </div>
    </div>
    <!-- END OF SECTION: Project Identity & Capital Breakdown -->

    <!-- START OF SECTION: Evaluation, Workflow & Dependents -->
    <div class="space-y-4 pb-4">
        <h4 class="text-sm sm:text-base font-bold text-emerald-800 dark:text-emerald-400 flex items-center gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center text-xs font-black">3</span>
            Evaluation & Workflow Notes (Optional)
        </h4>

        <!-- Row: Evaluator Name & Date Evaluated -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <!-- Name of Evaluator Dropdown -->
            <div class="space-y-1.5 relative">
                <label class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Name of Evaluator
                </label>
                <input type="hidden" id="proponent-evaluator-name" name="evaluator_name" value="KATE" />
                <button
                    id="dropdownEvaluatorBtn"
                    data-dropdown-toggle="dropdownEvaluatorMenu"
                    data-dropdown-placement="bottom-start"
                    type="button"
                    class="w-full inline-flex items-center justify-between px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white hover:bg-stone-100 dark:hover:bg-slate-750 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer text-left"
                >
                    <span id="selected-evaluator-label" class="truncate font-semibold">KATE</span>
                    <svg class="w-4 h-4 text-stone-500 dark:text-slate-400 shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                </button>

                <div id="dropdownEvaluatorMenu" class="z-30 hidden bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 rounded-xl shadow-xl w-full min-w-full">
                    <div class="p-2 border-b border-stone-200 dark:border-slate-700 bg-stone-50/70 dark:bg-slate-850 rounded-t-xl">
                        <input
                            type="text"
                            id="search-evaluator"
                            class="bg-white dark:bg-slate-900 border border-stone-300 dark:border-slate-600 text-stone-900 dark:text-white text-xs rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full px-2.5 py-1.5 placeholder-stone-400"
                            placeholder="Search evaluator or type custom name..."
                        />
                    </div>
                    <ul class="h-32 p-1.5 text-xs text-stone-700 dark:text-slate-300 font-medium overflow-y-auto space-y-0.5 custom-scrollbar" id="evaluator-options-list">
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="KATE">KATE</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="LAI">LAI</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="PESO ILIGAN">PESO ILIGAN</button></li>
                        <li><button type="button" class="w-full text-left px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-lg transition cursor-pointer font-semibold" data-value="PESO SND">PESO SND</button></li>
                    </ul>
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="date-evaluated" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                    Date Evaluated
                </label>
                <input
                    type="date"
                    id="date-evaluated"
                    name="date_evaluated"
                    class="block w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-hidden transition shadow-2xs"
                />
            </div>
        </div>

        <!-- Field: Remarks / Findings -->
        <div class="space-y-1.5">
            <label for="remarks-findings" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                Remarks / Findings Note
            </label>
            <input
                type="text"
                id="remarks-findings"
                name="remarks_findings"
                placeholder="e.g. COMPLETE, CHECK PROFILE FORM IF ALLOWED, NO ORIG SIG OF VALID ID"
                class="block w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-hidden transition shadow-2xs"
            />
        </div>

        <!-- Field: Name of Dependent(s) -->
        <div class="space-y-1.5">
            <label for="dependents-list" class="block text-xs sm:text-sm font-bold text-stone-800 dark:text-slate-200">
                Name of Dependent(s) & Particulars
            </label>
            <textarea
                id="dependents-list"
                name="dependents_list"
                rows="2"
                placeholder="e.g. GIALYN L. CAÑADA (18 yo - Student)"
                class="block w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-hidden transition shadow-2xs"
            ></textarea>
        </div>
    </div>
    <!-- END OF SECTION: Evaluation, Workflow & Dependents -->

    <!-- Form Submit & Reset Action Buttons (50% / 50% Equal Grid: Submit on Left, Cancel on Right) -->
    <div class="pt-4 grid grid-cols-2 gap-3 border-t border-stone-200 dark:border-slate-800 sticky bottom-0 bg-white dark:bg-slate-900 py-3 z-10">
        <!-- Left 50% Grid: Emerald Save Proponent Record Button (Solid by default, Transparent on hover/click) -->
        <button
            type="submit"
            id="proponent-submit-btn"
            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 text-sm sm:text-base font-bold text-white bg-emerald-700 hover:bg-transparent hover:text-emerald-700 dark:hover:text-emerald-400 border border-emerald-700 active:bg-emerald-50 dark:active:bg-emerald-950/40 active:scale-95 rounded-xl shadow-sm transition-all duration-200 hover:shadow-md cursor-pointer select-none truncate"
        >
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="truncate">Save Proponent Record</span>
        </button>

        <!-- Right 50% Grid: Red Cancel Button (Transparent stroke by default, Solid fill on hover/click) -->
        <button
            type="button"
            data-drawer-hide="drawer-add-proponent"
            aria-controls="drawer-add-proponent"
            class="w-full inline-flex items-center justify-center px-4 py-3 text-sm sm:text-base font-bold text-red-700 dark:text-red-400 hover:text-white bg-red-50 dark:bg-red-950/40 hover:bg-red-700 dark:hover:bg-red-700 border border-red-200 dark:border-red-800/80 hover:border-red-700 active:bg-red-800 active:scale-95 rounded-xl transition-all duration-200 shadow-2xs hover:shadow-xs cursor-pointer select-none"
        >
            Cancel
        </button>
    </div>

</form>
<?php
$drawerSlot = ob_get_clean();
require __DIR__ . '/../../components/drawer.php';
?>

<!-- Universal Dynamic Drawer (Used for Proponent Detail & other subchild dynamic views) -->
<?php
$drawerId = 'app-drawer';
$drawerTitle = 'Proponent Detail';
$drawerWidth = 'w-full sm:w-[38rem] md:w-[42rem] lg:w-[44rem]';
$drawerSlot = null;
require __DIR__ . '/../../components/drawer.php';
?>

<!-- Universal Modals & Scripts Components -->
<?php require_once __DIR__ . '/../../components/modal.php'; ?>
<?php require_once __DIR__ . '/../../components/toast.php'; ?>
<?php require_once __DIR__ . '/../../components/scripts.php'; ?>

<?php
/**
 * END OF FILE: frontend/pages/proponent/index.php
 */
?>
