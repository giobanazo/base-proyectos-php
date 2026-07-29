<?php
declare(strict_types=1);

function debuguear(mixed $variable): never {
  echo "<pre>";
  var_dump($variable);
  echo "</pre>";
  exit();
}

function redirect(string $url): never {
  header("Location: $url");
  exit();
}

function setearCookie(string $name, mixed $value, int $expires, string $path = '/'): void {
  setcookie($name, $value, [
    'expires' => $expires,
    'path' => $path,
    'secure' => ENV::get('COOKIE_SECURE', 'false') === 'true',
    'httponly' => ENV::get('COOKIE_HTTPONLY', 'true') === 'true',
    'samesite' => ENV::get('COOKIE_SECURE', 'false') === 'true' ? 'Strict' : 'Lax'
  ]);
}

function formatearMoneda(int|float|string $valor): string {
  return number_format($valor, 0, ',', '.');
}

function limpiarFormatoMoneda(string $valor): string {
  return str_replace('.', '', $valor);
}

function formatearFecha(string $fecha): string {
  return date('d-m-Y', strtotime($fecha));
}

function setFlash(string $tipo, string $mensaje): void {
  $_SESSION['flash'][] = [
    'tipo' => $tipo,
    'mensaje' => $mensaje
  ];
}

function getFlash(): array|null {
  if (!isset($_SESSION['flash'])) return null;

  $flash = $_SESSION['flash'];
  unset($_SESSION['flash']);
  return $flash;
}

function exportarXLS(string $filename, string $content, bool $download = true): never {
  $disposition = $download ? 'attachment' : 'inline';

  header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
  header("Content-Disposition: $disposition; filename=$filename.xls");
  header("Pragma: no-cache");
  header("Expires: 0");

  echo "\xEF\xBB\xBF";
  echo $content;

  exit();
}