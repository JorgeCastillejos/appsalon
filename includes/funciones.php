<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function isAuth():void{
    session_start();
    if(!$_SESSION['login']){
        header('Location: /');
    }
}

function isAdmin(){
    session_start();
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}

//Calcular el Total a pagar
function esUltimo(string $actual, string $proximo){
    if($actual !== $proximo){
        return true;
    }
    return false;
}

function verErrores(){
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
}