<?php
        require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/usuario/Paths.php";
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
            $usuario= $controlador->buscarAlumno($id);
            if (is_null($usuario)){ 
                header("location: /games/admin/usuario/Vistas/error.php");
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


<img  src='<?php echo "../imagenes/" . $usuario->getImagen() ?>' alt="Alps" style="width:50%;float:right">
                
                             <div style="widht:40%">
                                <label><b>Nombre</b></label>
                                <p ><?php echo $usuario->getNombre(); ?></p>

                                <label><b>Apellido</b></label>
                                <p ><?php echo $usuario->getApellido(); ?></p>
                            </div><br>
                           
                
              
                        <label><b>Email</b></label>
                            <p class="form-control-static"><?php echo $usuario->getEmail(); ?></p>
                 
                        <label><b>Contraseña</b></label>
                        <p class="form-control-static"><?php echo str_repeat("*",strlen($usuario->getPassword())); ?></p>
                  
                        <label><b>Idioma</b></label>
                            <p class="form-control-static"><?php echo $usuario->getAdmin(); ?></p>
                  
                        <label><b>Matricula</b></label>
                            <p class="form-control-static"><?php echo $usuario->getTelefono(); ?></p>
               
                        <label><b>Fecha</b></label>
                            <p class="form-control-static"><?php echo $usuario->getFecha(); ?></p><br><br>
                 
                    
                    <a href="/games/admin/usuario/gestion.php" class="w3-btn w3-block w3-black  w3-hover-blue" style="width:100%;text-decoration:none"> Volver</a>
</div> 
<br><br><br>
<?php require_once VIEW_PATH."footer.php"; ?>