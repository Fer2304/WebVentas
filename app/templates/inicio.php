<?php ob_start() ?>
<h1>Inicio</h1>
<h3> Fecha: <?php echo $params['fecha'] ?> </h3>
<?php echo $params['mensaje'] ?>
<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>

<!--    View que se muestra en el inicio con informacion de la fecha actual y un mensaje de bienvenida que hacemos llegar desde el Controller -->
