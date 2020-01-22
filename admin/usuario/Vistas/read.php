<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/usuario/Paths.php";
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
            header("location: /games/admin/usuario/Vistas/Login.php");
      exit();
        }    

       if(isset($_SESSION['USUARIO']['email']) && !in_array($_SESSION['USUARIO']['email'],$admins)){
              //echo "entro a lista admin";
              header("location: /games/admin/usuario/Vistas/error_idi.php");
                exit();
       }   
/*********************************************************************seguro************************************* */

        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id = decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $usuario= $controlador->buscarAlumno($id);
            if (is_null($usuario)){ 
                header("location: /games/admin/usuario/Vistas/error.php");
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
                                <p class="form-control-static"><?php echo $usuario->getNombre(); ?></p>

                                <label><b>Apellido</b></label>
                                <p class="form-control-static"><?php echo $usuario->getApellido(); ?></p>
                                </div>
                            </td>
                            <td class="align-left">
                                <label><b>Fotografía</b></label><br>
                                <img src='<?php echo "../imagenes/" . $usuario->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                            </td>
                        </tr>
                    </table>
                
              
                        <label><b>Email</b></label>
                            <p class="form-control-static"><?php echo $usuario->getEmail(); ?></p>
                 
                        <label><b>Contraseña</b></label>
                        <p class="form-control-static"><?php echo str_repeat("*",strlen($usuario->getPassword())); ?></p>
                  
                        <label><b>Idioma</b></label>
                            <p class="form-control-static"><?php echo $usuario->getAdmin(); ?></p>
                  
                        <label><b>Matricula</b></label>
                            <p class="form-control-static"><?php echo $usuario->getTelefono(); ?></p>
               
                        <label><b>Fecha</b></label>
                            <p class="form-control-static"><?php echo $usuario->getFecha(); ?></p>
                 
                    <p><a href="/games/admin/usuario/gestion.php" class="w3-btn w3-blue"> Volver</a></p>
 
<br><br><br>
<?php require_once VIEW_PATH."footer.php"; ?>