<?php
declare(strict_types=1);
require_once __DIR__ . '/../services/AuthService.php';

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
  public static function login(Router $Router, array $params): void {
    $Router->render('pages/login', [], false);
  }

  public static function authenticate(Router $Router, array $params): void {
    AuthService::requireGuest();
    $resultado = AuthService::login($_POST['usuario'] ?? '', $_POST['password'] ?? '', isset($_POST['recordarme']));

    if ($resultado['exitoso']) {
      setFlash('success', $resultado['mensajes'][0]);
      header('Location: /');
    } else {
      foreach ($resultado['mensajes'] as $mensaje) {
        setFlash('danger', $mensaje);
      }
      header('Location: /login');
    }
    exit();
  }

  public static function logout(): void {
    AuthService::requireAuth();
    AuthService::logout();
    redirect('/login');
  }

  public static function register(Router $Router): void {
    AuthService::requireGuest();
    $Router->render('/pages/register', [], false);
  }


  public static function createUser(): void {
    AuthService::requireGuest();
    $resultado = AuthService::register($_POST['usuario'], $_POST['nombre'], $_POST['email'], $_POST['password']);

    if ($resultado['exitoso']) {
      setFlash('success', $resultado['mensajes'][0]);
      header('Location: /login');
    } else {
      foreach ($resultado['mensajes'] as $mensaje) {
        setFlash('danger', $mensaje);
      }
      header('Location: /register');
    }
    exit();
  }
}