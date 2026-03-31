<?php
declare(strict_types=1);

class Usuario extends DB {
  protected static $tabla = 'usuarios';

  public static function validateLogin(array $datos): array {
    $errores = [];

    $usuario = trim($datos['usuario'] ?? '');
    $password = $datos['password'] ?? '';

    if (empty($usuario)) {
      $errores[] = 'El usuario es obligatorio.';
    }

    if (empty($password)) {
      $errores[] = 'La contraseña es obligatoria.';
    }

    return [
      'valid' => empty($errores),
      'mensajes' => $errores,
      'datos' => [
        'usuario' => $usuario,
        'password' => $password
      ]
    ];
  }

  public static function findByCredentials(string $user, string $password): array|bool {
    $resultado = self::find($user, ['usuario', 'nombre', 'password'], 'usuario');

    if (!$resultado) return false;

    if (password_verify($password, $resultado['password'])) {
      unset($resultado['password']);
      return $resultado;
    }

    return false;
  }

  public static function existsUserOrEmail(string $user, string $email): bool {
    return !empty(self::whereMultiple(['usuario' => $user, 'email' => $email], 'OR'));
  }
}