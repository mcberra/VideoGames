<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/Alum1/Paths.php";
        require_once CONTROLLER_PATH."ControladorAlumno.php";
        require_once CONTROLLER_PATH."ControladorImagen.php";
        require_once UTILITY_PATH."funciones.php";
        
        // Obtenemos los datos del alumno que nos vienen de la página anterior
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // Cargamos el controlador de alumnos
            $id = decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $alumno = $controlador->buscarAlumno($id);
            if (is_null($alumno)) {
                // hay un error
                header("location: error.php");
                exit();
            }
        }
        
        // Los datos del formulario al procesar el sí.
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            $controlador = ControladorAlumno::getControlador();
            $alumno = $controlador->buscarAlumno($_POST["id"]);
            if ($controlador->borrarAlumno($_POST["id"])) {
                //Se ha borrado y volvemos a la página principal
               // Debemos borrar la foto del alumno
               $controlador = ControladorImagen::getControlador();
               if($controlador->eliminarImagen($alumno->getImagen())){
                    header("location: /Alum1/indexAL.php");
                    exit();
               }else{
                    header("location: /Alum1/Vistas/error.php");
                    exit();
                }
            } else {
                header("location: /Alum1/Vistas/error.php");
                exit();
            }
        } 
        
?>

<?php require_once VIEW_PATH."header.php"; ?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<h1>Borrar Alumno</h1>
            
                <table>
                    <tr>
                        <td class="col-xs-11" class="align-top">
                           
                               
                        <label><b>Nombre</b></label>
                        <p class="form-control-static"><?php echo $alumno->getNombre(); ?></p>

                        <label><b>Apellido</b></label>
                        <p class="form-control-static"><?php echo $alumno->getApellido(); ?></p>
                              
                        </td>
                        <td class="align-left">
                            <label><b>Fotografía</b></label><br>
                            <img src='<?php echo "../imagenes/" . $alumno->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                        </td>
                    </tr>
                </table>

                  

               
                        <label><b>Email</b></label>
                            <p class="form-control-static"><?php echo $alumno->getEmail(); ?></p>
                
                        <label><b>Contraseña</b></label>
                        <p class="form-control-static"><?php echo str_repeat("*",strlen($alumno->getPassword())); ?></p>
            
                        <label><b>Admin</b></label>
                            <p class="form-control-static"><?php echo $alumno->getAdmin(); ?></p>
                  
                        <label><b>Telefono</b></label>
                            <p class="form-control-static"><?php echo $alumno->getTelefono(); ?></p>
               
               
                        <label><b>Fecha</b></label>
                            <p class="form-control-static"><?php echo $alumno->getFecha(); ?></p>
                  
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="w3-panel w3-pale-red w3-border">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este alumno/a?</p><br>
                        <p>
                            <button type="submit" class="w3-btn w3-red">   Borrar</button>
                            <a href="/Alum1/indexAL.php" class="w3-btn w3-blue"> Volver</a>
                        </p>
                    </div>
                </form>
<?php require_once VIEW_PATH."footer.php"; ?>