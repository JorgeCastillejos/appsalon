<?php 
// Conectarnos a la base de datos

use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotvenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotvenv->safeLoad();

require 'funciones.php';
require 'database.php';



ActiveRecord::setDB($db);