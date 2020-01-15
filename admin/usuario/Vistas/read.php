<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/usuario/Paths.php";
        require_once CONTROLLER_PATH."ControladorAlumno.php";
        require_once UTILITY_PATH."funciones.php";

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