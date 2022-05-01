<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Editar categoría - <?= $category->name ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="title">Editar Categoría</h2>
<h3 class="subtitle">Ingrese los nuevos datos asociados con esta categoría</h3>
<form action="<?= base_url(route_to('categories.update', $category->id)) ?>" method="post">
    <div class="field">
        <label class="label">Nombre</label>
        <div class="control">
            <input name="name" value="<?= old('name', esc($category->name)) ?>" class="input" type="text" placeholder="Ingrese el nombre de la nueva categoría">
        </div>
        <span class="is-danger help"><?= session('errors.name') ?></span>
    </div>
    <div class="field">
        <p class="control">
            <button type="submit" class="button is-dark">Actualizar</button>
        </p>
    </div>
</form>
<?= $this->endSection() ?>