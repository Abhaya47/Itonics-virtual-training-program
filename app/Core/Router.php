<?php

namespace App\Core;

/**
 * Router Class
 * A simple Laravel-like router for handling HTTP requests
 */
class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    /**
     * Register a GET route
     */
    public function get(string $uri, array $action): self
    {
        $this->addRoute('GET', $uri, $action);
        return $this;
    }

    /**
     * Register a POST route
     */
    public function post(string $uri, array $action): self
    {
        $this->addRoute('POST', $uri, $action);
        return $this;
    }

    /**
     * Register a PUT route
     */
    public function put(string $uri, array $action): self
    {
        $this->addRoute('PUT', $uri, $action);
        return $this;
    }

    /**
     * Register a DELETE route
     */
    public function delete(string $uri, array $action): self
    {
        $this->addRoute('DELETE', $uri, $action);
        return $this;
    }

    /**
     * Add route to collection
     */
    private function addRoute(string $method, string $uri, array $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $action[0],
            'action' => $action[1]
        ];
    }

    /**
     * Dispatch the request to appropriate controller
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove base path if exists
        if ($this->basePath && strpos($uri, $this->basePath) === 0) {
            $uri = substr($uri, strlen($this->basePath));
        }
        
        // Handle PUT/DELETE from forms using _method field
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            $pattern = $this->convertToRegex($route['uri']);
            
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                $this->executeAction($route['controller'], $route['action'], $matches);
                return;
            }
        }

        // No route found
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    /**
     * Convert URI pattern to regex
     */
    private function convertToRegex(string $uri): string
    {
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }

    /**
     * Execute the controller action
     */
    private function executeAction(string $controller, string $action, array $params): void
    {
        $controllerInstance = new $controller();
        call_user_func_array([$controllerInstance, $action], $params);
    }

    /**
     * Get all registered routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
