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

<form action="index.php?ctl=registroAgente" method="POST">

	<h2>Registro Nuevo Agente</h2>
	<?php echo $params['mensaje'] ?>
	<table>
		<tr>
			<th>Nombre</th>
			<th>Contra</th>
			<th>Sede</th>
			<th>Puesto</th>

		</tr>
		<tr>
			<td><input type="text" placeholder="Username" name="usuario" /></td>
			<td><input type="password" placeholder="Password" name="contra" /></td>
			<td><input type="text" placeholder="Sede" name="nom_ciudad" list="provinciasCV" />
				<datalist id="provinciasCV">
					<option value="Valencia" />
					<option value="Alicante" />
					<option value="Castellon" />
				</datalist></td>
			<td><input type="text" placeholder="Puesto" name="puesto" /></td>
		</tr>
	</table>

	<br><br>
	<input class="bg-success" type="submit" value="Registrarse" name="bRegister" />
	<hr>

</form>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>