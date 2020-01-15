
  <?php

require_once $_SERVER['DOCUMENT_ROOT']."/Alum1/Paths.php";
require_once MODEL_PATH."alumno.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// $admins=[];
// $bd = ControladorBD::getControlador();
// $bd->abrirBD();
// $consulta = "SELECT email FROM usuario WHERE admin = 'si'";
// $filas = $bd->consultarBD($consulta);

//     foreach ($filas as $a) {
//         $mail = array_shift($a);// se queda con el primer elemento del array OJO sin su clave solo el elemento
//         //array_pop($a); //saca un elemento de un array
//         // print_r($fruit);
//         // echo "<br>";
//         // print_r($a);
//         // echo "<br>";
//         array_push($admins, $mail);  //introducimos los emails a un array 
//     }

// $bd->cerrarBD();
// //print_r($admins);



// if (isset($_SESSION['USUARIO']['email'])) {
//        print_r($admins);
//       echo  $_SESSION['USUARIO']['email'];
//       exit;
//        if(isset($_SESSION['USUARIO']['email']) && in_array($_SESSION['USUARIO']['email'],$admins)){
      
//               require_once VIEW_PATH."lista_admin.php";
//                 exit();
//        } else{
      
//               require_once VIEW_PATH."lista_normal.php";
             
//        }     
// }else {
//        header("location: /Alum1/Vistas/Login.php");
// }

session_start();
if (isset($_SESSION['USUARIO']['email'])) {
       require_once VIEW_PATH."lista_admin.php";
}else {
       header("location: /Alum1/Vistas/Login.php");
}



  ?>
