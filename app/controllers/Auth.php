<?php
require_once __DIR__ . '/../models/Usuario.php';

class Auth {
  public static function login(Router $Router, array $params): void {


    

    exit();
    /*
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $usuario = new Usuario($_POST);

      $alertas = $usuario->validarLogin();

      if (empty($alertas)) {
        // Verificar quel el usuario exista
        $usuario = Usuario::where('email', $usuario->email);
        if (!$usuario || !$usuario->confirmado) {
          Usuario::setAlerta('error', 'El Usuario No Existe o no esta confirmado');
        } else {
          // El Usuario existe
          if (password_verify($_POST['password'], $usuario->password)) {

            // Iniciar la sesión
            session_start();
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre;
            $_SESSION['apellido'] = $usuario->apellido;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['admin'] = $usuario->admin ?? null;
          } else {
            Usuario::setAlerta('error', 'Password Incorrecto');
          }
        }
      }
    }

    $alertas = Usuario::getAlertas();

    // Render a la vista 
    $router->render('auth/login', [
      'titulo' => 'Iniciar Sesión',
      'alertas' => $alertas
    ]);
    */
  }

  /*
  public static function logout() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      session_start();
      $_SESSION = [];
      header('Location: /');
    }
  }

  public static function registro(Router $router) {
    $alertas = [];
    $usuario = new Usuario;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $usuario->sincronizar($_POST);

      $alertas = $usuario->validar_cuenta();

      if (empty($alertas)) {
        $existeUsuario = Usuario::where('email', $usuario->email);

        if ($existeUsuario) {
          Usuario::setAlerta('error', 'El Usuario ya esta registrado');
          $alertas = Usuario::getAlertas();
        } else {
          // Hashear el password
          $usuario->hashPassword();

          // Eliminar password2
          unset($usuario->password2);

          // Generar el Token
          $usuario->crearToken();

          // Crear un nuevo usuario
          $resultado =  $usuario->guardar();

          // Enviar email
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarConfirmacion();


          if ($resultado) {
            header('Location: /mensaje');
          }
        }
      }
    }

    // Render a la vista
    $router->render('auth/registro', [
      'titulo' => 'Crea tu cuenta en DevWebcamp',
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);
  }
  */
}
