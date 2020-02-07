<?php
//es una pagina muy simple que simplemente  elimina el indice indicado del array
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$id = decode($_GET["id"]);//esta variable id realmente contiene el nombre del indice del array
$borrar_indice= $id;
echo "<br>";
unset($_SESSION["cart"][$borrar_indice]);
header("Location: /games/Vistas/carrito.php")


?>