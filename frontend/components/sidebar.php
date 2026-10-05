<?php
/* START: SidebarComponent — expandable/collapsible left sidebar for dashboard */
use App\services\AuthService;
$currentUser = AuthService::user() ?? ['name' => 'Administrator', 'role' => 'admin'];
?>
<aside
    id="dashboard-sidebar"
    class="sidebar-transition fixed top-0 left-0 z-40 h-screen bg-white border-e border-ink-200 shadow-md flex flex-col justify-between w-72"
    aria-label="Dashboard Sidebar"
>
    <!-- Top Area: Brand & Toggle -->
    <div id="dashboard-sidebar-top">
        <div id="dashboard-sidebar-brand" class="flex items-center justify-between p-4 h-20 border-b border-ink-200">
            <div id="dashboard-sidebar-brand-info" class="flex items-center gap-3 overflow-hidden">
                <img
                    id="dashboard-sidebar-logo"
                    src="<?= \App\core\Vite::asset('frontend/src/public/images/logo/logo.png') ?>"
                    alt="DILP"
                    class="size-10 object-contain shrink-0"
                    onerror="this.style.display='none'; document.getElementById('dashboard-sidebar-logo-fallback').classList.remove('hidden');"
                >
                <div id="dashboard-sidebar-logo-fallback" class="hidden flex items-center justify-center size-10 rounded-xl bg-primary-700 text-white font-black text-sm shrink-0">
                    DILP
                </div>
                <div id="dashboard-sidebar-title-block" class="truncate sidebar-label">
                    <span id="dashboard-sidebar-agency" class="block text-xs font-bold uppercase text-primary-700">DILP System</span>
                    <span id="dashboard-sidebar-title" class="block text-sm font-extrabold text-ink-950 truncate">DOLE Livelihood</span>
                </div>
            </div>
            <!-- Desktop Collapse/Expand Button -->
            <button
                type="button"
                id="dashboard-sidebar-btn-collapse"
                class="hidden lg:flex items-center justify-center size-8 rounded-lg text-ink-400 hover:text-ink-900 hover:bg-ink-100 cursor-pointer transition focus:outline-hidden"
                title="Toggle Sidebar"
            >
                <svg id="dashboard-sidebar-collapse-icon" class="size-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu Items -->
        <nav id="dashboard-sidebar-nav" class="p-4 space-y-1.5 overflow-y-auto">
            <a
                href="/dashboard/"
                id="dashboard-sidebar-nav-home"
                class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-base font-bold text-white bg-primary-600 shadow-xs cursor-pointer transition"
            >
                <svg class="size-6 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span data-sidebar-label class="sidebar-label">Dashboard</span>
            </a>

            <a
                href="javascript:void(0)"
                id="dashboard-sidebar-nav-beneficiaries"
                class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-base font-semibold text-ink-700 hover:text-ink-950 hover:bg-ink-100 cursor-pointer transition"
            >
                <svg class="size-6 shrink-0 text-ink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span data-sidebar-label class="sidebar-label">Beneficiaries</span>
                <span data-sidebar-label class="sidebar-label ms-auto text-xs px-2 py-0.5 rounded-full bg-ink-200 text-ink-700 font-bold">Soon</span>
            </a>

            <a
                href="javascript:void(0)"
                id="dashboard-sidebar-nav-projects"
                class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-base font-semibold text-ink-700 hover:text-ink-950 hover:bg-ink-100 cursor-pointer transition"
            >
                <svg class="size-6 shrink-0 text-ink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span data-sidebar-label class="sidebar-label">Livelihood Projects</span>
                <span data-sidebar-label class="sidebar-label ms-auto text-xs px-2 py-0.5 rounded-full bg-ink-200 text-ink-700 font-bold">Soon</span>
            </a>

            <a
                href="javascript:void(0)"
                id="dashboard-sidebar-nav-reports"
                class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-base font-semibold text-ink-700 hover:text-ink-950 hover:bg-ink-100 cursor-pointer transition"
            >
                <svg class="size-6 shrink-0 text-ink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span data-sidebar-label class="sidebar-label">Analytics & Reports</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Area: User Info & Sign Out -->
    <div id="dashboard-sidebar-bottom" class="p-4 border-t border-ink-200 space-y-3">
        <div id="dashboard-sidebar-user-card" class="flex items-center gap-3 p-2 rounded-xl bg-ink-50">
            <div id="dashboard-sidebar-user-avatar" class="size-10 rounded-full bg-primary-700 text-white flex items-center justify-center font-bold text-sm shrink-0">
                <?= strtoupper(substr($currentUser['name'] ?? 'A', 0, 1)) ?>
            </div>
            <div id="dashboard-sidebar-user-details" class="truncate sidebar-label">
                <span data-sidebar-label id="dashboard-sidebar-user-name" class="block text-sm font-bold text-ink-950 truncate">
                    <?= htmlspecialchars($currentUser['name'] ?? 'Administrator', ENT_QUOTES, 'UTF-8') ?>
                </span>
                <span data-sidebar-label id="dashboard-sidebar-user-role" class="block text-xs font-semibold text-primary-700 uppercase">
                    <?= htmlspecialchars($currentUser['role'] ?? 'admin', ENT_QUOTES, 'UTF-8') ?>
                </span>
            </div>
        </div>

        <button
            type="button"
            id="dashboard-sidebar-btn-logout"
            data-action="logout"
            class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-sm font-bold text-danger-700 hover:text-white hover:bg-danger-600 active:bg-danger-700 border border-danger-200 hover:border-danger-600 cursor-pointer transition focus:outline-hidden"
        >
            <svg class="size-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span data-sidebar-label class="sidebar-label">Sign Out</span>
        </button>
    </div>
</aside>
<?php
/* END: SidebarComponent */
