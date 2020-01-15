<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/Alum/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

$dni = $nombre = $email = $password = $idioma = $matricula = $lenguaje = $fecha = $imagen ="";
$imagenAnterior = "";
 
// Procesamos la información obtenida por el get
    if(isset($_POST["id"]) && !empty($_POST["id"])){
            $id = $_POST["id"];
            
        $dni=filtrado($_POST["dni"]);
        $nombre=filtrado($_POST["nombre"]);
        $email=filtrado($_POST["email"]);
        //$idioma=filtrado(implode(",",$_POST["idioma"]));
        $matricula=filtrado($_POST["matricula"]);
        $lenguaje=filtrado($_POST["lenguaje"]);
        //$fecha=filtrado($_POST["fecha"]);
        

/*----------------------------------------------COMPROBACION DNI-----------------------------------------------------------------*/
        $dnierr = 0; 
        //$duplicateDNI = 0;
        //$tabla= "alumnado";
       
        $formatodni=preg_match('/[0-9]{8}[A-Za-z]{1}/', $dni);
        if ($formatodni==0) {
            $dnierr = $dnierr+1;
            alerta("El DNI que introdujo no cumple con el formato requerido para ser un dni valido. 1");
            
        }

        if(empty($dni)){
            alerta("El DNI que introdujo esta en blanco. 2");
            $dnierr = $dnierr+1; 
        } 

        
      /*$controlador = ControladorAlumno::getControlador();
        $alumno = $controlador->buscarAlumnoDni($dni);
       if(isset($alumno)){
           //alerta(print_r($alumno->getDni()));
           //$dniErr = "Ya existe un alumno con DNI:" .$dniVal. " en la Base de Datos";
           alerta("El DNI que introdujo ya existe.");
           $dnierr = $dnierr+1;
       }
            $controlador = ControladorAlumno::getControlador();
            $lista= $controlador->BuscarTabla($tabla);
            foreach ( $lista as $al ) {

                if ( $dni == $al->getdni() ) {
                    alerta("Ya existe este id, introduzca otro");
                    //echo "Si manuel, si!!!!! funciona y te compueba que este dni existe!";
                    $duplicateDNI = 1;
                }
            
            }
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
/*----------------------------------------------COMPROBACION IDIOMAS-----------------------------------------------------------------*/
$idioma="";
$idiomaerr = 0;
if (isset($_POST["idioma"])) {
    $idioma = filtrado(implode(",", $_POST["idioma"]));
    $idiomas =array("castellano","ingles","frances","chino"); 
    $idiomasPasados = explode(",",$idioma);
    foreach ($idiomasPasados as $idi) {
            if (in_array($idi, $idiomas)) {
                $idiomaerr = 0;
            }else{
                alerta("Debe introducir un IDIOMA que este entre los siguientes: Castellano, Ingles, Frances, Chino.");
                $idiomaerr = $idiomaerr+1;
            }
        }
}
if(empty($idioma)){
    $idiomaerr = $idiomaerr+1;
    alerta("Debe elegir al menos un idioma");
}

                       
/*----------------------------------------------COMPROBACION FECHA-----------------------------------------------------------------*/

// $fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
// $hoy =date("d-m-Y");
// $fechaerr = 0;
// if($fecha>$hoy){
//     $fechaerr = $fechaerr+1;
//     alerta("La fecha no puede ser superior a la fecha actual");
// }

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
if($_FILES['imagen']['size']>0){
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

          $imagenAnterior = trim($_POST["imagenAnterior"]);
          if($imagenAnterior!=$imagen){
              if(!$controlador->eliminarImagen($imagenAnterior)){
                  alerta("Error al borrar la antigua imagen en el servidor");
                  $imagenerr = $imagenerr+1;
              }
          }else{
            // Si no la hemos modificado
                $imagen=trim($_POST["imagenAnterior"]);
            }
      }
    }
                    
/*-----------------------------------------------------------------------------------------------------------------------------*/
if (  $dnierr == 0 && $nombreerr == 0 && $mod = true && $emailerr == 0 && $passwordErr == 0 && $idiomaerr == 0 && $fechaerr == 0
&& $imagenerr == 0) {        
        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->actualizarAlumno($id, $dni, $nombre, $email, $password, $idioma, $matricula, $lenguaje, $fecha, $imagen);
        if($estado){
            //header("location: /Alum/indexAL.php");
            exit();
        }else{
            header("location: /Alum/Vistas/error.php");
        exit();
        }
                        
        }
}//se cierra aqui
                        
