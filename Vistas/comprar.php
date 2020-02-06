<?php

//Si pulsamos el boton comprar se ejecuta esta pagina, es igual que la de añadir pero nos lleva al carrito para iniciar el proceso de compra
//
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";


error_reporting(E_ERROR | E_WARNING | E_PARSE);


if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = decode($_GET["id"]);
    $controlador = ControladorAlumno::getControlador();
    $producto= $controlador->buscarAlumno($id);
    if (is_null($producto)){ 
        header("location: /games/Vistas/error.php");
        exit();
    } 
}
print_r($_SESSION['cart'][$producto->getNombre()][6]); 
echo $producto->getNombre();
echo "<br>";
print_r($_SESSION['cart']);
$uds = 1;


session_start();

$_SESSION['temp']=[];


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart']=[];
   
}
if(!isset($_SESSION['indice'])){
    $_SESSION['indice']=0;
}



if(!isset($_SESSION['cart'])){
    $_SESSION['ind'] = 0;
    $_SESSION['temp'][$producto->getNombre()]['0']=$producto->getId();
    $_SESSION['temp'][$producto->getNombre()]['1']=$producto->getNombre();
    $_SESSION['temp'][$producto->getNombre()]['2']=$producto->getImagen();
    $_SESSION['temp'][$producto->getNombre()]['3']=$producto->getPrecio();
    $_SESSION['temp'][$producto->getNombre()]['4']=$producto->getDescuento();
    $_SESSION['temp'][$producto->getNombre()]['5']=$producto->getStock();
    $_SESSION['temp'][$producto->getNombre()]['6']=$uds;
    $_SESSION['temp'][$producto->getNombre()]['7']=$producto->getNombre();

    $_SESSION['cart']=$_SESSION['temp'];

}else{


    $_SESSION['temp']=$_SESSION['cart'];

    $_SESSION['temp'][$producto->getNombre()]['0']=$producto->getId();
    $_SESSION['temp'][$producto->getNombre()]['1']=$producto->getNombre();
    $_SESSION['temp'][$producto->getNombre()]['2']=$producto->getImagen();
    $_SESSION['temp'][$producto->getNombre()]['3']=$producto->getPrecio();
    $_SESSION['temp'][$producto->getNombre()]['4']=$producto->getDescuento();
    $_SESSION['temp'][$producto->getNombre()]['5']=$producto->getStock();
    $_SESSION['temp'][$producto->getNombre()]['6']=$uds;
    $_SESSION['temp'][$producto->getNombre()]['7']=$producto->getNombre();

    $_SESSION['cart']=$_SESSION['temp'];

}

header("Location: /games/Vistas/carrito.php");

?>

                      

