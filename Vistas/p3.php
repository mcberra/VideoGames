<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
    require_once CONTROLLER_PATH."ControladorAlumno.php";
    require_once CONTROLLER_PATH."ControladorImagen.php";
    require_once UTILITY_PATH."funciones.php";
    require_once CONTROLLER_PATH."ControladorBD.php";
    require_once MODEL_PATH."alumno.php";
    
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);   
    
//debe ser implementado en add.php




//print_r($_SESSION['cart']);

// $num_articulos = [];
// foreach ($_SESSION['cart'] as $key => $value) {
//     echo "unidades: ".$value[6]." nombre: ".$value[1];
//     echo "<br>";
    
//     array_push($num_articulos,$value[6]);
// }

// $displa_num_articulos = array_sum($num_articulos);
// print_r($displa_num_articulos);
// echo "<br>";
// print_r($_SESSION['cart']);
// echo "<br>";
// echo "<br>";



                // $id_compra = $_SESSION["id_compra"];
                // $controlador = ControladorAlumno::getControlador();
                // $compra= $controlador->buscarIdcompra($id_compra);


                    
                   // $temp_dir = objectToArray ( $compra );
                    
                   //$compra_dir = [];
                    // foreach ($temp_dir as $a) {
                    //     $a = array_shift($temp_dir);
                    
                    //     array_push($compra_dir,$a);
                    // }
                    
                    //  print_r($compra);
                    // echo "<br>";
                    // echo "<br>";
                    // echo "<br>";

                    // function objectToArray ( $compra ) {

                    //     if(!is_object($compra) && !is_array($compra)) {
                    
                    //     return $compra;
                    
                    //     }
                        
                    //     return array_map( 'objectToArray', (array) $compra );
                    
                    // }

                    // function objectToArray1 ( $item ) {

                    //     if(!is_object($item) && !is_array($item)) {
                    
                    //     return $item;
                    
                    //     }
                        
                    //     return array_map( 'objectToArray1', (array) $item );
                    
                    // }
                    
                    // foreach ($_SESSION["cart"] as $key => $value) {
                    //         //echo $value[6];
                    //         $nombre = $value[1];
                    //         $controlador = ControladorAlumno::getControlador();
                    //         $item = $controlador->buscarStock($nombre);

                           
                    //     if (!is_array($item )) {
                    //         $temp_stock = objectToArray1 ( $item );
                    //         //echo "es un array";
                    //     }else {
                    //         $temp_stock =   $item;
                    //         //echo "no es un array";
                    //     }

                    //      //print_r($temp_stock);
                    
                    //     $compra_stock = [];
                    //     foreach ($temp_stock as $a) {
                    //         $a = array_shift($temp_stock);
                        
                    //         array_push($compra_stock,$a);
                    //     }
                    //     echo "<br>";
                    //     $stock_left = $compra_stock[6] - $value[6];
                    //     print_r("stock total : " .$compra_stock[6]. ", unidades a comprar: ".$value[6]. ", stock restante: ".$stock_left);
                    //     echo "<br>";

                    //     $stock = $stock_left;
                    //     print_r($stock);
                    //     echo "<br>";
                    //     print_r($nombre);
                    //     echo "<br>";

                    //     $controlador = ControladorAlumno::getControlador();
                    //     $estado = $controlador->actualizarStock( $stock,  $nombre );

                    //     //print($estado);
                    // }   
                    
                    // $nombre = "Halo 4";
                    // $stock = "27";
                    // $bd = ControladorBD::getControlador();
                    // $bd->abrirBD();
                    // $consulta = "UPDATE producto SET   stock=:stock WHERE nombre=:nombre ";
                    // $parametros= array(  ':nombre'=>$nombre, ':stock'=>$stock );
                    // $estado = $bd->actualizarBD($consulta,$parametros);
                    // $bd->cerrarBD();



  print_r($_SESSION['USUARIO']['email'][2])

?>