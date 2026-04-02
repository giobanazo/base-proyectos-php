<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <style>
    #alert-flash-container {
      margin-bottom: 1rem;
    }

    #alert-flash-container p {
      background-color: rgb(255, 0, 0);
      padding: .3rem .5rem;
      margin-bottom: .5rem;
      color: #fff;
      border-radius: .3rem;
    }
  </style>
</head>

<body class="bg-light">

  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-sm-8 col-md-6 col-lg-4">

        <div class="card mt-4">
          <div class="card-body p-4">

            <h4 class="card-title mb-4">Iniciar sesión</h4>

            <?php if ($errores = getFlash()): ?>
              <div id="alert-flash-container">
                <?php foreach ($errores as $error): ?>
                  <p><?= $error['mensaje'] ?></p>
                <?php endforeach ?>
              </div>
            <?php endif ?>

            <form>
              <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" placeholder="Ingresa tu usuario" autocomplete="username" />
              </div>

              <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" placeholder="Ingresa tu contraseña" autocomplete="current-password" />
              </div>

              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="recordarme" />
                <label class="form-check-label" for="recordarme">Recordarme</label>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Entrar</button>
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