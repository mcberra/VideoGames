<?php
//en esta pagina realizamos la factura que podemos visualizar antes de imprimirla en pdf
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once UTILITY_PATH."funciones.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();

if (empty($_SESSION['total']) || $_SESSION['RV_seguro']=="no" || $_SESSION['payment_seguro']=="no" ) {//seguro de la pagina
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
<div id=centrar style="width:20%">
    <center><img src="\games\admin\producto\img\GOC.png" alt="titulo" width="200px"></center>
    <p style="text-align:center">Gracias por su compra!</p><br><br><br>
    <h6>PEDIDO Nº : <?php echo $_SESSION["id_compra"];?></h6>
    <h6>  <?php echo date("d-m-Y")?> </h6><br><br><br><br>

    <div>
        <?php
            foreach ($_SESSION['cart'] as  $productos) {//recorremos el array para pintar los valores deseado y damos formato a los mismos

                echo "<div class='abajo'>";
                echo "<p> ".$productos[1]."</p>";
                $descuento=$productos[4];  
                if ($descuento > 0) {
                    $price=($productos[3])-($productos[3]*$productos[4]/100);
                    echo "<p style='float:right'> uds x <del> ".$productos[3]."€  </del> <i style='color:red'>".$price." €</i> </p>";   
                }else{
                    echo "<p style='float:right'>uds x    ".$productos[3]." €   </p>"; 
                }
                echo "<p>Unidades: ".$productos[6]."</p>";
                echo "</div>";
                echo "<br>";
            }
        ?>

    </div>

    <h6 style="float:right"> Total: <?php echo array_sum($_SESSION['total']); ?>€</h6>
    <br><br><br><br><br>
    <p style="font-size:75%">
        Para obtener más información, consulta la Política de cambios y reembolsos y el derecho a cancelar tu suscripción en nuestro apartado de Condiciones de compra .
    </p><br><br>

    <p style="font-size:75%">
        Este ticket es imprescindible para cualquier cambio o devolución. Puedes presentarlo en tu dispositivo móvil o imprimirlo.
    </p>
    
    </div>
    <p style="text-align:center">
    <a href="/games/utilidades/descargar.php?opcion=PDF" class="w3-btn w3-black" target="_blank" style="text-decoration:none"><span class="glyphicon glyphicon-print"></span> PDF</a>
    <a href="/games/Vistas/finalizar.php" class="w3-btn w3-green w3-border w3-border-green w3-round-large" style="text-decoration:none">Finalizar</a>
    </p>



<?php require_once VIEW_PATH."footer.php"; ?>