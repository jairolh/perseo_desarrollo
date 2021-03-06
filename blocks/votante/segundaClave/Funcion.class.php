<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("core/builder/Mensaje.class.php");
include_once("core/crypto/Encriptador.class.php");
include_once("classes/Validador.class.php");
include_once("core/builder/FormularioHtml.class.php");

//Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
//metodos mas utilizados en la aplicacion
//Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
//en camel case precedido por la palabra Funcion

class FuncionsegundaClave {

    var $sql;
    var $funcion;
    var $lenguaje;
    var $ruta;
    var $miConfigurador;
    var $miInspectorHTML;
    var $error;
    var $miRecursoDB;
    var $crypto;
    var $validar;
    var $miFormulario;

    function verificarCampos() {
        include_once($this->ruta . "/funcion/verificarCampos.php");
        if ($this->error == true) {
            return false;
        } else {
            return true;
        }
    }

    function procesarAjax() {
        include_once($this->ruta . "/funcion/procesarAjax.php");
    }

    function redireccionar($opcion, $datos) {
        include_once($this->ruta . "/funcion/redireccionar.php");
    }

    function validarFormulario() {
        include_once($this->ruta . "/funcion/validarFormulario.php");
        return $mensaje;
    }

    function procesarSegundaClave() {
        include_once($this->ruta . "/funcion/procesarSegundaClave.php");
    }
    
    function enviarCorreo($nombre, $correo) {
        include_once($this->ruta . "/funcion/enviarCorreoClave.php");
        return $mensaje;
    }
    
    function validarPreguntas() {        
        include_once($this->ruta . "/funcion/validarPreguntas.php");
    }
    
    function regresar(){
        $this->redireccionar("regresar", '');
    }
    
    function rescatarSesion() {        
        $id_usuario=include_once($this->ruta . "/funcion/rescatarSesion.php");
        return $id_usuario;
    }

//    function mostrarMensaje($mensaje, $error) {
//        include_once($this->ruta . "/funcion/mostrarMensaje.php");
//    }

    function action() {
         
        if (isset($_REQUEST["procesarAjax"])) {
            $this->procesarAjax();
        } else {
            if ($_REQUEST["opcion"] == "segundaClave") {
                $this->procesarSegundaClave();
            }else if ($_REQUEST["opcion"] == "validarPreguntas") {
                $this->validarPreguntas();
            }else if ($_REQUEST["opcion"] == "regresar") {
                $this->regresar();
            }
        }
    }

    function __construct() {

        $this->miConfigurador = Configurador::singleton();
        $this->miInspectorHTML = InspectorHTML::singleton();
        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");
        $this->miMensaje = Mensaje::singleton();
        $this->validar = new Validador();
        $this->miFormulario = new formularioHtml();


        $conexion = "estructura";
        $this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if (!$this->miRecursoDB) {

            $this->miConfigurador->fabricaConexiones->setRecursoDB($conexion, "tabla");
            $this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        }
    }

    public function setRuta($unaRuta) {
        $this->ruta = $unaRuta;
        //Incluir las funciones
    }

    function setSql($a) {
        $this->sql = $a;
    }

    function setFuncion($funcion) {
        $this->funcion = $funcion;
    }

    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function setFormulario($formulario) {
        $this->formulario = $formulario;
    }

}

?>
