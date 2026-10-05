<?php
namespace App\core;

/* START: Vite — asset loader supporting hot dev server and production manifest */
class Vite
{
    /* START: tags — renders HTML link and script tags for Vite bundles */
    public static function tags(string $entry = 'frontend/src/js/main.js'): string
    {
        $devServer = rtrim($_ENV['VITE_DEV_URL'] ?? 'http://localhost:5173', '/');
        
        // Auto-detect if Vite dev server is currently running on localhost:5173
        $isDev = false;
        if (isset($_ENV['VITE_DEV'])) {
            $isDev = filter_var($_ENV['VITE_DEV'], FILTER_VALIDATE_BOOLEAN);
        } else {
            // Check if dev server port 5173 responds quickly
            $connection = @fsockopen('127.0.0.1', 5173, $errno, $errstr, 0.1);
            if (is_resource($connection)) {
                $isDev = true;
                fclose($connection);
            }
        }

        if ($isDev) {
            return <<<HTML
    <script type="module" src="{$devServer}/@vite/client"></script>
    <script type="module" src="{$devServer}/{$entry}"></script>
HTML;
        }

        // Determine base path for Laragon (e.g. /Livelihood or empty)
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = '';
        if (strpos($scriptName, '/Livelihood') === 0 || strpos($_SERVER['REQUEST_URI'] ?? '', '/Livelihood') === 0 || strpos($_SERVER['REQUEST_URI'] ?? '', '/livelihood') === 0) {
            // Check casing from request uri
            if (preg_match('#^/([^/]+)#', $_SERVER['REQUEST_URI'] ?? '', $m) && strtolower($m[1]) === 'livelihood') {
                $baseDir = '/' . $m[1];
            } else {
                $baseDir = '/Livelihood';
            }
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
                $html .= "    <link rel=\"stylesheet\" href=\"{$baseDir}/dist/{$cssFile}\">\n";
            }
        }

        // Inject JS bundle
        if (!empty($item['file'])) {
            $html .= "    <script type=\"module\" src=\"{$baseDir}/dist/{$item['file']}\"></script>\n";
        }

        return trim($html);
    }
    /* END: tags */

    /* START: asset — returns relative URL for public assets with base path support */
    public static function asset(string $path): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = '';
        if (strpos($scriptName, '/Livelihood') === 0 || strpos($_SERVER['REQUEST_URI'] ?? '', '/Livelihood') === 0 || strpos($_SERVER['REQUEST_URI'] ?? '', '/livelihood') === 0) {
            if (preg_match('#^/([^/]+)#', $_SERVER['REQUEST_URI'] ?? '', $m) && strtolower($m[1]) === 'livelihood') {
                $baseDir = '/' . $m[1];
            } else {
                $baseDir = '/Livelihood';
            }
        }
        $cleanPath = '/' . ltrim($path, '/');
        return $baseDir . $cleanPath;
    }
    /* END: asset */
}
/* END: Vite */
