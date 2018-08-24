<?php

require_once('../class/CapturaInformacion.class.php');
require_once('../class/XML.class.php');

switch ($_POST['metodo']) { 
    
    case 'GetIdeasEval':
      XML::xmlResponse(GetIdeasEval($_POST['codigoIdea'], $_POST['Tipo']));
      break;
    case 'getCamposFormulario':
        XML::xmlResponse(getCamposFormulario());
        break;
    case 'GetConsultaIdeas':
        XML::xmlResponse(GetConsultaIdeas($_REQUEST['idColaborador']));
        break;
   case 'GetIdeasEvaluacion':
        XML::xmlResponse(GetIdeasEvaluacion());
        break;
    case 'GetIdeasEvaluadas':
        XML::xmlResponse(GetIdeasEvaluadas());
        break;
    case 'GetMensaje':
      XML::xmlResponse(GetMensaje($_POST['codigoIdea'], $_POST['Tipo']));
      break;
    case 'GetHistoricoIdeas':
        XML::xmlResponse(GetHistoricoIdeas($_REQUEST['codigoIdea'],$_REQUEST['Tipo']));
        break;
     case 'BuscarIdeas':
        XML::xmlResponse(BuscarIdeas($_POST['TipoBusqueda'], $_POST['CampoBusqueda']
        ));
        break;
    case 'guardarDatosBasicosIdea':
        XML::xmlResponse(guardarDatosBasicosIdea($_REQUEST['NombreCol'], $_REQUEST['CedulaCol'], $_REQUEST['ProcesoCol'], $_REQUEST['CorreoCol'], $_REQUEST['JefeCol'], $_REQUEST['TelefonoCol']));
        break;
    case 'guardarDatosIdea':
        XML::xmlResponse(guardarDatosIdea($_REQUEST['CodigoIdea'], $_REQUEST['NombreCol'], $_REQUEST['CedulaCol'], $_REQUEST['ProcesoCol'], $_REQUEST['CorreoCol'], $_REQUEST['JefeCol'], $_REQUEST['TelefonoCol'],$_REQUEST['focoOfertaValor'],$_REQUEST['focoExplotaFuncion'],$_REQUEST['focoEstrategiaPropia'],$_REQUEST['focoAseguraProcesos'],$_REQUEST['NombreIdea'],$_REQUEST['DescripcionIdea'],$_REQUEST['AportaReto'],$_REQUEST['GradoNovedad'],$_REQUEST['getDatosDesarrollos'],$_REQUEST['Diagrama']));
        break;
     case 'guardarDatosRetos':
        XML::xmlResponse(guardarDatosRetos($_REQUEST['NombreReto'], $_REQUEST['Sponsor'], $_REQUEST['LiderReto'], $_REQUEST['Proponentes'],  $_REQUEST['CorreoCol'],$_REQUEST['Colaborador'],$_REQUEST['Definicion'], $_REQUEST['SituacionActual'], $_REQUEST['getDatosValoracion'],$_REQUEST['getEquipoTrabajo'],$_REQUEST['getDatosDesarrollosRetos']));
        break;
    case 'guardarDatosTabla':
        XML::xmlResponse(guardarDatosTabla($_REQUEST['array_fase'],$_REQUEST['$array_descripcion']));
        break;
    case 'guardarEvaluacion':
        XML::xmlResponse(guardarEvaluacion($_REQUEST['CodigoIdea'],$_REQUEST['Tipo'],$_REQUEST['CodigoEvaluacion'],$_REQUEST['NombreEvaluador'], $_REQUEST['FocosInnovación'], $_REQUEST['IdeaClara'], $_REQUEST['Ideaespecifica'], $_REQUEST['ComprendeElementos'], $_REQUEST['DefinicionFinal'], $_REQUEST['Observaciones']));
        break;
    case 'guardarEvaluacionHistorial':
        XML::xmlResponse(guardarEvaluacionHistorial($_REQUEST['CodigoIdea'],$_REQUEST['Tipo'], $_REQUEST['DefinicionFinal'],$_REQUEST['NombreEvaluador'], $_REQUEST['Observaciones']));
        break;
    case 'getDatosIdea':
      XML::xmlResponse(getDatosIdea($_REQUEST['idIdea']));
      break;
  
       case 'getDatosRetos':
      XML::xmlResponse(getDatosRetos($_REQUEST['idReto']));
      break;
    
    case 'getDesarrollosIdeas':
        XML::xmlResponse(getDesarrollosIdeas($_POST['idIdea']
        ));
        break;
     case 'getValoracionReto':
        XML::xmlResponse(getValoracionReto($_POST['idReto']
        ));
        break;
     
    case 'getEquipoTrabajoReto':
        XML::xmlResponse(getEquipoTrabajoReto($_POST['idReto']
        ));
        break;
    case 'getFasesPropuestaReto':
        XML::xmlResponse(getFasesPropuestaReto($_POST['idReto']
        ));
        break;
    case 'getFormularios':
        XML::xmlResponse(getFormularios());
        break;
    case 'cambiarEstadoFormulario':
        XML::xmlResponse(cambiarEstadoFormulario($_POST));
        break;
    default :
        echo 'No se ejecuto la función';
        break;
}


