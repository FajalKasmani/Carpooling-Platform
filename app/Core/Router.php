<?php
namespace App\Core;

/**
 * Router — Minimal HTTP router with named params and middleware.
 */
class Router
{
    private array $routes = [];

    /**
     * Register a route.
     *
     * @param string   $method     HTTP method (GET, POST, PUT, DELETE)
     * @param string   $path       URI pattern, e.g. '/trip/:id/start'
     * @param array    $handler    [ControllerClass::class, 'methodName']
     * @param array    $middleware Array of middleware class names
     */
    public function add(string $method, string $path, array $handler, array $middleware = []): void
    {
        $this->routes[] = compact('method', 'path', 'handler', 'middleware');
    }

    /** Convenience: GET route */
    public function get(string $path, array $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    /** Convenience: POST route */
    public function post(string $path, array $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    /** Convenience: PUT route */
    public function put(string $path, array $handler, array $middleware = []): void
    {
        $this->add('PUT', $path, $handler, $middleware);
    }

    /** Convenience: DELETE route */
    public function delete(string $path, array $handler, array $middleware = []): void
    {
        $this->add('DELETE', $path, $handler, $middleware);
    }

    /**
     * Dispatch the current request to the matching route.
     */
    public function dispatch(string $method, string $uri): void
    {
        // Strip query string and trailing slash
        $uri = strtok($uri, '?');
        $uri = rtrim($uri, '/') ?: '/';

        // Strip the base path (for XAMPP subdirectory installs)
        $basePath = $this->getBasePath();
        if ($basePath && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath)) ?: '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $params = [];
            if ($this->matches($route['path'], $uri, $params)) {
                // Run middleware chain
                foreach ($route['middleware'] as $mw) {
                    (new $mw())->handle();
                }

                // Call controller action
                [$class, $action] = $route['handler'];
                $controller = new $class();
                $controller->$action(...array_values($params));
                return;
            }
        }

        // No route matched
        http_response_code(404);
        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => '404 Not Found']);
        } else {
            echo '<h1>404 — Page Not Found</h1>';
        }
    }

    /**
     * Match a route pattern against a URI, extracting named params.
     */
    private function matches(string $pattern, string $uri, array &$params): bool
    {
        // Convert :param placeholders to named regex groups
        $regex = preg_replace('#:(\w+)#', '(?P<$1>[^/]+)', $pattern);

        if (preg_match("#^{$regex}$#", $uri, $matches)) {
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }

        return false;
    }

    /**
     * Detect AJAX requests.
     */
    private function isAjax(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json'));
    }

    /**
     * Determine the base path for subdirectory installs.
     * For XAMPP: /CarPooling/public
     */
    private function getBasePath(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        return dirname($scriptName);
    }
}
