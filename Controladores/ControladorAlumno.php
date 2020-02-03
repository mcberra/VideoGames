<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorAlumno
 *
 * @author link
 */

require_once MODEL_PATH."producto.php";
require_once MODEL_PATH."compra.php";
require_once MODEL_PATH."alumno.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorAlumno {

     // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }
    
    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorAlumno();
        }
        return self::$instancia;
    }
    
    /**
     * Lista el alumnado según el nombre o dni
     * @param type $nombre
     * @param type $dni
     */
    public function listarAlumnos($nombre){
        // Creamos la conexión a la BD
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta pero esta vez paremtrizada
        $consulta = "SELECT * FROM producto WHERE nombre LIKE :nombre";
        $parametros = array(':nombre' => "%".$nombre."%");
        // Obtenemos las filas directamente como objetos con las columnas de la tabla
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        //var_dump($filas);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $producto = new producto($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->stock,  $a->imagen);
                // Lo añadimos
                $lista[] = $producto;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }
    
    public function almacenarAlumno($nombre,$tipo, $distribuidor, $precio, $descuento, $stock,  $imagen){
        //$alumno = new Alumno("",$dni, $nombre, $email, $password, $idioma, $matricula, $lenguaje, $fecha, $imagen);
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO producto ( nombre,tipo, distribuidor, precio, 
            descuento, stock, imagen) VALUES ( :nombre, :tipo, :distribuidor, :precio, :descuento, 
            :stock,  :imagen)";
        
        $parametros= array( ':nombre'=>$nombre, ':tipo'=>$tipo, ':distribuidor'=>$distribuidor,':precio'=>$precio,
                            ':descuento'=>$descuento, ':stock'=>$stock,':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
    public function buscarAlumno($id){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM producto WHERE id = :id";
        $parametros = array(':id' => $id);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $producto = new producto($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->stock,  $a->imagen);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $producto;
        }else{
            return null;
        }    
    }



    
    public function buscarAlumnoDni($nombre){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM producto  WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $producto = new producto($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->stock,  $a->imagen);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $producto;
        }else{
            return null;
        }    
    }


    
    public function borrarAlumno($id){ 
        $estado=false;
        // Borro el alumno de la
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "DELETE FROM producto WHERE id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
    public function actualizarAlumno($id, $nombre,$tipo, $distribuidor, $precio, $descuento, $stock,  $imagen){
       // $alumno = new Alumno($id,$dni, $nombre, $email, $password, $idioma, $matricula, $lenguaje, $fecha, $imagen);
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "UPDATE producto SET  nombre=:nombre, tipo=:tipo, distribuidor=:distribuidor, precio=:precio, descuento=:descuento, 
            stock=:stock,  imagen=:imagen 
            WHERE id=:id";
        $parametros= array(':id' => $id,  ':nombre'=>$nombre, ':tipo'=>$tipo, ':distribuidor'=>$distribuidor,':precio'=>$precio,
                            ':descuento'=>$descuento, ':stock'=>$stock,':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
    public function buscarID($email){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT id FROM usuarios  WHERE email = :email";
        $parametros = array(':email' => $email);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new usuario($a->id, $a->nombre,  $a->apellido, $a->email, $a->password, $a->admin, $a->telefono,  $a->fecha, $a->imagen);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $usuario;
        }else{
            return null;
        }    
    }
    
    public function buscarDuplicado($nombre){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM producto  WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $producto = new producto($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->stock,  $a->imagen);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $producto;
        }else{
            return null;
        }    
    }

    public function actualizarAlumno1($id, $nombre,$apellido, $email, $password, $admin, $telefono, $fecha, $imagen){
        // $alumno = new Alumno($id,$dni, $nombre, $email, $password, $idioma, $matricula, $lenguaje, $fecha, $imagen);
         $bd = ControladorBD::getControlador();
         $bd->abrirBD();
         $consulta = "UPDATE usuarios SET  nombre=:nombre, apellido=:apellido, email=:email, password=:password, admin=:admin, 
             telefono=:telefono, fecha=:fecha, imagen=:imagen 
             WHERE id=:id";
         $parametros= array(':id' => $id,  ':nombre'=>$nombre, ':apellido'=>$apellido, ':email'=>$email,':password'=>$password,
                             ':admin'=>$admin, ':telefono'=>$telefono,':fecha'=>$fecha,':imagen'=>$imagen);
         $estado = $bd->actualizarBD($consulta,$parametros);
         $bd->cerrarBD();
         return $estado;
     }


     public function buscarAlumno1($id){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM usuarios WHERE id = :id";
        $parametros = array(':id' => $id);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new usuario($a->id, $a->nombre, $a->apellido, $a->email, $a->password, $a->admin, $a->telefono, $a->fecha, $a->imagen);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $usuario;
        }else{
            return null;
        }    
    }

    public function almacenarDireccion($email_usuario,$direccion, $direccion2, $ciudad, $estado, $codigo_postal, $pais,$id_compra){
        //$alumno = new Alumno("",$dni, $nombre, $email, $password, $idioma, $matricula, $lenguaje, $fecha, $imagen);
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO direccion ( email_usuario,direccion, direccion2, 
            ciudad, estado, codigo_postal, pais,id_compra) VALUES ( :email_usuario, :direccion, :direccion2, :ciudad, :estado, 
            :codigo_postal,  :pais ,  :id_compra)";
        
        $parametros= array( ':email_usuario'=>$email_usuario, ':direccion'=>$direccion, ':direccion2'=>$direccion2,':ciudad'=>$ciudad,
                            ':estado'=>$estado, ':codigo_postal'=>$codigo_postal,':pais'=>$pais ,':id_compra'=>$id_compra);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }

    public function almacenarTarjeta($email_usuario, $id_compra, $numero_tarjeta, $total, $fecha){
        //$alumno = new Alumno("",$dni, $nombre, $email, $password, $idioma, $matricula, $lenguaje, $fecha, $imagen);
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO ventas ( email_usuario,numero_tarjeta, id_compra, 
            fecha, total) VALUES ( :email_usuario, :numero_tarjeta, :id_compra, :fecha, 
            :total)";
        
        $parametros= array( ':email_usuario'=>$email_usuario, ':numero_tarjeta'=>$numero_tarjeta, ':id_compra'=>$id_compra,':fecha'=>$fecha,
                             ':total'=>$total);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }


    public function buscarIdcompra($id_compra){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM direccion WHERE id_compra = :id_compra";
        $parametros = array(':id_compra' => $id_compra);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $compra = new compra($a->email_usuario, $a->direccion, $a->direccion2, $a->ciudad, $a->estado, $a->codigo_postal, $a->pais, $a->id_compra);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $compra;
        }else{
            return null;
        }    
    }

    // public function actualizarStock($stock, $nombre){
    //     // $alumno = new Alumno($id,$dni, $nombre, $email, $password, $idioma, $matricula, $lenguaje, $fecha, $imagen);
    //      $bd = ControladorBD::getControlador();
    //      $bd->abrirBD();
    //      $consulta = "UPDATE producto SET  stock=:stock
    //          WHERE nombre=:".$nombre;
    //      $parametros= array(':stock' => $stock,':nombre' => $nombre);
    //      $estado = $bd->actualizarBD($consulta,$parametros);
    //      $bd->cerrarBD();
    //      return $estado;
    //  }



     public function buscarStock($nombre){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM producto  WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $producto = new producto($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->stock,  $a->imagen);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $producto;
        }else{
            return null;
        }    
    }


    public function actualizarStock( $stock,  $nombre){
         $bd = ControladorBD::getControlador();
         $bd->abrirBD();
         $consulta = "UPDATE producto SET   stock=:stock WHERE nombre=:nombre ";
         $parametros= array(  ':nombre'=>$nombre, ':stock'=>$stock );
         $estado = $bd->actualizarBD($consulta,$parametros);
         $bd->cerrarBD();
         return $estado;
     }

}
