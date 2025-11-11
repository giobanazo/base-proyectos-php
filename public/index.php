<?php
require_once __DIR__ . '/../app/ENV.php';
require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/models/DB.php';

ENV::load(__DIR__ . '/../.env');
DB::initDB();


spl_autoload_register(function ($class) {
  require_once __DIR__ . "/../app/controllers/$class.php";
});


$Router = new Router();

$Router->get('/login', [Auth::class, 'login']);
$Router->post('/login', [Auth::class, 'login']);

$Router->apiGet('/api/datos', [API::class, 'obtenerDatos']);

$Router->comprobarRutas();