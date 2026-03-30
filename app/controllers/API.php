<?php
declare(strict_types=1);

class API {
  private static function send(string $status, string|array $response): void {
    echo json_encode(['status' => $status, 'response' => $response]);
    exit;
  }

  /*
  public static function getIngresoById(Router $Router, array $params): void {
    if (!isAuthenticated()) self::send('ERROR', 'ACCESS_DENIED');

    require_once __DIR__ . '/../models/Ingreso.php';

    $result = Ingreso::whereMultiple([
      'usuario' => $_SESSION['user']['usuario'],
      'id' => $params[0]
    ], 'AND', ['id', 'fecha', 'concepto', 'valor'])[0];

    $result ? self::send('OK', $result) : self::send('ERROR', 'NOT_FOUND');
  }
  */

  public static function obtenerDatos(Router $Router, array $params): void {
    self::send('OK', ['mensaje' => 'Obteniendo datos de la base de datos...']);
  }
}