<?php
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once UTILITY_PATH."funciones.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();

if (empty($_SESSION['total']) || $_SESSION['RV_seguro']=="no" ) {//seguro de la pagina
    header("Location: /games/IndexCAT.php");
  }

  
  

?>
 <style>
	#centrar
	{
        margin: 0 auto;
        padding:30px;
        border:1px solid grey;
        margin-top:100px;
        margin-bottom:50px;
	}
    .form{
      
        background-image:url("/games/admin/producto/img/Cell.jpg");
    
    }
    .abajo{
        border-bottom:solid 2px lightgrey;
    }
    .border1{
        border:solid 1px lightgrey;
    }
    div#box2 {
  display: inline-block;
}
.botones{
    text-align:center;
}
</style>
<?php require_once VIEW_PATH."header.php"; ?>

<div id=centrar style="width:70%">
        <center><img src="\games\admin\producto\img\GOC.png" alt="titulo"></center>
        <h1>Resumen de compra</h1>
        <h3>PEDIDO Nº : <?php echo $_SESSION["id_compra"];?></h3>
        
        <?php
            
            if (isset($_SESSION['USUARIO']['email'])) {//indica como se esta realizando la compra
                echo "<h4>Ha realizado la compra como : <b>" .$_SESSION['USUARIO']['email'][0]."</b></h4>";
            }else{
                echo "<h4>Ha realizado la compra como invitado.</h4>";
            }
            echo "<h4> Total del pedido: ".array_sum($_SESSION['total'])." €</h4>"; 
            echo "<h4> Fecha: ".date("d-m-Y")." </h4>";
        ?><br><br><br><br><br><br><br><br><br>
            <div class="abajo">
                <h2 style="text-align:center">Entrega</h2>
                <h3 style="text-align:center">ENVÍO A DOMICILIO</h3><br>
                <?php

                $id_compra = $_SESSION["id_compra"];
                $controlador = ControladorAlumno::getControlador();
                $compra= $controlador->buscarIdcompra($id_compra);//buscamos el id de la compra

                    function objectToArray ( $compra ) {

                        if(!is_object($compra) && !is_array($compra)) {
                    
                        return $compra;
                    
                        }
                        
                        return array_map( 'objectToArray', (array) $compra );
                    
                    }
                    //print_r($compra);
                    $temp_dir = objectToArray ( $compra );//convertimos el objeto en un array
                    
                    $compra_dir = [];
                    foreach ($temp_dir as $a) {//obtengo un array de indices numericos
                        $a = array_shift($temp_dir);
                    
                        array_push($compra_dir,$a);
                    }

                    echo "<h4 style='text-align:center'>" .$compra_dir[1]."</h4>";
                    echo "<h4 style='text-align:center'>" .$compra_dir[5] ." ". $compra_dir[3]." ". $compra_dir[4] ." ". $compra_dir[6].  "</h4>";

                ?><br><br>
            </div><br><br>
            <div >
                    <h2 style="text-align:center">Productos elegidos</h2><br><br><br>
            <?php
                foreach ($_SESSION['cart'] as  $productos) {//recorremos el array
                    echo "<div class=' w3-margin' style='width:46% ' id='box2'>";
                    echo "<center><img src='/games/admin/producto/imagenes/".$productos[2] ."' style='width:25%'> <img></center>";
                    echo "<br>";
                    echo "<p style='text-align:center'>Nombre del producto: ".$productos[1]."</p>";
                    echo "<br>";
                    //echo "<p style='text-align:center'>Precio: ".$productos[3]." €</p>";
                    $descuento=$productos[4];  //calculamos el descuento si lo hay
                    if ($descuento > 0) {
                        $price=($productos[3])-($productos[3]*$productos[4]/100);
                        echo "<p style='text-align:center'> Precio por unidad:  <del> ".$productos[3]."€  </del> <i style='color:red'>".$price." €</i> </p>";   
                    }else{
                        echo "<p style='text-align:center'> Precio por unidad:  ".$productos[3]." €   </p>"; 
                    }
                    echo "<br>";
                    echo "<p style='text-align:center'>Unidades: ".$productos[6]."</p>";
                    echo "<br>";
                    //echo "<br>";
                    echo "</div>";
            }
            //echo "</div>"
            ?>
            </div>
</div>
<p class="botones">
    <a href="/games/Vistas/carrito.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large" style="text-decoration:none">Volver</a>
    <button class="w3-btn w3-black w3-border w3-border-black w3-round-large">Total: <?php echo array_sum($_SESSION['total']); ?> €</button>
    <a href="/games/Vistas/payment.php" class="w3-btn w3-green w3-border w3-border-green w3-round-large" style="text-decoration:none">Realizar pago</a>
</p>
<?php require_once VIEW_PATH."footer.php"; ?>