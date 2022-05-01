<section class="hero is-info">
    <div class="hero-body">
        <div class="container">
            <p class="title">
                Blog.io
            </p>
            <p class="subtitle">
                Las mejores publicaciones
            </p>
        </div>
    </div>
    <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
            <div class="container">
                <ul>
                    <!-- CI cuenta con una clase IncomingRequest que consiste en un servicio que brinda información
                    acerca de la petición del cliente.
                    Esta se inyecta en el objeto request automáticamente si nuestro controlador hereda de BaseController, 
                    fuera del controlador solo es accesible invocando el servicio request. -->
                    <li class="<?= service('request')->uri->getPath() == '/' ? 'is-active' : '' ?>">
                        <a href="<?= base_url(route_to('page.home')); ?>">Home</a>
                    </li>
                    <li class="<?= service('request')->uri->getPath() == 'auth/register' ? 'is-active' : '' ?>">
                        <a href="<?= base_url(route_to('auth.register')) ?>">Registro</a>
                    </li>

                    <!-- Mostrar elementos del menú con base a usuarios logeados -->
                    <?php if (session()->is_logged): ?>
                    <li class="<?= service('request')->uri->getPath() == 'admin/posts' ? 'is-active' : '' ?>">
                        <a href="<?= base_url(route_to('posts.index')) ?>">Posts</a>
                    </li>
                    <li>
                        <a href="<?= base_url(route_to('auth.signout')) ?>">Cerrar Sesión</a>
                    </li>
                    <?php else: ?>
                    <li class="<?= service('request')->uri->getPath() == 'auth/login' ? 'is-active' : '' ?>">
                        <a href="<?= base_url(route_to('auth.login')) ?>">Login</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</section>