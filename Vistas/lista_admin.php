<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
    require_once CONTROLLER_PATH."ControladorAlumno.php";
    require_once CONTROLLER_PATH."ControladorImagen.php";
    require_once UTILITY_PATH."funciones.php";
    require_once CONTROLLER_PATH."ControladorBD.php";
    require_once MODEL_PATH."alumno.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// $admins=[];
// $bd = ControladorBD::getControlador();
// $bd->abrirBD();
// $consulta = "SELECT email,password FROM usuario WHERE admin = 'si'";
// $filas = $bd->consultarBD($consulta);

//     foreach ($filas as $a) {
//         $mail = array_shift($a);// se queda con el primer elemento del array OJO sin su clave solo el elemento
//         //array_pop($a); //saca un elemento de un array
//         array_push($admins, $mail);  //introducimos los emails a un array 
//     }

// $bd->cerrarBD();



//  session_start();
//         if(!isset($_SESSION['USUARIO']['email'])){
//             //echo "entro a lista admin";
//             header("location: /games/admin/producto/Vistas/Login.php");
//       exit();
//         }    

//        if(isset($_SESSION['USUARIO']['email']) && !in_array($_SESSION['USUARIO']['email'],$admins)){
//               //echo "entro a lista admin";
//               header("location: /games/admin/producto/Vistas/error_idi.php");
//                 exit();
//        }
?>
<div style="margin-left:5%">
<center><img src="\games\admin\producto\img\GOC.png" alt="titulo"></center>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

             
    
<input type="text" id="buscar" name="producto" placeholder="Busque aqui por nombre..." class="w3-input">
                    
<button type="submit"class="w3-btn w3-black" >  <i class="fa fa-search "></i></button>

        
</form>
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

    
              // Si hay filas (no nulo), pues mostramos la tabla
            //if (!is_null($lista) && count($lista) > 0) {
                echo "<div class='all'>";
                    echo "<div class='w3-margin-bottom'>";
                        // Recorremos los registros encontrados
                        foreach ($resultados->datos as $a) {
                            $producto = new producto($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->stock, $a->imagen);
                            echo "<div class='w3-card-4 w3-margin' style='width:21% ' id='box2'>";
                                echo '<div class="w3-display-container w3-text-black">';
                                    echo "<a href='/games/Vistas/read.php?id=" . encode($producto->getId()) . "' ><img src='/games/admin/producto/imagenes/".$producto->getImagen()."' style='width:100%' class='w3-button'> <img></a>";
                                    echo  "<p style='text-align:center'><button class='w3-btn w3-white w3-border w3-border-grey w3-round-large'>Nombre del producto : " .$producto->getNombre() ."</button></p><br>";
                                    
                                    $descuento=$producto->getDescuento(); 
                                    if ($descuento > 0) {
                                        $price=($producto->getPrecio()-($producto->getPrecio()*$descuento/100));
                                        echo "<p style='text-align:center'><del> € ".$producto->getPrecio()." </del> <i style='color:red'>€".$price."</i> </p>"; 

                                    }else{
                                        echo "<p style='text-align:center'> € ".$producto->getPrecio()."   </p>";
                                    }
                                echo "</div>";
                                echo '<div class="w3-row">';
                                    echo '<div class="w3-third w3-center">';
                                    echo "<p><a href='/games/Vistas/read.php?id=" . encode($producto->getId()) . "' title='Mas informacion' data-toggle='tooltip'class='w3-btn w3-white w3-border w3-border-green w3-round-large'> Mas info.</a></p>";
                                    echo "</div>";
                                    echo '<div class="w3-third w3-center">';
                                        echo "<p><a href='#' title='Añadir a la cestao' data-toggle='tooltip'class='w3-btn w3-white w3-border w3-border-black w3-round-large'> Añadir <span class='glyphicon glyphicon-shopping-cart'></span> </a></p>";
                                    echo "</div>";
                                    echo '<div class="w3-third w3-center w3-margin-bottom">';
                                        echo "<p><a href='#' title='Comprar' data-toggle='tooltip'class='w3-btn w3-white w3-border w3-border-blue w3-round-large'> Comprar</a></p>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            // echo  "Nombre : " .$producto->getNombre() ."<br>";
                            // echo  $producto->getTipo();
                            // echo  $producto->getDistribuidor() ;
                            // echo $producto->getPrecio();
                            // echo $producto->getDescuento();
                            // echo  $producto->getStock();
                            
                            // echo "<p><a href='/games/admin/producto/Vistas/read.php?id=" . encode($producto->getId()) . "' title='Ver usuario' data-toggle='tooltip'class='w3-btn w3-black'> Ver</a></p>";
                            // echo "<p><a href='/games/admin/producto/Vistas/update.php?id=" . encode($producto->getId()) . "' title='Actualizar usuario' data-toggle='tooltip'class='w3-btn w3-black'> Modificar</a></p>";
                            // echo "<p><a href='/games/admin/producto/Vistas/delete.php?id=" . encode($producto->getId()) . "' title='Borar usuario' data-toggle='tooltip'class='w3-btn w3-black'> Borrar</a></p>";
                            // echo "</div>";
                            
        
                        }
                        echo "</div>";
                echo "</div>";
                    
                    echo "<ul >"; //  <ul class="pagination">
                    echo $paginador->crearLinks($enlaces);
                    echo "</ul>";
                    echo "</>";


                
?>

<?php
        // Leemos la cookie
        if(isset($_COOKIE['CONTADOR'])){
            echo "<b>".$contador."</b>";
            echo "<b>".$acceso."</b>";
            echo "<br>";
            echo "<b>Logged in as: ".$_SESSION['USUARIO']['email']."</b>";
        }
        else
            echo "Es tu primera visita hoy";
           
    ?>
    </div>
    </div>
    <?php require_once VIEW_PATH."footer.php"; ?>