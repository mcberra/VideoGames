
  <?php
//en esta pagina enlazamos a la lista de usuario
require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/usuario/Paths.php";
require_once MODEL_PATH."alumno.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);


session_start();//seguro de la pagina
if(isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='si'){
              //echo "entro a lista admin";
              require_once VIEW_PATH."lista_usuario.php";
               
           
}else {
       header("location: /games/admin/usuario/Vistas/Login.php");
}

  ?>
