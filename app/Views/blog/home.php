<!-- Extender de un layout -->
<?= $this->extend('layout/app'); ?>

<!-- Definir la sección dinámica particular de esta vista -->
<?= $this->section('title'); ?>Mi Blog<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<div class="section">
    <div class="container">
        <div class="columns is-multiline">
            <?php foreach($posts as $post): ?>
            <div class="column is-4">
               
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <img src="<?= $post->getLinkImage() ?>" alt="Placeholder image">
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <p class="title is-4"><?= $post->title ?></p>
                                    <p class="subtitle is-6"><?= $post->author->getFullName() ?></p>
                                </div>
                            </div>
                            <div class="content">
                                <!-- No conviene escapar (esc) el contenido, ya que este se genera mediante un editor enriquecido
                                y mostraría los tags html escapados. Por tanto el enfoque será retirar esos tags
                    
                                CI tiene un helper para generar excerpts ya sea por caracters o palabras.
                                Pero es necesario cargarlo anticipadamente en el controlador. -->
                                <?= character_limiter(strip_tags($post->body), 100) ?>
                                <br>
                                <?php if ($post->getCategories()): ?>
                                    <div>
                                    <?php foreach ($post->getCategories() as $category): ?>
                                        <a href="#">#<?= $category->name ?></a>
                                    <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <time datetime="2016-1-1"><?= $post->published_at->humanize() ?></time>
                                <br>
                                <br>
                                <p><a href="<?= $post->getLinkPost() ?>" class="button is-dark">Visitar</a></p>
                            </div>
                        </div>
                    </div>
                
            </div>
            <?php endforeach; ?>
        </div>
        <?= $pager->links() ?>
    </div>
</div>

<?= $this->endSection(); ?>