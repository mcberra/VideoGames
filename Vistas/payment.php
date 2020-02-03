<?php
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once UTILITY_PATH."funciones.php";


//hacer una select que se ejecute con foreach por cada uno de los campos de nombre del array del carrito
//1. primero hacer la select que funcione con uno solo
//2. implementar la idea.form
//SELECT stock FROM 'producto'  WHERE nombre = :nombre
//la funcion debe ejecutarse dentro del foreach
//hay que hacer una funcion buscar tambien



error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();

if (empty($_SESSION['total']) || $_SESSION['RV_seguro']=="no" ) {//seguro de la pagina
    header("Location: /games/IndexCAT.php");
  }
  
  $_SESSION["payment_seguro"]="no";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Pagar"]) {

    $_SESSION["payment_seguro"]="pago";

    $email_usuario=filtrado($_POST["email_usuario"]);
    if (empty($email_usuario)) {
        $email_usuario = "Invitado";
    }
    $id_compra=filtrado($_POST["id_compra"]);
    $numero_tarjeta=filtrado($_POST["numero_tarjeta"]);
    $numero_tarjeta= hash('sha256',$numero_tarjeta);
    $total=filtrado($_POST["total"]);
    $fecha=filtrado($_POST["fecha"]);
    

    /******************************Confirmamos que tenemos stock y si lo tenemos procedemos con la venta */

    function objectToArray1 ( $item ) {

        if(!is_object($item) && !is_array($item)) {
    
        return $item;
    
        }
        
        return array_map( 'objectToArray1', (array) $item );
    
    }
    
    foreach ($_SESSION["cart"] as $key => $value) {
            //echo $value[6];
            $nombre = $value[1];
            $controlador = ControladorAlumno::getControlador();
            $item = $controlador->buscarStock($nombre);

           
        if (!is_array($item )) {
            $temp_stock = objectToArray1 ( $item );
            //echo "es un array";
        }else {
            $temp_stock =   $item;
            //echo "no es un array";
        }

         //print_r($temp_stock);
    
        $compra_stock = [];
        foreach ($temp_stock as $a) {
            $a = array_shift($temp_stock);
        
            array_push($compra_stock,$a);
        }
        //echo "<br>";
        $stock_left = $compra_stock[6] - $value[6];
        //print_r("stock total : " .$compra_stock[6]. ", unidades a comprar: ".$value[6]. ", stock restante: ".$stock_left);
        //echo "<br>";

        $stock = $stock_left;
        if ($stock < 0) {
            alerta("Lo sentimos, no puede realizar esta compra porque no disponemos de stock suficiente.Porfavor acceda nueva ves a la pagina.");
            exit();
        }
        // print_r($stock);
        // echo "<br>";
        // print_r($nombre);
        // echo "<br>";

        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->actualizarStock( $stock,  $nombre );

        //print($estado);
    } 


    $controlador = ControladorAlumno::getControlador();
    $estado = $controlador->almacenarTarjeta( $email_usuario, $id_compra,$numero_tarjeta, $total, $fecha);
    if($estado){

 

        header("location: /games/Vistas/factura.php");
        
    }else{
        header("location: error.php");
        
    }
}
?>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style>
/* body { margin-top:20px; } */
/* .panel-title {display: inline;font-weight: bold;} */
/* .checkbox.pull-right { margin: 0; } */
/* .pl-ziro { padding-left: 0px; } */
#centrar
	{

        margin-left:620;
        padding:5px;
        margin-bottom:50px;
	}
    .form{
      
        background-image:url("/games/admin/producto/img/Cell.jpg");
    
    }
</style>
<?php require_once VIEW_PATH."header.php"; ?>

<div class="" id="centrar">
    <div class="row"  >
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payment Details
                    </h3>

                </div>
                <div class="panel-body">
                    <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> <!-- inicio del formulario -->
                    <div class="form-group">
                        <label for="cardNumber">
                            CARD NUMBER</label>
                        <div class="input-group">
                            <input type="number" class="form-control" minlength="13" required name="numero_tarjeta" id="cardNumber" placeholder="Valid Card Number"
                                required autofocus />
                            
                        </div>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-md-7">
                            <div class="form-group">
                                <label for="expityMonth">
                                    EXPIRY DATE</label>
                                <div class="">
                                    <input type="number" name="expiry_date1" required class="form-control" maxlenght="2" id="expityMonth" placeholder="MM" required />
                                </div>
                                <div class="">
                                    <input type="number" name="expiry_date2" required class="form-control" maxlenght="2" id="expityYear" placeholder="YY" required /></div>
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-5 pull-right">
                            <div class="form-group">
                                <label for="cvCode">
                                    CV CODE</label>
                                <input type="password" name="cv_code" required class="form-control" id="cvCode" placeholder="CV" required />
                            </div>
                        </div>
                    </div>
                    <input type=hidden name="total" value="<?php echo array_sum($_SESSION['total']); ?>">
                    <input type=hidden name="email_usuario" value="<?php echo $_SESSION['USUARIO']['email'][0]; ?>">
                    <input type="hidden" name="id_compra" value="<?php echo $_SESSION["id_compra"]; ?>">
                    <input type="hidden" name="fecha" value="<?php echo date("d-m-Y"); ?>">
                   
                    <a href="/games/Vistas/carrito.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large" style="text-decoration:none">Volver</a>
                    <button class="w3-btn w3-black w3-border w3-border-black w3-round-large">Total: <?php echo array_sum($_SESSION['total']); ?> €</button>
                    <input type="submit" name="Pagar" value="Pagar" class="w3-btn w3-green w3-border w3-border-green w3-round-large" >
                    </form><!-- fin del formulario -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH."footer.php"; ?>




