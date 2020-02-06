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

if (empty($_SESSION['total']) || $_SESSION['RV_seguro']=="no" ) {//seguro de la pagina, solo si hay un total o la variable seguro esta inciada se puede acceder a esta pagina.
    header("Location: /games/IndexCAT.php");
  }
  
  $_SESSION["payment_seguro"]="no";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Pagar"]) {

    $_SESSION["payment_seguro"]="pago";//variable inicializada para el seguro, si esta variable no esta iniciada no se puede acceder a la pagina de facturacion.

    $email_usuario=filtrado($_POST["email_usuario"]);
    if (empty($email_usuario)) {
        $email_usuario = "Invitado";
    }

    $id_compra=filtrado($_POST["id_compra"]);
    $id_compraerr = 0;
    if (empty($id_compra)) {
      $id_compraerr = $id_compraerr = + 1;
  }

    $numero_tarjeta=filtrado($_POST["numero_tarjeta"]);
    $numero_tarjeta= hash('sha256',$numero_tarjeta);
    $numero_tarjetaerr = 0;
    if (empty($numero_tarjeta)) {
      $numero_tarjetaerr = $numero_tarjetaerr = + 1;
  }

    $total=filtrado($_POST["total"]);
    $totalerr = 0;
    if (empty($total)) {
      $totalerr = $totalerr = + 1;
  }

    $fecha=filtrado($_POST["fecha"]);
    $fechaerr = 0;
    if (empty($fecha)) {
      $fechaerr = $fechaerr = + 1;
  }
    

    /******************************Confirmamos que tenemos stock y si lo tenemos procedemos con la venta */

    function objectToArray1 ( $item ) {//funcion para convertir el objeto que nos de vuelve la BBDD en array

        if(!is_object($item) && !is_array($item)) {
    
        return $item;
    
        }
        
        return array_map( 'objectToArray1', (array) $item );
    
    }
    
    
    foreach ($_SESSION["cart"] as $key => $value) {//recorremos el array carrito para usar sus valores
            //echo $value[6];
            $nombre = $value[1];
            $controlador = ControladorAlumno::getControlador();
            $item = $controlador->buscarStock($nombre);//usamos esta funcion para buscar en la BBDD el producto y sus datos

           
        if (!is_array($item )) { //este if es necesario para que no intente convertir un objeto en un array en cada vuelta del bucle,despues de la primera iteracion ya es un array.
            $temp_stock = objectToArray1 ( $item );
            //echo "es un array";
        }else {
            $temp_stock =   $item;
            //echo "no es un array";
        }

         //print_r($temp_stock);

        $compra_stock = [];
        foreach ($temp_stock as $a) {//aunque el array ya no es un objeto, es un array asociativo con nombres extensos, con esto lo convierto en un array de indice numerico.
            $a = array_shift($temp_stock);
        
            array_push($compra_stock,$a);
        }

        
        $stock_left = $compra_stock[6] - $value[6];//obtenemos el stock restante 

        $stock_actualizado = $stock_left;//si el stock restante es menor que 0, la compra no se puede realizar.
        if ($stock < 0) {
            alerta("Lo sentimos, no puede realizar esta compra porque no disponemos de stock suficiente.Porfavor acceda nueva ves a la pagina.");
            exit();
        }


        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->actualizarStock( $stock_actualizado,  $nombre ); //finalmente actualizamos el stock en la BBDD

 //todo este proceso va dentro de un foreah para que lo realize por cada uno de los productos dentro del array carrito       
    } 

    if ($id_compraerr == 0 && $numero_tarjetaerr == 0 && $totalerr == 0 && $fechaerr == 0 ) {//comprobamos errores
        

        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->almacenarTarjeta( $email_usuario, $id_compra,$numero_tarjeta, $total, $fecha);
        if($estado){

            header("location: /games/Vistas/factura.php");
            
        }else{
            header("location: error.php");
            
        }
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




