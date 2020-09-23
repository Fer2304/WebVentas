<?php ob_start() ?>

    <!--    View de la parte de la busqueda de ventas por fecha -->

<form name="formBusqueda" action="index.php?ctl=buscarVentasFecha" method="POST">

<h2>Busqueda Por Fechas</h2>

    <table>
        <tr>
            <th>Desde:</th>
            <th>Hasta:</th>
        </tr>

        <tr>
            <td><input type="date" name="fecha_1" value="<?php echo $params['fecha_1'] ?>" required></td>
            <td><input type="date" name="fecha_2" value="<?php echo $params['fecha_2'] ?>" required></td>

            <td><input type="submit" value="buscarN" name="buscarN"></td>
        </tr>
    </table>

</form>

    <!--    Una vez pasados los parametros comprueba si hay una respuesta y si es asi nos la muestra en la paantalla detro de una tabla -->

<?php if (count($params['ventas']) > 0) : ?>
    <table>
        <tr>
            <th>Nombre Agente</th>
            <th>Tipo Venta</th>
            <th>Importe</th>
        </tr>
        <?php foreach ($params['ventas'] as $venta) : ?>
            <tr>
                <td><a href="index.php?ctl=ventasAgente&id=<?php echo $venta['id'] ?>">
                        <?php echo $venta['nombre'] ?></a></td>
                <td><?php echo $venta['nom_venta'] ?></td>
                <td><?php echo $venta['importe_venta'] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php endif; ?>

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>