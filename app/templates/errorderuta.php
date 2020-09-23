<?php ob_start() ?>

<div class="row">
    <!--    View que se mostrará en el caso de que haya un error de ruta -->

    <h3> La ruta que estas introducioendo en el navegador no existe. </h3>

    <?php $contenido = ob_get_clean() ?>

    <?php include 'layout.php' ?>