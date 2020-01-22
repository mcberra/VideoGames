<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
        require_once CONTROLLER_PATH."ControladorAlumno.php";
        require_once UTILITY_PATH."funciones.php";
        require_once CONTROLLER_PATH."ControladorBD.php";
        require_once MODEL_PATH."alumno.php";

        error_reporting(E_ERROR | E_WARNING | E_PARSE);

// $admins=[];
// $bd = ControladorBD::getControlador();
// $bd->abrirBD();
// $consulta = "SELECT email,password FROM usuario WHERE admin = 'si'";
// $filas = $bd->consultarBD($consulta);

//     foreach ($filas as $a) {
//         $mail = array_shift($a);// se queda con el primer elemento del array OJO sin su clave solo el elemento
//         //array_pop($a); //saca un elemento de un array
//         array_push($admins, $mail);  //introducimos los emails a un array 
//     }

// $bd->cerrarBD();



//  session_start();
//         if(!isset($_SESSION['USUARIO']['email'])){
//             //echo "entro a lista admin";
//             header("location: /games/Vistas/Login.php");
//       exit();
//         }    

//        if(isset($_SESSION['USUARIO']['email']) && !in_array($_SESSION['USUARIO']['email'],$admins)){
//               //echo "entro a lista admin";
//               header("location: /games/Vistas/error_idi.php");
//                 exit();
//        }   
/*********************************************************************seguro************************************* */

        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id = decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $producto= $controlador->buscarAlumno($id);
            if (is_null($producto)){ 
                header("location: /games/Vistas/error.php");
                exit();
            } 
        }
?>
<?php require_once VIEW_PATH."header.php"; ?>
<style>
	#centrar
	{
        margin: 0 auto;
	}
	</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    

<div class="w3-card-4" style='width:35%;margin-top:25px' id="centrar"  >       
        
        <img src='<?php echo "/games/admin/producto/imagenes/" . $producto->getImagen() ?>' alt="Alps" style="width:100%">

        <table class="w3-table w3-blue-grey">

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
                             

            <a href="/games/indexCAT.php" class="w3-btn w3-block w3-pale-blue w3-hover-aqua" style="width:100%"> Volver</a>
</div>
     
<br><br><br>
