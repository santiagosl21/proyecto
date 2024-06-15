<div class="container is-fluid mb-6">
<h1 class="title">Parqueaderos</h1>
<h2 class="subtitle">Actualizar parqueadero</h2>
</div>

<div class="container pb-6 pt-6">
<?php
	include "./inc/btn_back.php";

	require_once "./php/main.php";

	$id = (isset($_GET['parqueadero_id_up'])) ? $_GET['parqueadero_id_up'] : 0;
	$id=limpiar_cadena($id);

	/*== Verificando parqueadero ==*/
	$check_parqueaderos=conexion();
	$check_parqueaderos=$check_parqueaderos->query("SELECT * FROM parqueaderos WHERE parqueadero_id='$id'");

	if($check_parqueaderos->rowCount()>0){
		$datos=$check_parqueaderos->fetch();
?>

<div class="form-rest mb-6 mt-6"></div>

<form action="./php/parqueadero_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

	<input type="hidden" name="parqueadero_id" value="<?php echo $datos['parqueadero_id']; ?>" required >

	<div class="columns">
		<div class="column">
			<div class="control">
				<label>Nombre</label>
				<input class="input" type="text" name="nombre_parqueadero" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required value="<?php echo $datos['nombre_parqueadero']; ?>" >
			</div>
		</div>
		<div class="column">
			<div class="control">
				<label>Ubicación</label>
				<input class="input" type="text" name="ubicacion_parqueadero" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" value="<?php echo $datos['ubicacion_parqueadero']; ?>" >
			</div>
		</div>
	</div>
	<p class="has-text-centered">
		<button type="submit" class="button is-success is-rounded">Actualizar</button>
	</p>
</form>
<?php 
	}else{
		include "./inc/error_alert.php";
	}
	$check_parqueaderos=null;
?>
</div>