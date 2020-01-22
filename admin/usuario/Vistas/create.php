
<?php

require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/usuario/Paths.php";
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
        header("location: /games/admin/usuario/Vistas/Login.php");
  exit();
    }    

   if(isset($_SESSION['USUARIO']['email']) && !in_array($_SESSION['USUARIO']['email'],$admins)){
          //echo "entro a lista admin";
          header("location: /games/admin/usuario/Vistas/error_idi.php");
            exit();
   }     
    

     $nombre =$apellido = $email = $password = $admin = $telefono  = $fecha = $imagen ="";

    if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

        
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

    /*----------------------------------------------COMPROBACION APELLIDO-----------------------------------------------------------------*/

    $apellidoerr = 0;
    if(empty($apellido)){
        alerta("El apellido que introdujo esta en blanco.");
        $apellidoerr = $apellidoerr+1; 
    } 

    $formatoapellido=preg_match('/([^\s][A-zÀ-ž\s]+$)/', $apellido);
    if ($formatoapellido==0) {
        $apellidoerr = $apellidoerr+1; 
        alerta("El apellido que introdujo no cumple con el formato requerido.");
        
    }
/*----------------------------------------------COMPROBACION EMAIL-----------------------------------------------------------------*/

$emailerr = 0;
if(empty($email)){
    alerta("El nombre que introdujo esta en blanco.");
    $emailerr = $emailerr+1; 
} 

$controlador = ControladorAlumno::getControlador();
$item = $controlador->buscarDuplicado($email);
if(isset($item)){
   alerta("El e-mail que introdujo ya existe.");
   $emailerr = $emailerr+1;
}

/*----------------------------------------------COMPROBACION PASSWORD-----------------------------------------------------------------*/
$passwordErr = 0;
$password = filtrado($_POST["password"]);
if(empty($password) || strlen($password)<5){
    $passwordErr = $passwordErr+1;
    alerta("Por favor introduzca password válido y que sea mayor que 5 caracteres.");
} else{
    $password= hash('sha256',$password);
}


/*----------------------------------------------COMPROBACION Telefono-----------------------------------------------------------------*/

$telefonoerr = 0;
if(empty($telefono)){
    alerta("El nombre que introdujo esta en blanco.");
    $telefonoerr = $telefonoerr+1; 
} 

$controlador = ControladorAlumno::getControlador();
$item = $controlador->buscarDuplicadoTel($telefono);
if(isset($item)){
   alerta("El telefono que introdujo ya existe.");
   $telefonoerr = $telefonoerr+1;
}

$formatotelefono=preg_match('/([0-9]{3}-[0-9]{3}-[0-9])/', $telefono);
if ($formatotelefono==0) {
    $telefonoerr = $telefonoerr+1; 
    alerta("El telefono que introdujo no cumple con el formato requerido.");
    
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

      // Procesamos la foto
      $propiedades = explode("/", $_FILES['imagen']['type']);
      $extension = $propiedades[1];
      $tam_max = 500000; // 50 KBytes
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

            
      
        if (   $nombreerr == 0 && $mod = true && $emailerr == 0 && $passwordErr == 0  && $fechaerr == 0
        && $imagenerr == 0 && $telefonoerr == 0 && $apellidoerr == 0) {
        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->almacenarAlumno( $nombre, $apellido, $email, $password, $admin, $telefono, $fecha, $imagen);
        if($estado){
            $controladorS = ControladorAlumno::getControlador();
            $estadoS = $controlador->almacenarSesion( $email, $password, $admin);
            //El registro se ha lamacenado corectamente
            //alerta("Alumno/a creado con éxito");
            header("location: /games/admin/usuario/gestion.php");
            exit();
        }else{
            header("location: error.php");
            exit();
        }
    }

}else{
    $admin="no";
    $fecha = date("Y-m-d");
}

        
//pattern="([^\s][A-zÀ-ž\s]+)"
        
 

  

?>
<?php require_once VIEW_PATH."header.php"; ?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<h1><b>Crear Usuario</b></h1>
        <p><b>Por favor rellene este formulario para añadir un nuevo usuario a la base de datos de la clase.</b></p>
            <!-- Formulario-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <!-- Nombre-->
                    <label><b>Nombre</b></label><br>
                            <input type="text" required name="nombre"  class="w3-input" value="<?php echo $nombre; ?>" 
                                title="El nombre no puede contener números"
                                minlength="1"><br>
                    <label><b>Apellidos</b></label><br>
                            <input type="text" required name="apellido"  class="w3-input" value="<?php echo $apellido; ?>" 
                                title="Los apellido no puede contener números"
                                minlength="1"><br>
                    <!-- Email -->
                    <label><b>E-Mail</b></label><br>
                            <input type="email" required name="email"  class="w3-input" value="<?php echo $email; ?>"><br>

                        <!-- Password -->
                    <label><b>Password</b></label><br>
                            <input type="password" required name="password"  class="w3-input" value="<?php //echo $password; ?>"
                            minlength="5" ><br>

                        <!-- Administrador -->
                    <label><b>Administrador</b></label><br>
                            <input type="radio" name="admin" class="w3-radio" value="si" <?php echo (strstr($admin, 'si')) ? 'checked' : ''; ?>>si</input>
                            <input type="radio" name="admin" class="w3-radio" value="no" <?php echo (strstr($admin, 'no')) ? 'checked' : ''; ?>>no</input><br>
                        <!-- Lenguaje-->
                    <label><b>Telefono</b></label><br>
                            <input type="tel" required name="telefono"  class="w3-input" value="<?php echo $telefono; ?>"><br>
                        <!-- Fecha-->
                    <label><b>Fecha de Alta</b></label><br>
                            <input type="date" required name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>"></input><br>
                         <!-- Foto-->
                    <label><b>Fotografía</b></label><br>
                        <!-- Solo acepto imagenes jpg -->
                            <input type="file" required name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"><br>    
                        <!-- Botones --> 
                        <p> 
                            <input type="submit" name="Enviar" value="Enviar" class="w3-btn w3-blue"> 
                            <input type="reset" name="Limpiar" value="Limpiar" class="w3-btn w3-red" >
                        </p>
                

        </form>

<?php require_once VIEW_PATH."footer.php"; ?>
