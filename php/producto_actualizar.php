<?php
require_once "main.php";

/*== Almacenando id ==*/
$id=limpiar_cadena($_POST['producto_id']);


/*== Verificando producto ==*/
$check_producto=conexion();
$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

if($check_producto->rowCount()<=0){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El vehiculo no existe en el sistema
        </div>
    ';
    exit();
}else{
    $datos=$check_producto->fetch();
}
$check_producto=null;


/*== Almacenando datos ==*/
$codigo=limpiar_cadena($_POST['matricula']);
$nombre=limpiar_cadena($_POST['marca']);
$estado=limpiar_cadena($_POST['nombreEstado']);
$categoria=limpiar_cadena($_POST['producto_categoria']);
$parqueadero=limpiar_cadena($_POST['nombre_parqueadero']);


/*== Verificando campos obligatorios ==*/
if($codigo=="" || $nombre=="" || $estado==""|| $categoria=="" || $parqueadero==""){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}


/*== Verificando integridad de los datos ==*/
if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}",$codigo)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La matricula no coincide con el formato solicitado
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


/*== Verificando codigo ==*/
if($codigo!=$datos['matricula']){
    $check_codigo=conexion();
    $check_codigo=$check_codigo->query("SELECT matricula FROM producto WHERE matricula='$codigo'");
    if($check_codigo->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La placa del vehículo ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_codigo=null;
}


/*== Verificando estado ==*/
if($estado!=$datos['estado_id']){
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
    $check_categoria=null;
}
/*== Verificando categoria ==*/
if($categoria!=$datos['categoria_id']){
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
}

    /*== Verificando parqueaderos ==*/
if($parqueadero!=$datos['parqueadero_id']){
    $check_parqueaderos=conexion();
    $check_parqueaderos=$check_parqueaderos->query("SELECT parqueadero_id FROM parqueaderos WHERE parqueadero_id='$parqueadero'");
    if($check_parqueaderos->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El condominio seleccionado no existe
            </div>
        ';
        exit();
    }
    $check_parqueaderos=null;
}


/*== Actualizando datos ==*/
$actualizar_producto=conexion();
$actualizar_producto=$actualizar_producto->prepare("UPDATE producto SET matricula=:codigo,marca=:nombre,estado_id=:estado,categoria_id=:categoria,parqueadero_id=:parqueadero WHERE producto_id=:id");

$marcadores=[
    ":codigo"=>$codigo,
    ":nombre"=>$nombre,
    ":estado"=>$estado,
    ":categoria"=>$categoria,
    ":parqueadero"=>$parqueadero,
    ":id"=>$id
];


if($actualizar_producto->execute($marcadores)){
    echo '
        <div class="notification is-info is-light">
            <strong>¡VEHÍCULO ACTUALIZADO!</strong><br>
            El vehículo se actualizo con exito
        </div>
    ';
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo actualizar el vehículo, por favor intente nuevamente
        </div>
    ';
}
$actualizar_producto=null;