<?php
class AuthService {
  private static function crearRememberToken(int $idUsuario): void {
    $token = bin2hex(random_bytes(32));
    $oneMonthInUnix = time() + 2592000;

    UserRememberToken::create([
      'token_hash' => hash('sha256', $token),
      'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
      'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
      'expires_at' => date('Y-m-d H:i:s', $oneMonthInUnix),
      'id_usuario' => $idUsuario
    ]);

    setearCookie('remember_token', $token, $oneMonthInUnix);
  }

  public static function login(string $usuario, string $password, bool $recordarme = false): array {
    $validation = Usuario::validateLogin(['usuario' => $usuario, 'password' => $password]);

    if (!$validation['valid']) {
      return [
        'exitoso' => false,
        'mensajes' => $validation['mensajes']
      ];
    }

    $usuarioValido = Usuario::findByCredentials($validation['datos']['usuario'], $validation['datos']['password']);

    if (!$usuarioValido) {
      return [
        'exitoso' => false,
        'mensajes' => ['Usuario o contraseña incorrectos']
      ];
    }

    $_SESSION['user'] = [
      'id' => $usuarioValido['id'],
      'nombre' => $usuarioValido['nombre'],
      'usuario' => $usuarioValido['usuario'],
      'email' => $usuarioValido['email'],
    ];

    if ($recordarme) {
      self::crearRememberToken($usuarioValido['id']);
    }

    return [
      'exitoso' => true,
      'mensajes' => ['Sesión iniciada correctamente']
    ];
  }

}