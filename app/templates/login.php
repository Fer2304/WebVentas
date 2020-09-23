<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <title>Web de Ventas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo 'css/' . Config::$mvc_vis_css ?>" />

</head>

<body>
    <div id="cabecera">

        <!--    View del login de usuario -->
        <!--    Compruebo si hay sesion activa y, si es asi, saludo al usuario. Si no hay, no aparecera nada -->

        <h1>LOGIN</h1>
        <h2><?php if ($_SESSION) {
                echo "Hola " . $_SESSION['user'];
            } ?></h2>

    </div>
    <div id="login">
        <form action="index.php?ctl=loginAgente" method="POST">

            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Contra</th>
                </tr>
                <tr>
                    <td><input type="text" placeholder="Nombre" name="user" /></td>
                    <td><input type="password" placeholder="Contra" name="password" /></td>
            </table>
            <br><br>

            <input class="bg-success" type="submit" value="Iniciar sesión" name="bLogin" />
            <hr>
        </form>
    </div>
    <div>
        <?php echo $params['mensaje']; ?>
    </div>
</body>

</html>