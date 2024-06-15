<?php
/*== Almacenando datos ==*/
$parqueadero_id_del=limpiar_cadena($_GET['parqueadero_id_del']);

/*== Verificando usuario ==*/
$check_parqueaderos=conexion();
$check_parqueaderos=$check_parqueaderos->query("SELECT parqueadero_id FROM parqueaderos WHERE parqueadero_id='$parqueadero_id_del'");

if($check_parqueaderos->rowCount()==1){

	$check_productos=conexion();
	$check_productos=$check_productos->query("SELECT parqueadero_id FROM producto WHERE parqueadero_id='$parqueadero_id_del' LIMIT 1");

	if($check_productos->rowCount()<=0){

		$eliminar_parqueaderos=conexion();
		$eliminar_parqueaderos=$eliminar_parqueaderos->prepare("DELETE FROM parqueaderos WHERE parqueadero_id=:id");

		$eliminar_parqueaderos->execute([":id"=>$parqueadero_id_del]);

		if($eliminar_parqueaderos->rowCount()==1){
			echo '
				<div class="notification is-info is-light">
					<strong>¡parqueaderos ELIMINADA!</strong><br>
					Los datos de la categoría se eliminaron con exito
				</div>
			';
		}else{
			echo '
				<div class="notification is-danger is-light">
					<strong>¡Ocurrio un error inesperado!</strong><br>
					No se pudo eliminar la categoría, por favor intente nuevamente
				</div>
			';
		}
		$eliminar_parqueaderos=null;
	}else{
		echo '
			<div class="notification is-danger is-light">
				<strong>¡Ocurrio un error inesperado!</strong><br>
				No podemos eliminar la categoría ya que tiene productos asociados
			</div>
		';
	}
	$check_productos=null;
}else{
	echo '
		<div class="notification is-danger is-light">
			<strong>¡Ocurrio un error inesperado!</strong><br>
			La parqueaderos que intenta eliminar no existe
		</div>
	';
}
$check_parqueaderos=null;