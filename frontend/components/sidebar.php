<?php
/* START: SidebarComponent — Flowbite drawer and desktop sidebar navigation */
use App\services\AuthService;
use App\core\Vite;

$currentUser = AuthService::user() ?? [
    'name'  => 'Administrator',
    'role'  => 'admin',
    'phone' => '+639171234567'
];

$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
$isDashboard = str_contains($currentUri, 'dashboard') || $currentUri === '/' || $currentUri === '';
?>

<!-- START OF ELEMENT: drawer-navigation -->
<aside
    id="drawer-navigation"
    class="fixed top-0 left-0 z-50 w-72 h-screen p-4 overflow-visible transition-transform -translate-x-full lg:translate-x-0 bg-stone-50 dark:bg-slate-900 border-e border-stone-200 dark:border-slate-800 flex flex-col shadow-xl lg:shadow-none"
>
    <!-- START OF ELEMENT: sidebar-toggle-btn (Overlay floating on very front z-70, moved up, unclipped) -->
    <button
        type="button"
        id="sidebar-toggle-btn"
        class="group absolute -right-3.5 top-3 z-[70] text-red-700 dark:text-red-400 bg-white dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-950/40 border border-stone-200 dark:border-slate-700 hover:border-red-300 dark:hover:border-red-800 rounded-full w-7 h-7 flex items-center justify-center cursor-pointer shadow-md transition-all duration-200 hover:scale-110 active:scale-95"
        aria-label="Toggle Sidebar"
        title="Toggle Sidebar"
    >
        <!-- ICON: Closed / Collapsing State (Active when Sidebar is OPEN) -->
        <div class="sidebar-icon-collapse inline-flex items-center justify-center">
            <!-- Static Outline Icon -->
            <svg class="w-4 h-4 text-red-700 dark:text-red-400 block group-hover:hidden group-active:hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.99994 10 7 11.9999l1.99994 2M12 5v14M5 4h14c.5523 0 1 .44772 1 1v14c0 .5523-.4477 1-1 1H5c-.55228 0-1-.4477-1-1V5c0-.55228.44772-1 1-1Z"/>
            </svg>
            <!-- Hover / Active Solid Icon -->
            <svg class="w-4 h-4 text-red-700 dark:text-red-400 hidden group-hover:block group-active:block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M13 21h6c1.1046 0 2-.8954 2-2V5c0-1.10457-.8954-2-2-2h-6v18Z"/>
                <path fill-rule="evenodd" d="M11 3H5c-1.10457 0-2 .89543-2 2v14c0 1.1046.89543 2 2 2h6V3Zm-2.29295 7.7071c.39052-.3905.39052-1.02368 0-1.41421-.39053-.39052-1.02369-.39052-1.41421 0L5.29289 11.2928c-.39052.3906-.39052 1.0237 0 1.4142l1.99995 2c.39052.3905 1.02368.3905 1.41421 0 .39052-.3905.39052-1.0237 0-1.4142l-1.29284-1.2929 1.29284-1.2928Z" clip-rule="evenodd"/>
            </svg>
        </div>

        <!-- ICON: Expand State (Active when Sidebar is Collapsed / Floating) -->
        <div class="sidebar-icon-expand hidden items-center justify-center">
            <!-- Static Outline Icon -->
            <svg class="w-4 h-4 text-red-700 dark:text-red-400 block group-hover:hidden group-active:hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 1.99994 1.9999-1.99994 2M12 5v14M5 4h14c.5523 0 1 .44772 1 1v14c0 .5523-.4477 1-1 1H5c-.55228 0-1-.4477-1-1V5c0-.55228.44772-1 1-1Z"/>
            </svg>
            <!-- Hover / Active Solid Icon -->
            <svg class="w-4 h-4 text-red-700 dark:text-red-400 hidden group-hover:block group-active:block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M13 21h6c1.1046 0 2-.8954 2-2V5c0-1.10457-.8954-2-2-2h-6v18Z"/>
                <path fill-rule="evenodd" d="M11 3H5c-1.10457 0-2 .89543-2 2v14c0 1.1046.89543 2 2 2h6V3Zm-5.70711 7.7071c-.39052-.3905-.39052-1.02368 0-1.41421.39053-.39052 1.02369-.39052 1.41422 0l1.99994 1.99991c.39052.3906.39052 1.0237 0 1.4142l-1.99994 2c-.39053.3905-1.02369.3905-1.41422 0-.39052-.3905-.39052-1.0237 0-1.4142l1.29284-1.2929-1.29284-1.2928Z" clip-rule="evenodd"/>
            </svg>
        </div>
    </button>
    <!-- END OF ELEMENT: sidebar-toggle-btn -->

    <!-- Top Area: Brand -->
    <div class="relative shrink-0">
        <div id="sidebar-brand-wrapper" class="border-b border-stone-200 dark:border-slate-800 pb-4 flex items-center min-h-[44px]">
            <a id="sidebar-brand-link" href="./" class="flex items-center gap-2 group min-w-0 cursor-pointer">
                <img
                    id="sidebar-brand-logo"
                    src="../../src/public/images/logo/logo.png"
                    class="h-7 w-7 object-contain shrink-0 drop-shadow-xs transition-transform group-hover:scale-105"
                    alt="DOLE Logo"
                />
                <div class="flex items-center gap-1 min-w-0" data-sidebar-label>
                    <span class="text-sm sm:text-base font-extrabold whitespace-nowrap text-emerald-700 dark:text-emerald-400 tracking-tight leading-none">
                        Livelihood Dashboard
                    </span>
                    <img
                        src="../../src/public/images/assets/leaves.png"
                        class="h-3.5 w-auto object-contain shrink-0 drop-shadow-xs transform rotate-45 transition-transform group-hover:rotate-90 duration-300"
                        alt="Leaves"
                    />
                </div>
            </a>
        </div>
    </div>

    <!-- Navigation Menu Items -->
    <div class="py-3 flex-1 overflow-y-auto overflow-x-hidden">
        <ul class="space-y-1 font-medium text-sm">
            <!-- 1. Dashboard Link -->
            <li>
                <a
                    href="./"
                    class="flex items-center px-2.5 py-2 rounded-xl font-bold transition-all duration-150 <?= $isDashboard ? 'text-white bg-emerald-700 shadow-xs' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400' ?> group cursor-pointer"
                >
                    <svg class="w-5 h-5 shrink-0 transition duration-75 <?= $isDashboard ? 'text-white' : 'text-slate-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-400' ?>" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/>
                    </svg>
                    <span class="ms-2.5 truncate" data-sidebar-label>Dashboard</span>
                </a>
            </li>

            <!-- 2. Beneficiaries (Collapsible Dropdown with Tree-Branch Design) -->
            <li>
                <button
                    type="button"
                    class="flex items-center w-full justify-between px-2.5 py-2 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 transition-all duration-150 group cursor-pointer"
                    aria-controls="dropdown-beneficiaries"
                    data-collapse-toggle="dropdown-beneficiaries"
                >
                    <svg class="shrink-0 w-5 h-5 text-slate-400 transition duration-75 group-hover:text-emerald-700 dark:group-hover:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <span class="flex-1 ms-2.5 text-left rtl:text-right whitespace-nowrap font-semibold truncate" data-sidebar-label>Beneficiaries</span>
                    <svg class="w-4 h-4 shrink-0 transition-transform duration-200" data-sidebar-label aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                    </svg>
                </button>
                <!-- Tree-branch styled submenu with vertical spine and horizontal branch connectors -->
                <ul id="dropdown-beneficiaries" class="hidden relative ml-5 pl-2.5 border-l-2 border-stone-200 dark:border-slate-700/80 my-1 space-y-1" data-sidebar-label>
                    <li class="relative">
                        <!-- Horizontal branch straight line -->
                        <span class="absolute -left-2.5 top-1/2 -translate-y-1/2 w-2.5 h-0.5 bg-stone-200 dark:bg-slate-700/80"></span>
                        <a href="#beneficiaries-list" class="flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 group cursor-pointer truncate transition-colors" data-sidebar-label>
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-300 dark:bg-slate-600 group-hover:bg-emerald-600 dark:group-hover:bg-emerald-400 mr-2 shrink-0 transition-colors"></span>
                            <span class="truncate">Masterlist</span>
                        </a>
                    </li>
                    <li class="relative">
                        <!-- Horizontal branch straight line -->
                        <span class="absolute -left-2.5 top-1/2 -translate-y-1/2 w-2.5 h-0.5 bg-stone-200 dark:bg-slate-700/80"></span>
                        <a href="#beneficiaries-add" class="flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 group cursor-pointer truncate transition-colors" data-sidebar-label>
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-300 dark:bg-slate-600 group-hover:bg-emerald-600 dark:group-hover:bg-emerald-400 mr-2 shrink-0 transition-colors"></span>
                            <span class="truncate">Add Beneficiary</span>
                        </a>
                    </li>
                    <li class="relative">
                        <!-- Horizontal branch straight line -->
                        <span class="absolute -left-2.5 top-1/2 -translate-y-1/2 w-2.5 h-0.5 bg-stone-200 dark:bg-slate-700/80"></span>
                        <a href="#beneficiaries-disbursements" class="flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 group cursor-pointer truncate transition-colors" data-sidebar-label>
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-300 dark:bg-slate-600 group-hover:bg-emerald-600 dark:group-hover:bg-emerald-400 mr-2 shrink-0 transition-colors"></span>
                            <span class="truncate">Grant Disbursements</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 3. Livelihood Projects Link -->
            <li>
                <a href="#projects" class="flex items-center px-2.5 py-2 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 transition-all duration-150 group cursor-pointer">
                    <svg class="shrink-0 w-5 h-5 text-slate-400 transition duration-75 group-hover:text-emerald-700 dark:group-hover:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span class="flex-1 ms-2.5 whitespace-nowrap font-semibold truncate" data-sidebar-label>Livelihood Projects</span>
                    <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 text-3xs font-bold px-1.5 py-0.5 rounded-full shrink-0" data-sidebar-label>Active</span>
                </a>
            </li>

            <!-- 4. Community Groups / ACPs -->
            <li>
                <a href="#associations" class="flex items-center px-2.5 py-2 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 transition-all duration-150 group cursor-pointer">
                    <svg class="shrink-0 w-5 h-5 text-slate-400 transition duration-75 group-hover:text-emerald-700 dark:group-hover:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                    </svg>
                    <span class="flex-1 ms-2.5 whitespace-nowrap font-semibold truncate" data-sidebar-label>Associations / ACPs</span>
                </a>
            </li>

            <!-- 5. Reports & Analytics Link -->
            <li>
                <a href="#reports" class="flex items-center px-2.5 py-2 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 transition-all duration-150 group cursor-pointer">
                    <svg class="shrink-0 w-5 h-5 text-slate-400 transition duration-75 group-hover:text-emerald-700 dark:group-hover:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="flex-1 ms-2.5 whitespace-nowrap font-semibold truncate" data-sidebar-label>Analytics & Reports</span>
                </a>
            </li>

            <!-- 6. Audit & Activity Logs Link -->
            <li>
                <a href="#logs" class="flex items-center px-2.5 py-2 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 transition-all duration-150 group cursor-pointer">
                    <svg class="shrink-0 w-5 h-5 text-slate-400 transition duration-75 group-hover:text-emerald-700 dark:group-hover:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/>
                    </svg>
                    <span class="flex-1 ms-2.5 whitespace-nowrap font-semibold truncate" data-sidebar-label>Activity Logs</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Bottom Area: Settings & User Profile Card -->
    <div class="mt-auto pt-3 border-t border-stone-200 dark:border-slate-800 space-y-1.5 overflow-x-hidden shrink-0">
        <!-- Settings Link -->
        <a
            href="#settings"
            id="sidebar-link-settings"
            class="flex items-center px-2.5 py-2 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-stone-200/70 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 transition-all duration-150 group font-semibold text-sm cursor-pointer"
        >
            <svg class="shrink-0 w-5 h-5 text-slate-400 transition duration-75 group-hover:text-emerald-700 dark:group-hover:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
            <span class="ms-2.5 truncate" data-sidebar-label>Settings</span>
        </a>

        <!-- User Chip & Sign Out (Compact & fully responsive without horizontal overflow) -->
        <div class="flex items-center justify-between p-1.5 rounded-xl bg-stone-100 dark:bg-slate-800/60 border border-stone-200 dark:border-slate-800 min-w-0 max-w-full">
            <div class="flex items-center gap-2 min-w-0 flex-1 overflow-hidden">
                <div class="w-7 h-7 rounded-full bg-emerald-700 text-white flex items-center justify-center font-bold text-xs shrink-0">
                    <?= strtoupper(substr($currentUser['name'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="min-w-0 flex-1 truncate" data-sidebar-label>
                    <span class="block text-xs font-bold text-slate-900 dark:text-white truncate leading-tight">
                        <?= htmlspecialchars($currentUser['name'] ?? 'Administrator', ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <span class="block text-3xs font-semibold text-emerald-700 dark:text-emerald-400 uppercase truncate leading-tight">
                        <?= htmlspecialchars($currentUser['role'] ?? 'admin', ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
            </div>
            <button
                type="button"
                data-action="logout"
                class="cursor-pointer p-1 rounded-lg text-slate-400 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950/40 transition shrink-0"
                title="Sign Out"
                data-sidebar-label
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </div>
    </div>
</aside>
<!-- END OF ELEMENT: drawer-navigation -->
<?php
/* END: SidebarComponent */

