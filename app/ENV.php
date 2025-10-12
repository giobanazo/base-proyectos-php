<?php
class ENV {
  private static array $vars = [];

  public static function load(string $path): void {
    if (!file_exists($path)) {
      throw new Exception("Archivo .env no encontrado en: {$path}");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
      // Ignorar comentarios
      if (strpos(trim($line), '#') === 0) {
        continue;
      }

      // Parsear KEY=VALUE
      if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Remover comillas si existen
        $value = trim($value, '"\'');

        self::$vars[$key] = $value;

        // También establecer en $_ENV y putenv() para compatibilidad
        $_ENV[$key] = $value;
        putenv("{$key}={$value}");
      }
    }
  }

  public static function get(string $key, mixed $default = null): mixed {
    return self::$vars[$key] ?? $_ENV[$key] ?? getenv($key) ?: $default;
  }
}
