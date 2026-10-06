<?php
/* START: HeadComponent — common HTML head metadata and asset links */
use App\core\Csrf;
use App\core\Vite;

$pageTitle = $pageTitle ?? 'Livelihood - DOLE Integrated Livelihood System';
$packageJson = json_decode(file_get_contents(dirname(__DIR__, 2) . '/package.json'), true);
$appVersion = $packageJson['version'] ?? '1.0.0';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">
<meta name="app-version" content="<?= htmlspecialchars($appVersion, ENT_QUOTES, 'UTF-8') ?>">

<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>

<!-- Google Fonts (Poppins) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="32x32" href="<?= Vite::asset('frontend/src/public/images/icons/favicon.png') ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?= Vite::asset('frontend/src/public/images/icons/favicon.png') ?>">
<link rel="shortcut icon" type="image/png" href="<?= Vite::asset('frontend/src/public/images/icons/favicon.png') ?>">
<link rel="apple-touch-icon" href="<?= Vite::asset('frontend/src/public/images/icons/favicon.png') ?>">

<!-- Vite Compiled / Dev Assets -->
<?= Vite::tags('frontend/src/js/main.js') ?>
<?php
/* END: HeadComponent */
