<?php

//en este apartado hacemos que los indices del array siempre se incrementen en 1, de tal forma que, al borrar y volver introducir
//un valores en el array los indices no coincidan con los que puedan haber quedado.
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
// if(isset($_SESSION['indice'])){
//     $_SESSION['indice']=$_SESSION['indice']+1;
// }


if(!isset($_SESSION['cart'])){
    $_SESSION['ind'] = 0;
    $_SESSION['temp'][$producto->getNombre()]['0']=$producto->getId();
    $_SESSION['temp'][$producto->getNombre()]['1']=$producto->getNombre();
    $_SESSION['temp'][$producto->getNombre()]['2']=$producto->getImagen();
    $_SESSION['temp'][$producto->getNombre()]['3']=$producto->getPrecio();
    $_SESSION['temp'][$producto->getNombre()]['4']=$producto->getDescuento();
    $_SESSION['temp'][$producto->getNombre()]['5']=$producto->getStock();
    $_SESSION['temp'][$producto->getNombre()]['6']=$uds;
    //$_SESSION['indice']=$indice;
    $_SESSION['temp'][$producto->getNombre()]['7']=$producto->getNombre();

    $_SESSION['cart']=$_SESSION['temp'];
    //array_push($_SESSION['cart'],$_SESSION['temp']);
}else{

    // $nombre=$producto->getNombre();
    // if (in_array($nombre,$_SESSION['cart'])) {
    //     $_SESSION['cart'][$producto->getNombre()][6] = $_SESSION['cart'][$producto->getNombre()][6]+1;
    //     exit();
       
    // }
    $_SESSION['temp']=$_SESSION['cart'];
    //$_SESSION['ind'] = count($_SESSION['temp']);
    //$_SESSION['ind'] = $_SESSION['ind']+1;

    $_SESSION['temp'][$producto->getNombre()]['0']=$producto->getId();
    $_SESSION['temp'][$producto->getNombre()]['1']=$producto->getNombre();
    $_SESSION['temp'][$producto->getNombre()]['2']=$producto->getImagen();
    $_SESSION['temp'][$producto->getNombre()]['3']=$producto->getPrecio();
    $_SESSION['temp'][$producto->getNombre()]['4']=$producto->getDescuento();
    $_SESSION['temp'][$producto->getNombre()]['5']=$producto->getStock();
    $_SESSION['temp'][$producto->getNombre()]['6']=$uds;
    //$_SESSION['indice']=$_SESSION['ind'] +  1;
    $_SESSION['temp'][$producto->getNombre()]['7']=$producto->getNombre();

    $_SESSION['cart']=$_SESSION['temp'];
    //array_push($_SESSION['cart'],$_SESSION['temp']);
}

    // array_push($_SESSION['temp'],$producto->getId());
    // array_push($_SESSION['temp'],$producto->getNombre());
    // array_push($_SESSION['temp'],$producto->getImagen());
    // array_push($_SESSION['temp'],$producto->getPrecio());
    // array_push($_SESSION['temp'],$producto->getDescuento());
    // array_push($_SESSION['temp'],$uds);
    // array_push($_SESSION['temp'],$_SESSION['indice']);

    
    // $_SESSION["cart"]=[
    //     $producto->getId() => $_SESSION['temp']
    // ];

echo "<br>";
//print_r($items);
echo "<br>";
//print_r($_SESSION['cart']);
header("Location: /games/Vistas/carrito.php");

?>

                      

