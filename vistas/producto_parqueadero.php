<div class="container is-fluid mb-6">
    <h1 class="title">Vehiculos</h1>
    <h2 class="subtitle">Lista de Vehículos por conjunto</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";
    ?>
    <div class="columns">
        <div class="column is-one-third">
            <h2 class="title has-text-centered">Conjuntos</h2>
            <?php
                $parqueadero=conexion();
                $parqueadero=$parqueadero->query("SELECT * FROM parqueaderos");
                if($parqueadero->rowCount()>0){
                    $parqueadero=$parqueadero->fetchAll();
                    foreach($parqueadero as $row){
                        echo '<a href="index.php?vista=producto_parqueadero&parqueadero_id='.$row['parqueadero_id'].'" class="button is-link is-inverted is-fullwidth">'.$row['nombre_parqueadero'].'</a>';
                    }
                }else{
                    echo '<p class="has-text-centered" >No hay parqueadero registrado</p>';
                }
                $parqueadero=null;
            ?>
        </div>
        <div class="column">
            <?php
                $parqueadero_id = (isset($_GET['parqueadero_id'])) ? $_GET['parqueadero_id'] : 0;

                /*== Verificando parquedero ==*/
                $check_parqueadero=conexion();
                $check_parqueadero=$check_parqueadero->query("SELECT * FROM parqueaderos WHERE parqueadero_id='$parqueadero_id'");

                if($check_parqueadero->rowCount()>0){

                    $check_parqueadero=$check_parqueadero->fetch();

                    echo '
                        <h2 class="title has-text-centered">'.$check_parqueadero['nombre_parqueadero'].'</h2>
                        <p class="has-text-centered pb-6" >'.$check_parqueadero['ubicacion_parqueadero'].'</p>
                    ';

                    require_once "./php/main.php";

                    # Eliminar producto #
                    if(isset($_GET['parqueadero_id_del'])){
                        require_once "./php/producto_eliminar.php";
                    }

                    if(!isset($_GET['page'])){
                        $pagina=1;
                    }else{
                        $pagina=(int) $_GET['page'];
                        if($pagina<=1){
                            $pagina=1;
                        }
                    }

                    $pagina=limpiar_cadena($pagina);
                    $url="index.php?vista=producto_parqueadero&parqueadero_id=$parqueadero_id&page="; /* <== */
                    $registros=15;
                    $busqueda="";

                    # Paginador producto #
                    require_once "./php/producto_lista.php";

                }else{
                    echo '<h2 class="has-text-centered title" >Seleccione un parqueadero para empezar</h2>';
                }
                $check_parqueadero=null;
            ?>
        </div>
    </div>
</div>