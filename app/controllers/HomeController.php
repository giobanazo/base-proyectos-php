<?php
declare(strict_types=1);
require_once __DIR__ . '/../services/AuthService.php';

class HomeController {
  public static function index(Router $Router, array $params): void {
    AuthService::requireAuth();
    $Router->render('inicio', ['titulo' => 'Inicio', 'page' => 'inicio']);
  }
}