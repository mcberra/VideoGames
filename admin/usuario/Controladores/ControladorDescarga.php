<?php
    // Incluimos los ficheros que ncesitamos
    require_once $_SERVER['DOCUMENT_ROOT']."/Alum/Paths.php";
    require_once CONTROLLER_PATH."ControladorAlumno.php";
    require_once MODEL_PATH."Alumno.php";


    /**
     * Controlador de descargas
     */
class ControladorDescarga {
    
    // Configuración del servidor
    private $fichero;

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }
    
    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }

    public function descargarTXT(){
        $this->fichero = "alumnado.txt";
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

        $controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumnos("","");

        // Si hay filas (no nulo), pues mostramos la tabla
        if (!is_null($lista) && count($lista) > 0) {
            foreach ($lista as &$alumno) {
                echo "DNI: " .$alumno->getDni(). " -- Nombre: ".$alumno->getNombre(). "  -- Email: ".$alumno->getEmail(). 
                " -- Idioma: ".$alumno->getIdioma(). " -- Matricula: ".$alumno->getMatricula(). " -- Lenguaje: ".$alumno->getLenguaje(). 
                " -- Fecha: ".$alumno->getFecha()."\r\n";
        }
        }else{
            echo "No se ha encontrado datos de alumnos";
        }
    }

    public function descargarJSON(){
        $this->fichero = "alumnado.json";
        header("Content-Type: application/octet-stream");
        header('Content-type: application/json');
        //header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

        $controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumnos("","");
        $sal=[];
        foreach ($lista as $al) {
            $sal[]=$this->json_encode_private($al);
        }
        echo json_encode($sal);
    }

    private function json_encode_private($object) {
        $public = [];
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $public[$property->getName()] = $property->getValue($object);
        }
        return json_encode($public);
    }

    public function descargarXML(){
        $this->fichero = "alumnado.xml";
        $lista=$controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumnos("","");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $alumnos = $doc->createElement('alumnos');

        foreach ($lista as $a) {
            // Creamos el nodo
            $alumno = $doc->createElement('alumno');
            // Añadimos elementos
            $alumno->appendChild($doc->createElement('dni', $a->getDni()));
            $alumno->appendChild($doc->createElement('nombre', $a->getNombre()));
            $alumno->appendChild($doc->createElement('email', $a->getEmail()));
            $alumno->appendChild($doc->createElement('password', $a->getPassword()));
            $alumno->appendChild($doc->createElement('idioma', $a->getIdioma()));
            $alumno->appendChild($doc->createElement('matricula', $a->getMatricula()));
            $alumno->appendChild($doc->createElement('lenguaje', $a->getLenguaje()));
            $alumno->appendChild($doc->createElement('fecha', $a->getFecha()));
            $alumno->appendChild($doc->createElement('imagen', $a->getImagen()));

            //Insertamos
            $alumnos->appendChild($alumno);
        }

        $doc->appendChild($alumnos);
        header('Content-type: application/xml');
        //header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida
        echo $doc->saveXML();

        exit;
    }
}

?>