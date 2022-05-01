<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>
Registro de usuarios
<?= $this->endSection(); ?>

<?= $this->section('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
    crossorigin="anonymous" />
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<main class="section">
    <div class="container">
        <h1 class="title">Registrate ahora!</h1>
        <p class="subtitle">Solo debes ingresar algunos datos para comenzar a publicar.</p>
        <form action="<?= base_url(route_to('auth.store')) ?>" method="post">

            <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                    <input name="first_name" value="<?= old('first_name') ?>" class="input" type="text" placeholder="Ingresa tu nombre">
                </div>
                <p class="is-danger help"><?= session('errors.first_name') ?></p>
            </div>

            <div class="field">
                <label class="label">Apellidos</label>
                <div class="control">
                    <input name="last_name" value="<?= old('last_name') ?>" class="input" type="text" placeholder="Ingresa tus apellidos">
                </div>
                <p class="is-danger help"><?= session('errors.last_name') ?></p>
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left has-icons-right">
                    <input name="email" value="<?= old('email') ?>" class="input" type="email" placeholder="Ingresa tu correo electrónico">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <span class="icon is-small is-right">
                        <i class="fas fa-exclamation-triangle"></i>
                    </span>
                </div>
                <p class="help is-danger"><?= session('errors.email') ?></p>
            </div>

            <div class="field">
                <label class="label">País</label>
                <div class="control">
                    <div class="select">
                        <select name="country_id">
                            <option value="" disabled selected>Selecciona tu país de origen</option>
                            <!-- set_select() es una función de utilidad que se incluye en el helper form -->
                            <?php foreach ($countries as $country): ?>
                                <option value="<?= $country->id; ?>" <?= set_select('country_id', $country->id) ?>><?= $country->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <p class="is-danger help"><?= session('errors.country_id') ?></p>
            </div>

            <div class="field">
                <label class="label">Contraseña</label>
                <div class="control">
                    <input name="password" class="input" type="password" placeholder="Ingresa tu contraseña">
                </div>
                <p class="is-danger help"><?= session('errors.password') ?></p>
            </div>

            <div class="field">
                <label class="label">Confirmar contraseña</label>
                <div class="control">
                    <input name="confirm_password" class="input" type="password" placeholder="Confirma tu contraseña">
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link">Registar</button>
                </div>
            </div>
        </form>
    </div>
</main>
<?= $this->endSection(); ?>