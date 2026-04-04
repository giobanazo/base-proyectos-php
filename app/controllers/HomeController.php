<?php
declare(strict_types=1);
require_once __DIR__ . '/../services/AuthService.php';

class HomeController {
  public static function index(Router $Router, array $params): void {
    AuthService::requireAuth();
    setFlash('success', 'Hola este es una alerta de exito');
    setFlash('info', 'Hola este es una alerta de información');
    setFlash('danger', 'Hola este es una alerta de error');
    setFlash('warning', 'Hola este es una alerta de advertencia');

    $Router->render('inicio', ['titulo' => 'Inicio', 'page' => 'inicio']);
  }
}