	<div class="container is-fluid mb-6">
		<h1 class="title">Productos</h1>
		<h2 class="subtitle">Actualizar producto</h2>
	</div>

	<div class="container pb-6 pt-6">
		<?php
			include "./inc/btn_back.php";

			require_once "./php/main.php";

			$id = (isset($_GET['product_id_up'])) ? $_GET['product_id_up'] : 0;
			$id=limpiar_cadena($id);

			/*== Verificando producto ==*/
			$check_producto=conexion();
			$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

			if($check_producto->rowCount()>0){
				$datos=$check_producto->fetch();
		?>
		<div class="form-rest mb-6 mt-6"></div>
		
		<h2 class="title has-text-centered"><?php echo $datos['marca']; ?></h2>
		<form action="./php/producto_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >
			<input type="hidden" name="producto_id" value="<?php echo $datos['producto_id']; ?>" required >
			<div class="columns">
				<div class="column">
					<div class="control">
						<label>Matricula</label>
						<input class="input" type="text" name="matricula" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required value="<?php echo $datos['matricula']; ?>" >
					</div>
				</div>
				<div class="column">
					<div class="control">
						<label>Marca</label>
						<input class="input" type="text" name="marca" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $datos['marca']; ?>" >
					</div>
				</div>
			</div>
			<div class="columns">
					<div class="column">
						<label>Estado</label><br>
						<div class="select is-rounded">
							<select name="nombreEstado" >
								<?php
									$estado=conexion();
									$estado=$estado->query("SELECT * FROM estado");
									if($estado->rowCount()>0){
										$estado=$estado->fetchAll();
										foreach($estado as $row){
											if($datos['estado_id']==$row['idEstado']){
												echo '<option value="'.$row['idEstado'].'" selected="" >'.$row['nombreEstado'].' (Actual)</option>';
											}else{
												echo '<option value="'.$row['idEstado'].'" >'.$row['nombreEstado'].'</option>';
											}
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
								<?php
									$categorias=conexion();
									$categorias=$categorias->query("SELECT * FROM categoria");
									if($categorias->rowCount()>0){
										$categorias=$categorias->fetchAll();
										foreach($categorias as $row){
											if($datos['categoria_id']==$row['categoria_id']){
												echo '<option value="'.$row['categoria_id'].'" selected="" >'.$row['categoria_nombre'].' (Actual)</option>';
											}else{
												echo '<option value="'.$row['categoria_id'].'" >'.$row['categoria_nombre'].'</option>';
											}
										}
									}
									$categorias=null;
								?>
							</select>
						</div>
					</div>
					<div class="column">
						<label>Parqueaderos</label><br>
						<div class="select is-rounded">
							<select name="nombre_parqueadero" >
								<?php
									$parqueadero=conexion();
									$parqueadero=$parqueadero->query("SELECT * FROM parqueaderos");
									if($parqueadero->rowCount()>0){
										$parqueadero=$parqueadero->fetchAll();
										foreach($parqueadero as $row){
											if($datos['parqueadero_id']==$row['parqueadero_id']){
												echo '<option value="'.$row['parqueadero_id'].'" selected="" >'.$row['nombre_parqueadero'].' (Actual)</option>';
											}else{
												echo '<option value="'.$row['parqueadero_id'].'" >'.$row['nombre_parqueadero'].'</option>';
											}
										}
									}
									$parqueadero=null;
								?>
							</select>
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
			$check_producto=null;
		?>
	</div>