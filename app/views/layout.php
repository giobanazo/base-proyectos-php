<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Finanzas - <?php echo $titulo; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <?php if (file_exists("./../public/css/bypages/$page.css")): ?>
    <link href="/css/bypages/<?= $page ?>.css" rel="stylesheet">
  <?php endif ?>
</head>

<body>
  <?php
  include_once __DIR__ . '/templates/header.php';
  echo $contenido;
  include_once __DIR__ . '/templates/footer.php';
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

  <?php if (file_exists("./../public/js/bypages/$page.js")): ?>
    <script src="/js/bypages/<?= $page ?>.js" defer></script>
  <?php endif ?>
</body>

</html>