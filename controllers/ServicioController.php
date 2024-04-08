<?php
namespace Controllers;

use Model\Servicios;
use MVC\Router;

class ServicioController{


    public static function index(Router $router){
        session_start();
        isAdmin();

        //Consultar la Base Para obtener los Servicios
        $servicios = Servicios::all();
        $alertas = [];
        
        $router->render('servicios/index',[
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios,
            'alertas' => $alertas
        ]);
    }

    public static function crear(Router $router){
        session_start();
        isAdmin();
        $servicio = new Servicios;
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validarNuevoServicio();

            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
                Servicios::setAlerta('exito','Servicio Creado Correctamente');
            }
        }

        $alertas = Servicios::getAlertas();
        $router->render('servicios/crear',[
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }


    public static function actualizar(Router $router){

        //Capturamos el ID del GET
        if(!is_numeric($_GET['id'])) return;
        $servicio = Servicios::find($_GET['id']);
        $alertas = [];  


        if($_SERVER["REQUEST_METHOD"] === 'POST'){
           $servicio->sincronizar($_POST);
           $alertas = $servicio->validarNuevoServicio();

           if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
           }
            
        }

        $router->render('servicios/actualizar',[
            'alertas' => $alertas,
            'servicio' => $servicio
            
            
        ]);
    }

    public static function eliminar(){
        
        
        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            if(!is_numeric($_POST['id'])) return;
            $servicio = Servicios::find($_POST['id']);
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}