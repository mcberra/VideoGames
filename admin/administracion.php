
 <?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/games/Paths.php"; 
    require_once CONTROLLER_PATH."ControladorBD.php";
    error_reporting(E_ERROR | E_WARNING | E_PARSE);





    session_start();
    if (!isset($_SESSION['USUARIO']['email'])) {
      header("location: /games/admin/producto/Vistas/Login.php");
    }
    if (isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='no'){
      header("location: /games/admin/producto/Vistas/Login.php");
    }

?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<?php require_once VIEW_PATH."header.php"; ?>

<div class="w3-card-4 w3-margin" style="width:27%" >
  <div class="w3-display-container w3-text-white">
    <img src="/games/admin/usuario/img/Set.jpg" alt="Lights" style="width:100%">
    <div class="w3-xlarge w3-display-topmiddle w3-padding">Administracion</div>
  </div>
  <div class="w3-row">
    <div class="w3-third w3-center">
      <h3> Añadir Usuario</h3>
      <a href="/games/admin/usuario/Vistas/create.php" ><button class="w3-button w3-circle w3-black">+</button>  </a>
    
    </div>
    <div class="w3-third w3-center">
      <h3>Listados</h3>
      <a href="/games/admin/usuario/gestion.php" title="Listado de Usuarios" class="w3-btn w3-round-xxlarge w3-black" > <i class=" w3-large fa fa-user"></i> </a>
      <a href="/games/admin/producto/gestion.php" title="Listado de productos" class="w3-btn w3-round-xxlarge w3-black" > P </a>
    </div>
    <div class="w3-third w3-center">
      <h3>Añadir Producto</h3>
       <a href="/games/admin/producto/Vistas/create.php" ><button class="w3-button w3-circle w3-black">+</button></a>
    </div>


  </div>
</div>
<?php require_once VIEW_PATH."footer.php"; ?>
