<?php
declare(strict_types=1);

class Usuario extends DB {
  protected static $tabla = 'usuarios';

  public static function validate(array $datos): array {
    $errores = [];

    $usuario = trim($datos['usuario'] ?? '');
    $nombre = trim($datos['nombre'] ?? '');
    $email = trim($datos['email'] ?? '');
    $password = $datos['password'] ?? '';

    if (empty($usuario)) {
      $errores[] = 'El usuario es obligatorio.';
    }

    if (empty($nombre)) {
      $errores[] = 'El nombre es obligatorio.';
    }

    if (empty($email)) {
      $errores[] = 'El email es obligatorio.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errores[] = 'El email no es válido.';
    }

    if (empty($password)) {
      $errores[] = 'La contraseña es obligatoria.';
    } else if (strlen($password) < 8) {
      $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
    }

    // Solo validar existencia si los campos básicos son correctos
    if (empty($errores) && self::existsUserOrEmail($usuario, $email)) {
      $errores[] = 'El usuario o email ya están registrados.';
    }

    return [
      'valid' => empty($errores),
      'mensajes' => $errores,
      'datos' => [
        'usuario' => $usuario,
        'nombre' => $nombre,
        'email' => $email,
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