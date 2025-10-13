<?php
class Usuario extends DB {
  protected static $tabla = 'usuarios';

  public static function saludar(string $nombre): string {

    return "Hola usuario $nombre, como estas?";

  }
}