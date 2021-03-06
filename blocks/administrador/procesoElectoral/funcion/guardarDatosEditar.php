<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
	 
	$miSesion = Sesion::singleton();
	
	$usuarioSoporte = $miSesion->getSesionUsuarioId(); 
	 
	$conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $dependencias = $_REQUEST['dependencias'];
        
        if(is_array($dependencias))
            {
                $depResponsable = "{";
                for ($i=0;$i<count($dependencias);$i++)    
                {
                    if(($i + 1) == count($dependencias))
                        {
                            $depResponsable .= $dependencias[$i];
                        }else
                            {
                                $depResponsable .= $dependencias[$i].",";
                            }
                }
                $depResponsable .= "}";
            }
        
	$arregloDatos = array($_REQUEST['nombreProceso'],
                              $_REQUEST['descripcion'],
                              $_REQUEST['fechaInicio'],
                              $_REQUEST['fechaFin'],
                              $_REQUEST['tipoacto'],
                              $_REQUEST['numeacto'],
                              $_REQUEST['fechaacto'],
                              $_REQUEST['cantelecciones'],
                              $depResponsable,
                              $_REQUEST['tipovotacion'],
                              $_REQUEST['proceso']);
	
	$this->cadena_sql = $this->sql->cadena_sql("actualizarProceso", $arregloDatos);
	$resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
        if($resultadoEstado)
	{	
            $idProceso=$esteRecursoDB->ultimo_insertado();
            $arregloPasa = array($_REQUEST['proceso'],$_REQUEST['nombreProceso']);
            $this->funcion->redireccionar('actualizo',$arregloPasa);
	}else
	{
		$this->funcion->redireccionar('noActualizo',$_REQUEST['nombreProceso']);
	}



}
?>