<?php ob_start() ?>

<div class="row">

    <!--    View que se mostrará en el caso de que haya algun error con el mensaje del motivo del error -->

    <h3> Ha habido un error </h3>
    <h2><?php echo $_SESSION['message']; ?></h2>

    <?php $contenido = ob_get_clean() ?>

    <?php include 'layout.php' ?>