function GetConsultaIdeas($idColaborador) {
    $captura = new CapturaInformacion();
    $data = $captura->GetConsultaIdeas($idColaborador);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < sizeof($data); $i++) {
            
            $xml .= "<registro 
                    Codigo='" . $data[$i]['Codigo'] . "'
                    FechaRadicacion='" . $data[$i]['FechaRadicacion'] . "'
                    Tipo='" . $data[$i]['Tipo'] . "'
                    Colaborador='" .utf8_encode($data[$i]['Colaborador']) . "'
                    Cedula='" . $data[$i]['Cedula'] . "'
                    NombreIdea='" .utf8_encode($data[$i]['NombreIdea']) . "'
                    Estado='" . utf8_encode($data[$i]['Estado']) . "'
                    ></registro>";
            
        }
    } else {
        $xml = '<registro>NOEXITOSO</registro>';
    }
    return $xml;
    
}
function GetIdeasEvaluacion() {
    $captura = new CapturaInformacion();
    $data = $captura->GetIdeasEvaluacion();
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < sizeof($data); $i++) {
            $xml .= "<registro 
                    Codigo='" . $data[$i]['Codigo'] . "'
                    Tipo='" . $data[$i]['Tipo'] . "'
                    FechaRadicacion='" . $data[$i]['FechaRadicacion'] . "'
                    NombreIdea='" . $data[$i]['NombreIdea'] . "'
                    ></registro>";
            
        }
    } else {
        $xml = '<registro>NOEXITOSO</registro>';
    }
    return $xml;  
}
function getDatosIdea($idIdea) {
  $captura = new CapturaInformacion();
  $data = $captura->getDatosIdea($idIdea);
  $xml = '';
  if (sizeof($data) > 0) {
 for ($i = 0; $i < sizeof($data); $i++) {     
  $xml .= "<registro
  NombreCol='" . utf8_encode($data[$i]['NombreCol']) . "'
  CedulaCol='" . utf8_encode($data[$i]['CedulaCol']) . "'
  ProcesoCol='" . utf8_encode($data[$i]['ProcesoCol']) . "'
  CorreoCol='" . utf8_encode($data[$i]['CorreoCol']) . "'
  JefeCol='" . utf8_encode($data[$i]['JefeCol']) . "'
  TelefonoCol='" . utf8_encode($data[$i]['TelefonoCol']) . "'
  focoOfertaValor='" . utf8_encode($data[$i]['focoOfertaValor']) . "'
  focoExploFuncio='" . utf8_encode($data[$i]['focoExploFuncio']) . "'
  focoEstrategiaPropia='" . utf8_encode($data[$i]['focoEstrategiaPropia']) . "'
  focoAseguraProcesos='" . utf8_encode($data[$i]['focoAseguraProcesos']) . "'
  NombreIdea='" . utf8_encode($data[$i]['NombreIdea']) . "'
  descripcionIdea='" . utf8_encode($data[$i]['descripcionIdea']) . "'
  aportaReto='" . utf8_encode($data[$i]['aportaReto']) . "'
  gradoNovedad='" . utf8_encode($data[$i]['gradoNovedad']) . "'
  diagrama='" . utf8_encode($data[$i]['diagrama']) . "'
  ></registro>";
   }
  } else 
  {
  $xml = '<registro>NOEXITOSO</registro>';
  }
  return $xml;
  } 
  
  function getDatosRetos($idReto) {
  $captura = new CapturaInformacion();
  $data = $captura->getDatosRetos($idReto);
  $xml = '';
  if (sizeof($data) > 0) {
 for ($i = 0; $i < sizeof($data); $i++) {     
  $xml .= "<registro    
  Nombre='" . utf8_encode($data[$i]['Nombre']) . "'
  Sponsor='" . utf8_encode($data[$i]['Sponsor']) . "'
  Lider='" . utf8_encode($data[$i]['Lider']) . "'
  Correo='" . utf8_encode($data[$i]['Correo']) . "'
  Proponentes='" . utf8_encode($data[$i]['Proponentes']) . "'
  Definicion='" . utf8_encode($data[$i]['Definicion']) . "'
  SituacionActual='" . utf8_encode($data[$i]['SituacionActual']) . "'
  ></registro>";
   }
  } else 
  {
  $xml = '<registro>NOEXITOSO</registro>';
  }
  return $xml;
  } 
 
  //controla los datos que se generan en suscripción de Ideas
