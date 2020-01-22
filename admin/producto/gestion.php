<?php require_once "Paths.php";?>
<?php require_once VIEW_PATH."header.php"; ?>
<br>
<style>
p.imp{
        
        text-align:center;
    }


    
</style> 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div class="w3-sidebar w3-blue-grey w3-bar-block" style="width:19%">
  <h3 class="w3-bar-item">Gestion de usuarios y productos</h3><br>
  Añadir Usuario <a href="/games/admin/usuario/Vistas/create.php" ><button class="w3-button w3-circle w3-black">+</button>  </a><br><br>
  
  <a href="/games/admin/usuario/gestion.php" ><button class="w3-btn w3-round-xxlarge w3-black"> Ir a lista de Usuarios</button> </a><br><br><br>

  <h3>Descargar en: </h3><br><br>
        <p class="imp">
            <a href="utilidades/descargar.php?opcion=PDF" class="w3-btn w3-black" target="_blank"> PDF</a>
            <a href="utilidades/descargar.php?opcion=XML" class="w3-btn w3-black" target="_blank">  XML</a>
            <a href="javascript:window.print()" class="w3-btn w3-black" title="Imprimir"><span class="glyphicon glyphicon-print"></span> </a>
        </p>
</div>

<?php require_once VIEW_PATH."lista.php"; ?>

