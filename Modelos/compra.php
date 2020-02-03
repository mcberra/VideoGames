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
class compra {
    //put your code here
    private $email_usuario;
    private $direccion;
    private $direccion2;
    private $ciudad;
    private $estado;
    private $codigo_postal;
    private $pais;
    private $id_compra;


    
    // Constructor
    public function __construct($email_usuario,$direccion, $direccion2, $ciudad, $estado, $codigo_postal, $pais,$id_compra) {
        $this->email_usuario = $email_usuario;
        $this->direccion = $direccion;
        $this->direccion2 = $direccion2;
        $this->ciudad = $ciudad;
        $this->estado = $estado;
        $this->codigo_postal = $codigo_postal;
        $this->pais = $pais;
        $this->id_compra = $id_compra;
    }
    
    // **** GETS & SETS
    function getemail_usuario() {
        return $this->email_usuario;
    }


    function getdireccion() {
        return $this->direccion;
    }

    function getdireccion2() {
        return $this->direccion2;
    }
    
    function getciudad() {
        return $this->ciudad;
    }

    function getestado() {
        return $this->estado;
    }

    function getcodigo_postal() {
        return $this->codigo_postal;
    }

    function getpais() {
        return $this->pais;
    }


    function getid_compra() {
        return $this->id_compra;
    }





    function setemail_usuario($email_usuario) {
        $this->email_usuario = $email_usuario;
    }


    function setdireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setdireccion2($direccion2) {
        $this->direccion2 = $direccion2;
    }

    function setciudad($ciudad) {
        $this->ciudad = $ciudad;
    }
    
    function setestado($estado) {
        $this->estado = $estado;
    } 

    function setcodigo_postal($codigo_postal) {
        $this->codigo_postal= $codigo_postal;
    } 

    function setpais($pais) {
        $this->pais= $pais;
    } 


    function setFecha($fecha) {
        $this->fecha= $fecha;
    } 

    function setid_compra($id_compra) {
        $this->id_compra= $id_compra;
    } 
}
