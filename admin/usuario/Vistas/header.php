<?php 
// Coockie contador
//Importante: las cookies se envían al cliente mediante encabezados HTTP. 
//Como cualquier otro encabezado, las cookies se deben enviar antes que cualquier salida que genere la página 
//(antes que <html>, <head> o un simple espacio en blanco).
  if(isset($_COOKIE['CONTADOR']))
  { 
    // Caduca en un día
    setcookie('CONTADOR', $_COOKIE['CONTADOR'] + 1, time() + 24 * 60 * 60); // un día
    $contador = 'Número de visitas hoy: ' . $_COOKIE['CONTADOR']; 
  } 
  else 
  { 
    // Caduca en un día
    setcookie('CONTADOR', 1, time() + 24 * 60 * 60); 
    $cotador = 'Número de visitas hoy: 1'; 
  } 
  if(isset($_COOKIE['ACCESO']))
  { 
    // Caduca en un día
    setcookie('ACCESO', date("d/m/Y  H:i:s"), time() + 3 * 24 * 60 * 60); // 3 días
    $acceso = '<br>Último acceso: ' . $_COOKIE['ACCESO']; 
  } 
  else 
  { 
    // Caduca en un día
    setcookie('ACCESO', date("d/m/Y  H:i:s"), time() + 3 * 24 * 60 * 60); // 3 días
    $acceso = '<br>Último acceso: '. date("d/m/Y  H:i:s"); 
  } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Gestion Tienda</title>
</head>
<body>
    

 <div class="w3-container w3-black">
<h1>Gestion y administracion</h1>
</div>
<!--  -->

<div class="w3-bar w3-blue-grey">
      <a href="#" class="w3-bar-item  w3-button " title="Inicio"><i class=" w3-large fa fa-home"></i></i></a>
      <a href="/games/admin/administracion.php" class="w3-bar-item  w3-button " title="Gestion de usuarios y productos"><span class="glyphicon glyphicon-cog"></span></i></a>
    
      
      <?php

          error_reporting(E_ERROR | E_WARNING | E_PARSE);
              // Abrimos las sesiones para leerla
              session_start();
              if(isset($_SESSION['USUARIO']['email'])){
                // Menu de administrador
                echo '<a href="#" class="w3-bar-item w3-button w3-black">Logged-in as: '.$_SESSION['USUARIO']['email'].'</a>';
                echo '<a href="/games/admin/usuario/Vistas/login.php" class="w3-bar-item w3-blue-grey" title="Log-Out"><i class=" w3-large fa fa-sign-out"></i></a>';
                
            } else{
                // Menú normal
                echo '<a href="#" class="w3-bar-item w3-button w3-black">Not logged</a>';
                echo '<a href="/games/admin/usuario/Vistas/login.php" class="w3-bar-item w3-button w3-blue-grey" title="Log-In"><i class="w3-large fa fa-sign-in"></i></a>';
          }
          
      ?>
</div>


