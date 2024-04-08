<?php
namespace Controllers;

use Model\AdminCita;
use Model\Cita;
use MVC\Router;

class AdminController{

    public static function index(Router $router){
        session_start();
        isAdmin();
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        
        $mensaje = $_GET['message'];
        if($mensaje === '1'){
            Cita::setAlerta('exito','Cita eliminada Correctamente');
        }


        //Valida que sea una fecha Valida
        $fechaSeleccionada = explode("-",$fecha);
        if(!checkdate($fechaSeleccionada[1],$fechaSeleccionada[2],$fechaSeleccionada[0])){
            header('Location: /404');
        }

        $consulta = "SELECT citas.id, citas.hora, CONCAT (usuarios.nombre, ' ', usuarios.apellido) as cliente,";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio FROM citas LEFT OUTER JOIN usuarios ON";
         $consulta .= " citas.usuarioId=usuarios.id LEFT OUTER JOIN citasservicios ON citasservicios.citaId=citas.id LEFT OUTER JOIN servicios";
        $consulta .= " ON citasservicios.servicioId=servicios.id";
        $consulta .= " WHERE fecha = '${fecha}'";
        
        
        $citas = AdminCita::SQL($consulta);

        // if(empty($citas)){ Asi lo hice yo
        //     Cita::setAlerta('error','No hay Citas en esta fecha');
        // }
        
        // $alertas = Cita::getAlertas();
        
        $alertas = Cita::getAlertas();

        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha,
            'alertas' => $alertas

            
        ]);
    }

    
}