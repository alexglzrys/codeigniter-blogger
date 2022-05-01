<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Registrar categorías
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="title">Registrar Categoría</h2>
<h3 class="subtitle">Ingrese la información asociada con la nueva categoría</h3>
<form action="<?= base_url(route_to('categories.store')) ?>" method="post">
    <div class="field">
        <label class="label">Nombre</label>
        <div class="control">
            <input name="name" value="<?= old('name') ?>" class="input" type="text" placeholder="Ingrese el nombre de la nueva categoría">
        </div>
        <span class="is-danger help"><?= session('errors.name') ?></span>
    </div>
    <div class="field">
        <p class="control">
            <button type="submit" class="button is-dark">Registrar</button>
        </p>
    </div>
</form>
<?= $this->endSection() ?>