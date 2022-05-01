<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Listado de Categorías
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="title">Listado de categorías</h2>
<h3 class="subtitle">Este es un listado de todas las categorías registradas</h3>
<div class="field">
    <a href="<?= base_url(route_to('categories.create')) ?>" class="button is-dark">Registrar categoría</a>
</div>

<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>FECHA DE REGISTRO</th>
            <th>FECHA DE ACTUALIZACIÓN</th>
            <th>ACCIONES</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($categories as $category): ?>
        <tr>
            <td><?= esc($category->id) ?></td>
            <td><?= esc($category->name) ?></td>
            <!-- Esto es posible gracias a que la entidad se le especifico que los campos de auditoria los trate como objetos de fecha (tipo Carbon) -->
            <td><?= esc($category->created_at->humanize()) ?></td>
            <td><?= esc($category->updated_at ? $category->updated_at->humanize() : '') ?></td>
            <td>
                <a href="<?= $category->getEditLink() ?>">Editar</a> | <a href="<?= $category->getDeleteLink() ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $pager->links() ?>
<?= $this->endSection() ?>