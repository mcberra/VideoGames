<?php
//en esta pagina borramos los productos
        require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
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
 /***************************************************seguro********************************************************************* */
       
        // Obtenemos los datos del alumno que nos vienen de la página anterior
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // Cargamos el controlador de alumnos
            $id = decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $producto = $controlador->buscarAlumno($id);
            if (is_null($producto)) {
                // hay un error
                header("location: /games/admin/producto/Vistas/error.php");
                exit();
            }
        }
        
        // Los datos del formulario al procesar el sí.
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            $controlador = ControladorAlumno::getControlador();
            $producto = $controlador->buscarAlumno($_POST["id"]);
            if ($controlador->borrarAlumno($_POST["id"])) {
                //Se ha borrado y volvemos a la página principal
               // Debemos borrar la foto del alumno
               $controlador = ControladorImagen::getControlador();
               if($controlador->eliminarImagen($producto->getImagen())){
                    header("location: /games/admin/producto/gestion.php");
                    exit();
               }else{
                    header("location: /games/admin/producto/Vistas/error.php");
                    exit();
                }
            } else {
                header("location:/games/admin/producto/Vistas/error.php");
                exit();
            }
        } 
        
?>

<?php require_once VIEW_PATH."header.php"; ?>
<style>
	#centrar
	{
        margin: 0 auto;
        padding:50px;
	}
</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-card-4" style='width:35%;margin-top:25px' id="centrar"  >
<img  src='<?php echo "../imagenes/" . $producto->getImagen() ?>' alt="Alps" style="width:50%;float:right">
            
                                <label><b>Nombre</b></label>
                                <p class="form-control-static"><?php echo $producto->getNombre(); ?></p>


                
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
                  
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="w3-panel w3-pale-red w3-border">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este alumno/a?</p><br>
                        <p>
                            <button type="submit" class="w3-btn w3-red w3-border  w3-round-large">   Borrar</button>
                            <a href="/games/admin/producto/gestion.php" class="w3-btn w3-blue w3-border  w3-round-large" style="text-decoration:none"> Volver</a>
                        </p>
                    </div>
                </form>
</div>
<?php require_once VIEW_PATH."footer.php"; ?>