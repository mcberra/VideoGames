
  <?php

require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
require_once MODEL_PATH."alumno.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);



$admins=[];
$bd = ControladorBD::getControlador();
$bd->abrirBD();
$consulta = "SELECT email,password FROM usuario WHERE admin = 'si'";
$filas = $bd->consultarBD($consulta);

    foreach ($filas as $a) {
        $mail = array_shift($a);// se queda con el primer elemento del array OJO sin su clave solo el elemento
        //array_pop($a); //saca un elemento de un array
        // print_r($fruit);
        // echo "<br>";
        // print_r($a);
        // echo "<br>";
        array_push($admins, $mail);  //introducimos los emails a un array 
    }

$bd->cerrarBD();
//print_r($admins);


session_start();
if (isset($_SESSION['USUARIO']['email'])) {
       //print_r($admins);
      //echo  $_SESSION['USUARIO']['email'];
     
       if(isset($_SESSION['USUARIO']['email']) && in_array($_SESSION['USUARIO']['email'],$admins)){
              //echo "entro a lista admin";
              require_once VIEW_PATH."lista_admin.php";
               
       } else{
      
              require_once VIEW_PATH."lista_normal.php";
             
       }     
}else {
       header("location: /games/admin/producto/Vistas/Login.php");
}

// session_start();
// if (isset($_SESSION['USUARIO']['email'])) {
//        require_once VIEW_PATH."lista_admin.php";
// }else {
//        header("location: /games/admin/usuario/gestion.php");
// }


// require_once VIEW_PATH."lista_admin.php";


  ?>
