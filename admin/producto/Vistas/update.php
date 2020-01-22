<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$admins=[];
$bd = ControladorBD::getControlador();
$bd->abrirBD();
$consulta = "SELECT email,password FROM usuario WHERE admin = 'si'";
$filas = $bd->consultarBD($consulta);

    foreach ($filas as $a) {
        $mail = array_shift($a);// se queda con el primer elemento del array OJO sin su clave solo el elemento
        //array_pop($a); //saca un elemento de un array
        array_push($admins, $mail);  //introducimos los emails a un array 
    }

$bd->cerrarBD();



 session_start();
        if(!isset($_SESSION['USUARIO']['email'])){
            //echo "entro a lista admin";
            header("location: /games/admin/producto/Vistas/Login.php");
      exit();
        }    

       if(isset($_SESSION['USUARIO']['email']) && !in_array($_SESSION['USUARIO']['email'],$admins)){
              //echo "entro a lista admin";
              header("location: /games/admin/producto/Vistas/error_idi.php");
                exit();
       }   

/***************************************seguro******************************************************************** */

$nombre =$tipo = $distribuidor = $precio = $descuento = $stock  = $imagen ="";
$imagenAnterior = "";
 
// Procesamos la información obtenida por el get
    if(isset($_POST["id"]) && !empty($_POST["id"])){
            $id = $_POST["id"];
            
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

            // $formatonombre=preg_match('/([^\s][A-zÀ-ž\s]+$)/', $nombre);
            // if ($formatonombre==0) {
            //     $nombreerr = $nombreerr+1; 
            //     alerta("El nombre que introdujo no cumple con el formato requerido.");
                
            // }


  
/*----------------------------------------------COMPROBACION IMAGEN-----------------------------------------------------------------*/
if($_FILES['imagen']['size']>0 && count($errores)==0){
    $propiedades = explode("/", $_FILES['imagen']['type']);
    $extension = $propiedades[1];
    $tam_max = 5000000; // 50 KBytes
    $tam = $_FILES['imagen']['size'];
    $mod = true;
    // Si no coicide la extensión
    if($extension != "jpg" && $extension != "jpeg"){
        $mod = false;
        $imagenErr= "Formato debe ser jpg/jpeg";
    }
    // si no tiene el tamaño
    if($tam>$tam_max){
        $mod = false;
        $imagenErr= "Tamaño superior al limite de: ". ($tam_max/1000). " KBytes";
    }

    // Si todo es correcto, mod = true
    if($mod){
        // salvamos la imagen
        $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'].time()) . "." . $extension;
        $controlador = ControladorImagen::getControlador();
        if(!$controlador->salvarImagen($imagen)){
            $imagenErr= "Error al procesar la imagen y subirla al servidor";
        }

        // Borramos la antigua
        $imagenAnterior = trim($_POST["imagenAnterior"]);
        if($imagenAnterior!=$imagen){
            if(!$controlador->eliminarImagen($imagenAnterior)){
                $imagenErr= "Error al borrar la antigua imagen en el servidor";
            }
        }
    }else{
    // Si no la hemos modificado
        $imagen=trim($_POST["imagenAnterior"]);
    }

}else{
    $imagen=trim($_POST["imagenAnterior"]);
}
                    
/*-----------------------------------------------------------------------------------------------------------------------------*/
if (   $nombreerr == 0 && $mod = true  ) {        
        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->actualizarAlumno($id, $nombre, $tipo, $distribuidor, $precio, $descuento, $stock,  $imagen);
        if($estado){
            header("location: /games/admin/producto/gestion.php");
            exit();
        }else{
            header("location: /games/admin/producto/Vistas/error.php");
        exit();
        }
                        
        }
}//se cierra aqui
                        
// Comprobamos que existe el id antes de ir más lejos
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id =  decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $producto = $controlador->buscarAlumno($id);
            if (!is_null($producto)) {
                $nombre = $producto->getNombre();
                $tipo = $producto->getTipo();
                $distribuidor = $producto->getDistribuidor();
                $precio = $producto->getPrecio();
                $descuento = $producto->getDescuento();
                $stock = $producto->getStock();
                $imagen = $producto->getImagen();
                $imagenAnterior = $imagen;
        }else{
            header("location: /games/admin/producto/Vistas/error.php");
            exit();
        }
    }else{
                            
        header("location:/games/admin/producto/Vistas/error.php");
        exit();
    }


?>
 

<?php require_once VIEW_PATH."header.php"; ?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-top">
                                <!-- DNI-->
                                
                            <!-- Nombre-->
                            <label><b>Nombre</b></label><br>
                            <input type="text" name="nombre" class="w3-input" value="<?php echo $nombre; ?>"><br><br>


                                    
                               
                            </td>
                            <!-- Fotogrsfía -->
                            <td class="align-left">
                                <label><b>Fotografía</b></label><br>
                                <img src='<?php echo "../imagenes/" . $producto->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                            </td>
                        </tr>
                    </table>

                        
                             <!-- tipo-->
                             <label><b>Tipo</b></label><br>
                        <input type="radio" name="tipo" class="w3-radio" value="ordenador" <?php echo (strstr($tipo, 'ordenador')) ? 'checked' : ''; ?>>ordenador</input>
                        <input type="radio" name="tipo" class="w3-radio" value="consola" <?php echo (strstr($tipo, 'consola')) ? 'checked' : ''; ?>>consola</input>
                        <input type="radio" name="tipo" class="w3-radio" value="ei" <?php echo (strstr($tipo, 'ei')) ? 'checked' : ''; ?>>ei</input>
                        <input type="radio" name="tipo" class="w3-radio" value="otro" <?php echo (strstr($tipo, 'otro')) ? 'checked' : ''; ?>>otro</input><br><br>                       
                        <!-- Email -->
              
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
                            <input type="file"  name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"><br>   
                     
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                        <button type="submit" value="Enviar" class="w3-btn w3-green"> </span>  Modificar</button>
                        <a href="/games/admin/producto/gestion.php" class="w3-btn w3-blue"></span> Volver</a>
                    </form>
     <br>

<?php require_once VIEW_PATH."footer.php"; ?>