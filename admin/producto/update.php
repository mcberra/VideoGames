<?php

include_once ("conexion.php");

$consulta = $con->prepare (" UPDATE producto SET id=:id, nombre =:nombre, tipo=:tipo, compañia=:compañia, precio=:precio, 
 descuento=:descuento, unidades=:unidades, imagen=:imagen WHERE id=5");


$id="3";
$nombre= "Dimitri";
$tipo="paquito";
$compañia="hola";
$precio="58";
$descuento="15";
$unidades="2";
$imagen="";



if($consulta->execute(array(':id'=>$id, ':nombre'=>$nombre, ':tipo'=>$tipo, ':compañia'=>$compañia,
    ':precio'=>$precio, ':descuento'=>$descuento, ':unidades'=>$unidades, ':imagen'=>$imagen ))) {

    echo "Se ha actualizado el producto";
}
    ?>