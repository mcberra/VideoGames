
<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
    require_once CONTROLLER_PATH."ControladorImagen.php";
    require_once CONTROLLER_PATH."ControladorBD.php";
    require_once MODEL_PATH."producto.php";

    // if (!isset($_SESSION['cart'])) {
    //     alerta("debe iniciar sesion para acceder al carrito.");
    // }
?>
<?php require_once VIEW_PATH."header.php"; ?>
<div style="margin-left:5%">

<center><img src="\games\admin\producto\img\GOC.png" alt="titulo"></center>
<h1 style="text-align:center" class='w3-btn w3-white w3-border w3-border-grey w3-round-large'>Productos añadidos al carrito</h1>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
    <input type="text" id="buscar" name="producto" placeholder="Busque aqui por nombre..." class="w3-input">
                    
    <button type="submit"class="w3-btn w3-black" >  <i class="fa fa-search "></i></button>
</form> -->
 <style>

div.all{
    min-height:450px;
}

#lipag{
        display:inline-block;
        list-style-type:none;
        width:30px;
        border: 2px solid grey;
        background-color:black;
        color:white;
    }
h1{
       text-align:center;
       font-size:bolder;
   }
div#box2 {
  display: inline-block;
}
div.mid{
  padding:-left:300px;  
}
    
</style> 
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH . "Paginador.php";

if (!isset($_POST["producto"])) {
    $nombre = "";  
} else {
    $nombre = filtrado($_POST["producto"]);    
}
   
$controlador = ControladorAlumno::getControlador();

// Parte del paginador
$pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;

$consulta = "SELECT * FROM producto WHERE nombre LIKE :nombre ";
$parametros = array(':nombre' => "%".$nombre."%");
$limite = 4; // Limite del paginador
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);

echo "<div class='all'>";
    echo "<div class='w3-margin-bottom'>";
    $_SESSION['total']=[];
    if (!empty($_SESSION['cart'])) {
    
            foreach($_SESSION['cart'] as $producto => $detalles)
                {
                        echo "<div class='w3-card-4 w3-margin' style='width:22% ' id='box2'>";
                        echo '<div class="w3-display-container w3-text-black">';
                            echo "<img src='/games/admin/producto/imagenes/".$detalles[2] ."' style='width:100%' class='w3-button'> <img>";
                            echo  "<p style='text-align:center'><a href='/games/Vistas/actualizar_carrito.php?resta=".encode($detalles[7])."' class='btn btn-info btn-lg'><span class='glyphicon glyphicon-minus-sign'></span> </a><button class='w3-btn w3-white w3-border w3-border-grey w3-round-large'>Unidades [ " .$detalles[6] ." ]</button><a href='/games/Vistas/actualizar_carrito.php?suma=".encode($detalles[7])."' class='btn btn-info btn-lg'><span class='glyphicon glyphicon-plus-sign'></span> </a></p><br>";
                            $descuento=$detalles[4];  
                            if ($descuento > 0) {
                                $price=($detalles[3])-($detalles[3]*$detalles[4]/100);
                                echo "<p style='text-align:center'><del> € ".$detalles[3]." </del> <i style='color:red'>€".$price."</i> </p>"; 
                                $sums = 0;
                                $sums = $detalles[6] * $price;
                                $_SESSION['tempo']=$sums;
                                array_push($_SESSION['total'],$_SESSION['tempo']);   
                            }else{
                                echo "<p style='text-align:center'> € ".$detalles[3]."   </p>";
                                $sums = 0;
                                $sums = $detalles[6] * $detalles[3];
                                $_SESSION['tempo']=$sums;
                                array_push($_SESSION['total'],$_SESSION['tempo']); 
                            }

                        echo "</div>";
                        echo '<div class="w3-row">';
                            echo '<div class="w3-third w3-center">';
                            echo  "<p style='text-align:center'><button class='w3-btn w3-white w3-border w3-border-grey w3-round-large'>" .$detalles[1] ."</button></p><br>";
                            echo "</div>";
                            echo '<div class="w3-third w3-center">';
                            echo "<p><a href='#' title='Mas informacion' data-toggle='tooltip'class='w3-btn w3-white w3-border w3-border-green w3-round-large'>Stock: ".$detalles[5]."</a></p>";
                            echo "</div>";
                            echo '<div class="w3-third w3-center w3-margin-bottom">';                            
                            echo "<p><a href='/games/Vistas/delete_item.php?id=".encode($detalles[7])."' title='Mas informacion' data-toggle='tooltip'class='w3-btn w3-white w3-border w3-border-green w3-round-large'> Borrar</a></p>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>"; 
            }
    }else {
        echo "<span class='w3-tag w3-xlarge w3-padding w3-red' style='transform:rotate(-5deg)'>No hay ningun articulo en el carrito</span>";
    }
        echo "</div>";
echo "</div>";
 if (isset($_SESSION['USUARIO']['email'])) {
     if (isset($_SESSION['cart'])) {
        echo '<p style="text-align:center"><button class="w3-btn  w3-xxxlarge w3-black w3-round-large w3-text-white " >Total : '.array_sum($_SESSION['total']).' €</button> <button class=" w3-btn  w3-xxxlarge w3-black w3-round-large w3-text-grey w3-hover-text-white"> Comprar </button></p>';
     }
    
 }else{
     if (isset($_SESSION['cart'])) {
        echo '<p style="text-align:center"><button class="w3-btn  w3-xxxlarge w3-black w3-round-large w3-text-white " >Total : '.array_sum($_SESSION['total']).' €</button> <button class=" w3-btn  w3-xxxlarge w3-black w3-round-large w3-text-grey w3-hover-text-white"> Comprar como invitado</button></p>';
     }

 }
                
?>

    </div>
    </div>
    <?php require_once VIEW_PATH."footer.php"; ?>