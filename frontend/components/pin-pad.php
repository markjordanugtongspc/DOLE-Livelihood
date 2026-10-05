<?php
/**
 * START OF FILE: frontend/components/pin-pad.php
 * Purpose: 4 to 6 digit interactive PIN visual dot slots and on-screen keypad
 */
?>
<!-- START OF ELEMENT: pin-container -->
<div id="pin-container" class="space-y-4">

    <!-- 6 Visual Dot Indicator Slots -->
    <div id="pin-dots" class="flex justify-center items-center gap-2 sm:gap-2.5 py-1" role="status" aria-label="PIN entry slots">
        <div id="pin-dot-slot-0" data-slot-index="0" class="w-11 h-12 sm:w-12 sm:h-14 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-lg font-bold text-slate-800 dark:text-white transition-all duration-200 shadow-xs"></div>
        <div id="pin-dot-slot-1" data-slot-index="1" class="w-11 h-12 sm:w-12 sm:h-14 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-lg font-bold text-slate-800 dark:text-white transition-all duration-200 shadow-xs"></div>
        <div id="pin-dot-slot-2" data-slot-index="2" class="w-11 h-12 sm:w-12 sm:h-14 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-lg font-bold text-slate-800 dark:text-white transition-all duration-200 shadow-xs"></div>
        <div id="pin-dot-slot-3" data-slot-index="3" class="w-11 h-12 sm:w-12 sm:h-14 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-lg font-bold text-slate-800 dark:text-white transition-all duration-200 shadow-xs"></div>
        <div id="pin-dot-slot-4" data-slot-index="4" class="w-11 h-12 sm:w-12 sm:h-14 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-lg font-bold text-slate-800 dark:text-white transition-all duration-200 shadow-xs"></div>
        <div id="pin-dot-slot-5" data-slot-index="5" class="w-11 h-12 sm:w-12 sm:h-14 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-lg font-bold text-slate-800 dark:text-white transition-all duration-200 shadow-xs"></div>
    </div>

    <!-- On-Screen Numeric Keypad -->
    <div id="pin-keypad" class="grid grid-cols-3 gap-2.5 sm:gap-3 select-none">
        <button type="button" id="pin-keypad-btn-1" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="1">
            <span>1</span>
        </button>
        <button type="button" id="pin-keypad-btn-2" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="2">
            <span>2</span>
            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">ABC</span>
        </button>
        <button type="button" id="pin-keypad-btn-3" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="3">
            <span>3</span>
            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">DEF</span>
        </button>
        <button type="button" id="pin-keypad-btn-4" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="4">
            <span>4</span>
            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">GHI</span>
        </button>
        <button type="button" id="pin-keypad-btn-5" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="5">
            <span>5</span>
            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">JKL</span>
        </button>
        <button type="button" id="pin-keypad-btn-6" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="6">
            <span>6</span>
            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">MNO</span>
        </button>
        <button type="button" id="pin-keypad-btn-7" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="7">
            <span>7</span>
            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">PQRS</span>
        </button>
        <button type="button" id="pin-keypad-btn-8" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="8">
            <span>8</span>
            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">TUV</span>
        </button>
        <button type="button" id="pin-keypad-btn-9" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="9">
            <span>9</span>
            <span class="text-3xs text-slate-400 font-normal uppercase tracking-widest leading-none">WXYZ</span>
        </button>
        <button type="button" id="pin-keypad-btn-clear" class="cursor-pointer h-12 sm:h-13 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-rose-50 dark:hover:bg-rose-950/40 text-rose-600 dark:text-rose-400 font-bold text-sm transition-all duration-150 border border-transparent hover:border-rose-200" data-action="clear" aria-label="Clear PIN">
            <span>Clear</span>
        </button>
        <button type="button" id="pin-keypad-btn-0" class="cursor-pointer h-12 sm:h-13 flex flex-col items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 active:bg-emerald-100 dark:active:bg-emerald-900/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg transition-all duration-150 shadow-xs" data-key="0">
            <span>0</span>
        </button>
        <button type="button" id="pin-keypad-btn-back" class="cursor-pointer h-12 sm:h-13 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold transition-all duration-150" data-action="backspace" aria-label="Backspace">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l7-7h11a2 2 0 012 2v10a2 2 0 01-2 2H10l-7-7z"></path></svg>
        </button>
    </div>

</div>
<!-- END OF ELEMENT: pin-container -->
<?php
/**
 * END OF FILE: frontend/components/pin-pad.php
 */
?>
