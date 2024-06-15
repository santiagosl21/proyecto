<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";
	$campos = "producto.producto_id, producto.matricula, producto.marca, estado.nombreEstado, producto.producto_foto, producto.categoria_id, producto.usuario_id, 
	categoria.categoria_id, categoria.categoria_nombre, 
	usuario.usuario_id, usuario.usuario_nombre, usuario.usuario_apellido, 
	parqueaderos.nombre_parqueadero";

//$categoria_id=0;
//$parqueadero_id=0;
$condicion = '';

if (isset($busqueda) && $busqueda != "") {
    $condicion = 'busqueda';
} elseif (isset($categoria_id) && $categoria_id > 0) {
    $condicion = 'categoria';
} elseif (isset($parqueadero_id) && $parqueadero_id > 0) {
    $condicion = 'parqueadero';
}

switch ($condicion) {
    case 'busqueda':
        $consulta_datos = "SELECT $campos 
            FROM producto 
            INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
            INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
            INNER JOIN parqueaderos ON producto.parqueadero_id = parqueaderos.parqueadero_id 
            INNER JOIN estado ON producto.estado_id = estado.idEstado
            WHERE (producto.matricula LIKE '%$busqueda%' OR producto.marca LIKE '%$busqueda%')
            ORDER BY producto.marca ASC 
            LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(producto_id) 
            FROM producto 
            INNER JOIN estado ON producto.estado_id = estado.idEstado
            WHERE (matricula LIKE '%$busqueda%' OR marca LIKE '%$busqueda%')";
        break;

    case 'categoria':
        $consulta_datos = "SELECT $campos 
            FROM producto 
            INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
            INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
            INNER JOIN parqueaderos ON producto.parqueadero_id = parqueaderos.parqueadero_id 
            INNER JOIN estado ON producto.estado_id = estado.idEstado
            WHERE producto.categoria_id='$categoria_id' 
            ORDER BY producto.marca ASC 
            LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(producto_id) 
            FROM producto 
            INNER JOIN estado ON producto.estado_id = estado.idEstado
            WHERE categoria_id='$categoria_id'";
        break;

    case 'parqueadero':
        $consulta_datos = "SELECT $campos 
            FROM producto 
            INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
            INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
            INNER JOIN parqueaderos ON producto.parqueadero_id = parqueaderos.parqueadero_id 
            INNER JOIN estado ON producto.estado_id = estado.idEstado
            WHERE producto.parqueadero_id='$parqueadero_id' 
            ORDER BY producto.marca ASC 
            LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(producto_id) 
            FROM producto 
            INNER JOIN estado ON producto.estado_id = estado.idEstado
            WHERE parqueadero_id='$parqueadero_id'";
        break;

    default:
        $consulta_datos = "SELECT $campos 
            FROM producto 
            INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
            INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
            LEFT JOIN parqueaderos ON producto.parqueadero_id = parqueaderos.parqueadero_id
            INNER JOIN estado ON producto.estado_id = estado.idEstado
            WHERE (producto.matricula LIKE '%$busqueda%' OR producto.marca LIKE '%$busqueda%')
            OR producto.parqueadero_id IS NULL
            ORDER BY producto.marca ASC 
            LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(producto_id) 
            FROM producto 
            INNER JOIN estado ON producto.estado_id = estado.idEstado
            WHERE (matricula LIKE '%$busqueda%' OR marca LIKE '%$busqueda%')
            OR producto.parqueadero_id IS NULL";
        break;
}

	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn();

	$Npaginas =ceil($total/$registros);

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<article class="media">
						<figure class="media-left">
							<p class="image is-64x64">';
							if(is_file("./img/producto/".$rows['producto_foto'])){
								$tabla.='<img src="./img/producto/'.$rows['producto_foto'].'">';
							}else{
								$tabla.='<img src="./img/producto.png">';
							}
				$tabla.='</p>
						</figure>
						<div class="media-content">
							<div class="content">
							<p>
								<strong>'.$contador.' - '.$rows['marca'].'</strong><br>
								<strong>MATRICULA:</strong> '.$rows['matricula'].', <strong>ESTADO:</strong> '.$rows['nombreEstado'].', <strong>CONDOMINIO:</strong> '.$rows['nombre_parqueadero'].', <strong>CATEGORIA:</strong> '.$rows['categoria_nombre'].', <strong>REGISTRADO POR:</strong> '.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'
							</p>
							</div>
							<div class="has-text-right">
								<a href="index.php?vista=product_img&product_id_up='.$rows['producto_id'].'" class="button is-link is-rounded is-small">Imagen</a>
								<a href="index.php?vista=product_update&product_id_up='.$rows['producto_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
								<a href="'.$url.$pagina.'&product_id_del='.$rows['producto_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
							</div>
						</div>
					</article>

					<hr>
				';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<p class="has-text-centered" >
					<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
						Haga clic acá para recargar el listado
					</a>
				</p>
			';
		}else{
			$tabla.='
				<p class="has-text-centered" >No hay registros en el sistema</p>
			';
		}
	}

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}