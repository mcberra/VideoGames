<?php

include_once ("conexion.php");

$consulta = $con->prepare (" INSERT INTO tabla (id, nombre, tipo, compañia, precio, descuento, unidades, imagen) 
                            VALUES (:id, :nombre, :tipo, :compañia, :precio, :descuento, :unidades, :imagen)");  //plantilla del INSERT
//insertas los datos sobre los otros datos
?>

<form action="insertar.php" method="post">
    <p>Nombre: <input type="text" name="nombre" size="40"></p>
    <p>Tipo:
        <input type="radio" name="tipo" value="Juego de Mando"> Juego de Mando
        <input type="radio" name="tipo" value="Juego de Mesa"> Juego de Mesa
        <input type="radio" name="tipo" value="Juego de PC"> Juego de PC
    </p>
    <p>Compañia:
        <input type="checkbox" name="compañia" value="Play Station">Play Station
        <input type="checkbox" name="compañia" value="Play Station">XBOX
        <input type="checkbox" name="compañia" value="Play Station">PC
        <input type="checkbox" name="compañia" value="Play Station">Nintendo
        <input type="checkbox" name="compañia" value="Play Station">WII
    </p>
    <p>Precio: <input type="number" name="precio"></p>
    <p>Descuento: <input type="number" name="descuento"></p>
    <p>Unidades: <input type="number" name="unidades"></p>
    <p><input type="file" name="imagen"></p>
    <p>
        <input type="submit" value="Enviar">
        <input type="reset" value="Borrar">
    </p>
</form>


<?php
$id="";
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$compañia = $_POST['compañia'];
$precio = $_POST['precio'];
$descuento = $_POST['descuento'];
$unidades = $_POST['unidades'];
$imagen = $_POST['imagen'];


if($consulta->execute(array(':id'=>$id, ':nombre'=>$nombre, ':tipo'=>$tipo, ':compañia'=>$compañia,
                            ':precio'=>$precio, ':descuento'=>$descuento, ':unidades'=>$unidades, ':imagen'=>$imagen ))){ //casas los datos unos con otros

    echo "Se ha creado el nuevo registro"; //mensaje de exito
}

?>
