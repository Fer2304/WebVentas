<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>

    <title>Web de Ventas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo 'css/' . Config::$mvc_vis_css ?>" />

</head>

<body>
    <div id="cabecera">

        <!--    Cabecera formada por informacion de sesion del usuario y enlaces a los diferentes Controllers o rutas de las que dispone la aplicación -->

    <h1 style="text-align: center">Web de Ventas</h1>
        <h2 style="text-align: right"><?php echo $_SESSION['nom_ciudad'] . ", " . $_SESSION['temp'] . "ºC"; ?> </h2>
        <h2><?php echo "Hola " . $_SESSION['user']; ?></h2> 
    </div>

    <div id="menu">
        <hr />
        <a href="index.php?ctl=inicio">Inicio</a> |
        <a href="index.php?ctl=insertarVenta">Insertar Venta</a> |
        <a href="index.php?ctl=ventasTotales">Ventas</a> |
        <a href="index.php?ctl=buscarVentasFecha">Buscar Ventas Por Fecha</a> |
        <a href="index.php?ctl=buscarVentasNombre">Buscar Ventas Por Tipo</a> |
        <a href="index.php?ctl=registroAgente">Registro Nuevos Agentes</a> |
        <a href="index.php?ctl=salir">Salir</a>
        <hr />
    </div>

    <div id="contenido">
        <?php echo $contenido ?>
    </div>

</body>

</html>