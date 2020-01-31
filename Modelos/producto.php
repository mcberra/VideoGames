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
class producto {
    //put your code here
    private $id;
    private $nombre;
    private $tipo;
    private $distribuidor;
    private $precio;
    private $descuento;
    private $stock;
    private $imagen;

    
    // Constructor
    public function __construct($id,  $nombre, $tipo,  $distribuidor, $precio, $descuento,  $stock, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->distribuidor = $distribuidor;
        $this->precio = $precio;
        $this->descuento = $descuento;
        $this->stock = $stock;
        $this->imagen = $imagen;
    }
    
    // **** GETS & SETS
    function getId() {
        return $this->id;
    }


    function getNombre() {
        return $this->nombre;
    }

    function getTipo() {
        return $this->tipo;
    }
    
    function getDistribuidor() {
        return $this->distribuidor;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getDescuento() {
        return $this->descuento;
    }

    function getStock() {
        return $this->stock;
    }


    function getImagen() {
        return $this->imagen;
    }

    //***********************sets************************* */

    function setId($id) {
        $this->id = $id;
    }


    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setDistribuidor($distribuidor) {
        $this->distribuidor = $distribuidor;
    }
    
    function setPrecio($precio) {
        //$this->password = md5($password);
        $this->precio = ($precio);
    } 

    function setDescuento($descuento) {
        $this->descuento= $descuento;
    } 

    function setStock($stock) {
        $this->stock= $stock;
    } 


    function setImagen($imagen) {
        $this->imagen= $imagen;
    } 
}
