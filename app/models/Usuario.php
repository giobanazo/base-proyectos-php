<?php
class Usuario extends DB {
  protected static $tabla = 'ingresos';

  public static function getIngresos(): array {
    return self::all();
  }
}