<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
        require_once CONTROLLER_PATH."ControladorAlumno.php";
        require_once UTILITY_PATH."funciones.php";
        require_once CONTROLLER_PATH."ControladorBD.php";
        require_once MODEL_PATH."alumno.php";

        error_reporting(E_ERROR | E_WARNING | E_PARSE);

$admins=[];
$bd = ControladorBD::getControlador();
$bd->abrirBD();
$consulta = "SELECT email,password FROM usuario WHERE admin = 'si'";
$filas = $bd->consultarBD($consulta);

    foreach ($filas as $a) {
        $mail = array_shift($a);// se queda con el primer elemento del array OJO sin su clave solo el elemento
        //array_pop($a); //saca un elemento de un array
        array_push($admins, $mail);  //introducimos los emails a un array 
    }

$bd->cerrarBD();



 session_start();
        if(!isset($_SESSION['USUARIO']['email'])){
            //echo "entro a lista admin";
            header("location: /games/admin/producto/Vistas/Login.php");
      exit();
        }    

       if(isset($_SESSION['USUARIO']['email']) && !in_array($_SESSION['USUARIO']['email'],$admins)){
              //echo "entro a lista admin";
              header("location: /games/admin/producto/Vistas/error_idi.php");
                exit();
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
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-top">
                                <div class="form-group" class="align-left">
                                <label><b>Nombre</b></label>
                                <p class="form-control-static"><?php echo $producto->getNombre(); ?></p>


                                </div>
                            </td>
                            <td class="align-left">
                                <label><b>Fotografía</b></label><br>
                                <img src='<?php echo "../imagenes/" . $producto->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                            </td>
                        </tr>
                    </table>
                
                        <label><b>Tipo</b></label>
                                <p class="form-control-static"><?php echo $producto->getTipo(); ?></p>
                        <label><b>Distribuidor</b></label>
                            <p class="form-control-static"><?php echo $producto->getDistribuidor(); ?></p>
                 
                        <label><b>Precio</b></label>
                        <p class="form-control-static"><?php echo str_repeat("*",strlen($producto->getPrecio())); ?></p>
                  
                        <label><b>Descuento</b></label>
                            <p class="form-control-static"><?php echo $producto->getDescuento(); ?></p>
                  
                        <label><b>Stock</b></label>
                            <p class="form-control-static"><?php echo $producto->getStock(); ?></p>
               

                 
                    <p><a href="/games/admin/producto/gestion.php" class="w3-btn w3-blue"> Volver</a></p>
 
<br><br><br>
<?php require_once VIEW_PATH."footer.php"; ?>