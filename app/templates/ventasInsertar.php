<?php ob_start() ?>

<?php

#   Comprueba las validaciones.En el caso de que haya algun error,  nos lo reportaría

if (is_object($validacion)) {
    foreach ($validacion->mensaje as $errores) {
        foreach ($errores as $error)
            echo $error . '<br>';
    }
}
?>
    <!--    View de la parte de la inserción de ventas -->

<form name="formInsertar" action="index.php?ctl=insertarVenta" method="POST">

<h2>Registrar Ventas</h2>

    <table>
        <tr>
            <th>Tipo Venta</th>
            <th>Fecha Venta</th>
        </tr>
        <tr>
            <td><input type="text" placeholder="Venta" name="nom_venta" list="Ventas"  />
                <datalist id="Ventas">
                    <option value="FIJO" />
                    <option value="MOVIL" />
                    <option value="FIJO + INTERNET" />
                    <option value="FIJO + INTERNET + MOVIL (CONVERGENTE)" />
                </datalist>
            <td><input type="date" name="fecha_venta" value="<?php echo $params['fecha_venta'] ?>"  /></td>
        </tr>

    </table>
    <input type="submit" value="insertar" name="bInsertar" />
</form>
Aquí puedes registrar tus ventas a nivel de Agente

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>