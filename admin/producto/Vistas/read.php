<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
        require_once CONTROLLER_PATH."ControladorAlumno.php";
        require_once UTILITY_PATH."funciones.php";
        require_once CONTROLLER_PATH."ControladorBD.php";
        require_once MODEL_PATH."alumno.php";

        error_reporting(E_ERROR | E_WARNING | E_PARSE);

        session_start();
        if (!isset($_SESSION['USUARIO']['email'])) {
          header("location: /games/admin/producto/Vistas/Login.php");
        }
        if (isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='no'){
          header("location: /games/admin/producto/Vistas/Login.php");
        }  
/*********************************************************************seguro************************************* */

        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id = decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $producto= $controlador->buscarAlumno($id);
            if (is_null($producto)){ 
                header("location: /games/admin/producto/Vistas/error.php");
                exit();
            } 
        }
?>
<?php require_once VIEW_PATH."header.php"; ?>
<style>
	#centrar
	{
        margin: 0 auto;
        padding:20px;
	}
</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-card-4" style='width:35%;margin-top:25px' id="centrar"  >
<img src='<?php echo "/games/admin/producto/imagenes/" . $producto->getImagen() ?>' alt="Alps" style="width:100%">

<table class="w3-table ">

<tbody>
    <tr>
        <td>Nombre del producto</td>
        <td><?php echo $producto->getNombre(); ?></td>
    </tr>
    <tr>
        <td>Video juego del tipo</td>
        <td><?php echo $producto->getTipo(); ?></button> </td>
    </tr>
    <tr>
        <td>Precio</td>
        <td>
            <?php 
                $descuento=$producto->getDescuento(); 
                if ($descuento > 0) {
                    $price=($producto->getPrecio()-($producto->getPrecio()*$descuento/100));
                    echo "<p><del> € ".$producto->getPrecio()." </del> <i style='color:red'>€".$price."</i> </p>"; 

                }else{
                    echo "<p> € ".$producto->getPrecio()."   </p>";
                }
            ?>
        </td>
    </tr>
    <tr>
        <td>Descuento</td>
        <td><?php echo $producto->getDescuento(); ?>%</td>
    </tr>
    <tr>
        <td>Stock</td>
        <td><?php echo $producto->getStock(); ?></td>
    </tr>

</tbody>
</table>
                     

    
                            <a href="/games/admin/producto/gestion.php" class="w3-btn w3-block w3-black  w3-hover-blue" style="width:100%;text-decoration:none"> Volver</a>
                   
 </div>
<br><br><br>
<?php require_once VIEW_PATH."footer.php"; ?>