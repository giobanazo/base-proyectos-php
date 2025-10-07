<?php

/* Cuando es una consulta inner join o es una consulta que debemos mezclar tablas, para hacer esto dentro del active record debemos 
crear una clase dentro del modelo, y la tabla de dicha clase es la principal del inner join que es la tabla pivote
y sus columnas son la informacion que estamos trayendo dentro de la consulta */

namespace Model;

class AdminCita extends ActiveRecord {
    protected static $tabla = "citasServicios";
    protected static $columnasDB = ["id", "hora", "cliente", "email", 'telefono', 'servicio', 'precio'];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct() {
        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? "";
        $this->cliente = $args['cliente'] ?? "";
        $this->email = $args['email'] ?? "";
        $this->telefono = $args['telefono'] ?? "";
        $this->servicio = $args['servicio'] ?? "";
        $this->precio = $args['precio'] ?? "";
    }
}