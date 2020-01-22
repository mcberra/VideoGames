
 <?php require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/usuario/Paths.php"; ?>
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<?php require_once VIEW_PATH."header.php"; ?>
<!-- <div class="w3-display-middle">
        <h1>Gestion de usuarios y productos</h1>

        <p>
            Añadir usuario <a href="/games/admin/usuario/Vistas/create.php" ><button class="w3-button w3-circle w3-black">+</button>  </a>
            <a href="/games/admin/usuario/gestion.php" > <button class="w3-btn w3-round-xxlarge w3-black">Ir a lista de usuarios</button> </a>
        </p>
        <p> 
            Añadir producto <a href="/games/admin/producto/Vistas/create.php" ><button class="w3-button w3-circle w3-black">+</button></a>
            
            <a href="/games/admin/producto/Vistas/create.php" > <button class="w3-btn w3-round-xxlarge w3-black">Ir a lista de productos</button> </a>
        </p>
        </div> -->

<div class="w3-card-4 w3-margin w3-display-middle" style="width:27%" >
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

