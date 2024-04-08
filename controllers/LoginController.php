<?php
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    
    //Login Pagina Principal
    public static function index(Router $router){


        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();   

            if(empty($alertas)){
                //Valida que la cuenta exista en BD
                $usuario = Usuario::were('email',$auth->email);
                
                if($usuario && $usuario->confirmado){
                    //Validamos que el password sea Correcto
                    $resultado = $auth->confirmaPassword($auth->password,$usuario->password);
                    if($resultado){
                        //Autenticar al usuario
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        //Redireccionar Dependiendo si es Admin o Cliente
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = true;
                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                        
                    }else{
                        $alertas = Usuario::setAlerta('error','El password es incorrecto');
                    }

                }else{
                    $alertas = Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/index',[
            'alertas' => $alertas
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    //Crear Nueva Cuenta
    public static function crear(Router $router){
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarCuentaNueva();

            if(empty($alertas)){
                //Validar si ya Existe el usuario
                $resultado = Usuario::were('email',$_POST['email']);
                if($resultado->num_rows){
                    $alertas = Usuario::setAlerta('error','El usuario ya esta registrado');
                }else{
                    
                    //Hashear Password
                    $usuario->hashearPassword();

                    //Crear Token
                    $usuario->crearToken();

                    //Enviar Email
                    $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                    $email->enviarConfirmacion();

                    //Guardar
                    $usuario->guardar();
                }
            }
            
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/crear',[
            'alertas' => $alertas
        ]);
    }

    public static function confirma(Router $router){
        $token = $_GET['token'];
        $alertas = [];
        $desaparece = false;
        
        //Confirma que sea un Token Valido
        $usuario = Usuario::were('token',$token);
        if(empty($usuario)){
            $alertas = Usuario::setAlerta('error','Token no Valido');
            $desaparece = true;
        }else{
            $alertas = Usuario::setAlerta('exito','Cuenta Confirmada Correctamente');

            //Cambiar el status de confirmado a 1
            $usuario->confirmado = 1;
            

            //Eliminar el Token
            $usuario->token = '';
            //Guardar Cambios
            $usuario->guardar();
        }
        
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/confirma-cuenta',[
            'alertas' => $alertas,
            'desaparece' => $desaparece
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    //Olvide el password
    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)){
                //Validar que el Usuario exista y Ademas que este confirmado
                $usuario = Usuario::were('email',$usuario->email);
                
                if($usuario && $usuario->confirmado){
                    
                    //Generar Token Unico
                    $usuario->crearToken();
                    
                    //Enviar Email
                    $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                    $email->enviarInstrucciones();

                    $usuario->guardar();

                    //Guardar Token en BD
                }else{
                    $alertas = Usuario::setAlerta('error','Usuario no registrado o la cuenta no ha sido confirmada');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/olvide',[
            'alertas' => $alertas
        ]);
    }


    public static function recuperar(Router $router){
        $token = $_GET['token'];
        $desaparece = false;

        //Validar que el Token sea Valido
        $usuario = Usuario::were('token',$token);

        if(empty($usuario)){
            $alertas = Usuario::setAlerta('error','Token No Valido');
            $desaparece = true;
        }

        //El Token es Valido
        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){

                //Elimina el Password Anterior
                $usuario->password = '';

                //Asigna el nuevo password
                $usuario->password = $password->password;

                //Hashea el password
                $usuario->hashearPassword();

                //Elimina el Token
                $usuario->token = '';

                //Guarda los Cambios
                $usuario->guardar();

                header('Location: /');
            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar',[
            'alertas' => $alertas,
            'desaparece' => $desaparece
        ]);
    }
    
}