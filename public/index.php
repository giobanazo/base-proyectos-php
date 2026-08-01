<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../app/ENV.php';
require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/models/DB.php';

ENV::load(__DIR__ . '/../.env');
DB::initDB();


spl_autoload_register(function ($class): void {
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

$Router->get('/', [HomeController::class, 'index']);

$Router->get('/login', [AuthController::class, 'login']);
$Router->post('/login', [AuthController::class, 'authenticate']);
$Router->get('/logout', [AuthController::class, 'logout']);

$Router->get('/register', [AuthController::class, 'register']);
$Router->post('/register', [AuthController::class, 'createUser']);

$Router->apiGet('/api/datos', [APIController::class, 'obtenerDatos']);

$Router->comprobarRutas();