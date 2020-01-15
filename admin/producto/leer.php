<?php

include_once ("conexion.php");

$consulta = $con->prepare ("SELECT * FROM producto");  //plantilla del select

$consulta->execute();

?>
<table>
    <tr>
        <td>Identificador</td>
        <td>Nombre</td>
        <td>Tipo</td>
        <td>Compañia</td>
        <td>Precio</td>
        <td>Descuento</td>
        <td>Unidades</td>
        <td>Imagen</td>
    </tr>
<?php
while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {  //el row contiene la consulta y los objetos, se pone para coger el valor de él ?>
    <tr>
        <td><?php echo $row->id;?></td>
        <td><?php echo $row->nombre;?></td>
        <td><?php echo $row->tipo;?></td>
        <td><?php echo $row->compañia;?></td>
        <td><?php echo $row->precio;?></td>
        <td><?php echo $row->descuento;?></td>
        <td><?php echo $row->unidades;?></td>
        <td><?php echo $row->imagen;?></td>
</tr>
<?php }
?>
</table>

<a href="insertar.php"> Insertar Un Producto </a> </br>
<a href="update.php"> Actualizar Un Producto </a> </br>
<a href="delete.php"> Eliminar un Producto</a>
