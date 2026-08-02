<?php
declare(strict_types=1);

class UserRememberToken extends DB {
  protected static string $tabla = 'user_remember_tokens';

  public static function verificarToken(string $tokenHash): ?array {
    $resultado = self::query('
      SELECT usuarios.id, usuario, nombre, email 
      FROM user_remember_tokens
      INNER JOIN usuarios ON user_remember_tokens.id_usuario = usuarios.id 
      WHERE token_hash = ? AND expires_at > NOW()', [$tokenHash]
    )->fetch_assoc();

    return $resultado;
  }
}