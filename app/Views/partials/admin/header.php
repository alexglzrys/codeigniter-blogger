<section class="hero is-dark">
    <!-- Hero head: will stick at the top -->
    <div class="hero-head">
        <header class="navbar">
            <div class="container">
                <div id="navbarMenuHeroC" class="navbar-menu">
                    <div class="navbar-end">
                        <p class="navbar-item">
                            <?= session('username') ?>
                        </p>
                        <a class="navbar-item" href="<?= base_url(route_to('auth.signout')) ?>">
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <div class="hero-body">
        <div class="container">
            <p class="title">
                Dashboard del Blog
            </p>
            <p class="subtitle">
                Administra el contenido de tu blog
            </p>
        </div>
    </div>
    <!-- Hero footer: will stick at the bottom -->
    <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
            <div class="container">
                <ul>
                    <li class="<?= preg_match('|^admin/posts(\S)*$|', service('request')->uri->getPath(), $matches) ? 'is-active' : '' ?>">
                        <a href="<?= base_url(route_to('posts.index')) ?>">Artículos</a>
                    </li>
                    <li
                        class="<?= preg_match('|^admin/categories(\S)*$|', service('request')->uri->getPath(), $matches) ? 'is-active' : '' ?>">
                        <a href="<?= base_url(route_to('categories.index')) ?>">Categorías</a>
                    </li>
                    <li><a>Usuarios</a></li>
                </ul>
            </div>
        </nav>
    </div>
</section>