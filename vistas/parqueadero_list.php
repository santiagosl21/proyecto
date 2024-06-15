<div class="container is-fluid mb-6">
    <h1 class="title">Conjuntos</h1>
    <h2 class="subtitle">Lista de conjuntos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar parqueadero #
        if(isset($_GET['parqueadero_id_del'])){
            require_once "./php/parqueadero_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }
        $parqueadero_id = (isset($_GET['parqueadero_id'])) ? $_GET['parqueadero_id'] : 0;
        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=product_list&page="; /* <== */
        $registros=15;
        $busqueda="";
        
        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=parqueadero_list&page="; /* <== */
        $registros=5;
        $busqueda="";

        # Paginador parqueadero #
        require_once "./php/parqueadero_lista.php";
    ?>
</div>