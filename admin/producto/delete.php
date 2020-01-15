<?php

include_once ("conexion.php"); //para incluir la funcion de la conexion

?>
    <form action="delete.php" method="post">
        <p>ID a Eliminar <input type="number" name="id"></p>
        <p>
            <input type="submit" value="Enviar">
            <input type="reset" value="Borrar">
        </p>
    </form>

<?php
$id=$_POST["id"];
//esto es para eliminar los registros
$consulta = $con->prepare ("DELETE FROM tabla WHERE ID='$id'");

if($consulta->execute(array(':id'=>$id, ':nombre'=>$nombre, ':tipo'=>$tipo, ':compañia'=>$compañia,
    ':precio'=>$precio, ':descuento'=>$descuento, ':unidades'=>$unidades, ':imagen'=>$imagen ))){ //casas los datos unos con otros

    echo "Se ha eliminado el registro"; //mensaje de exito
}
?>