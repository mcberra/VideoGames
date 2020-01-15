<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author link
 */
class usuario {
    //put your code here
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $admin;
    private $telefono;
    private $fecha;
    private $imagen;

    
    // Constructor
    public function __construct($id,  $nombre, $apellido, $email, $password, $admin, $telefono,  $fecha, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->telefono = $telefono;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
    }
    
    // **** GETS & SETS
    function getId() {
        return $this->id;
    }


    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }
    
    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getAdmin() {
        return $this->admin;
    }

    function getTelefono() {
        return $this->telefono;
    }


    function getFecha() {
        return $this->fecha;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setId($id) {
        $this->id = $id;
    }


    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    
    function setPassword($password) {
        //$this->password = md5($password);
        $this->password = md5($password);
    } 

    function setAdmin($admin) {
        $this->admin= $admin;
    } 

    function setTelefono($telefono) {
        $this->telefono= $telefono;
    } 


    function setFecha($fecha) {
        $this->fecha= $fecha;
    } 

    function setImagen($imagen) {
        $this->imagen= $imagen;
    } 
}
