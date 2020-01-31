<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();
if (!isset($_SESSION['USUARIO']['email'])) {
  header("location: /games/admin/usuario/Vistas/Login.php");
}
// if (isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='no'){
//   header("location: /games/admin/usuario/Vistas/Login.php");
// }  

/***************************************seguro******************************************************************** */

$nombre =$apellido = $email = $password = $admin = $telefono  = $fecha = $imagen ="";
$imagenAnterior = "";

// Procesamos la información obtenida por el get
    if(isset($_POST["id"]) && !empty($_POST["id"])){
            $id = $_POST["id"];
            
            $nombre=filtrado($_POST["nombre"]);
            $apellido=filtrado($_POST["apellido"]);
            $email=filtrado($_POST["email"]);
            $admin=filtrado($_POST["admin"]);
            $telefono=filtrado($_POST["telefono"]);
        


/*----------------------------------------------COMPROBACION NOMBRE-----------------------------------------------------------------*/

            $nombreerr = 0;
            if(empty($nombre)){
                alerta("El nombre que introdujo esta en blanco.");
                $nombreerr = $nombreerr+1; 
            } 

            $formatonombre=preg_match('/([^\s][A-zÀ-ž\s]+$)/', $nombre);
            if ($formatonombre==0) {
                $nombreerr = $nombreerr+1; 
                alerta("El nombre que introdujo no cumple con el formato requerido.");
                
            }
/*----------------------------------------------COMPROBACION EMAIL-----------------------------------------------------------------*/

$emailerr = 0;
if(empty($email)){
    alerta("El email que introdujo esta en blanco.");
    $emailerr = $emailerr+1; 
} 

/*----------------------------------------------COMPROBACION PASSWORD-----------------------------------------------------------------*/
$passwordErr = 0;
$password = filtrado($_POST["password"]);
if(empty($password) || strlen($password)<5){
    $passwordErr = $passwordErr+1;
    alerta("Por favor introduzca password válido y que sea mayor que 5 caracteres.");
} else{
    $password= hash('md5',$password);
}

                       
/*----------------------------------------------COMPROBACION FECHA-----------------------------------------------------------------*/


$fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
$hoy =date("d-m-Y",time());
$fechaerr = 0;
$fecha_mat = new Datetime($fecha);
$fecha_hoy = new Datetime($hoy);
$intervalo = $fecha_hoy->diff($fecha_mat);
if($intervalo->format('%R%a dias')>0){
    $fechaerr = $fechaerr+1;
    alerta("La fecha no puede ser superior a la fecha actual");
}


  
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
if (   $nombreerr == 0 && $mod = true && $emailerr == 0 && $passwordErr == 0  && $fechaerr == 0 ) {        
        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->actualizarAlumno1($id, $nombre, $apellido, $email, $password, $admin, $telefono, $fecha, $imagen);
        if($estado){
            header("location: /games/indexCAT.php");
            exit();
        }else{
            //header("location: /games/Vistas/error.php");
            alerta( "Error no act");
        exit();
        }
                        
        }
}//se cierra aqui
                     
// Comprobamos que existe el id antes de ir más lejos
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id =  decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $usuario = $controlador->buscarAlumno1($id);
            if (!is_null($usuario)) {
                $nombre = $usuario->getNombre();
                $apellido = $usuario->getApellido();
                $email = $usuario->getEmail();
                $password = $usuario->getPassword();
                $admin = $usuario->getAdmin();
                $telefono = $usuario->getTelefono();
                $fecha = $usuario->getFecha();
                $imagen = $usuario->getImagen();
                $imagenAnterior = $imagen;
        }else{
            //header("location: /games/Vistas/error.php");
            alerta( "Error get 1");
            exit();
        }
    }else{
        alerta( "Error get 2");                   
        //header("location:/games/Vistas/error.php");
        exit();
    }


?>
 <style>
	#centrar
	{
        margin: 0 auto;
        padding:30px;
        
	}
    .form{
      
        background-image:url("/games/admin/producto/img/Cell.jpg");
    
    }
</style>

<?php require_once VIEW_PATH."header.php"; ?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div  class="form">
    <div class="w3-card-4" style='width:32%;background-color:white' id="centrar">
    <h1 style="text-align:center" class='w3-btn w3-white w3-border w3-border-grey w3-round-large'><b>Configuracion de perfil</b></h1><br><br>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td class="col-xs-11" class="align-top">
                        <!-- DNI-->
                        
                    <!-- Nombre-->
                    <label><b>Nombre</b></label><br>
                    <input type="text" name="nombre" class="w3-input" value="<?php echo $nombre; ?>"><br><br>

                    <!-- APELLIDO-->
                    <label><b>Apellido</b></label><br>
                    <input type="text" name="apellido" class="w3-input" value="<?php echo $apellido; ?>"><br><br>
                            
                    
                    </td>
                    <!-- Fotogrsfía -->
                    <td class="align-left">
                        <label><b>Fotografía</b></label><br>
                        <img src='<?php echo "/games/admin/usuario/imagenes/" . $usuario->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                    </td>
                </tr>
            </table>

                

                <!-- Email -->
    
                    <label><b>E-Mail</b></label><br>
                    <input type="email" required name="email" class="w3-input" value="<?php echo $email; ?>"><br>
                    

                    <label><b>Password</b></label><br>
                    <input type="password" required name="password"  class="w3-input" value="<?php echo ($password); ?>"
                        readonly><br>
                
            
            
                        <label><b>Administrador</b></label><br>
                    <input type="radio" name="admin" class="w3-radio" value="si" <?php echo (strstr($admin, 'si')) ? 'checked' : ''; ?>>si</input>
                    <input type="radio" name="admin" class="w3-radio" value="no" <?php echo (strstr($admin, 'no')) ? 'checked' : ''; ?>>no</input><br>
                    
            
                <!-- Matrícula -->
                
                <label><b>Telefono</b></label><br>
                    <input type="tel" required name="telefono"  class="w3-input" value="<?php echo $telefono; ?>"><br>
                
        
                <!-- Fecha-->
    
                <label><b>Fecha de Matriculación</b></label><br>
                    <input type="date" disabled name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>"></input><br><br>
                
            
                <!-- Foto-->
                
                <label><b>Fotografía</b></label><br>
                <!-- Solo acepto imagenes jpg -->
                <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"> <br>
                
            
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                <button type="submit" value="Enviar" class="w3-btn w3-white w3-border w3-border-green w3-round-large"> </span>  Modificar</button>
                <a href="/games/indexCAT.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large"></span> Volver</a>
         </form><br>
     </div>
</div>
<?php require_once VIEW_PATH."footer.php"; ?>