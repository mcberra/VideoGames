<?php
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
?>
<div style="margin-left:19%">
<h1>Listado de productos registrados</h1><br><br>
<h3 class="pull-left">Buscar fichas de Productos</h3>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

             
    
<input type="text" id="buscar" name="producto" placeholder="Busque aqui por nombre..." class="w3-input">
                    
<button type="submit"class="w3-btn w3-black" >  <i class="fa fa-search "></i></button>


               
            
            

            <a href="/games/admin/producto/Vistas/create.php" class="w3-btn w3-green">  Añadir Producto</a>
</form>
 <style>
#pag{
        
        list-style-type:none;
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
       $limite = 5; // Limite del paginador
       $paginador  = new Paginador($consulta, $parametros, $limite);
       $resultados = $paginador->getDatos($pagina);

    
              // Si hay filas (no nulo), pues mostramos la tabla
            //if (!is_null($lista) && count($lista) > 0) {
                if(count( $resultados->datos)>0){
                    echo "<table class='w3-table-all w3-card-4' >";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Nombre</th>";
                    echo "<th>Tipo</th>";
                    echo "<th>Distribuidor</th>";
                    echo "<th>Precio</th>";
                    echo "<th>Descuento</th>";
                    echo "<th>Stock</th>";
                    echo "<th>Fotografia</th>";
                    echo "<th>Acción</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    // Recorremos los registros encontrados
                    foreach ($resultados->datos as $a) {
                        $producto = new producto($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->stock, $a->imagen);
                        echo "<tr>";
                        echo "<td>" . $producto->getNombre() . "</td>";
                        echo "<td>" . $producto->getTipo() . "</td>";
                        echo "<td>" . $producto->getDistribuidor() . "</td>";
                        echo "<td>" . $producto->getPrecio() . "</td>";
                        echo "<td>" . $producto->getDescuento() . "</td>";
                        echo "<td>" . $producto->getStock() . "</td>";
                        echo "<td><img src='/games/admin/producto/imagenes/".$producto->getImagen()."' width='150px' height='170px'></td>";
                        echo "<td>";
                        echo "<p><a href='/games/admin/producto/Vistas/read.php?id=" . encode($producto->getId()) . "' title='Ver usuario' data-toggle='tooltip'class='w3-btn w3-black'> <span class='glyphicon glyphicon-eye-open'></span></a></p>";
                        echo "<p><a href='/games/admin/producto/Vistas/update.php?id=" . encode($producto->getId()) . "' title='Actualizar usuario' data-toggle='tooltip'class='w3-btn w3-black'> <span class='glyphicon glyphicon-refresh'></span></a></p>";
                        echo "<p><a href='/games/admin/producto/Vistas/delete.php?id=" . encode($producto->getId()) . "' title='Borrar usuario' data-toggle='tooltip'class='w3-btn w3-black'> <span class='glyphicon glyphicon-trash'></span></a></p>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "<ul class=''>"; //  <ul class="pagination">
                    echo $paginador->crearLinks($enlaces);
                    echo "</ul>";
                } else {
                    // Si no hay nada seleccionado
                    echo "<p class='lead'><em>No se ha encontrado datos de los items.</em></p>";
                }  

                
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
