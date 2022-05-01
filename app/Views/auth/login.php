<?= $this->extend('layout/app') ?>

<?= $this->section('title') ?>
Login
<?= $this->endSection() ?>

<?= $this->section('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
    crossorigin="anonymous" />
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<main class="section">
    <div class="container">

        <!-- Componente para mostrar mensajes enviados via flash a esta vista -->
        <?php if (session('message')): ?>
        <article class="message is-<?= session('message.type') ?>">
            <div class="message-header">
                <p>Aviso del sistema</p>
                <button class="delete" aria-label="delete"></button>
            </div>
            <div class="message-body">
                <?= session('message.body') ?>
            </div>
        </article>
        <?php endif; ?>

        <h2 class="title">Login</h2>
        <h3 class="subtitle">Ingresa al sistema ahora</h3>

        <form action="<?= base_url(route_to('auth.signin')) ?>" method="post">
            <div class="field">
                <p class="control has-icons-left has-icons-right">
                    <input name="email" value="<?= old('email') ?>" class="input" type="email" placeholder="Email">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <span class="icon is-small is-right">
                        <i class="fas fa-check"></i>
                    </span>
                </p>
                <p class="is-danger help"><?= session('errors.email') ?></p>
            </div>
            <div class="field">
                <p class="control has-icons-left">
                    <input name="password" class="input" type="password" placeholder="Password">
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </p>
                <p class="is-danger help"><?= session('errors.password') ?></p>
            </div>
            <div class="field">
                <p class="control">
                    <button type="submit" class="button is-info">
                        Acceder
                    </button>
                </p>
            </div>
        </form>
    </div>
</main>
<?= $this->endSection() ?>