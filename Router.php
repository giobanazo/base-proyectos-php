<?php
class Router {
  private array $routes = [];

  private function addRoute(string $httpMethod, string $url, array $fn): void {
    $this->routes[] = [
      'method' => $httpMethod,
      'url' => $url,
      'fn' => $fn,
    ];
  }

  public function get(string $url, array $fn): void {
    $this->addRoute('GET', $url, $fn);
  }

  public function post(string $url, array $fn): void {
    $this->addRoute('POST', $url, $fn);
  }

  private function convertToRegex(string $url): string {
    $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $url);
    return '#^' . $pattern . '$#';
  }

  public function comprobarRutas(): void {
    $method = $_SERVER['REQUEST_METHOD'];
    $urlActual = $_SERVER['REQUEST_URI'] ?? '/';

    foreach ($this->routes as $route) {
      if ($route['method'] !== $method) continue;

      $pattern = $this->convertToRegex($route['url']);

      if (preg_match($pattern, $urlActual, $matches)) {
        array_shift($matches);
        call_user_func_array($route['fn'], [$this, $matches]);
        return;
      }
    }

    http_response_code(404);
    $this->render('pages/404', [], false);
  }

  public function render(string $view, array $datos = [], bool $layout = true): void {
    foreach ($datos as $key => $value) {
      $$key = $value;
    }

    if ($layout) {
      ob_start();
      include_once __DIR__ . "/app/views/$view.php";
      $contenido = ob_get_clean(); // Limpia el Buffer
      include_once __DIR__ . '/app/views/layout.php';
    } else {
      include_once __DIR__ . "/app/views/$view.php";
    }
  }
}