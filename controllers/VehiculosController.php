<?php 

require_once 'models/Vehiculos.php';

class VehiculosController{
    
    public $vehiculo;
    public function __construct(){
        $this->vehiculo = new Vehiculo();
	}


    function create(){
        
    }
    function read(){
        $vehiculos = $this->vehiculo->read();
        require_once 'views/vehiculo/read.php';
    }
    function update(){
        
    }
    function delete(){
        
    }
}