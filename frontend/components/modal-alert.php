<?php
/* START: ModalAlertComponent — Flowbite modal for alerts and lockout notices */
?>
<div
    id="modal-alert"
    tabindex="-1"
    aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
>
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div id="modal-alert-content" class="relative bg-white rounded-2xl shadow-2xl border border-ink-200">
            <!-- Modal header -->
            <div id="modal-alert-header" class="flex items-center justify-between p-4 sm:p-5 border-b border-ink-200 rounded-t-2xl">
                <h3 id="modal-alert-title" class="text-xl font-bold text-ink-950 flex items-center gap-2">
                    <svg class="size-6 text-danger-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Notice
                </h3>
                <button
                    type="button"
                    id="modal-alert-btn-close"
                    data-modal-hide="modal-alert"
                    class="text-ink-400 bg-transparent hover:bg-ink-100 hover:text-ink-900 rounded-lg text-sm size-8 ms-auto inline-flex justify-center items-center cursor-pointer transition"
                >
                    <svg class="size-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close alert modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal-alert-body" class="p-4 sm:p-5 space-y-4">
                <p id="modal-alert-message" class="text-base leading-relaxed text-ink-700 font-medium">
                    An alert notification message.
                </p>
            </div>
            <!-- Modal footer -->
            <div id="modal-alert-footer" class="flex items-center justify-end p-4 sm:p-5 border-t border-ink-200 rounded-b-2xl">
                <button
                    type="button"
                    id="modal-alert-btn-ok"
                    data-modal-hide="modal-alert"
                    class="text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 focus:ring-4 focus:outline-hidden focus:ring-primary-200 font-bold rounded-xl text-sm px-6 py-3 text-center cursor-pointer transition shadow-xs"
                >
                    Understood
                </button>
            </div>
        </div>
    </div>
</div>
<?php
/* END: ModalAlertComponent */
