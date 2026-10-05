<?php
namespace App\core;

/* START: Vite — asset loader supporting hot dev server and production manifest */
class Vite
{
    /* START: tags — renders HTML link and script tags for Vite bundles */
    public static function tags(string $entry = 'frontend/src/js/main.js'): string
    {
        $isDev = filter_var($_ENV['VITE_DEV'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $devServer = rtrim($_ENV['VITE_DEV_URL'] ?? 'http://localhost:5173', '/');

        if ($isDev) {
            return <<<HTML
    <script type="module" src="{$devServer}/@vite/client"></script>
    <script type="module" src="{$devServer}/{$entry}"></script>
HTML;
        }

        $rootPath = dirname(__DIR__, 2);
        $manifestPath = $rootPath . '/dist/.vite/manifest.json';
        if (!file_exists($manifestPath)) {
            $manifestPath = $rootPath . '/dist/manifest.json';
        }

        if (!file_exists($manifestPath)) {
            return '<!-- Vite build manifest not found. Run npm run build. -->';
        }

        $manifest = json_decode(file_get_contents($manifestPath), true) ?: [];
        $item = $manifest[$entry] ?? null;

        if (!$item) {
            return "<!-- Vite entry '{$entry}' not found in manifest -->";
        }

        $html = '';

        // Inject CSS bundles
        if (!empty($item['css'])) {
            foreach ($item['css'] as $cssFile) {
                $html .= "    <link rel=\"stylesheet\" href=\"/dist/{$cssFile}\">\n";
            }
        }

        // Inject JS bundle
        if (!empty($item['file'])) {
            $html .= "    <script type=\"module\" src=\"/dist/{$item['file']}\"></script>\n";
        }

        return trim($html);
    }
    /* END: tags */
}
/* END: Vite */
