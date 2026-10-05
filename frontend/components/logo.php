<?php
/* START: LogoComponent — brand logo and title */
$size = $logoSize ?? 'default';
$imgClass = ($size === 'small') ? 'h-10 w-auto' : 'h-16 w-auto sm:h-20';
?>
<div id="brand-logo-container" class="flex items-center gap-4">
    <img
        id="brand-logo-image"
        src="/frontend/src/public/images/logo/logo.png"
        alt="DILP Logo"
        class="<?= $imgClass ?> object-contain drop-shadow-sm"
        onerror="this.style.display='none'; document.getElementById('brand-logo-fallback').classList.remove('hidden');"
    >
    <!-- Fallback badge if image is not yet loaded -->
    <div id="brand-logo-fallback" class="hidden flex items-center justify-center size-14 rounded-2xl bg-primary-700 text-white font-black text-2xl shadow-md">
        DILP
    </div>
    <div id="brand-logo-text" class="flex flex-col">
        <span id="brand-logo-title" class="text-xs sm:text-sm font-bold uppercase tracking-wider text-primary-800">
            DOLE Integrated Livelihood Program
        </span>
        <span id="brand-logo-acronym" class="text-2xl sm:text-3xl font-extrabold tracking-tight text-ink-950 font-sans">
            DILP System
        </span>
    </div>
</div>
<?php
/* END: LogoComponent */
