<?php 

require_once __DIR__ . '/../includes/app.php';

/* Para utilizar los "use" necesitamos incluir los ficheros en donde estan los archivos que tenga el namespace
gracias a composer y a su autoload no necesitamos hacer un include o require a los ficheros */

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoguinController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

// Iniciar Sesión
$router->get("/", [LoguinController::class, "login"]);
$router->post("/", [LoguinController::class, "login"]);
$router->get("/logout", [LoguinController::class, "logout"]);


// Recuperar Password
$router->get("/olvide", [LoguinController::class, "olvide"]);
$router->post("/olvide", [LoguinController::class, "olvide"]);
$router->get("/recuperar", [LoguinController::class, "recuperar"]);
$router->post("/recuperar", [LoguinController::class, "recuperar"]);


// Crear cuenta
$router->get("/crear-cuenta", [LoguinController::class, "crear"]);
$router->post("/crear-cuenta", [LoguinController::class, "crear"]);


// Confirmar cuenta
$router->get('/confirmar-cuenta', [LoguinController::class, "confirmar"]);
$router->get('/mensaje', [LoguinController::class, "mensaje"]);


/* --- Controlador de CitaController --- (Area Privada)*/ 
$router->get('/cita', [CitaController::class, "index"]);
$router->get('/admin', [AdminController::class, "index"]);



// API de Citas
$router->get('/api/servicios', [APIController::class, "index"]);
$router->post('/api/citas', [APIController::class, "guardar"]);
$router->post('/api/eliminar', [APIController::class, "eliminar"]);


// CRUD de Servicios
$router->get('/servicios', [ServicioCOntroller::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();