function getDesarrollosIdeas($idIdea) {
    $captura = new CapturaInformacion();
    $data = $captura->getDesarrollosIdeas($idIdea);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
            $xml .= "<registro                 
                           di_id_pk='" . utf8_encode(ltrim(rtrim($data[$i]['di_id_pk']))) . "'
                           di_fase='" . utf8_encode(ltrim(rtrim($data[$i]['di_fase']))) . "'
                           di_descripcion='" . utf8_encode(ltrim(rtrim($data[$i]['di_descripcion']))) . "'                              
                           di_inicio='" . utf8_encode(ltrim(rtrim($data[$i]['di_inicio']))) . "'                              
                           di_fin='" . utf8_encode(ltrim(rtrim($data[$i]['di_fin']))) . "'                              
                           di_responsable='" . utf8_encode(ltrim(rtrim($data[$i]['di_responsable']))) . "'                                                           
                    ></registro>";
        }
    } else {
        $xml = "<registro>NOEXITOSO</registro>";
    }
    return $xml;
}  

 //controla los datos que se generan en factores de valoracion - Retos
function getValoracionReto($idReto) {
    $captura = new CapturaInformacion();
    $data = $captura->getValoracionReto($idReto);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
            $xml .= "<registro                 
                           Indicador='" . utf8_encode(ltrim(rtrim($data[$i]['Indicador']))) . "'
                           Descripcion='" . utf8_encode(ltrim(rtrim($data[$i]['Descripcion']))) . "'                              
                           Forma='" . utf8_encode(ltrim(rtrim($data[$i]['Forma']))) . "'                              
                           Meta='" . utf8_encode(ltrim(rtrim($data[$i]['Meta']))) . "' 
                           Umbral='" . utf8_encode(ltrim(rtrim($data[$i]['Umbral']))) . "'
                           Tiempo='" . utf8_encode(ltrim(rtrim($data[$i]['Tiempo']))) . "'   
                           fuente='" . utf8_encode(ltrim(rtrim($data[$i]['fuente']))) . "'                                                           
                    ></registro>";
        }
    } else {
        $xml = "<registro>NOEXITOSO</registro>";
    }
    return $xml;
}  

function getEquipoTrabajoReto($idReto) {
    $captura = new CapturaInformacion();
    $data = $captura->getEquipoTrabajoReto($idReto);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
            $xml .= "<registro
                        Reto='" . utf8_encode(ltrim(rtrim($data[$i]['Reto']))) . "'
                        Persona_rol='" . utf8_encode(ltrim(rtrim($data[$i]['Persona_rol']))) . "'
                        Proceso='" . utf8_encode(ltrim(rtrim($data[$i]['Proceso']))) . "'
                        Dedicacion='" . utf8_encode(ltrim(rtrim($data[$i]['Dedicacion']))) . "'
                        Justificacion='" . utf8_encode(ltrim(rtrim($data[$i]['Justificacion']))) . "'
                    ></registro>";
        }
    } else {
        $xml = "<registro>NOEXITOSO</registro>";
    }
    return $xml;
}

function getFasesPropuestaReto($idReto) {
    $captura = new CapturaInformacion();
    $data = $captura->getFasesPropuestaReto($idReto);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
            $xml .= "<registro
                        Reto='" . utf8_encode(ltrim(rtrim($data[$i]['Reto']))) . "'
                        Fase='" . utf8_encode(ltrim(rtrim($data[$i]['Fase']))) . "'
                        Descripcion='" . utf8_encode(ltrim(rtrim($data[$i]['Descripcion']))) . "'
                        Inicio='" . utf8_encode(ltrim(rtrim($data[$i]['Inicio']))) . "'
                        Fin='" . utf8_encode(ltrim(rtrim($data[$i]['Fin']))) . "'
                        Responsable='" . utf8_encode(ltrim(rtrim($data[$i]['Responsable']))) . "'
                    ></registro>";
        }
    } else {
        $xml = "<registro>NOEXITOSO</registro>";
    }
    return $xml;
}
  
