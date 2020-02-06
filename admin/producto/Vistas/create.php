
<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
    require_once CONTROLLER_PATH."ControladorAlumno.php";
    require_once CONTROLLER_PATH."ControladorImagen.php";
    require_once UTILITY_PATH."funciones.php";
    require_once CONTROLLER_PATH."ControladorBD.php";
    require_once MODEL_PATH."alumno.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();
if (!isset($_SESSION['USUARIO']['email'])) {
  header("location: /games/admin/producto/Vistas/Login.php");
}
if (isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='no'){
  header("location: /games/admin/producto/Vistas/Login.php");
}   


     $nombre =$tipo = $distribuidor = $precio = $descuento = $stock  = $imagen ="";

    if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

        
        $nombre=filtrado($_POST["nombre"]);
        $tipo=filtrado($_POST["tipo"]);
        $distribuidor=filtrado($_POST["distribuidor"]);
        $precio=filtrado($_POST["precio"]);
        $descuento=filtrado($_POST["descuento"]);
        $stock=filtrado($_POST["stock"]);
      
        



/*----------------------------------------------COMPROBACION NOMBRE-----------------------------------------------------------------*/

            $nombreerr = 0;
            if(empty($nombre)){
                alerta("El nombre que introdujo esta en blanco.");
                $nombreerr = $nombreerr+1; 
            } 

            $controlador = ControladorAlumno::getControlador();
            $item = $controlador->buscarDuplicado($nombre);
            if(isset($item)){
               alerta("El nombre del item que introdujo ya existe.");
               $nombreerr = $nombreerr+1;
            }



/*----------------------------------------------COMPROBACION IMAGEN-----------------------------------------------------------------*/

      // Procesamos la foto
      $propiedades = explode("/", $_FILES['imagen']['type']);
      $extension = $propiedades[1];
      $tam_max = 5000000; // 50 KBytes
      $tam = $_FILES['imagen']['size'];
      $imagenerr = 0;
      //print_r ($propiedades);
      //print_r ($tam);
      // Si no coicide la extensión
      if($extension != "jpg" && $extension != "jpeg"){
          alerta("Formato debe ser jpg/jpeg");
          $imagenerr = $imagenerr+1;
      }
      // si no tiene el tamaño
      if($tam>$tam_max){
          alerta("Tamaño superior al limite de: ". ($tam_max/1000). " KBytes");
          $imagenerr = $imagenerr+1;
          
      }
  
      // Si todo es correcto, mod = true
      if($imagenerr == 0){
          // salvamos la imagen
          $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'].time()) . "." . $extension;
          $controlador = ControladorImagen::getControlador();
          if(!$controlador->salvarImagen($imagen)){
              alerta( "Error al procesar la imagen y subirla al servidor");
              $imagenerr = $imagenerr+1;
              echo "salvar imagen entro";
          }
      }
                    
/*-----------------------------------------------------------------------------------------------------------------------------*/           

            
      
        if (   $nombreerr == 0 && $mod = true && $imagenerr == 0) {
        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->almacenarAlumno( $nombre, $tipo, $distribuidor, $precio, $descuento, $stock,  $imagen);
        if($estado){
            //El registro se ha lamacenado corectamente
            //alerta("Alumno/a creado con éxito");
            header("location: /games/admin/producto/gestion.php");
            exit();
        }else{
            header("location: error.php");
            exit();
        }
    }

}else{
    $tipo="otro";
    
}

        
//pattern="([^\s][A-zÀ-ž\s]+)"
        
 

  

?>
<?php require_once VIEW_PATH."header.php"; ?>
<style>
	#centrar
	{
        margin: 0 auto;
        padding:50px;
	}
</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-card-4" style='width:35%;margin-top:25px' id="centrar"  >
<h1 style="text-align:center"><b>Añade un producto</b></h1>
        <br><br>
            <!-- Formulario-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <!-- Nombre-->
                    <label><b>Nombre</b></label><br>
                            <input type="text" required name="nombre"  class="w3-input" value="<?php echo $nombre; ?>" 
                                title="El nombre no puede contener números"
                                minlength="1"><br>
                    <label><b>Tipo</b></label><br>
                        <input type="radio" name="tipo" class="w3-radio" value="ordenador" <?php echo (strstr($tipo, 'ordenador')) ? 'checked' : ''; ?>>ordenador</input>
                        <input type="radio" name="tipo" class="w3-radio" value="consola" <?php echo (strstr($tipo, 'consola')) ? 'checked' : ''; ?>>consola</input>
                        <input type="radio" name="tipo" class="w3-radio" value="ei" <?php echo (strstr($tipo, 'ei')) ? 'checked' : ''; ?>>Consola portatil</input>
                        <input type="radio" name="tipo" class="w3-radio" value="otro" <?php echo (strstr($tipo, 'otro')) ? 'checked' : ''; ?>>otro</input><br><br>
                    <!-- Distribuidor -->
                    <label><b>Distribuidor</b></label><br>
                            <input type="text" required name="distribuidor"  class="w3-input" value="<?php echo $distribuidor; ?>"><br>

                        <!-- Precio -->
                        <label><b>Precio</b></label><br>
                            <input type="number" step="0.01" name="precio" required class="w3-input" value="<?php echo $precio; ?>"><br>

                        <!-- Descuento -->
                    <label><b>Descuento</b></label><br>
                        <input type="number"  name="descuento" required class="w3-input" value="<?php echo $descuento; ?>"><br>
                        <!-- Stock-->
                    <label><b>Stock</b></label><br>
                    <input type="number"  name="stock" required class="w3-input" value="<?php echo $stock; ?>"><br>
                         <!-- Foto-->
                    <label><b>Fotografía</b></label><br>
                        <!-- Solo acepto imagenes jpg -->
                            <input type="file" required name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"><br><br><br>   
                        <!-- Botones --> 
                        <p style="text-align:center"> 
                            <input type="submit" name="Enviar" value="Enviar" class="w3-btn w3-green w3-border  w3-round-large"> 
                            <input type="reset" name="Limpiar" value="Limpiar" class="w3-btn w3-red w3-border  w3-round-large" >
                            <a href="/games/admin/producto/gestion.php" class="w3-btn w3-blue w3-border  w3-round-large" style="text-decoration:none"></span> Volver</a>
                        </p>
                

        </form>
</div>
<?php require_once VIEW_PATH."footer.php"; ?>
