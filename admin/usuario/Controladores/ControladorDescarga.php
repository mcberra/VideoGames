<?php

// Incluimos los ficheros que ncesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/games/admin/usuario/Paths.php";
require_once CONTROLLER_PATH . "ControladorAlumno.php";
require_once MODEL_PATH . "Alumno.php";
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
        $usuarios = $doc->createElement('usuarios');

        foreach ($lista as $a) {
            // Creamos el nodo
            $usuario = $doc->createElement('item');
            // Añadimos elementos
            $usuario->appendChild($doc->createElement('nombre', $a->getNombre()));
            $usuario->appendChild($doc->createElement('apellido', $a->getApellido()));
            $usuario->appendChild($doc->createElement('email', $a->getEmail()));
            $usuario->appendChild($doc->createElement('telefono', $a->getTelefono()));
            $usuario->appendChild($doc->createElement('fecha', $a->getFecha()));
            $usuario->appendChild($doc->createElement('imagen', $a->getImagen()));

            //Insertamos
            $usuarios->appendChild($usuario);
        }

        $doc->appendChild($usuarios);
        header('Content-type: application/xml');
        header("Content-Disposition: attachment; filename='Usuarios.xml'"); //archivo de salida
        echo $doc->saveXML();

        exit;
    }


    public function descargarPDF(){
        $sal ='<h2 class="pull-left">Listado de usuarios</h2>';
        $lista = $controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumnos("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table border='1'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>Apellido</th>";
            $sal.="<th>Email</th>";
            //$sal.="<th>Contraseña</th>";
            $sal.="<th>Telefono</th>";
            $sal.="<th>Fecha de Registro</th>";
            $sal.="<th>Imagen</th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $usuario) {
                // Pintamos cada fila
                $sal.="<tr>";
                $sal.="<td>" . $usuario->getNombre() . "</td>";
                $sal.="<td>" . $usuario->getApellido() . "</td>";
                $sal.="<td>" . $usuario->getEmail() . "</td>";
                //$sal.="<td>" . str_repeat("*",strlen($alumno->getPassword())) . "</td>";
                $sal.="<td>" . $usuario->getTelefono() . "</td>";
                $sal.="<td>" . $usuario->getFecha() . "</td>";
                // Para sacar una imagen hay que decirle el directprio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/games/admin/usuario/imagenes/".$usuario->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>";
        } else {
            // Si no hay nada seleccionado
            $sal.="<p class='lead'><em>No se ha encontrado datos de items.</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listado.pdf');

    }
}
