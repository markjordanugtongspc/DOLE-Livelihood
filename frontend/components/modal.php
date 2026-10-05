<?php
/**
 * START OF FILE: frontend/components/modal.php
 * Purpose: Generic Flowbite Pop-up Modal parent template (Rule #4)
 */
$modalId = $modalId ?? 'app-modal';
$modalTitle = $modalTitle ?? 'Notice';
?>
<!-- START OF ELEMENT: <?= htmlspecialchars($modalId) ?> -->
<div
    id="<?= htmlspecialchars($modalId) ?>"
    tabindex="-1"
    aria-hidden="true"
    role="dialog"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
>
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal Card -->
        <div class="relative bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 sm:p-5 border-b border-slate-100 dark:border-slate-800">
                <h3 id="<?= htmlspecialchars($modalId) ?>-title" class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">
                    <?= htmlspecialchars($modalTitle) ?>
                </h3>
                <button
                    type="button"
                    data-modal-hide="<?= htmlspecialchars($modalId) ?>"
                    class="text-slate-400 hover:text-slate-700 dark:hover:text-white rounded-lg p-1.5 inline-flex items-center cursor-pointer transition"
                    aria-label="Close modal"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div id="<?= htmlspecialchars($modalId) ?>-body" class="p-5 text-sm text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                <p id="<?= htmlspecialchars($modalId) ?>-message">Notification message.</p>
            </div>
            <!-- Modal Footer -->
            <div class="flex items-center justify-end p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40">
                <button
                    type="button"
                    id="<?= htmlspecialchars($modalId) ?>-btn-confirm"
                    data-modal-hide="<?= htmlspecialchars($modalId) ?>"
                    class="cursor-pointer px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold text-sm transition shadow-sm"
                >
                    Understood
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END OF ELEMENT: <?= htmlspecialchars($modalId) ?> -->
<?php
/**
 * END OF FILE: frontend/components/modal.php
 */
?>
