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
                                Proponent Organization
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white bg-stone-100/60 dark:bg-slate-750">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white">
                                Authorized Representative
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white bg-stone-100/60 dark:bg-slate-750">
                                Location
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white">
                                Project Focus
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white bg-stone-100/60 dark:bg-slate-750">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-stone-900 dark:text-white text-right">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm sm:text-base divide-y divide-stone-200/80 dark:divide-slate-700/70">
                        <!-- Row 1 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="association">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-1" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-1" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        TR
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Tipanoy Rice & Farmers Association</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">DOLE-REG-2024-0012</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">Association</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Juanito Dela Cruz</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0917-234-5678</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Agricultural Grains
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="association">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-2" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-2" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 flex items-center justify-center font-black text-xs shrink-0">
                                        KF
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Kapatagan Fisherfolk Cooperative</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">CDA-REG-9812-44</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300">Cooperative</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Elena Mendoza</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0928-876-5432</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Kapatagan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Boat Kits & Fish Drying
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                    Fund Released
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="association">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-3" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-3" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-pink-100 dark:bg-pink-950/60 text-pink-700 dark:text-pink-400 flex items-center justify-center font-black text-xs shrink-0">
                                        LW
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Lala Women Weavers Guild</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">DOLE-REG-2023-8831</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">Association</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Marites Rosal</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0919-555-1234</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Lala
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Garments & Native Weaving
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="acp">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-4" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-4" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-400 flex items-center justify-center font-black text-xs shrink-0">
                                        TA
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Tubod ARB Cooperative</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">ACP-ACCRED-2024-09</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-purple-100 text-purple-800 dark:bg-purple-950/60 dark:text-purple-300">ACP Partner</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Rodrigo P. Tan</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0939-112-9988</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Tubod
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Rice Mill & Solar Dryer
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                    Under Evaluation
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 5 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="association">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-5" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-5" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-teal-100 dark:bg-teal-950/60 text-teal-700 dark:text-teal-400 flex items-center justify-center font-black text-xs shrink-0">
                                        BM
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Balo-i Traders Guild</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">DOLE-REG-2022-7719</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">Association</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Aminah Usman</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0918-443-2211</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Balo-i
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Native Food Processing
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
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
                                    <div class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-950/60 text-orange-700 dark:text-orange-400 flex items-center justify-center font-black text-xs shrink-0">
                                        MS
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Maria Clara Santos</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">IND-DISP-2024-331</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-stone-200 text-stone-800 dark:bg-slate-700 dark:text-slate-200">Individual</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Maria Clara Santos</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0917-889-3344</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Sewing & Alteration Shop
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 7 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="association">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-7" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-7" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        BC
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Baroy Coconut Tappers Org</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">DOLE-REG-2023-1120</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">Association</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Danilo G. Reyes</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0920-776-5544</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Baroy
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Virgin Coconut Oil
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                    Fund Released
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 8 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="acp">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-8" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-8" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 flex items-center justify-center font-black text-xs shrink-0">
                                        KC
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Kolambugan Transport Coop</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">ACP-ACCRED-2024-17</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-purple-100 text-purple-800 dark:bg-purple-950/60 dark:text-purple-300">ACP Partner</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Capt. Nestor Villanueva</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0927-665-4433</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Kolambugan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Motor Boat Kit Repair
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                    Under Evaluation
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 9 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="lgu">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-9" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-9" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-xs shrink-0">
                                        IL
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">Iligan City LGU - PESO Partner</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">LGU-PART-2021-01</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">LGU Partner</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Atty. Francisco Ramos</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0917-332-1100</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Community Skills Hub
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Accredited
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="#" class="font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 hover:underline">Edit</a>
                            </td>
                        </tr>

                        <!-- Row 10 -->
                        <tr class="proponent-row hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors group" data-type="association">
                            <td class="w-4 p-4 bg-stone-50/30 dark:bg-slate-800/40 group-hover:bg-transparent">
                                <div class="flex items-center">
                                    <input id="checkbox-row-10" type="checkbox" class="table-row-checkbox w-4 h-4 text-emerald-600 bg-white dark:bg-slate-900 border-stone-300 dark:border-slate-600 rounded-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                                    <label for="checkbox-row-10" class="sr-only">Row Select</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-stone-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-400 flex items-center justify-center font-black text-xs shrink-0">
                                        SR
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 dark:text-white leading-tight">San Roque PWD Association</div>
                                        <div class="text-xs text-stone-500 dark:text-slate-400 font-normal">DOLE-REG-2023-4501</div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">Association</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                <div>Josephina Alcantara</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400">0930-998-7766</div>
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Iligan City
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800 dark:text-slate-200">
                                Commercial Baking Shop
                            </td>
                            <td class="px-6 py-4 bg-stone-50/40 dark:bg-slate-800/40 group-hover:bg-transparent whitespace-nowrap font-medium">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
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

    <!-- Section 1: Classification & Identification -->
    <div class="space-y-4 pb-4 border-b border-stone-200 dark:border-slate-800">
        <h4 class="text-sm sm:text-base font-bold text-emerald-800 dark:text-emerald-400 flex items-center gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center text-xs font-black">1</span>
            Classification & Organization
        </h4>

        <!-- Field: Proponent Type -->
        <div class="space-y-1.5">
            <label for="proponent-type" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Proponent Classification <span class="text-red-500">*</span>
            </label>
            <select
                id="proponent-type"
                name="proponent_type"
                required
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            >
                <option value="">Select Proponent Type</option>
                <option value="association">Workers Association / Cooperative</option>
                <option value="acp">Accredited Co-Partner (ACP)</option>
                <option value="individual">Individual Worker / Entrepreneur</option>
                <option value="lgu">Local Government Unit (LGU)</option>
            </select>
        </div>

        <!-- Field: Organization Name -->
        <div class="space-y-1.5">
            <label for="proponent-name" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Proponent / Organization Name <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="proponent-name"
                name="proponent_name"
                required
                placeholder="e.g. Tipanoy Livelihood Association"
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            />
        </div>

        <!-- Field: Accreditation Number -->
        <div class="space-y-1.5">
            <label for="accreditation-no" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Registration / Accreditation Number
            </label>
            <input
                type="text"
                id="accreditation-no"
                name="accreditation_no"
                placeholder="e.g. DOLE-REG-2024-0012 or SEC/CDA No."
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            />
        </div>
    </div>

    <!-- Section 2: Contact Representative -->
    <div class="space-y-4 pb-4 border-b border-stone-200 dark:border-slate-800">
        <h4 class="text-sm sm:text-base font-bold text-emerald-800 dark:text-emerald-400 flex items-center gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center text-xs font-black">2</span>
            Authorized Contact Person
        </h4>

        <!-- Field: Contact Person -->
        <div class="space-y-1.5">
            <label for="contact-person" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Full Name of Representative <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="contact-person"
                name="contact_person"
                required
                placeholder="e.g. Juanito Dela Cruz"
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            />
        </div>

        <!-- Field: Contact Number -->
        <div class="space-y-1.5">
            <label for="contact-phone" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Contact Mobile Number <span class="text-red-500">*</span>
            </label>
            <input
                type="tel"
                id="contact-phone"
                name="contact_phone"
                required
                placeholder="0917-123-4567"
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            />
        </div>

        <!-- Field: Contact Email -->
        <div class="space-y-1.5">
            <label for="contact-email" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Official Email Address
            </label>
            <input
                type="email"
                id="contact-email"
                name="contact_email"
                placeholder="proponent@domain.gov.ph"
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            />
        </div>
    </div>

    <!-- Section 3: Project & Location Information -->
    <div class="space-y-4 pb-4">
        <h4 class="text-sm sm:text-base font-bold text-emerald-800 dark:text-emerald-400 flex items-center gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center text-xs font-black">3</span>
            Project & Geographic Location
        </h4>

        <!-- Field: Municipality / Location -->
        <div class="space-y-1.5">
            <label for="municipality" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Municipality / City <span class="text-red-500">*</span>
            </label>
            <select
                id="municipality"
                name="municipality"
                required
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            >
                <option value="">Select Municipality / City</option>
                <option value="Iligan City">Iligan City</option>
                <option value="Tubod">Tubod</option>
                <option value="Kapatagan">Kapatagan</option>
                <option value="Lala">Lala</option>
                <option value="Balo-i">Balo-i</option>
                <option value="Baroy">Baroy</option>
                <option value="Kolambugan">Kolambugan</option>
                <option value="Sultan Naga Dimaporo">Sultan Naga Dimaporo</option>
            </select>
        </div>

        <!-- Field: Project Category -->
        <div class="space-y-1.5">
            <label for="project-category" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Proposed Livelihood Project Category <span class="text-red-500">*</span>
            </label>
            <select
                id="project-category"
                name="project_category"
                required
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            >
                <option value="">Select Project Category</option>
                <option value="agriculture">Agriculture & Crop Farming</option>
                <option value="fishery">Fishery & Marine Resources</option>
                <option value="food_processing">Food Processing & Preservation</option>
                <option value="garments">Garments & Handicraft Production</option>
                <option value="transport">Transport & Machinery Services</option>
                <option value="retail">Vending, Retail & Small Business</option>
            </select>
        </div>

        <!-- Field: Street / Barangay Address -->
        <div class="space-y-1.5">
            <label for="barangay-address" class="block text-sm sm:text-base font-semibold text-stone-800 dark:text-slate-200">
                Barangay / Complete Address
            </label>
            <textarea
                id="barangay-address"
                name="address"
                rows="2"
                placeholder="e.g. Purok 4, Brgy. Tipanoy, Iligan City"
                class="block w-full px-4 py-3 text-sm sm:text-base rounded-xl border border-stone-300 dark:border-slate-600 bg-stone-50 dark:bg-slate-800 text-stone-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition"
            ></textarea>
        </div>
    </div>

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

<!-- Universal Modals & Scripts Components -->
<?php require_once __DIR__ . '/../../components/modal.php'; ?>
<?php require_once __DIR__ . '/../../components/toast.php'; ?>
<?php require_once __DIR__ . '/../../components/scripts.php'; ?>

<?php
/**
 * END OF FILE: frontend/pages/proponent/index.php
 */
?>
