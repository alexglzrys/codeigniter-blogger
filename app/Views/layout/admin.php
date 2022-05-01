<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <!-- Estilos CSS particulares de cada vista -->
    <?= $this->renderSection('css') ?>
</head>

<body>
    <?= $this->include('partials/admin/header') ?>

    <main class="section">
        <div class="container">
            <?= $this->include('partials/messages') ?>
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Scripts particulares de cada vista -->
    <?= $this->renderSection('js') ?>
</body>

</html>