<?php
require_once "main.php";

/*== Almacenando id ==*/
$id=limpiar_cadena($_POST['parqueadero_id']);


/*== Verificando parqueadero ==*/
$check_parqueaderos=conexion();
$check_parqueaderos=$check_parqueaderos->query("SELECT * FROM parqueaderos WHERE parqueadero_id='$id'");

if($check_parqueaderos->rowCount()<=0){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El parqueadero no existe en el sistema
        </div>
    ';
    exit();
}else{
    $datos=$check_parqueaderos->fetch();
}
$check_parqueaderos=null;

/*== Almacenando datos ==*/
$nombre=limpiar_cadena($_POST['nombre_parqueadero']);
$ubicacion=limpiar_cadena($_POST['ubicacion_parqueadero']);


/*== Verificando campos obligatorios ==*/
if($nombre==""){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}


/*== Verificando integridad de los datos ==*/
if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if($ubicacion!=""){
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La UBICACION no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
}


/*== Verificando nombre ==*/
if($nombre!=$datos['nombre_parqueadero']){
    $check_nombre=conexion();
    $check_nombre=$check_nombre->query("SELECT nombre_parqueadero FROM parqueaderos WHERE nombre_parqueadero='$nombre'");
    if($check_nombre->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre=null;
}


/*== Actualizar datos ==*/
$actualizar_parqueadero=conexion();
$actualizar_parqueadero=$actualizar_parqueadero->prepare("UPDATE parqueaderos SET nombre_parqueadero=:nombre,ubicacion_parqueadero=:ubicacion WHERE parqueadero_id=:id");

$marcadores=[
    ":nombre"=>$nombre,
    ":ubicacion"=>$ubicacion,
    ":id"=>$id
];

if($actualizar_parqueadero->execute($marcadores)){
    echo '
        <div class="notification is-info is-light">
            <strong>¡PARQUEADERO ACTUALIZADA!</strong><br>
            El parqueadero se actualizo con exito
        </div>
    ';
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo actualizar el parqueadero, por favor intente nuevamente
        </div>
    ';
}
$actualizar_parqueadero=null;