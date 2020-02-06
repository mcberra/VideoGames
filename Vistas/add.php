<?php
//en este apartado es donde introducimos los productos en la session, los introducimos utilizando el propio nombre del producto como
//nombre de los indices del array, para facilitar asi la busqueda de un producto en el propio array.
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";

// if (!isset($_SESSION['USUARIO']['email'])) {
//     header("Location: /games/indexCAT.php");
// }
error_reporting(E_ERROR | E_WARNING | E_PARSE);


if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){//obtenemos el id pasado por get
    $id = decode($_GET["id"]);
    $controlador = ControladorAlumno::getControlador();
    $producto= $controlador->buscarAlumno($id);
    if (is_null($producto)){ 
        header("location: /games/Vistas/error.php");
        exit();
    } 
}
// print_r($_SESSION['cart'][$producto->getNombre()][6]); 
// echo $producto->getNombre();
// echo "<br>";
// print_r($_SESSION['cart']);



session_start();

if (!isset($_SESSION['cart'])) {//sino esta inicializada la session la creamos vacia
    $_SESSION['cart']=[];
   
}

$uds = 1;


// if(!isset($_SESSION['cart'])){//se ejecutara la primera vez que añadamos un producto al carrito
//     $_SESSION['temp'][$producto->getNombre()]['0']=$producto->getId();
//     $_SESSION['temp'][$producto->getNombre()]['1']=$producto->getNombre();
//     $_SESSION['temp'][$producto->getNombre()]['2']=$producto->getImagen();
//     $_SESSION['temp'][$producto->getNombre()]['3']=$producto->getPrecio();
//     $_SESSION['temp'][$producto->getNombre()]['4']=$producto->getDescuento();
//     $_SESSION['temp'][$producto->getNombre()]['5']=$producto->getStock();
//     $_SESSION['temp'][$producto->getNombre()]['6']=$uds;
//     $_SESSION['temp'][$producto->getNombre()]['7']=$producto->getNombre();

//     $_SESSION['cart']=$_SESSION['temp'];

//}else{

    //$_SESSION['temp']=$_SESSION['cart'];//si ya esta creada la sesion se ejecuta este codigo para seguir añadiendo productos

    $_SESSION['cart'][$producto->getNombre()]['0']=$producto->getId();
    $_SESSION['cart'][$producto->getNombre()]['1']=$producto->getNombre();
    $_SESSION['cart'][$producto->getNombre()]['2']=$producto->getImagen();
    $_SESSION['cart'][$producto->getNombre()]['3']=$producto->getPrecio();
    $_SESSION['cart'][$producto->getNombre()]['4']=$producto->getDescuento();
    $_SESSION['cart'][$producto->getNombre()]['5']=$producto->getStock();
    $_SESSION['cart'][$producto->getNombre()]['6']=$uds;


    //$_SESSION['cart']=$_SESSION['temp'];

//}

header("Location: /games/indexCAT.php");

?>

                      
