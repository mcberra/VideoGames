<?php


require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);   
$_SESSION['total']=[];
foreach ($_SESSION['cart'] as $key => $value) {
    $sums = 0;
    $sums = $value[6] * $value[3];
    print_r($sums);
    echo "<br>";
    $_SESSION['tempo']=$sums;
    //array_push($_SESSION['tempo'],$sums);
    array_push($_SESSION['total'],$_SESSION['tempo']);
   
}
echo "<br>";
print_r($_SESSION['total']);
echo array_sum($_SESSION['total']);
 
?>
