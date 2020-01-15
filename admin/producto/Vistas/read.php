<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/Alum/Paths.php";
        require_once CONTROLLER_PATH."ControladorAlumno.php";
        require_once UTILITY_PATH."funciones.php";

        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id = decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $alumno= $controlador->buscarAlumno($id);
            if (is_null($alumno)){ 
                header("location: /Alum/vistas/error.php");
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
                                    <label><b>DNI</b></label>
                                    <p class="form-control-static"><?php echo $alumno->getDni(); ?></p>
                                </div>
                            </td>
                            <td class="align-left">
                                <label><b>Fotografía</b></label><br>
                                <img src='<?php echo "../imagenes/" . $alumno->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                            </td>
                        </tr>
                    </table>
                
                  
                        <label><b>Nombre</b></label>
                        <p class="form-control-static"><?php echo $alumno->getNombre(); ?></p>
              
                        <label><b>Email</b></label>
                            <p class="form-control-static"><?php echo $alumno->getEmail(); ?></p>
                 
                        <label><b>Contraseña</b></label>
                        <p class="form-control-static"><?php echo str_repeat("*",strlen($alumno->getPassword())); ?></p>
                  
                        <label><b>Idioma</b></label>
                            <p class="form-control-static"><?php echo $alumno->getIdioma(); ?></p>
                  
                        <label><b>Matricula</b></label>
                            <p class="form-control-static"><?php echo $alumno->getMatricula(); ?></p>
               
                        <label><b>Lenguaje</b></label>
                            <p class="form-control-static"><?php echo $alumno->getLenguaje(); ?></p>
               
                        <label><b>Fecha</b></label>
                            <p class="form-control-static"><?php echo $alumno->getFecha(); ?></p>
                 
                    <p><a href="/Alum/indexAL.php" class="w3-btn w3-blue"> Volver</a></p>
 
<br><br><br>
<?php require_once VIEW_PATH."footer.php"; ?>