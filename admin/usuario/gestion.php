<?php 
//esta pagina sirve para coloca el navbar vertical y alberga el listado
require_once "Paths.php";?>
<?php require_once VIEW_PATH."header.php"; ?>
<br>
<style>
p.imp{
        
        text-align:center;
    }


    
</style> 

<div class="w3-sidebar  w3-bar-block" style="width:13%;margin-top:70px;">
<h3 class="w3-bar-item">Gestion de usuarios y productos</h3><br>
<p class="imp"> <a href="/games/admin/usuario/Vistas/create.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large w3-circle " > Añadir Producto </a> </a></p><br>
<p class="imp"> <a href="/games/admin/producto/gestion.php" ><button class="w3-btn w3-white w3-border w3-border-grey w3-round-large w3-circle "> Ir a lista de productos</button> </a></p><br><br>

  <h3>Descargar en: </h3><br><br>
        <p class="imp">
            <a href="utilidades/descargar.php?opcion=PDF" class="w3-btn w3-black" target="_blank"> PDF</a>
            <a href="utilidades/descargar.php?opcion=XML" class="w3-btn w3-black" target="_blank">  XML</a>
            <a href="javascript:window.print()" class="w3-btn w3-black" title="Imprimir"> <span class="glyphicon glyphicon-print"></a>
        </p>
</div>

<?php require_once VIEW_PATH."lista.php"; ?>

