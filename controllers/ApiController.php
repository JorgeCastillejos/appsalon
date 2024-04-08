<?php
namespace Controllers;

use Model\Cita;
use Model\citasServicios;
use Model\Servicios;

class ApiController{

    public static function index(){
       $servicios = Servicios::all();
       echo json_encode($servicios);
    }

    public static function guardar(){

        if($_SERVER["REQUEST_METHOD"] === 'POST'){
             $cita = new Cita($_POST);
             $resultado = $cita->guardar();

             
             $citaId = $resultado['id'];

             $servicios = explode(",", $_POST['servicios']);

             foreach($servicios as $servicio){
                $args = [
                    'citaId' => $citaId,
                    'servicioId' => $servicio
                ];

                $citasservicios = new citasServicios($args);
                $citasservicios->guardar();
             }

             $respuesta = [
                'tipo' => 'exito',
                'mensaje' => 'Cita Creada Correctamente'
             ];    

             echo json_encode($respuesta);
        }
    }
}