<?php 

use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
/* .env dentro de este archivo ponemos nuestra variables de entorno para que las personas no las pueda verlas */

/* vlucas/phpdotenv Asi de llama la libreria para el Deployment */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos

ActiveRecord::setDB($db);