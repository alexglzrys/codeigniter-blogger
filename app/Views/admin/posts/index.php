<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Lista de Artículos
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="section">
    <div class="container">
        <h2 class="title">Posts</h2>
        <h3 class="subtitle">Estos son los posts del momento</h3>
        <div class="field">
            <a href="<?= base_url(route_to('posts.create')) ?>" class="button is-dark">Crear Post</a>
        </div>
    </div>
</main>

<?= $this->endSection() ?>

