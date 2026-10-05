<?php
namespace App\core;

/* START: Router — lightweight API routing engine */
class Router
{
    private static array $routes = [];

    /* START: add — registers an HTTP route definition */
    public static function add(string $method, string $path, string|callable $handler): void
    {
        $path = '/' . trim($path, '/');
        self::$routes[] = [
            'method'  => strtoupper($method),
            'path'    => $path,
            'handler' => $handler
        ];
    }
    /* END: add */

    /* START: get — registers a GET route */
    public static function get(string $path, string|callable $handler): void
    {
        self::add('GET', $path, $handler);
    }
    /* END: get */

    /* START: post — registers a POST route */
    public static function post(string $path, string|callable $handler): void
    {
        self::add('POST', $path, $handler);
    }
    /* END: post */

    /* START: put — registers a PUT route */
    public static function put(string $path, string|callable $handler): void
    {
        self::add('PUT', $path, $handler);
    }
    /* END: put */

    /* START: delete — registers a DELETE route */
    public static function delete(string $path, string|callable $handler): void
    {
        self::add('DELETE', $path, $handler);
    }
    /* END: delete */

    /* START: dispatch — matches incoming request and executes the route handler */
    public static function dispatch(string $method, string $uri): void
    {
        // Strip /api prefix if present
        if (str_starts_with($uri, '/api')) {
            $uri = substr($uri, 4);
        }
        $uri = '/' . trim($uri, '/');

        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            // Convert route pattern with parameters to regex (e.g. /users/{id} -> /users/(?P<id>[^/]+))
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if (is_callable($route['handler'])) {
                    call_user_func_array($route['handler'], $params);
                    return;
                }

                if (is_string($route['handler']) && str_contains($route['handler'], '@')) {
                    [$controllerName, $action] = explode('@', $route['handler']);
                    $controllerClass = "App\\controllers\\{$controllerName}";

                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass();
                        if (method_exists($controller, $action)) {
                            call_user_func_array([$controller, $action], $params);
                            return;
                        }
                    }
                }

                Response::error('Action handler not found', null, 500);
                return;
            }
        }

        Response::error('Route not found', ['uri' => $uri, 'method' => $method], 404);
    }
    /* END: dispatch */
}
/* END: Router */
