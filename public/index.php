<?php
require_once __DIR__ . '/../app/ENV.php';
require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/models/DB.php';

ENV::load(__DIR__ . '/../.env');
DB::initDB();


spl_autoload_register(function ($class) {
  $paths = [
    __DIR__ . '/../app/controllers/',
    __DIR__ . '/../app/models/',
  ];

  foreach ($paths as $path) {
    $file = $path . $class . '.php';

    if (file_exists($file)) {
      require_once $file;
      return;
    }
  }
});


$Router = new Router();

$Router->get('/', [Home::class, 'index']);

$Router->get('/login', [Auth::class, 'login']);
$Router->post('/login', [Auth::class, 'login']);

$Router->apiGet('/api/datos', [API::class, 'obtenerDatos']);

$Router->comprobarRutas();