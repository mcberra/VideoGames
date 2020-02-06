<?php
//vaciamos el carrito
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";

session_start();
unset($_SESSION['cart']);
session_unset($_SESSION['cart']);
session_destroy($_SESSION['cart']);
header("Location: /games/Vistas/carrito.php");

?>