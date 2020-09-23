<?php ob_start() ?>

    <!--    View de la parte de la busqueda de los agentes registrados en la BD -->

<h3>Agentes dados de alta:</h3>

<table>
    <tr>
        <th>Nombre Agente</th>
        <th>Contra</th>
        <th>Sede</th>
    </tr>

<!--    En esta ocación no hay ningun parametro. Nos busca todas las ventas que haya hasta el momento dentro de una tabla -->


    <?php foreach ($params['agentes'] as $agentes) : ?>
        <tr>
            <td><a href="index.php?ctl=ventasAgente&id=<?php echo $agentes['id'] ?>">
                    <?php echo $agentes['nombre'] ?></a></td>
            <td><?php echo $agentes['contra'] ?></td>
            <td><?php echo $agentes['nom_ciudad'] ?></td>
        </tr>
    <?php endforeach; ?>

</table>


<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>