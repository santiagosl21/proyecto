<?php

class Vehiculo{
    private $db;

    public $id;
    public $marca;
    public $modelo;
    public $tipo;
    public $placa;

    
    public function __construct()
    {
		try{
            //Conectando a la bd
            $this->db = new mysqli('localhost:3307', 'root', '', 'sgvur');
		}catch(Exception $e){
			die($e->getMessage());
		}
	}


    function create(){
        
    }
    function read(){
        $sql = "SELECT * FROM vehiculos";
        // Ejecutamos la consulta
        $result = $this->db->query($sql);
        
        // Cerramos la conexión
        $this->db->close();
        // Resornamos el resultado
        return $result;
    }
    function update(){
        
    }
    function delete(){
        
    }

}