	<div class="container is-fluid mb-6">
		<h1 class="title">Productos</h1>
		<h2 class="subtitle">Nuevo producto</h2>
	</div>

	<div class="container pb-6 pt-6">
		<?php
			require_once "./php/main.php";
		?>

		<div class="form-rest mb-6 mt-6"></div>

		<form action="./php/producto_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
			<div class="columns">
			<div class="column">
			<div class="control">
				<label>Matricula del Vehículo</label>
					<input class="input" type="text" name="matricula" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.]{3,70}" maxlength="70" required >
					</div>
				</div>
				<div class="column">
					<div class="control">
						<label>Marca del Vehículo</label>
						<input class="input" type="text" name="marca" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
					</div>
				</div>
			</div>
			<div class="columns">
			<div class="column">
					<label>Estado</label><br>
					<div class="select is-rounded">
						<select name="nombreEstado" >
							<option value="" selected="" >Seleccione una opción</option>
							<?php
								$estado=conexion();
								$estado=$estado->query("SELECT * FROM estado");
								if($estado->rowCount()>0){
									$estado=$estado->fetchAll();
									foreach($estado as $row){
										echo '<option value="'.$row['idEstado'].'" >'.$row['nombreEstado'].'</option>';
									}
								}
								$estado=null;
							?>
						</select>
					</div>
				</div>
				<div class="column">
					<label>Categoría</label><br>
					<div class="select is-rounded">
						<select name="producto_categoria" >
							<option value="" selected="" >Seleccione una opción</option>
							<?php
								$categorias=conexion();
								$categorias=$categorias->query("SELECT * FROM categoria");
								if($categorias->rowCount()>0){
									$categorias=$categorias->fetchAll();
									foreach($categorias as $row){
										echo '<option value="'.$row['categoria_id'].'" >'.$row['categoria_nombre'].'</option>';
									}
								}
								$categorias=null;
							?>
						</select>
					</div>
				</div>
				<div class="column">
					<label>Parqueqadero</label><br>
					<div class="select is-rounded">
						<select name="nombre_parqueadero" >
							<option value="" selected="" >Seleccione una opción</option>
							<?php
								$parqueadero=conexion();
								$parqueadero=$parqueadero->query("SELECT * FROM parqueaderos");
								if($parqueadero->rowCount()>0){
									$parqueadero=$parqueadero->fetchAll();
									foreach($parqueadero as $row){
										echo '<option value="'.$row['parqueadero_id'].'" >'.$row['nombre_parqueadero'].'</option>';
									}
								}
								$parqueadero=null;
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<label>Foto o imagen del Vehículo</label><br>
					<div class="file is-small has-name">
						<label class="file-label">
							<input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg" >
							<span class="file-cta">
								<span class="file-label">Imagen</span>
							</span>
							<span class="file-name">JPG, JPEG, PNG. (MAX 4MB)</span>
						</label>
					</div>
				</div>
			</div>
			<p class="has-text-centered">
				<button type="submit" class="button is-info is-rounded">Guardar</button>
			</p>
		</form>
	</div>