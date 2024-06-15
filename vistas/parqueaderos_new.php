<div class="container is-fluid mb-6">
	<h1 class="title">Condominios</h1>
	<h2 class="subtitle">Nuevo condominio</h2>
</div>

<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/parqueadero_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
		<div class="columns">
		<div class="column">
		<div class="control">
					<label>Nombre del condominio</label>
				<input class="input" type="text" name="nombre_parqueadero" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required >
				</div>
		</div>
		<div class="column">
		<div class="control">
					<label>Ubicación del condominio</label>
				<input class="input" type="text" name="ubicacion_parqueadero" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" >
				</div>
		</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>