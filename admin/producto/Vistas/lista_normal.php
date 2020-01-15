<?php

// session_start();
// if(!isset($_SESSION['USUARIO']['email']) || $_SESSION['USUARIO']['email'] != "admin@admin.com"){
//     //echo $_SESSION['USUARIO']['email'];
//     //exit();
//     header("location: /pc/Vistas/login.php");
//     exit();
// }
?>

<h2 class="pull-left">Fichas de Items</h2>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <p>        
    
    <input type="text" id="buscar" name="usuario" placeholder="Busque aqui por nombre o apellidos..." class="w3-input">
                    
    <button type="submit"class="w3-btn w3-grey" >  Buscar</button>
      </p>              
            
            
            <h3>Descargar en: </h3>
            <a href="utilidades/descargar.php?opcion=PDF" class="w3-btn w3-black" target="_blank"> PDF</a>
            <a href="javascript:window.print()" class="w3-btn w3-black"> IMPRIMIR</a>
            <a href="/Alum1/Vistas/create.php" class="w3-btn w3-green">  Añadir Usuario</a>
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
   
    
</style> 
<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/Alum1/Paths.php";
    require_once CONTROLLER_PATH."ControladorAlumno.php";
    require_once UTILITY_PATH."funciones.php";
    require_once CONTROLLER_PATH . "Paginador.php";

    if (!isset($_POST["usuario"])) {
        $nombre = "";
        $apellido = "";
        
    } else {
        $nombre = filtrado($_POST["usuario"]);
        $apellido = filtrado($_POST["usuario"]);

        
    }
   
    $controlador = ControladorAlumno::getControlador();

       // Parte del paginador
       $pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
       $enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;

       $consulta = "SELECT * FROM usuario WHERE nombre LIKE :nombre OR apellido LIKE :apellido";
       $parametros = array(':nombre' => "%".$nombre."%",':apellido' => "%".$apellido."%");
       $limite = 5; // Limite del paginador
       $paginador  = new Paginador($consulta, $parametros, $limite);
       $resultados = $paginador->getDatos($pagina);

    
              // Si hay filas (no nulo), pues mostramos la tabla
            //if (!is_null($lista) && count($lista) > 0) {
                if(count( $resultados->datos)>0){
                    echo "<table class='w3-table  w3-bordered'border='1'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Nombre</th>";
                    echo "<th>Apellido</th>";
                    echo "<th>E-mail</th>";
                    echo "<th>Admin</th>";
                    echo "<th>Telefono</th>";
                    echo "<th>fecha</th>";
                    echo "<th>Fotografia</th>";
                    echo "<th>Acción</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    // Recorremos los registros encontrados
                    foreach ($resultados->datos as $a) {
                        $usuario = new usuario($a->id, $a->nombre, $a->apellido, $a->email, $a->password, $a->admin, $a->telefono, $a->fecha, $a->imagen);
                        echo "<tr>";
                        echo "<td>" . $usuario->getNombre() . "</td>";
                        echo "<td>" . $usuario->getApellido() . "</td>";
                        echo "<td>" . $usuario->getEmail() . "</td>";
                        echo "<td>" . $usuario->getAdmin() . "</td>";
                        echo "<td>" . $usuario->getTelefono() . "</td>";
                        echo "<td>" . $usuario->getFecha() . "</td>";
                        echo "<td><img src='imagenes/".$usuario->getImagen()."' width='150px' height='170px'></td>";
                        echo "<td>";
                        echo "<p><a href='/Alum1/Vistas/read.php?id=" . encode($usuario->getId()) . "' title='Ver usuario' data-toggle='tooltip'class='w3-btn w3-blue'> Ver</a></p>";
                        //echo "<p><a href='/Alum1/Vistas/update.php?id=" . encode($usuario->getId()) . "' title='Actualizar usuario' data-toggle='tooltip'class='w3-btn w3-yellow'> Modificar</a></p>";
                        echo "<p><a href='/Alum1/Vistas/delete.php?id=" . encode($usuario->getId()) . "' title='Borar usuario' data-toggle='tooltip'class='w3-btn w3-red'> Borrar</a></p>";
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
    <?php require_once VIEW_PATH."footer.php"; ?>