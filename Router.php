<?php
declare(strict_types=1);

class Router {
  private array $routes = [];
  private array $apiRoutes = [];

  private function addRoute(string $httpMethod, string $url, array $fn, bool $isApi = false): void {
    $route = [
      'method' => $httpMethod,
      'url' => $url,
      'fn' => $fn,
    ];

    if ($isApi) {
      $this->apiRoutes[] = $route;
    } else {
      $this->routes[] = $route;
    }
  }

  public function get(string $url, array $fn): void {
    $this->addRoute('GET', $url, $fn);
  }

  public function post(string $url, array $fn): void {
    $this->addRoute('POST', $url, $fn);
  }

  // Rutas API
  public function apiGet(string $url, array $fn): void {
    $this->addRoute('GET', $url, $fn, true);
  }
  
  public function apiPost(string $url, array $fn): void {
    $this->addRoute('POST', $url, $fn, true);
  }
  
  public function apiPut(string $url, array $fn): void {
    $this->addRoute('PUT', $url, $fn, true);
  }

  public function apiPatch(string $url, array $fn): void {
    $this->addRoute('PATCH', $url, $fn, true);
  }
  
  public function apiDelete(string $url, array $fn): void {
    $this->addRoute('DELETE', $url, $fn, true);
  }


  private function convertToRegex(string $url): string {
    $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $url);
    return '#^' . $pattern . '$#';
  }

  public function comprobarRutas(): void {
    $method = $_SERVER['REQUEST_METHOD'];
    $urlActual = $_SERVER['REQUEST_URI'] ?? '/';

    if (str_starts_with($urlActual, '/api/')) {
      header('Content-Type: application/json; charset=utf-8');
      
      $isApiRoute = $this->matchRoute($this->apiRoutes, $method, $urlActual);

      if (!$isApiRoute) {
        http_response_code(404);
        echo json_encode([
          'status' => 'ERROR',
          'response' => [
            'mensaje' => 'No existe el endpoint de la API solicitado'
          ]
        ]);
      }
      
      exit();
    }
    
    $isNormalRoute = $this->matchRoute($this->routes, $method, $urlActual);      
    if (!$isNormalRoute) {
      http_response_code(404);
      $this->render('pages/404', [], false);
    }
  }

  private function matchRoute(array $routes, string $method, string $url): bool {
    foreach ($routes as $route) {
      if ($route['method'] !== $method) continue;
      
      $pattern = $this->convertToRegex($route['url']);
      if (preg_match($pattern, $url, $matches)) {
        array_shift($matches);
        
        call_user_func_array($route['fn'], [$this, $matches]);
        return true;
      }
    }
    return false;
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