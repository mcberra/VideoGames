<?php 
      require_once CONTROLLER_PATH."ControladorBD.php";
      require_once CONTROLLER_PATH."ControladorAlumno.php";

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
    <link rel="shortcut icon" type="image/x-icon" href="./4288favicon.ico">
    <title>Game Over</title>
</head>

<style>
  .black{
    background-color:black;
    border-bottom:solid 5px #152F4F;
    color:white;
  }
</style>
<body>
    <div class="black">
        <img src="\games\admin\producto\img\14.png" alt="titulo" class=""><br>
        <p>        Oficial web page of Game Over store.</p>
    </div>

        <div class="w3-bar w3-black" >
            <a href="/games/indexCAT.php" class="w3-bar-item w3-button w3-hover-none w3-border-black w3-bottombar w3-hover-border-white w3-hover-text-white" title="Inicio"><i class=" w3-large fa fa-home"></i></i></a>
            <a href="/games/Vistas/registro.php" class="w3-bar-item w3-button w3-hover-none w3-border-black w3-bottombar w3-hover-border-white w3-hover-text-white" title="Registro de usuarios" style="text-decoration:none"><span class="glyphicon glyphicon-check"></span> Sing-in </i></a> 
            <?php

error_reporting(E_ALL ^ E_NOTICE);           
session_start();
                  
            if(isset($_SESSION['USUARIO']['email'])){
                
                echo '<div class="w3-dropdown-hover w3-mobile">';
                    echo '<button class="w3-button w3-black w3-hover-none w3-text-white w3-hover-text-white"><i class=" w3-large fa fa-user"></i> '.$_SESSION['USUARIO']['email'][0].' <i class="fa fa-caret-down"></i></button>';         
                    echo '<div class="w3-dropdown-content w3-bar-block w3-dark-grey">';
                        echo '<a href="/games/Vistas/perfil_config.php?id=' . encode($_SESSION['USUARIO']['email'][2]) . '" class="w3-bar-item w3-button w3-black w3-hover-black w3-text-grey w3-hover-text-white" style="text-decoration:none"><span class="glyphicon glyphicon-edit"></span> Configuracion de perfil</a>';
                        echo '</div>';
                    echo '</div>';
              if (isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='si') {
                echo '<div class="w3-dropdown-hover w3-mobile">';
                echo '<button class="w3-button w3-black w3-hover-none w3-text-white w3-hover-text-white"> <span class="glyphicon glyphicon-cog"></span> Administration <i class="fa fa-caret-down"></i></button>';
                //echo '<a href="/games/admin/administracion.php" class="w3-bar-item w3-button w3-black w3-hover-black w3-text-grey w3-hover-text-white" title="Gestion de usuarios y productos" style="text-decoration:none"><span class="glyphicon glyphicon-cog"></span> Administracion</a>';         
                    echo '<div class="w3-dropdown-content w3-bar-block w3-dark-grey">';
                        echo '<a href="/games/admin/usuario/Vistas/create.php" class="w3-bar-item w3-button w3-black w3-hover-black w3-text-grey w3-hover-text-white" style="text-decoration:none" ><span class="glyphicon glyphicon-plus-sign"></span>  Añadir Usuario </a>';
                        echo '<a href="/games/admin/producto/Vistas/create.php" class="w3-bar-item w3-button w3-black w3-hover-black w3-text-grey w3-hover-text-white" style="text-decoration:none" > <span class="glyphicon glyphicon-plus-sign"></span> Añadir Producto  </a>';
                        echo '<a href="/games/admin/usuario/gestion.php" class="w3-bar-item w3-button w3-black w3-hover-black w3-text-grey w3-hover-text-white" style="text-decoration:none" ><span class="glyphicon glyphicon-list-alt"></span>  Listado de Usuarios </a>';
                        echo '<a href="/games/admin/producto/gestion.php" class="w3-bar-item w3-button w3-black w3-hover-black w3-text-grey w3-hover-text-white" style="text-decoration:none" ><span class="glyphicon glyphicon-list-alt"></span>  Listado de Productos</a>';
                    echo '</div>';
                echo '</div>';
              }
                echo '<a href="/games/Vistas/login.php" class="w3-bar-item w3-button w3-hover-none w3-border-black w3-bottombar w3-hover-border-white w3-hover-text-white" title="Log-Out"><i class=" w3-large fa fa-sign-out"> Log-out</i></a>';           
            } else{
                    // Menú sin log
                    echo '<a href="#" class="w3-bar-item w3-button w3-hover-none w3-border-black w3-bottombar w3-hover-border-white w3-hover-text-white">Not logged</a>';
                    echo '<a href="/games/Vistas/login.php" class="w3-bar-item w3-button w3-hover-none w3-border-black w3-bottombar w3-hover-border-white w3-hover-text-white" title="Log-In"><i class="w3-large fa fa-sign-in"> Log-in</i></a>';
                }
                          
              ?>
        </div>

