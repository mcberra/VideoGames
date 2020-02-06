<?php
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE); 

session_start();
  

if (isset($_GET["suma"])) {//si recibimos la variable suma por get esto se ejecuta
    $suma = decode($_GET["suma"]);
    
    if ($_SESSION['cart'][$suma][6] >= $_SESSION['cart'][$suma][5]) {
        alerta("La cantidad que intenta comprar es superior a la que tenemos en stock.");
        header("Location: /games/Vistas/carrito.php");
    }else{
    $_SESSION['cart'][$suma][6] = $_SESSION['cart'][$suma][6] + 1;
    header("Location: /games/Vistas/carrito.php");
    }

}

if (isset($_GET["resta"])) {//si recibimos la variable resta por get esto se ejecuta
    $resta = decode($_GET["resta"]);
    if ($_SESSION['cart'][$resta][6] < 2 ) {
        alerta("Solo le queda un objeto de este tipo en el carrito, si quiere borrarlo pulse borrar.");
        header("Location: /games/Vistas/carrito.php");
    }else{
    $_SESSION['cart'][$resta][6] = $_SESSION['cart'][$resta][6] - 1;
    header("Location: /games/Vistas/carrito.php");
    }
}
?>