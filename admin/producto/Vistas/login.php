<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/producto/Paths.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorAcceso.php";

//Debemos decir que no estamos identificando
$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();
?>

<?php require_once VIEW_PATH."header.php"; ?>
<!-- Barra de Navegacion -->

<?php
    
    // Procesamos la indetificación
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $controlador = ControladorAcceso::getControlador();
        $controlador->procesarIdentificacion($_POST['email'], $_POST['password']);
    }
 
?>






                    <h2>Identificación de Usuario administrador:</h2>
                
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
             
                  
                        <label>Email:</label>
                        <input type="email" required name="email" class="w3-input" value="pepe@pepe.com"><br><br>
                   
           
                        <label>Contraseña:</label>
                        <input type="password" required name="password" class="w3-input" value="pepe"><br><br>
                  
                    <button type="submit" class="w3-btn w3-green">  Entrar</button>
                    <a href="/games/admin/producto/Vistas/gestion.php" class="w3-btn w3-blue"> Volver inicio</a>
                </form>

<br>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH."footer.php"; ?>