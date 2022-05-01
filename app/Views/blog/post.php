<?= $this->extend('layout/app') ?>

<?= $this->section('title') ?>
<?= $post->title ?> - Mi Blog
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="section">
    <div class="container">
        <div class="content">
            <img src="<?= $post->getLinkImage() ?>" alt="Cover" style="display: block; width: 100%; height: 300px; object-fit: cover; margin-bottom: 1rem">
            <h1 ><?= $post->title ?></h1>
            <h3>Por: <?= $post->author->fullName ?></h3>
            <p>Fecha de publicación: <?= $post->published_at->humanize() ?></p>
            <!-- Como getCategories() es un metodo getter, se puede usar como propiedad o como función -->
            <?php if ($post->categories): ?>
            <div class="tags are-medium">
                <?php foreach ($post->getCategories() as $category): ?>
                    <span class="tag"><?= $category->name ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div>
                <?= $post->body ?>
                
            </div>
        </div>

        <!-- Mostrar un conjunto de 4 publicaciones relacionadas

        Las view cell funcionan como componentes. Invocan a un metodo de un controlador o librería,
        pasandole opcionalmente algunos parametros. Lo que se espera es que este metodo retorne
        una vista basada en contenido dinámico -->
        
        <?= view_cell('\App\Controllers\Blog\Home::relacionados', ['category' => 'Desarrollo Web', 'limit' => 4, 'except' => $post->id]) ?>
    </div>
</main>
<?= $this->endSection() ?>