<?php
require_once __DIR__ . '/../models/Usuario.php';

class Home {
  public static function index(Router $Router, array $params): void {
  
    $ingresos = Usuario::getIngresos();
    var_dump($ingresos);

    $Router->render('inicio', ['titulo' => 'Inicio', 'page' => 'inicio']);
  }
}