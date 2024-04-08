<?php
namespace Model;
class Servicios extends ActiveRecord{
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validarNuevoServicio(){
        if(!$this->nombre){
            self::setAlerta('error','El nombre es obligatorio');
        }

        if(!$this->precio){
            self::setAlerta('error','El Precio es obligatorio');
        }

        if(!is_numeric($this->precio)){
            self::setAlerta('error','Formato de precio no Valido');
        }

        return self::$alertas;
    }

    
}