<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title'); ?></title>
    <!-- Estilos globales para la aplicación -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <!-- Estilos particulares de cada vista -->
    <?= $this->renderSection('css'); ?>
</head>

<body>
    <!-- Incluir archivos parciales (estáticos) -->
    <?= $this->include('partials/header'); ?>

    <!-- Incluir secciones dinámicas -->
    <?= $this->renderSection('content'); ?>

    <?= $this->include('partials/footer'); ?>

    <!-- Scripts particulares de cada vista -->
    <?= $this->renderSection('js'); ?>
</body>

</html>