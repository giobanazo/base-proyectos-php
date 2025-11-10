<?php
function debuguear($variable): string {
  echo "<pre>";
  var_dump($variable);
  echo "</pre>";
  exit;
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