function GetIdeasEval($codigoIdea, $tipo) {
    $captura = new CapturaInformacion();
    $data = $captura->GetIdeasEval($codigoIdea, $tipo);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < sizeof($data); $i++) {
            $xml .= "<registro 
                    CodigoEvaluacion='" .  utf8_decode($data[$i]['codigoEvaluacion']) . "'
                    NombreEvaluador='" .  utf8_decode($data[$i]['NombreEvaluador']) . "'
                    Fecha='".utf8_decode($data[$i]['Fecha'])."'
                    FocoInnova='" . utf8_decode($data[$i]['FocoInnova']) . "'
                    IdeaClara='" .utf8_decode($data[$i]['IdeaClara']). "'
                    SolucEspeci='" .utf8_decode($data[$i]['SolucEspeci']). "'
                    AsocObjet='" .utf8_decode($data[$i]['AsocObjet']). "'
                    EstadoDef='" .utf8_decode($data[$i]['EstadoDef']). "'
                    Observa='" . utf8_decode($data[$i]['Observa']). "'
                    ></registro>";
            
        }
    } else {
        $xml = '<registro>NOEXITOSO</registro>';
    }
    return $xml;    
}

function GetIdeasEvaluadas() {
    $captura = new CapturaInformacion();
    $data = $captura->GetIdeasEvaluadas();
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < sizeof($data); $i++) {
            
            $xml .= "<registro 
                    Codigo='" . $data[$i]['Codigo'] . "'
                    Tipo='" . $data[$i]['Tipo'] . "'
                    FechaRadicacion='" . $data[$i]['FechaRadicacion'] . "'
                    Colaborador='" . $data[$i]['Colaborador'] . "'
                    Cedula='" . $data[$i]['Cedula'] . "'
                    NombreIdea='" . $data[$i]['NombreIdea'] . "'
                    Estado='" . $data[$i]['Estado'] . "'
                    ></registro>";
            
        }
    } else {
        $xml = '<registro>NOEXITOSO</registro>';
    }
    return $xml;
}
function GetHistoricoIdeas($codigoIdea,$Tipo) {
    $captura = new CapturaInformacion();
    $data = $captura->GetHistoricoIdeas($codigoIdea,$Tipo);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < sizeof($data); $i++) {
            
            $xml .= "<registro 
                    Codigo='" . $data[$i]['Codigo'] . "'
                    FechaModifica='" . $data[$i]['FechaModifica'] . "'
                    Evaluador='" . $data[$i]['Evaluador'] . "'
                    Estado='" . $data[$i]['Estado'] . "'
                    observa='" . $data[$i]['observa'] . "'
                    ></registro>";
            
        }
    } else {
        $xml = '<registro>NOEXITOSO</registro>';
    }
    return $xml;
}

function GetMensaje($codigoIdea,$Tipo) {
    $captura = new CapturaInformacion();
    $data = $captura->GetMensaje($codigoIdea,$Tipo);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < sizeof($data); $i++) {
            
            $xml .= "<registro 
                   Cuerpo='" . $data . "'
                    ></registro>";
            
        }
    } else {
        $xml = '<registro>NOEXITOSO</registro>';
    }
    return $xml;
}


//consulta de filtros de Ideas y Retos
function BuscarIdeas($TipoBusqueda, $CampoBusqueda) {
    $captura = new CapturaInformacion();
    $data = $captura->BuscarIdeas($TipoBusqueda, $CampoBusqueda);
    $xml = '';
    if (sizeof($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
               $xml .= "<registro 
                    Codigo='" . $data[$i]['Codigo'] . "'
                    FechaRadicacion='" . $data[$i]['FechaRadicacion'] . "'
                    Tipo='" . $data[$i]['Tipo'] . "'
                    Colaborador='" . $data[$i]['Colaborador'] . "'
                    Cedula='" . $data[$i]['Cedula'] . "'
                    NombreIdea='" . $data[$i]['NombreIdea'] . "'
                    Estado='" . $data[$i]['Estado'] . "'
                    ></registro>";
        }
    } else {
        $xml = "<registro>NOEXITOSO</registro>";
    }
    return $xml;
}


