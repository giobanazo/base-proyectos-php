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
}