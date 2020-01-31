<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once CONTROLLER_PATH."ControladorBD.php";

class ControladorAcceso {
    // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia de controlador
     * @return instancia del controlador
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorAcceso();
        }
        return self::$instancia;
    }
    
    public function salirSesion() {
        // Recuperamos la información de la sesión
        session_start();
        // Y la eliminamos las variables de la sesión y coockies
        unset($_SESSION['USUARIO']);
        //unset($_COOKIE['CONTADOR']);
        // ahora o las borramos todas o las destruimos, yo haré todo para que se vea
        session_unset();
        session_destroy();
    }
    
    
    public function procesarIdentificacion($email, $password){

        //borro la sesion, por gusto, no se debería hacer pues nos cargamos todas
       // $this->salierSesion();

       $password= hash('sha256',$password);
       //admin=:admin and ':admin'=>'si',
        // Conectamos a la base de datos
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM usuarios WHERE  email=:email and password=:password";
        $parametros = array(':email' => $email, ':password' => $password);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) { 
            $lista=[];
            foreach ($filas as $a) {
                $usuario = new usuario($a->id, $a->nombre,  $a->apellido, $a->email, $a->password, $a->admin, $a->telefono,  $a->fecha, $a->imagen);
                $lista = array($a->email,$a->admin,$a->id,$a->nombre,$a->apellido,$a->imagen, $a->fecha,$a->telefono, $a->password);
            }
            
        $bd->cerrarBD();
             session_start();
             $_SESSION['USUARIO']['email']=$lista;
             //echo $_SESSION['USUARIO']['email'];
             header("location: /games/indexCAT.php"); 
             exit();              
        } else {
            echo "<div class='wrapper'>";
                echo "<div class='container-fluid'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                            echo "<div class='page-header'>";
                                 echo "<h1>Usuario/a incorrecto</h1>";
                             echo "</div>";
                            echo "<div class='alert alert-warning fade in'>";
                                echo "<p>Lo siento, el emial o password es incorrecto. Por favor <a href='/games/Vistas/login.php' class='alert-link'>regresa</a> e inténtelo de nuevo.</p>";
                                echo$_SESSION['USUARIO']['email'];
                                //echo $email;
                                //echo $password;
                   
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
            //<!-- Pie de la página web -->
            require_once VIEW_PATH."footer.php";
            exit();
        }
}
    
    

}
