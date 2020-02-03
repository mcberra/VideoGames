<?php
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once UTILITY_PATH."funciones.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();


// if ($_SESSION["RV_seguro"]=="iniciada") {
//   header("Location: /games/Vistas/resumen_venta.php");
// }

if (empty($_SESSION['total'])) {//seguro de la pagina
  header("Location: /games/IndexCAT.php");
}

if (isset($_GET["email"])) {
    $email_usuario = decode($_GET["email"]);
}

$_SESSION["RV_seguro"]="no";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["save"]) {
    $direccion=filtrado($_POST["direccion"]);
    $direccion2=filtrado($_POST["direccion2"]);
    if (empty($direccion2)) {
        $direccion2="ninguna";
    }
    
    $_SESSION["RV_seguro"]="iniciada";//seguro de la pagina

    $ciudad=filtrado($_POST["ciudad"]);
    $estado=filtrado($_POST["estado"]);
    $codigo_postal=filtrado($_POST["codigo_postal"]);
    $pais=filtrado($_POST["pais"]);
    $email_usuario=filtrado($_POST["email_usuario"]);
    $id_compra=filtrado($_POST["id_compra"]);

    if (empty($email_usuario)) {
        $email_usuario="invitado";
    }



    $controlador = ControladorAlumno::getControlador();
    $estado = $controlador->almacenarDireccion( $email_usuario,$direccion, $direccion2, $ciudad, $estado, $codigo_postal, $pais,$id_compra);
    if($estado){

        header("location: /games/Vistas/resumen_venta.php");
        exit();
    }else{
        header("location: error.php");
        exit();
    }
}
?>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
#centrar
	{
        
        
     
        padding:10px;
        margin-bottom:50px;
	}
    .form{
      
        background-image:url("/games/admin/producto/img/Cell.jpg");
    
    }
</style>
<?php require_once VIEW_PATH."header.php"; ?>
  <div class="row" id="centrar">
    <div class="col-md-4 col-md-offset-4">
      <form class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <fieldset>

          <!-- Form Name -->
          <legend>Address Details</legend>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">Line 1</label>
            <div class="col-sm-10">
              <input type="text" name="direccion" required placeholder="Address Line 1" class="form-control">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">Line 2</label>
            <div class="col-sm-10">
              <input type="text" name="direccion2" placeholder="Address Line 2" class="form-control">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">City</label>
            <div class="col-sm-10">
              <input type="text" name="ciudad" required placeholder="City" class="form-control">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">State</label>
            <div class="col-sm-4">
              <input type="text" name="estado" required placeholder="State" class="form-control">
            </div>

            <label class="col-sm-2 control-label" for="textinput">Postcode</label>
            <div class="col-sm-4">
              <input type="text" name="codigo_postal" required placeholder="Post Code" class="form-control">
            </div>
          </div>



          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">Country</label>
            <div class="col-sm-10">
              <input type="text" name="pais" required placeholder="Country" class="form-control">
            </div>
          </div>

            <!-- Text input-->
            <input type="hidden" name="email_usuario" value="<?php echo $email_usuario; ?>">
            <input type="hidden" name="id_compra" value="<?php echo $_SESSION["id_compra"]; ?>">
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                <a href="/games/Vistas/carrito.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large" style="text-decoration:none">Volver</a>
                <input type="submit" name="save" value="Guardar y continuar" class="w3-btn w3-green w3-border w3-border-green w3-round-large">
              </div>
            </div>
          </div>

        </fieldset>
      </form>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php require_once VIEW_PATH."footer.php"; ?>