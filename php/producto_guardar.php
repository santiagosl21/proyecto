<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

	/*== Almacenando datos ==*/
	$codigo=limpiar_cadena($_POST['matricula']);
	$nombre=limpiar_cadena($_POST['marca']);
    $estado=limpiar_cadena($_POST['nombreEstado']);
	$categoria=limpiar_cadena($_POST['producto_categoria']);
    $parqueadero=limpiar_cadena($_POST['nombre_parqueadero']);


	/*== Verificando campos obligatorios ==*/
    if($codigo=="" || $nombre=="" || $categoria=="" || $estado=="" || $parqueadero==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.]{3,7}",$codigo)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La placa no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La marca no coincide con el formato solicitado
            </div>
        ';
        exit();
    }



    /*== Verificando placa ==*/
    $check_codigo=conexion();
    $check_codigo=$check_codigo->query("SELECT matricula FROM producto WHERE matricula='$codigo'");
    if($check_codigo->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La placa ingresada ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_codigo=null;



    /*== Verificando categoria ==*/
    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
    if($check_categoria->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoría seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_categoria=null;
        /*== Verificando estado ==*/
    $check_estado=conexion();
    $check_estado=$check_estado->query("SELECT idEstado FROM estado WHERE idEstado='$estado'");
    if($check_estado->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El estado seleccionado no existe
            </div>
        ';
        exit();
    }
    $check_estado=null;

        /*== Verificando parqueadero ==*/
        $check_parqueaderos=conexion();
        $check_parqueaderos=$check_parqueaderos->query("SELECT parqueadero_id FROM parqueaderos WHERE parqueadero_id='$parqueadero'");
        if($check_parqueaderos->rowCount()<=0){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El parqueadero seleccionado no existe
                </div>
            ';
            exit();
        }
        $check_parqueaderos=null;


    /* Directorios de imagenes */
	$img_dir='../img/producto/';


	/*== Comprobando si se ha seleccionado una imagen ==*/
	if($_FILES['producto_foto']['name']!="" && $_FILES['producto_foto']['size']>0){

        /* Creando directorio de imagenes */
        if(!file_exists($img_dir)){
            if(!mkdir($img_dir,0777)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Error al crear el directorio de imagenes
                    </div>
                ';
                exit();
            }
        }

		/* Comprobando formato de las imagenes */
		if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
			echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        La imagen que ha seleccionado es de un formato que no está permitido
                    </div>
                ';
                exit();
		}


		/* Comprobando que la imagen no supere el peso permitido */
		if(($_FILES['producto_foto']['size']/1024)>3072){
			echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        La imagen que ha seleccionado supera el límite de peso permitido
                    </div>
                ';
			exit();
		}


		/* extencion de las imagenes */
		switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
			case 'image/jpeg':
			$img_ext=".jpg";
			break;
			case 'image/png':
			$img_ext=".png";
			break;
		}

		/* Cambiando permisos al directorio */
		chmod($img_dir, 0777);

		/* Nombre de la imagen */
		$img_nombre=renombrar_fotos($nombre);

		/* Nombre final de la imagen */
		$foto=$img_nombre.$img_ext;

		/* Moviendo imagen al directorio */
		if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir.$foto)){
			echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
                    </div>
                ';
			exit();
		}

	}else{
		$foto="";
	}


	/*== Guardando datos ==*/
    $guardar_producto=conexion();
    $guardar_producto=$guardar_producto->prepare("INSERT INTO producto(matricula,marca,estado_id,producto_foto,categoria_id,usuario_id,parqueadero_id) VALUES(:codigo,:nombre,:estado,:foto,:categoria,:usuario,:parqueadero)");

    $marcadores=[
        ":codigo"=>$codigo,
        ":nombre"=>$nombre,
        ":estado"=>$estado,
        ":foto"=>$foto,
        ":categoria"=>$categoria,
        ":usuario"=>$_SESSION['id'],
        ":parqueadero"=>$parqueadero,
    ];

    $guardar_producto->execute($marcadores);

    if($guardar_producto->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡VEHÍCULO REGISTRADO!</strong><br>
                El vehículo se registro con exito
            </div>
        ';
    }else{

            if(is_file($img_dir.$foto)){
			chmod($img_dir.$foto, 0777);
			unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el producto, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_producto=null;