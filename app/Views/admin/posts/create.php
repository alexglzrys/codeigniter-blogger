<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Registrar Publicación
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
    crossorigin="anonymous" />
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js" integrity="sha512-RnlQJaTEHoOCt5dUTV0Oi0vOBMI9PjCU7m+VHoJ4xmhuUNcwnB5Iox1es+skLril1C3gHTLbeRepHs1RpSCLoQ==" crossorigin="anonymous"></script>
<script>
const fileInput = document.querySelector('input[type=file]');
  fileInput.onchange = () => {
    if (fileInput.files.length > 0) {
      const fileName = document.querySelector('.file-name');
      fileName.textContent = fileInput.files[0].name;
    }
  }
  tinymce.init({
        selector: '#bodyRich',
        height: 500,
        menubar: false,
        branding: false
      });
</script>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2 class="title">Registrar Publicación</h2>
<h3 class="subtitle">Ingrese los datos relacionados con la nueva publicación</h3>

<form action="<?= base_url(route_to('posts.store')) ?>" method="post" enctype="multipart/form-data">
    <div class="columns">
        <div class="column is-8">
            <div class="field">
                <label class="label">Titulo</label>
                <div class="control">
                    <input name="title" value="<?= old('title') ?>" type="text" class="input" placeholder="Ingresa el titulo de la publicación">
                </div>
                <span class="is-danger help"><?= session('errors.title') ?></span>
            </div>
            <div class="field">
                <label class="label">Contenido</label>
                <div class="control">
                    <textarea name="body" class="textarea" id="bodyRich"
                        placeholder="Información detallada de la publicación"><?= old('body') ?></textarea>
                </div>
                <span class="is-danger help"><?= session('errors.body') ?></span>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <div class="file has-name is-boxed">
                    <label class="file-label">
                        <input class="file-input" type="file" name="cover">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Buscar archivo...
                            </span>
                        </span>
                        <span class="file-name">
                            Screen Shot 2017-07-29 at 15.54.25.png
                        </span>
                    </label>
                </div>
                <p class="is-danger help"><?= session('errors.cover') ?></p>
            </div>
            <div class="field">
                <label class="label">Fecha de la publicación</label>
                <div class="control">
                    <input type="date" value="<?= old('published_at') ?>" name="published_at" class="input" placeholder="Fecha de publicación">
                </div>
                <span class="is-danger help"><?= session('errors.published_at') ?></span>
            </div>
            <div class="field">
                <label class="label">Categorías</label>
                <?php if($categories): ?>
                    <?php foreach($categories as $category): ?>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="categories[]" <?= in_array($category->id, old('categories.*', [])) ? 'checked' : '' ?>
                                    value="<?= $category->id ?>">
                                <?= $category->name ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Al momento de hoy, cuando el error se da en un campo de tipo array, la sesion no proyecta el contenido
                    Para ello es necesario invocar la sesion, esta devuelve un array, y se procede a acceder al key de forma tradicional
                    []['campo.*']. Si el campo es opcional es necesario usar ??
                    El cual se traduce en si existe el valor, imprime valor, caso contrario imprime otra cosa -->
                    <span class="is-danger help"><?= session('errors')['categories.*'] ?? '' ?></span>
                <?php else: ?>
                    <a href="<?= base_url(route_to('categories.create')) ?>" class="button is-dark">Crear categoría</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="field">
        <button type="submit" class="button is-dark is-fullwidth">Registrar</button>
    </div>
</form>

<pre>
    <?= var_dump(session('errors')) ?>
</pre>
<?= $this->endSection() ?>