function guardarDatosIdea($CodigoIdea, $NombreCol, $CedulaCol, $ProcesoCol, $CorreoCol, $JefeCol, $TelefonoCol,$focoOfertaValor, $focoExplotaFuncion, $focoEstrategiaPropia ,$focoAseguraProcesos,$NombreIdea, $DescripcionIdea,$AportaReto,$GradoNovedad,$getDatosDesarrollos,$Diagrama) {
    $captura = new CapturaInformacion();
    $data = $captura->guardarDatosIdea($CodigoIdea, $NombreCol, $CedulaCol, $ProcesoCol, $CorreoCol, $JefeCol, $TelefonoCol,$focoOfertaValor, $focoExplotaFuncion, $focoEstrategiaPropia ,$focoAseguraProcesos,$NombreIdea, $DescripcionIdea,$AportaReto,$GradoNovedad,$getDatosDesarrollos,$Diagrama);
    $xml = "<registro  Id_Idea = '" . $data . "'>Exitoso</registro>";
    return $xml;
}

function guardarDatosRetos($NombreReto, $Sponsor, $LiderReto, $Proponentes, $CorreoCol,$Colaborador, $Definicion, $SituacionActual, $getDatosValoracion,$getEquipoTrabajo,$getDatosDesarrollosRetos) {
    $captura = new CapturaInformacion();
    $data = $captura->guardarDatosRetos($NombreReto, $Sponsor, $LiderReto, $Proponentes, $CorreoCol,$Colaborador, $Definicion, $SituacionActual, $getDatosValoracion,$getEquipoTrabajo,$getDatosDesarrollosRetos);
    $xml = "<registro  Id_Reto = '" . $data . "'>Exitoso</registro>";
    return $xml;
}
function guardarDatosTabla($array_fase,$array_descripcion) {
    $captura = new CapturaInformacion();
    $data = $captura->guardarDatosTabla($array_fase,$array_descripcion);
    $xml = "<registro>Exitoso</registro>";
    return $xml;
}


function guardarEvaluacion($CodigoIdea, $tipo, $CodigoEvaluacion, $NombreEvaluador, $FocosInnovación, $IdeaClara, $Ideaespecifica, $ComprendeElementos, $DefinicionFinal, $Observaciones) {
    $captura = new CapturaInformacion();
    $data = $captura->guardarEvaluacion($CodigoIdea, $tipo, $CodigoEvaluacion, $NombreEvaluador,$FocosInnovación, $IdeaClara, $Ideaespecifica, $ComprendeElementos, $DefinicionFinal, $Observaciones);
    $xml = "<registro>Exitoso</registro>";
    return $xml;
}
function guardarEvaluacionHistorial($CodigoIdea,$Tipo,$DefinicionFinal, $NombreEvaluador,$Observaciones) {
    $captura = new CapturaInformacion();
    $data = $captura->guardarEvaluacionHistorial($CodigoIdea,$Tipo,$DefinicionFinal, $NombreEvaluador,$Observaciones);
    $xml = "<registro>Exitoso</registro>";
    return $xml;
}
//function getCamposFormulario() {
//    $captura = new CapturaInformacion();
//    $data = $captura->getCamposFormulario();
//    $xml = "";
//    if (strlen($data) > 0) {
//         $xml .= '<registro>'.$data.'</registro>';
//    } else {
//        $xml = '<registro>NOEXITOSO</registro>';    
//    }
//    return $xml;
//}

if(isset($_REQUEST["guardar"]))
{
    $array_fase=$_POST['fase'];
    $array_descripcion=$_POST['proceso'];
    $array_fec_inicio=$_POST['inicioReto'];
    $array_fec_fin=$_POST['finReto'];
    $array_responsable=$_POST['responsable'];
    
    foreach ($array_fase as $i => $t) {
        echo $array_fase[$i]." - ".$array_descripcion ." - ".$array_responsable;
    }
}
                        
 function getFormularios() {
    $captura = new CapturaInformacion();
    $data = $captura->getFormulariosIdeas();
    $xml = "<registro>NOEXITOSO</registro>";
    foreach ($data as $i => $_data) {
        if ($i == 0)
            $xml = "";
        
        $xml .= "<registro 
                    id_formulario = '" . utf8_encode(trim($_data['id_formulario'])) . "'
                    fo_nombre = '" . utf8_encode(trim($_data['fo_nombre'])) . "'
                    fo_estado = '" . utf8_encode(trim($_data['fo_estado'])) . "'
                    fo_fecha_mod = '" . utf8_encode(trim($_data['fo_fecha_mod'])) . "'
                    usuario_mod = '" . utf8_encode(trim($_data['usuario_mod'])) . "'
                ></registro>";
    }
    return $xml;
}

function cambiarEstadoFormulario($post) {
    $captura = new CapturaInformacion();
    $data = $captura->cambiarEstadoFormulario($post);
    $xml = "<registro>NOEXITOSO</registro>";
}

?>
