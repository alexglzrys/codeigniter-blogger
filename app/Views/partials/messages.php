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