<?php
declare(strict_types=1);

class Usuario extends DB {
  protected static string $tabla = 'usuarios';

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

  public static function validateRegister(array $datos): array {
    $errores = [];

    $usuario = trim($datos['usuario'] ?? '');
    $nombre = trim($datos['nombre'] ?? '');
    $email = trim($datos['email'] ?? '');
    $password = $datos['password'] ?? '';

    if (empty($usuario)) {
      $errores[] = 'El campo usuario es obligatorio.';

    } else if (mb_strlen($usuario) < 3) {
      $errores[] = 'El usuario debe tener al menos 3 caracteres.';

    } else if (mb_strlen($usuario) > 30) {
      $errores[] = 'El usuario no puede tener más de 30 caracteres.';

    } else if (!preg_match('/^[a-zA-Z0-9_-]+$/', $usuario)) {
      $errores[] = 'El usuario solo puede contener letras, números, - y _';
    }


    if (empty($nombre)) {
      $errores[] = 'El campo nombre es obligatorio.';

    } else if (mb_strlen($nombre) < 2) {
      $errores[] = 'El nombre debe tener al menos 2 caracteres.';
      
    } else if (mb_strlen($nombre) > 60) {
      $errores[] = 'El nombre no puede tener más de 60 caracteres.';

    } else if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s-]+$/', $nombre)) {
      $errores[] = 'El nombre solo puede contener letras, espacios y guion medio.';
    }


    if (empty($email)) {
      $errores[] = 'El campo email es obligatorio.';

    } else if (mb_strlen($email) > 255) {
      $errores[] = 'El email no puede tener más de 255 caracteres.';

    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errores[] = 'El correo electrónico no es válido.';
    }


    if (empty($password)) {
      $errores[] = 'La campo contraseña es obligatoria.';
    
    } else if (mb_strlen($password) < 8) {
      $errores[] = "La contraseña debe tener al menos 8 caracteres.";

    } else if (mb_strlen($password) > 60) {
      $errores[] = 'El contraseña no puede tener más de 60 caracteres.';
    }

    return [
      'valid' => empty($errores),
      'mensajes' => $errores,
      'datos' => [
        'usuario' => $usuario,
        'nombre' => $nombre,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'created_at' => date('Y-m-d H:i:s')
      ]
    ];
  }

  public static function findByCredentials(string $user, string $password): array|false {
    $resultado = self::find($user, ['id', 'usuario', 'nombre', 'email', 'password'], 'usuario');

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