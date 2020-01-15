<?php
try { //intentar la conexion

$con=new PDO('mysql:host=localhost; dbname=productos', 'root', ''); //conexion a la base de datos

}

catch (PDOException $e) {
    echo $e->getMessage(); //esto es por si acaso falla
}

$id="";
$nombre="";
$tipo="";
$compañia="";
$precio="";
$descuento="";
$unidades="";
$imagen="";







