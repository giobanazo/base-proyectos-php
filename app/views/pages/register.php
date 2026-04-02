<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crear cuenta</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet" />
</head>

<body class="bg-light">

  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-sm-8 col-md-6 col-lg-4">

        <div class="card mt-4">
          <div class="card-body p-4">

            <h4 class="card-title mb-4">Crear cuenta</h4>

            <form action="/register" method="POST">
              <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" placeholder="Elige un usuario" />
              </div>

              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre completo" />
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" placeholder="ejemplo@correo.com" />
              </div>

              <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" placeholder="Crea una contraseña" />
              </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Registrarme</button>
              </div>

              <div class="text-center">
                <small>¿Ya tienes cuenta? <a href="#">Inicia sesión</a></small>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>