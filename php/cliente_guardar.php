<?php
    
    require_once "main.php";

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['cliente_nombre']);
    $numero=limpiar_cadena($_POST['cliente_numero']);
    $email=limpiar_cadena($_POST['cliente_email']);
    $mensaje=limpiar_cadena($_POST['cliente_mensaje']);


    /*== Verificando campos obligatorios ==*/
    if($nombre=="" || $numero=="" || $email=="" || $mensaje==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9 ]{10}",$numero)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El numero no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando email ==*/
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email=$check_email->query("SELECT cliente_email FROM clientes WHERE cliente_email='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_email=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no valido
                </div>
            ';
            exit();
        } 
    }

    /*== Guardando datos ==*/
    $guardar_cliente=conexion();
    $guardar_cliente=$guardar_cliente->prepare("INSERT INTO clientes(cliente_nombre,cliente_numero,cliente_email,cliente_mensaje) VALUES(:nombre,:numero,:email,:mensaje)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":numero"=>$numero,
        ":email"=>$email,
        ":mensaje"=>$mensaje
    ];

    $guardar_cliente->execute($marcadores);

    if($guardar_cliente->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡cliente REGISTRADO!</strong><br>
                Se cliente se registro con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el cliente, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_cliente=null;