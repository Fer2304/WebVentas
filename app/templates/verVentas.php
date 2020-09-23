<?php ob_start() ?>

<!--    View de la parte de la busqueda de ventas totales -->

<h2>Ventas registradas hasta la fecha:</h2>

<table>
    <tr>
        <th>Nombre Agente</th>
        <th>Tipo Venta</th>
        <th>Importe</th>
    </tr>

    <!--    En esta ocación no hay ningun parametro. Nos busca todas las ventas que haya hasta el momento dentro de una tabla -->

    <?php foreach ($params['ventas'] as $ventas) : ?>
        <tr>
            <td><a href="index.php?ctl=ventasAgente&id=<?php echo $ventas['id'] ?>">
                    <?php echo $ventas['nombre'] ?></a></td>
            <td><?php echo $ventas['nom_venta'] ?></td>
            <td><?php echo $ventas['importe_venta'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>