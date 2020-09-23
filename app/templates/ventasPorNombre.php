<?php ob_start() ?>

<!--    View de la parte de la busqueda de ventas por nombre -->

<form name="formBusqueda" action="index.php?ctl=buscarVentasNombre" method="POST">

    <h2>Busqueda Por Nombre</h2>

    <table>
        <tr>
            <td>Tipo de Venta:</td>
            <td><input type="text" name="nom_venta" value="<?php echo $params['nom_venta'] ?>">(puedes utilizar '%' como comodín)</td>

            <td><input type="submit" value="buscarE" name="buscarE"></td>
        </tr>
    </table>

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
        <?php foreach ($params['ventas'] as $ventas) : ?>
            <tr>
                <td><a href="index.php?ctl=ventasAgente&id=<?php echo $ventas['id'] ?>">
                        <?php echo $ventas['nombre'] ?></a></td>
                <td><?php echo $ventas['nom_venta'] ?></td>
                <td><?php echo $ventas['importe_venta'] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php endif; ?>

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>