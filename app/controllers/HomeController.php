<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Usuario.php';

class HomeController {
  public static function index(Router $Router, array $params): void {
    $Router->render('inicio', ['titulo' => 'Inicio', 'page' => 'inicio']);
  }
}