// Comprobamos que existe el id antes de ir más lejos
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id =  decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $alumno = $controlador->buscarAlumno($id);
            if (!is_null($alumno)) {
                $dni = $alumno->getDni();
                $nombre = $alumno->getNombre();
                $email = $alumno->getEmail();
                $password = $alumno->getPassword();
                $idioma = $alumno->getIdioma();
                $matricula = $alumno->getMatricula();
                $lenguaje = $alumno->getLenguaje();
                $fecha = $alumno->getFecha();
                $imagen = $alumno->getImagen();
                $imagenAnterior = $imagen;
        }else{
            header("location: error.php");
            exit();
        }
    }else{
                            
        header("location: error.php");
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
                                
                                    <label><b>DNI</b></label><br>
                                    <input type="text" required name="dni" class="w3-input" value="<?php echo $dni; ?>" 
                                        pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra">
                                    
                               
                            </td>
                            <!-- Fotogrsfía -->
                            <td class="align-left">
                                <label><b>Fotografía</b></label><br>
                                <img src='<?php echo "../imagenes/" . $alumno->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                            </td>
                        </tr>
                    </table>
                        <!-- Nombre-->
                        
                            <!-- Nombre-->
                            <label><b>Nombre</b></label><br>
                            <input type="text" name="nombre" class="w3-input" value="<?php echo $nombre; ?>"><br><br>
                        <!-- Email -->
              
                            <label><b>E-Mail</b></label><br>
                            <input type="email" required name="email" class="w3-input" value="<?php echo $email; ?>"><br>
                            

                            <label><b>Password</b></label><br>
                            <input type="password" required name="password" class="w3-input" value="<?php echo ($password); ?>"
                                readonly><br>
                           
                      
                       
                            <label><b>Idiomas</b></label><br>
                            <input type="checkbox" name="idioma[]" class="w3-check" value="castellano" <?php echo (strstr($idioma, 'castellano')) ? 'checked' : ''; ?>>Castellano</input>
                            <input type="checkbox" name="idioma[]" class="w3-check" value="ingles" <?php echo (strstr($idioma, 'ingles')) ? 'checked' : ''; ?>>Inglés</input>
                            <input type="checkbox" name="idioma[]" class="w3-check" value="frances" <?php echo (strstr($idioma, 'frances')) ? 'checked' : ''; ?>>Francés</input>
                            <input type="checkbox" name="idioma[]" class="w3-check" value="chino" <?php echo (strstr($idioma, 'chino')) ? 'checked' : ''; ?>>Chino</input><br><br>
                            
                      
                        <!-- Matrícula -->
                        
                            <label><b>Matrícula</b></label><br>
                            <input type="radio" name="matricula" class="w3-radio" value="modular" <?php echo (strstr($matricula, 'modular')) ? 'checked' : ''; ?>>Modular</input>
                            <input type="radio" name="matricula" class="w3-radio" value="completa" <?php echo (strstr($matricula, 'completa')) ? 'checked' : ''; ?>>Completa</input><br><br>
                           
                      
                        <!-- Lenguaje-->
                     
                        <label><b>Lenguaje</b></label><br>
                            <select name="lenguaje">
                                <option value="PHP" <?php echo (strstr($lenguaje, 'PHP')) ? 'selected' : ''; ?>>PHP</option>
                                <option value="JAVA" <?php echo (strstr($lenguaje, 'JAVA')) ? 'selected' : ''; ?>>JAVA</option>
                                <option value="C#" <?php echo (strstr($lenguaje, 'C#')) ? 'selected' : ''; ?>>C#</option>
                                <option value="PYTHON" <?php echo (strstr($lenguaje, 'PYTHON')) ? 'selected' : ''; ?>>PYTHON</option><br><br>
                            </select>
                   
                        <!-- Fecha-->
              
                        <label><b>Fecha de Matriculación</b></label><br>
                            <input type="date" required name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>"></input><br><br>
                         
                    
                         <!-- Foto-->
                        
                        <label><b>Fotografía</b></label><br>
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"> <br>
                         
                     
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                        <button type="submit" value="Enviar" class="w3-btn w3-green"> </span>  Modificar</button>
                        <a href="/Alum/indexAL.php" class="w3-btn w3-blue"></span> Volver</a>
                    </form>
     <br>

<?php require_once VIEW_PATH."footer.php"; ?>