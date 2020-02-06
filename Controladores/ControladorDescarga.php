<?php

// Incluimos los ficheros que ncesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/games/admin/producto/Paths.php";
require_once CONTROLLER_PATH . "ControladorAlumno.php";
require_once MODEL_PATH . "alumno.php";
require_once MODEL_PATH . "compra.php";
require_once MODEL_PATH . "producto.php";
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;


/**
 * Controlador de descargas
 */
class ControladorDescarga
{

    // Configuración del servidor
    private $fichero;

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }

    // public function descargarTXT()
    // {
    //     $this->fichero = "item.txt";
    //     header("Content-Type: application/octet-stream");
    //     header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

    //     $controlador = Controladoritem::getControlador();
    //     $lista = $controlador->listaritems("", "");

    //     // Si hay filas (no nulo), pues mostramos la tabla
    //     if (!is_null($lista) && count($lista) > 0) {
    //         foreach ($lista as &$item) {
    //             echo "Marca: " . $item->getmarca() . " -- Modelo: " . $item->getmodelo() . "  -- Tipo: " . $item->getTipo() .
    //                 " -- Disponible: " . $item->getdisponible() . " -- Precio: " . $item->getprecio() . "\r\n";
    //         }
    //     } else {
    //         echo "No se ha encontrado datos de items";
    //     }
    // }

    // public function descargarJSON()
    // {
    //     $this->fichero = "items.json";
    //     header("Content-Type: application/octet-stream");
    //     header('Content-type: application/json');
    //     //header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

    //     $controlador = Controladoritem::getControlador();
    //     $lista = $controlador->listaritems("", "");
    //     $sal = [];
    //     foreach ($lista as $al) {
    //         $sal[] = $this->json_encode_private($al);
    //     }
    //     echo json_encode($sal);
    // }

    // private function json_encode_private($object)
    // {
    //     $public = [];
    //     $reflection = new ReflectionClass($object);
    //     foreach ($reflection->getProperties() as $property) {
    //         $property->setAccessible(true);
    //         $public[$property->getName()] = $property->getValue($object);
    //     }
    //     return json_encode($public);
    // }

    public function descargarXML()
    {
        $this->fichero = "Usuarios.xml";
        $lista = $controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumnos("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $productos = $doc->createElement('usuarios');

        foreach ($lista as $a) {
            // Creamos el nodo
            $producto = $doc->createElement('item');
            // Añadimos elementos
            $producto->appendChild($doc->createElement('nombre', $a->getNombre()));
            $producto->appendChild($doc->createElement('apellido', $a->getTipo()));
            $producto->appendChild($doc->createElement('email', $a->getDistribuidor()));
            $producto->appendChild($doc->createElement('telefono', $a->getPrecio()));
            $producto->appendChild($doc->createElement('fecha', $a->getDescuento()));
            $producto->appendChild($doc->createElement('fecha', $a->getStock()));
            $producto->appendChild($doc->createElement('imagen', $a->getImagen()));

            //Insertamos
            $productos->appendChild($producto);
        }

        $doc->appendChild($productos);
        header('Content-type: application/xml');
        header("Content-Disposition: attachment; filename='Usuarios.xml'"); //archivo de salida
        echo $doc->saveXML();

        exit;
    }

    
    public function descargarPDF(){//funcion para imprimir la factura
        session_start();
        $id_compra = $_SESSION["id_compra"];
        $controlador = ControladorAlumno::getControlador();
        $compra= $controlador->buscarIdcompra($id_compra);

            function objectToArray ( $compra ) {

                if(!is_object($compra) && !is_array($compra)) {
            
                return $compra;
            
                }
                
                return array_map( 'objectToArray', (array) $compra );
            
            }
            
            $temp_dir = objectToArray ( $compra );
            
            $compra_dir = [];
            foreach ($temp_dir as $a) {
                $a = array_shift($temp_dir);
            
                array_push($compra_dir,$a);
            }

            
            
        $sal='<div border="1" style="width:25%;margin-left:400px;padding:25px">';   
        $sal.='<h2 style="text-align:center">Game Over</h2>';
        //$sal.='<p style="text-align:center">Gracias por su compra!</p>';
        $sal.='<h4 style="text-align:center">PEDIDO Nº : ' .$_SESSION["id_compra"].' | fecha: '.date("d-m-Y").'</h4>';
        //$sal.='<h4 style="text-align:center">Fecha : ' .date("d-m-Y").'date("d-m-Y")</h4>';
        
        foreach ($_SESSION["cart"] as $a) {
            $sal.='<div style="border-bottom:solid 2px lightgrey">';
            $sal.='<p >'.$a[1].' </p>';
            $sal.='<p >Unidades: '.$a[6].'</p>';
            $descuento=$a[4];  
            if ($descuento > 0) {
                $price=($a[3])-($a[3]*$a[4]/100);
                //echo "<p style='float:right'> uds x <del> ".$a[3]."€  </del> <i style='color:red'>".$price." €</i> </p>";
                $sal.='<p style="text-align:center">uds x '.$price.' €</p>';    
            }else{
                //echo "<p style='float:right'>uds x    ".$a[3]." €   </p>";
                $sal.='<p style="text-align:center"> uds x '.$a[3].' €</p>'; 
            }
            $sal.='</div>';
        }
        $sal.='<h4 style="text-align:center">Total :'.array_sum($_SESSION['total']).' €</h4>';
        $sal.='<p>Para obtener más información, consulta la Política de cambios y reembolsos y el derecho a cancelar tu suscripción en nuestro apartado de Condiciones de compra .</p>';
        $sal.='<p>Este ticket es imprescindible para cualquier cambio o devolución. Puedes presentarlo en tu dispositivo móvil o imprimirlo.</p>';
        $sal.='</div>';
        
        
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listado.pdf');

    }

    
}


