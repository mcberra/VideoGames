<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Alum1/Paths.php";
require_once MODEL_PATH."alumno.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";

// consultarBDDirecta($consulta)
// $bd = ControladorBD::getControlador();
// $bd->abrirBD();
// $consulta = "SELECT email from 'lol' WHERE admin = 'si'"
// return $estado;
// $bd->cerrarBD();

// $user =  ["manuel","ciprian","berra","antonio"];
// $admins=[];

// foreach ($user as $a) {
    
//     array_push($admins, $a);  
// }

//$admins=[];
//  function buscarAdmins($admins){ 
//     $bd = ControladorBD::getControlador();
//     $bd->abrirBD();
//     $consulta = "SELECT email FROM lol WHERE admin = 'si'";
//     $filas = $bd->consultarBD($consulta);
//     //$res = $bd->consultarBD($consulta);
//     //$filas=$res;
//     //->fetchAll(PDO::FETCH_OBJ);
    

//     if (count($filas) > 0) {
//         foreach ($filas as $a) {
    
//             array_push($admins, $a);  
//         }
//         $bd->cerrarBD();
//         print_r($admins);
//         return $admins;
//     }else{
//         return null;
//     }    
// }
// buscarAdmins($admins);

//funcion de busqueda de correos admin---------------

$admins=[];
$bd = ControladorBD::getControlador();
$bd->abrirBD();
$consulta = "SELECT email FROM usuario WHERE admin = 'si'";
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
print_r($admins);


//seguro de la pagina------------------------------------

$email="mcberra16@hotmail.com";
$_SESSION['USUARIO']['email']=$email;


if (!in_array($_SESSION['USUARIO']['email'],$admins)) {// sino esta el email  en el array, no nos dejara entrar a la pagina
    print_r("no loco, no vas pa dentro buen palomo!");
}else {
    print_r("si taaaaaaaaaaaaaaaaaaa");
}




?>