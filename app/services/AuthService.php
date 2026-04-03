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

  public static function register(string $usuario, string $nombre, string $email, string $password): array {
    $validation = Usuario::validateRegister(['usuario' => $usuario, 'nombre' => $nombre, 'email' => $email, 'password' => $password]);

    if (!$validation['valid']) {
      return [
        'exitoso' => false,
        'mensajes' => $validation['mensajes']
      ];
    }

    $resultado = Usuario::create($validation['datos']);

    if (!$resultado) {
      return [
        'exitoso' => false,
        'mensajes' => ['Hubo un problema al crear tu cuenta. ¡Inténtelo más tarde!']
      ];
    }

    return [
      'exitoso' => true,
      'mensajes' => ['La cuenta se ha creado correctamente.']
    ];
  }

  public static function isAuthenticated(): bool {
    if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) return true;

    if (isset($_COOKIE['remember_token'])) {
      $usuario = UserRememberToken::verificarToken(hash('sha256', $_COOKIE['remember_token']));

      if ($usuario) {
        $_SESSION['user'] = [
          'id' => $usuario['id'],
          'nombre' => $usuario['nombre'],
          'usuario' => $usuario['usuario'],
          'email' => $usuario['email'],
        ];
        return true;
      }
    }

    setearCookie('remember_token', '', time() - 3600);
    return false;
  }

  public static function requireAuth(): void {
    if (!self::isAuthenticated()) {
      setFlash('danger', 'Debes iniciar sesión');
      redirect('/login');
    }
  }

  public static function requireGuest(): void {
    if (self::isAuthenticated()) {
      redirect('/');
    }
  }

  public static function logout(): void {
    $token = $_COOKIE['remember_token'] ?? null;

    if ($token) {
      UserRememberToken::delete(hash('sha256', $token), 'token_hash');
    }

    setearCookie('remember_token', '', time() - 3600);
    $_SESSION = [];
    session_destroy();
  }
}