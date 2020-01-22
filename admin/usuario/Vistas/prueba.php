<?php
         require_once $_SERVER['DOCUMENT_ROOT']."/games/admin/usuario/Paths.php";
         require_once CONTROLLER_PATH."ControladorAlumno.php";
         require_once CONTROLLER_PATH."ControladorImagen.php";
         require_once UTILITY_PATH."funciones.php";
         require_once CONTROLLER_PATH."ControladorBD.php";
         require_once MODEL_PATH."alumno.php";

      
         $borra = true;
         if($borra == true){
                $email = "mcberra16@hotmailcom";
                $bd = ControladorBD::getControlador();
                $bd->abrirBD();
                $consulta = "DELETE  FROM sesion WHERE email = 'mcberra16@hotmail.com'";
                $parametros = array(':email' => $email);
                $estado = $bd->actualizarBD($consulta,$parametros);
                echo $email;
                $bd->cerrarBD();
         }
?>

