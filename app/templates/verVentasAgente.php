<?php ob_start() ?>

<!--    Tabla que se mostrará cuando pinchemos en los enlaces de los nombres de agentes que son resultado de las busquedas de
        ventas totales, ventas por fecha o ventas por nombre -->

<h1><?php echo 'Datos del agente: ' . $params['nombre'] ?></h1>
<table id="mi_tabla">
    <tr>
        <td>Agente</td>
        <td><?php echo $alimento['nombre'] ?></td>
    </tr>
    <tr>
        <td>Sede</td>
        <td><?php echo $alimento['sede'] ?></td>
    </tr>
    <tr>
        <td>Nº Ventas Total</td>
        <td><?php echo $alimento['ventas'] ?></td>
    </tr>
    <tr>
        <td>Suma Importe Ventas</td>
        <td><?php echo $alimento['total'] ?>€</td>
    </tr>
</table>


<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>