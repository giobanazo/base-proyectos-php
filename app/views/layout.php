<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - <?= $titulo ?></title>
  <link rel="icon" type="image/svg+xml" href="/img/favicon.svg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
  <link href="/css/global.min.css" rel="stylesheet">
  <?php if (file_exists("./../public/css/bypages/$page.min.css")): ?>
    <link href="/css/bypages/<?= $page ?>.min.css" rel="stylesheet">
  <?php endif ?>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <i class="bi bi-wallet2"></i> Dashboard
    </div>
    <nav class="sidebar-nav">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a href="/" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>">
            <i class="bi bi-house-door"></i> Inicio
          </a>
        </li>
      </ul>
    </nav>
  </aside>

  <!-- Overlay para móviles -->
  <div class="sidebar-overlay" id="overlay"></div>

  <!-- Header -->
  <header class="header" id="header">
    <button class="toggle-sidebar" id="toggleSidebar">
      <i class="bi bi-list"></i>
    </button>
    <h1 class="page-title"><?= $titulo ?></h1>
    <div class="dropdown">
      <button class="btn btn-light dropdown-toggle" style="color: #2c3e50" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle fs-4"></i>
      </button>
      <ul class="dropdown-menu shadow" aria-labelledby="userDropdown">
        <li>
          <a class="dropdown-item dropdown-item-header text-danger" href="/logout">
            <i class="bi bi-box-arrow-right me-2"></i> Salir
          </a>
        </li>
      </ul>
    </div>
  </header>

  <main class="main-content" id="mainContent">
    <?= $contenido ?>
  </main>

  <?php if (file_exists("./../app/views/modals/$page.php")) include_once __DIR__ . "/modals/$page.php" ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="/js/global.min.js" defer></script>
  <?php if (file_exists("./../public/js/bypages/$page.min.js")): ?>
    <script src="/js/bypages/<?= $page ?>.min.js" defer></script>
  <?php endif ?>
</body>

<?php if ($flash = getFlash()): ?>
  <div id="alerta-flash-container">
    <div class="alert alert-<?= $flash['tipo'] ?> alert-dismissible" role="alert">
      <?= htmlspecialchars($flash['mensaje']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  </div>
<?php endif; ?>

</html>