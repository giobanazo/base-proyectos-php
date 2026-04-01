<?php
declare(strict_types=1);
require_once __DIR__ . '/../services/AuthService.php';

require_once __DIR__ . '/../models/Usuario.php';

class Auth {
  public static function login(Router $Router, array $params): void {
    $Router->render('pages/login', [], false);
  }

  public static function logout(): void {
    AuthService::requireAuth();
    AuthService::logout();
    redirect('/login');
  }
}