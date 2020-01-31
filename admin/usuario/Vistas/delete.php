<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/usuario/Paths.php";
        require_once CONTROLLER_PATH."ControladorAlumno.php";
        require_once CONTROLLER_PATH."ControladorImagen.php";
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

       /**************************seguro************************************************************** */
        
        // Obtenemos los datos del alumno que nos vienen de la página anterior
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // Cargamos el controlador de alumnos
            $id = decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $usuario = $controlador->buscarAlumno($id);
            if (is_null($usuario)) {
                // hay un error
                header("location: /games/admin/usuario/Vistas/error.php");
                exit();
            }
        }
        
        
        // Los datos del formulario al procesar el sí.
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            $controlador = ControladorAlumno::getControlador();
            $usuario = $controlador->buscarAlumno($_POST["id"]);

            if ($controlador->borrarAlumno($_POST["id"])) {
                $borra = true;
               // Debemos borrar la foto del alumno
               $controlador = ControladorImagen::getControlador();
               if($controlador->eliminarImagen($usuario->getImagen())){
                    
                    header("location: /games/admin/usuario/gestion.php");
                   
               }else{
                  header("location: /games/admin/usuario/Vistas/error.php");
                    
                }
            } else {
                header("location:/games/admin/usuario/Vistas/error.php");
                
            }
        } 
        
        
        if($borra == true){
                //echo $usuario->getEmail();
               $email = $usuario->getEmail();
               $bd = ControladorBD::getControlador();
               $bd->abrirBD();
               $consulta = "DELETE  FROM sesion WHERE email = :email";
               $parametros = array(':email' => $email);
               $estado = $bd->actualizarBD($consulta,$parametros);
               echo $email;
               $bd->cerrarBD();
        }
?>

<?php require_once VIEW_PATH."header.php"; ?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<h1>Borrar Alumno</h1>
            
                <table>
                    <tr>
                        <td class="col-xs-11" class="align-top">
                           
                               
                        <label><b>Nombre</b></label>
                        <p class="form-control-static"><?php echo $usuario->getNombre(); ?></p>

                        <label><b>Apellido</b></label>
                        <p class="form-control-static"><?php echo $usuario->getApellido(); ?></p>
                              
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
            
                        <label><b>Admin</b></label>
                            <p class="form-control-static"><?php echo $usuario->getAdmin(); ?></p>
                  
                        <label><b>Telefono</b></label>
                            <p class="form-control-static"><?php echo $usuario->getTelefono(); ?></p>
               
               
                        <label><b>Fecha</b></label>
                            <p class="form-control-static"><?php echo $usuario->getFecha(); ?></p>
                  
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="w3-panel w3-pale-red w3-border">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este alumno/a?</p><br>
                        <p>
                            <button type="submit" class="w3-btn w3-red">   Borrar</button>
                            <a href="/games/admin/usuario/gestion.php" class="w3-btn w3-blue"> Volver</a>
                        </p>
                    </div>
                </form>
<?php require_once VIEW_PATH."footer.php"; ?>