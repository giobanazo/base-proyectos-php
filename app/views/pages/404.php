<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Página no encontrada</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    .container {
      text-align: center;
      padding: 40px;
      max-width: 600px;
    }

    .error-code {
      font-size: 120px;
      font-weight: bold;
      line-height: 1;
      margin-bottom: 20px;
      text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .error-message {
      font-size: 24px;
      margin-bottom: 10px;
      font-weight: 500;
    }

    .error-url {
      background: rgba(255, 255, 255, 0.1);
      padding: 10px 20px;
      border-radius: 8px;
      margin: 20px 0;
      font-family: monospace;
      word-break: break-all;
    }

    .btn {
      display: inline-block;
      padding: 12px 30px;
      background: white;
      color: #667eea;
      text-decoration: none;
      border-radius: 25px;
      font-weight: 600;
      margin-top: 20px;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .suggestions {
      margin-top: 30px;
      text-align: left;
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 8px;
    }

    .suggestions h3 {
      margin-bottom: 15px;
      font-size: 18px;
    }

    .suggestions ul {
      list-style: none;
      padding-left: 0;
    }

    .suggestions li {
      padding: 8px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .suggestions li:last-child {
      border-bottom: none;
    }

    .suggestions a {
      color: white;
      text-decoration: none;
      transition: opacity 0.2s;
    }

    .suggestions a:hover {
      opacity: 0.8;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="error-code">404</div>
    <h1 class="error-message"><?= $titulo ?? 'Página no encontrada' ?></h1>
    <p>La página que buscas no existe o ha sido movida.</p>

    <?php if (isset($url)): ?>
      <div class="error-url">
        <strong>URL:</strong> <?= htmlspecialchars($url) ?>
      </div>
    <?php endif; ?>

    <a href="/" class="btn">Volver al Inicio</a>

    <div class="suggestions">
      <h3>Páginas sugeridas:</h3>
      <ul>
        <li><a href="/login">🔐 Iniciar Sesión</a></li>
        <li><a href="/ingresos">💸 Ingresos</a></li>
        <li><a href="/gastos">📈 Gastos</a></li>
      </ul>
    </div>
  </div>
</body>

</html>