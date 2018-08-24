<?php

date_default_timezone_set('America/Bogota');
require_once 'SQLServerDatabase.class.php';
set_time_limit(90000);

class CapturaInformacion {

    var $database;
    public function __construct() {
        $this->database= new SQLServerDatabase();
    }
    public function identificar($usuario,$password){
        $sql = "select nombre as nombre,pass as pass from usuario where estado=1 and nombre= '".$usuario."' and pass= '".$password."';";
        $data = $this->database->query(utf8_decode($sql));
         $user = ($data[0]['nombre']);
         $contraseña=($data[0]['pass']);
         if($user==$usuario && $contraseña==$password){
             Return true;
        }else{
            return false;
        }
    }
    public function getDatosUsuario($_usuario) {
        $sql="SELECT nombre,perfil,estado from usuario WHERE nombre='".$_usuario."';";
        $data = $this->database->query(utf8_decode($sql));
        return $data;
    }
    
//    public function getDatosIdea($idIdea) {
//        if (empty($idIdea)){
//            $idIdea=0;
//        }
//        $sql = "select id_codigo_idea,id_NombreCol as 'NombreCol',id_CedulaCol as 'CedulaCol',
//	id_ProcesoCol as 'ProcesoCol',id_CorreoCol as 'CorreoCol',id_JefeCol as 'JefeCol',id_TelefonoCol as 'TelefonoCol',
//        id_foco_oferta_valor as 'focoOfertaValor', id_foco_explo_funci as 'focoExploFuncio',id_foco_estra_prop as 'focoEstrategiaPropia',
//	id_foco_aseg_proc as 'focoAseguraProcesos', id_nombre_idea as 'NombreIdea',id_descripcion_idea as  'descripcionIdea',
//	id_aporta_reto as 'aportaReto',id_grado_novedad 'gradoNovedad', id_archivo 'diagrama'
//	from Ideas where id_codigo_idea= " . $idIdea .
//        " order by id_codigo_idea desc";
//        $data = $this->database->query(utf8_decode($sql));
//        return $data;
//    }
//    
//      public function getDatosRetos($idReto) {
//        if (empty($idReto)){
//            $idReto=0;
//        }
//        $sql = "select re_nombre_reto 'Nombre',re_sponsor 'Sponsor',re_lider_reto 'Lider',
//                re_proponentes 'Proponentes',re_correo 'Correo',re_definicion 'Definicion',re_situacion_actual 'SituacionActual'
//                from Retos
//                where id_Reto_pk= ".$idReto."	
//                order by id_Reto_pk desc";
//        //echo $sql;
//        $data = $this->database->query(utf8_decode($sql));
//        return $data;
//    }
    

  
      public function GetIdeasEval($codigoIdea, $tipo) {
          if ($tipo == "Idea") {
              $campo = "ev_codigo_Idea";
          } else {
              $campo = "ev_codigo_Reto";
          }
          
      $sql = "SELECT ev_Codigo_Evaluacion 'CodigoEvaluacion',ev_nombre_Evaluador as 'NombreEvaluador',ev_Fecha_Evaluacion as 'Fecha',ev_Foco_Innova 'FocoInnova',ev_Idea_Clara as 'IdeaClara',
	ev_Solucion_Especifica as 'SolucEspeci',ev_Asoc_Objetivo as 'AsocObjet',ev_Codigo_Def_Final as 'EstadoDef',
	ev_Observaciones as 'Observa'
	from Evaluacion_Ideas  where $campo=".$codigoIdea."
	order by ev_Codigo_Evaluacion desc";
      $data = $this->database->query(utf8_decode($sql));
      return $data;
      }
      
    public function GetMensaje($codigoIdea, $tipo) {
          if ($tipo == "Idea") {
            $mensaje="";
            $sql = "select i.id_codigo_idea,i.id_NombreCol as 'Nombre', ep.df_Mensaje 'Mensaje',ep.contenido 'Contenido'
                          from Ideas i,EstadosPropuesta ep
                          Where i.id_codigo_idea=" . $codigoIdea . " and ep.df_codigo_Estado=6";

            $data = $this->database->query(utf8_decode($sql));
            for ($i = 0; $i < count($data); $i++) {
                $asunto = "Código Idea $codigoIdea";
                $nomUsuario = $data[$i]['Nombre'];
                $mensajeEncabezado = $data[$i]['Mensaje'];
                $contenido = $data[$i]['Contenido'];
            }
            $mensaje = "Hola " . $nomUsuario . ",<br><br>";
            $mensaje .= $mensajeEncabezado . "<br><br>";
            $mensaje .= $contenido . "<br>";
            $mensaje = str_replace("<br>", "\r", $mensaje);
            $mensaje = str_replace("#cod_idea#", $codigoIdea, $mensaje);

            return utf8_encode($mensaje);
        } 
            else {
            $mensaje="";
            $sql = "select r.id_Reto_pk,r.re_nombre_reto as 'Nombre', ep.df_Mensaje 'Mensaje',ep.contenido 'Contenido'
                          from Retos r,EstadosPropuesta ep
                          Where r.id_Reto_pk=" . $codigoIdea. " and ep.df_codigo_Estado=6";
            $data = $this->database->query(utf8_decode($sql));             
            for ($i = 0; $i < count($data); $i++) {
                $asunto = "Código Reto $codigoIdea";
                $nomUsuario = $data[$i]['Nombre'];
                $mensajeEncabezado = $data[$i]['Mensaje'];
                $contenido = $data[$i]['Contenido'];
            }

            $mensaje = "Hola,<br /><br />";
            $mensaje .= $mensajeEncabezado . "<br />";
            $mensaje .= $contenido . "<br />";

            $mensaje = str_replace("<br />", "\n", $mensaje);
            $mensaje = str_replace("#cod_idea#", $codigoIdea, $mensaje);

            return utf8_encode($mensaje);
        }
         
      }
 
    public function getMenuCompleto($perfil, $usuario) {
          $sql = "select  idmenu as codigo, padre as padre,tipoOpcion as tipo, 
                                                    nombremenu as nombre, accion as accion
                                                    from Menus where perfil = '" . $perfil . "'
                                                    AND  ltrim(rtrim(padre)) = '' AND estado = '1'
                                                    order by idmenu";
        $menus= $this->database->query(utf8_decode($sql));
        $menu = '';
        if (sizeof($menus) > 0) {
            for ($i = 0; $i < count($menus); $i++) {
                $menu .= '<li  id="' . $menus[$i]['codigo'] . '">';
                if ($menus[$i]['tipo'] == 'M') {
//                    $menu .= '<li class="treeview">
//                                    <a href="#">
//                                        <i class="fa ' . $menus[$i]['me_icono'] . '"></i>
//                                        <span>' . $menus[$i]['nombre'] . '</span>
//                                        <i class="fa fa-angle-left pull-right"></i>
//                                    </a>';
                     $menu .= '<li class="treeview">
                                    <a href="#">
                                        <span>' . $menus[$i]['nombre'] . '</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>';

//                    $hijos = "select  a.me_codigo as codigo, a.me_idPadre as padre, a.me_tipoOpcion as tipo, 
//                                                                    a.me_nombre as nombre, a.me_accion as accion, a.me_parametro as param
//                                                    from " . $this->baseUsuarios . "[menu_UEN] as a
//                                                    INNER JOIN " . $this->baseUsuarios . "[permiso_campañas] as b ON a.me_codCampa = b.cod_campa and 
//                                                                                                     a.me_codigo = b.cod_menu and 
//                                                                                                     b.cod_perfil = '" . $perfil . "'
//                                                                                                     LEFT JOIN [App_Innovacion].[dbo].[formularios] f
//                                                                                                     on f.codigo_menuUEN=a.me_codigo collate database_default
//                                                    where a.me_codCampa = '" . $this->codigo_campana . "' AND a.me_idPadre = '" . $menus[$i]['codigo'] . "' AND a.me_estado = '1'
//                                                     and (f.fo_estado is NULL or f.fo_estado=1) order by a.me_codigo";    
                    $hijos="select  idmenu as codigo, padre as padre,tipoOpcion as tipo, 
                                                    nombremenu as nombre, accion as accion
                                                    from Menus where perfil = '" . $perfil . "'"
                            . "                     AND padre='".$menus[$i]['codigo']."' AND estado=1 order by idmenu";
                    $submenus = $this->database->query(utf8_decode($hijos));
                    if (sizeof($submenus) > 0) {
                        $menu .= '<ul class="treeview-menu">';
                        for ($j = 0; $j < count($submenus); $j++) {
                            $menu .= '<li  id="' . $submenus[$j]['codigo'] . '">';
                            if ($submenus[$j]['tipo'] == 'P') {
                                $menu .= '<a href="' . utf8_encode(trim($submenus[$j]['accion'])) . ' ?asesor=' . $usuario . '" target="centerframe"><i class="fa fa-angle-double-right"></i>' . utf8_encode(trim($submenus[$j]['nombre'])) . '</a>';
                            }

                            $menu .= "</li>";
                        }
                        $menu .= "</ul>";
                    }
               } else {
                    $menu .= '<li><a target="centerframe" href="' . utf8_encode(trim($menus[$i]['accion'])) . '">
                                        <i class="fa ' . utf8_encode(trim($menus[$i]['me_icono'])) . '"></i> <span>' . utf8_encode(trim($menus[$i]['nombre'])) . '</span>
                                    </a></li>';
                }
            }
        } else {
            $menu = '';
        }


        return $menu;
    }

   
    public function BuscarIdeas($TipoBusqueda, $CampoBusqueda) {
        $CampoBusqueda = $this->QuitarSignos($CampoBusqueda);
        switch ($TipoBusqueda) {
            case 1:
                $sql = "select a.id_codigo_idea as 'Codigo',ev.ev_Fecha_Evaluacion as 'FechaRadicacion',a.id_NombreCol as 'Colaborador',
                                    a.id_cedulaCol as 'Cedula',a.id_nombre_idea  as 'NombreIdea',ep.df_nombre as 'Estado'
                                    from Ideas a inner join Evaluacion_Ideas ev on
                                    a.id_codigo_idea= ev.ev_codigo_Idea
                                    inner join  EstadosPropuesta ep on
                                    ev.ev_Codigo_Def_Final=ep.df_codigo_Estado
                                     where a.id_cedulaCol ='" . $CampoBusqueda . "'";
                break;
            case 2:
                $sql = "if (select count(*) from (select a.id_codigo_idea as 'Codigo',ev.ev_Fecha_Evaluacion as 'FechaRadicacion','Idea' 'Tipo',a.id_NombreCol as 'Colaborador',
                                    a.id_cedulaCol as 'Cedula',a.id_nombre_idea  as 'NombreIdea',case(ep.df_nombre)
									when 'null' then 'sin Evaluacion'else ep.df_nombre end  'Estado'
                                    from Ideas a inner join Evaluacion_Ideas ev on
                                    a.id_codigo_idea= ev.ev_codigo_Idea
                                    inner join  EstadosPropuesta ep on
                                    ev.ev_Codigo_Def_Final=ep.df_codigo_Estado
									where a.id_codigo_idea =" . $CampoBusqueda . ") as consulta)<> 0
									begin
									select a.id_codigo_idea as 'Codigo',ev.ev_Fecha_Evaluacion as 'FechaRadicacion','Idea' 'Tipo',a.id_NombreCol as 'Colaborador',
                                                                        a.id_cedulaCol as 'Cedula',a.id_nombre_idea  as 'NombreIdea',case(ep.df_nombre)
									when 'null' then 'sin Evaluacion'else ep.df_nombre end  'Estado'
                                                                        from Ideas a inner join Evaluacion_Ideas ev on
                                                                         a.id_codigo_idea= ev.ev_codigo_Idea
                                                                         inner join  EstadosPropuesta ep on
                                                                         ev.ev_Codigo_Def_Final=ep.df_codigo_Estado
									where a.id_codigo_idea =" . $CampoBusqueda . "
									end
									else
									begin
									select top 1  a.id_codigo_idea as 'Codigo',a.id_fecha_radica as 'FechaRadicacion','Idea' 'Tipo',a.id_NombreCol as 'Colaborador',
                                    a.id_cedulaCol as 'Cedula',a.id_nombre_idea  as 'NombreIdea','Pendiente por Evaluación' as 'Estado'
                                    from Ideas a,Evaluacion_Ideas ev,EstadosPropuesta ep where a.id_codigo_idea=" . $CampoBusqueda . " order by FechaRadicacion
									end";
                break;
            case 3:
                $sql = "if (select count(*) from (SELECT id_Reto_pk as 'Codigo',re_fecha as 'FechaRadicacion','Reto' 'Tipo',re_proponentes as 'Colaborador',
                                    re_nombre_reto as 'NombreIdea',ep.df_nombre as 'Estado'
                                    from retos r inner join Evaluacion_Ideas ev on
                                     r.id_Reto_pk= ev.ev_Codigo_Reto
                                     inner join  EstadosPropuesta ep on
                                    ev.ev_Codigo_Def_Final=ep.df_codigo_Estado
                                    where r.id_Reto_pk=" . $CampoBusqueda . ") as consulta)<> 0
									begin
									SELECT id_Reto_pk as 'Codigo',re_fecha as 'FechaRadicacion','Reto' 'Tipo',re_proponentes as 'Colaborador',
                                    re_nombre_reto as 'NombreIdea',ep.df_nombre as 'Estado'
                                    from retos r inner join Evaluacion_Ideas ev on
                                     r.id_Reto_pk= ev.ev_Codigo_Reto
                                     inner join  EstadosPropuesta ep on
                                    ev.ev_Codigo_Def_Final=ep.df_codigo_Estado
                                    where r.id_Reto_pk=" . $CampoBusqueda . "
									end
									else
									begin
									print 'No hay'
									SELECT top 1 id_Reto_pk as 'Codigo',re_fecha as 'FechaRadicacion','Reto' 'Tipo',re_proponentes as 'Colaborador',
                                    re_nombre_reto as 'NombreIdea','Pendiente por Evaluación' as 'Estado'
                                    from retos r,Evaluacion_Ideas ev,EstadosPropuesta ep where id_Reto_pk=" . $CampoBusqueda . " order by FechaRadicacion 
                                     end";
                    ;
                break;
        }
 
        $data = $this->database->query(utf8_decode($sql));

        return $data;
    }
    public function GetConsultaIdeas($idColaborador) {
        $sql = "(select
                a.id_codigo_idea as 'Codigo',
				a.id_fecha_radica as 'FechaRadicacion',
				'Idea' 'Tipo',
				a.id_NombreCol as 'Colaborador',
				a.id_CedulaCol as 'Cedula',
				a.id_nombre_idea as 'NombreIdea',
				ep.df_nombre as 'Estado'
                
            from
                Ideas a inner join Evaluacion_Ideas ev
				on a.id_codigo_idea=ev.ev_codigo_Idea
				inner join  EstadosPropuesta ep on
                ev.ev_Codigo_Def_Final=ep.df_codigo_Estado
    union all
					select distinct a.id_codigo_idea as 'Codigo',
					a.id_fecha_radica as 'FechaRadicacion',
					'Idea' 'Tipo',
					 a.id_NombreCol as 'Colaborador',
					 a.id_cedulaCol as 'Cedula',
					 a.id_nombre_idea  as 'NombreIdea',
					 'Pendiente por Evaluación' as 'Estado'
                      from Ideas a
				where a.id_codigo_idea not in(
				select
                             a.id_codigo_idea as 'Codigo'
                    from
                                 Ideas a inner join Evaluacion_Ideas ev
				on a.id_codigo_idea=ev.ev_codigo_Idea
				inner join  EstadosPropuesta ep on
                ev.ev_Codigo_Def_Final=ep.df_codigo_Estado))
    union all
         (SELECT r.id_Reto_pk as 'Codigo',
			   r.re_fecha as 'FechaRadicacion',
			   'Reto' 'Tipo',
			   r.re_proponentes as 'Colaborador',
			   '',
			   r.re_nombre_reto as 'NombreIdea',
			   ep.df_nombre as 'Estado'
                          from retos r inner join Evaluacion_Ideas ev
				on r.id_Reto_pk= ev.ev_Codigo_Reto
				inner join  EstadosPropuesta ep on
				 ev.ev_Codigo_Def_Final=ep.df_codigo_Estado
			union all
			SELECT distinct id_Reto_pk as 'Codigo',
				re_fecha as 'FechaRadicacion',
				'Reto' 'Tipo',
				re_proponentes as 'Colaborador',
				'',
                                 re_nombre_reto as 'NombreIdea',
				'Pendiente por Evaluación' as 'Estado'
                         from retos r where r.id_Reto_pk
				  not in(
				   SELECT
						id_Reto_pk
					from retos r inner join Evaluacion_Ideas ev
						on r.id_Reto_pk= ev.ev_Codigo_Reto
						inner join  EstadosPropuesta ep on
						ev.ev_Codigo_Def_Final=ep.df_codigo_Estado))
						order by Codigo;";
        $data = $this->database->query(utf8_decode($sql));

        return $data;
    }

    public function GetIdeasEvaluacion() {
        $sql = "
            select
                a.id_codigo_idea as 'Codigo',
                a.id_fecha_radica as 'FechaRadicacion',
                a.id_nombre_idea as 'NombreIdea',
                'Idea' 'Tipo'
            from
                Ideas a
            where
                a.id_codigo_idea not in (
                    select a.id_codigo_idea from Ideas a inner join Evaluacion_Ideas b on a.id_codigo_idea=b.ev_Codigo_Idea
                )
            union all
            select
                r.id_Reto_pk 'Codigo',
                r.re_fecha 'FechaRadicacion',
                r.re_nombre_reto 'NombreIdea',
                'Reto' 'Tipo'
            from
                Retos r
                left join Evaluacion_Ideas e on (e.ev_Codigo_Reto = r.id_Reto_pk)
            where
                e.ev_Codigo_Reto is null
            ;
        ";
        $data = $this->database->query(utf8_decode($sql));
        return $data;
    }
    
     public function GetIdeasEvaluadas() {
        $sql = "
            select
                a.id_codigo_idea as 'Codigo',
                a.id_NombreCol as 'Colaborador',
                a.id_CedulaCol as 'Cedula',
                a.id_fecha_radica as 'FechaRadicacion',
                a.id_nombre_idea as 'NombreIdea',
                'Idea' 'Tipo',
                p.df_nombre 'Estado'
            from
                Ideas a
                join Evaluacion_Ideas e on (e.ev_Codigo_Idea = a.id_codigo_idea)
                left join EstadosPropuesta p on (p.df_codigo_Estado = e.ev_Codigo_Def_Final and p.estado = 1)
            union all
            select
                r.id_Reto_pk 'Codigo',
                r.re_proponentes 'Colaborador',
                '' 'Cedula',
                r.re_fecha 'FechaRadicacion',
                r.re_nombre_reto 'NombreIdea',
                'Reto' 'Tipo',
                p.df_nombre 'Estado'
            from
                Retos r
                join Evaluacion_Ideas e on (e.ev_Codigo_Reto = r.id_Reto_pk)
                left join EstadosPropuesta p on (p.df_codigo_Estado = e.ev_Codigo_Def_Final and p.estado = 1)
            ;
        ";
        //echo $sql;
        $data = $this->database->query(utf8_decode($sql));

        return $data;
    }
    
     public function GetHistoricoIdeas($codigoIdea,$Tipo) {
        if ($Tipo == "Idea") {
            
                 $sql = "select ih_codigo_idea as 'Codigo',ih_fecha_modificacion as 'FechaModifica',a.ih_Nombre_Evaluador as 'Evaluador',
                b.df_nombre as 'Estado', a.ih_Observacion as 'observa' from ideasHistorial a inner join EstadosPropuesta b
                on a.ih_id_Estado=b.df_codigo_Estado inner join Evaluacion_Ideas c on a.ih_codigo_idea=c.ev_codigo_Idea
                where a.ih_codigo_idea=".$codigoIdea.";";
                
            } else {
                 $sql = "select ih_codigo_Reto as 'Codigo',ih_fecha_modificacion as 'FechaModifica',a.ih_Nombre_Evaluador as 'Evaluador',
                b.df_nombre as 'Estado', a.ih_Observacion as 'observa' from ideasHistorial a inner join EstadosPropuesta b
                on a.ih_id_Estado=b.df_codigo_Estado inner join Evaluacion_Ideas c on a.ih_codigo_Reto=c.ev_Codigo_Reto
                where a.ih_codigo_Reto=".$codigoIdea.";";
            }   
        
        $data = $this->database->query(utf8_decode($sql));

        return $data;
    }
    public function getDesarrollosIdeas($idIdea) {
    $sql = "SELECT [di_id_pk]
                        ,[di_fase]
                        ,[di_descripcion]
                        ,[di_inicio]
                        ,[di_fin]
                        ,[di_responsable]
                        FROM [desarrollo_Idea]
                         WHERE di_id_Idea_fk=". $idIdea;
        $data = $this->database->query(utf8_encode($sql));
        return $data;
    }
     public function getValoracionReto($idReto) {
    $sql = "select id_Reto_fk 'Reto',fv_indicador 'Indicador',fv_descripcion 'Descripcion',fv_forma 'Forma',
            fv_meta 'Meta', fv_umbral 'Umbral',FV_tiempo 'Tiempo', FV_fuente 'fuente'
            from factores_Valoracion
            where id_Reto_fk=". $idReto."
            order by id_Reto_fk desc";
        //echo $sql;
        $data = $this->database->query(utf8_encode($sql));
        return $data;
    }

    public function getEquipoTrabajoReto($idReto) {
        $sql = "
            select
                e.et_id_Reto_fk 'Reto',
                e.et_persona_rol 'Persona_rol',
                e.et_proceso 'Proceso',
                e.et_dedicacion 'Dedicacion',
                e.et_justificacion 'Justificacion'
            from
                equipo_trabajo_Reto e
            where
                e.et_id_Reto_fk = " . $idReto. "
            order by
                e.et_id_Reto_fk desc
        ";
        //echo $sql;
        $data = $this->database->query(utf8_encode($sql));
        return $data;
    }

    public function getFasesPropuestaReto($idReto) {
        $sql = "
            select
                f.fp_id_Reto_fk 'Reto',
                f.fp_fase 'Fase',
                f.fp_descripcion 'Descripcion',
                f.fp_inicio 'Inicio',
                f.fp_fin 'Fin',
                f.fp_responsable 'Responsable'
            from
                fases_propuesta_Reto f
            where
                f.fp_id_Reto_fk = " . $idReto. "
            order by
                f.fp_id_Reto_fk desc
        ";
        //echo $sql;
        $data = $this->database->query(utf8_encode($sql));
        return $data;
    }
   

    public function getParametrosComboFormulario($idPadre) {
        $sql = "select a.fo_id_pk as 'Codigo', a.fo_nombre as 'Nombre' from formulario a where fo_estado=1
                  order by fo_id_pk";
        $data = $this->database->query(utf8_decode($sql));
        return $data;
    }

    
  //Funcion para insertar susripciones de ideas
    public function guardarDatosIdea($CodigoIdea, $NombreCol, $CedulaCol, $ProcesoCol, $CorreoCol, $JefeCol, $TelefonoCol,$focoOfertaValor, $focoExplotaFuncion, $focoEstrategiaPropia ,$focoAseguraProcesos,$NombreIdea, $DescripcionIdea,$AportaReto,$GradoNovedad,$getDatosDesarrollos,$Diagrama) {
        $NombreCol = $this->QuitarSignos($NombreCol);
        $CedulaCol = $this->QuitarSignos($CedulaCol);
        $ProcesoCol = $this->QuitarSignos($ProcesoCol);
        $CorreoCol = $this->QuitarSignos($CorreoCol);
        $JefeCol = $this->QuitarSignos($JefeCol);
        $TelefonoCol = substr($this->QuitarSignos($TelefonoCol), 0, 10);
        $NombreIdea=$this->QuitarSignos($NombreIdea);
        $DescripcionIdea=$this->QuitarSignos($DescripcionIdea);
        $AportaReto=$this->QuitarSignos($AportaReto);
        $GradoNovedad=$this->QuitarSignos($GradoNovedad);
        
        if ($CodigoIdea) {
            $sql = "
                update
                    Ideas
                set
                    id_fecha_radica = GETDATE ( ),
                    id_NombreCol = '$NombreCol',
                    id_CedulaCol = '$CedulaCol',
                    id_ProcesoCol = '$ProcesoCol',
                    id_CorreoCol = '$CorreoCol',
                    id_JefeCol = '$JefeCol',
                    id_TelefonoCol = '$TelefonoCol',
                    id_foco_oferta_valor = '$focoOfertaValor',
                    id_foco_explo_funci = '$focoExplotaFuncion',
                    id_foco_estra_prop = '$focoEstrategiaPropia',
                    id_foco_aseg_proc = '$focoAseguraProcesos',
                    id_nombre_idea = '$NombreIdea',
                    id_descripcion_idea = '$DescripcionIdea',
                    id_aporta_reto = '$AportaReto',
                    id_grado_novedad = '$GradoNovedad',
                    id_archivo = '$Diagrama'
                where
                    id_codigo_idea = $CodigoIdea
            ";
            $Id_Idea = $CodigoIdea;
            
            $data = $this->database->nonReturnQuery(utf8_decode($sql));
        } else {
            $sql = "select * from consecutivo";
            $dato = $this->database->query(utf8_decode($sql));
            $codigoIdea = intval($dato[0]['Id'])+1;
            
            $sql = "insert into Ideas( id_codigo_idea,
                                         id_fecha_radica,
                                         id_NombreCol,
                                         id_CedulaCol,
                                         id_ProcesoCol,
                                         id_CorreoCol,
                                         id_JefeCol,
                                         id_TelefonoCol,
                                         id_foco_oferta_valor,
                                         id_foco_explo_funci,
                                         id_foco_estra_prop,
                                         id_foco_aseg_proc,
                                         id_nombre_idea,
                                         id_descripcion_idea,
                                         id_aporta_reto,
                                         id_grado_novedad,
                                         id_archivo)
                                        values(
                    " . $codigoIdea . ",  
                        GETDATE ( )
                    ,'" . $NombreCol . " '"                   
                    .",'" .   $CedulaCol . " '"
                    . ",'" . $ProcesoCol . "'"
                    . ",'" . $CorreoCol . "'"
                    . ",'" . $JefeCol . "'"
                    . ",'" . $TelefonoCol . "'"
                    . ",'" . $focoOfertaValor . "'"
                    . ",'" . $focoExplotaFuncion . "'"
                    . ",'" . $focoEstrategiaPropia . "'"
                    . ",'" . $focoAseguraProcesos . "'"
                    . ",'" . $NombreIdea . "'"
                    . ",'" . $DescripcionIdea . "'"
                    . ",'" . $AportaReto . "'"
                    . ",'" . $GradoNovedad. "'"
                    . ",'" . $Diagrama. "')";
            $data = $this->database->nonReturnQuery(utf8_decode($sql));
            $sql = "SELECT top 1 id_codigo_idea AS 'id_codigo_idea' FROM Ideas order by id_codigo_idea desc";
            $data2 = $this->database->query(utf8_decode($sql));
            $Id_Idea = $data2[0]['id_codigo_idea'];

            self::correoIdea("", $Id_Idea, $NombreCol, array($CorreoCol));
        }
                if ($getDatosDesarrollos != 0) {
            for ($i = 0; $i < count($getDatosDesarrollos); $i++) {
                if ($getDatosDesarrollos[$i]['NewDesarrolloId']) {
                    $sql = "
                        update
                            desarrollo_Idea
                        set
                            di_fase = '{$getDatosDesarrollos[$i]['NewDesarrolloFase']}',
                            di_descripcion = '{$getDatosDesarrollos[$i]['NewDesarrolloDescri']}',
                            di_inicio = '{$getDatosDesarrollos[$i]['NewDesarrolloInicio']}',
                            di_fin = '{$getDatosDesarrollos[$i]['NewDesarrolloFin']}',
                            di_responsable = '{$getDatosDesarrollos[$i]['NewDesarrolloRespo']}'
                        where
                            di_id_pk = {$getDatosDesarrollos[$i]['NewDesarrolloId']}
                    ";
                } else {
                    $sql = "INSERT INTO [desarrollo_Idea]
                                        ([di_id_Idea_fk]
                                        ,[di_fase]
                                        ,[di_descripcion]
                                        ,[di_inicio]
                                        ,[di_fin]
                                        ,[di_responsable])
                                  VALUES
                                        (" .$Id_Idea ."
                                        ,'" . $getDatosDesarrollos[$i]['NewDesarrolloFase'] . "'                                    
                                        ,'" . $getDatosDesarrollos[$i]['NewDesarrolloDescri'] . "'                                    
                                        ,'" . $getDatosDesarrollos[$i]['NewDesarrolloInicio'] . "'                                    
                                        ,'" . $getDatosDesarrollos[$i]['NewDesarrolloFin'] . " '                                   
                                        ,'" . $getDatosDesarrollos[$i]['NewDesarrolloRespo'] . "')";                                                                                                        
                    // echo $sql;
                }
                $this->database->nonReturnQuery(utf8_decode($sql));
            }
        }
        return $Id_Idea;
    }
    
    //Funcion para insertar susripciones de ideas
    public function guardarDatosRetos($NombreReto, $Sponsor, $LiderReto, $Proponentes,$CorreoCol,$Colaborador, $Definicion, $SituacionActual, $getDatosValoracion,$getEquipoTrabajo,$getDatosDesarrollosRetos) {
        //$NombreReto = $this->QuitarSignos($NombreReto);
        $Sponsor = $this->QuitarSignos($Sponsor);
        $LiderReto = $this->QuitarSignos($LiderReto);
        $Proponentes = $this->QuitarSignos($Proponentes);
        $Definicion = $this->QuitarSignos($Definicion);
        $SituacionActual=$this->QuitarSignos($SituacionActual);
  

            $sql = "select * from consecutivo";
            $dato = $this->database->query(utf8_decode($sql));
            $codigoReto = intval($dato[0]['Id'])+1;
            $sql = "insert into Retos( id_Reto_pk,
                                         re_nombre_reto,
                                         re_fecha,
                                         re_correo,
                                         re_sponsor,
                                         re_lider_reto,
                                         re_proponentes,
                                         re_definicion,
                                         re_situacion_actual)
                                        values( 
                    '" . $codigoReto . " '"
                    .",'" . $NombreReto . " '"
                    .',GETDATE()'
                    .",'" .   $CorreoCol . " '"  
                    .",'" .   $Sponsor . " '"   
                    . ",'" . $LiderReto . "'"
                    . ",'" . $Proponentes . "'"
                    . ",'" . $Definicion . "'"
                    . ",'" . $SituacionActual . "')";
                   
           
            $data = $this->database->nonReturnQuery(utf8_decode($sql));
                $sql = "SELECT top 1 id_Reto_pk AS 'id_Reto_pk' FROM Retos order by id_Reto_pk desc";
            $data2 = $this->database->query(utf8_decode($sql));
            $Id_Reto = $data2[0]['id_Reto_pk'];
            
            //envío de correo
            self::correoIdea("", $Id_Reto, $Colaborador, array($CorreoCol));
            
            //Validar contenido de la tabla de Factores de Valoración
            if ($getDatosValoracion != 0) {
            for ($i = 0; $i < count($getDatosValoracion); $i++) {
                      $sql = "INSERT INTO [factores_Valoracion]
                                        ([id_Reto_fk]
                                        ,[fv_indicador]
                                        ,[fv_descripcion]
                                        ,[fv_forma]
                                        ,[fv_meta]
                                        ,[fv_umbral]
                                        ,[FV_tiempo]
                                        ,[FV_fuente])
                                  VALUES
                                        ('" . $Id_Reto . "'
                                        ,'" . $getDatosValoracion[$i]['NewValoracionIndicador'] . "'                                    
                                        ,'" . $getDatosValoracion[$i]['NewValoracionDescrip'] . "'                                    
                                        ,'" . $getDatosValoracion[$i]['NewValoracionFormula'] . "'                                    
                                        ,'" . $getDatosValoracion[$i]['NewValoracionMeta'] . " '  
                                        ,'" . $getDatosValoracion[$i]['NewValoracionUmbral'] . " '  
                                        ,'" . $getDatosValoracion[$i]['NewValoracionTiempo'] . " '  
                                        ,'" . $getDatosValoracion[$i]['NewValoracionFuente'] . "')";                                                                                                        
                 //echo $sql;
                //}
                $this->database->nonReturnQuery(utf8_decode($sql));
            }
        }
        
           
            //Validar contenido de la tabla de Equipo de Trabajo
            if ($getEquipoTrabajo != 0) {
            for ($i = 0; $i < count($getEquipoTrabajo); $i++) {
   
                    $sql = "INSERT INTO equipo_trabajo_Reto
                                                 ([et_id_Reto_fk]
                                                ,[et_persona_rol]
                                                ,[et_proceso]
                                                ,[et_dedicacion]
                                                ,[et_justificacion])
                                  VALUES
                                        ('" . $Id_Reto . "'
                                        ,'" . $getEquipoTrabajo[$i]['NewRegistroPersona'] . "'                                    
                                        ,'" . $getEquipoTrabajo[$i]['NewRegistroProcesoReto'] . "'                                    
                                        ,'" . $getEquipoTrabajo[$i]['NewRegistroDedicacion'] . "'                                    
                                        ,'" . $getEquipoTrabajo[$i]['NewRegistroJustificacion'] . "')";  
                                                                                                      

                //}
                $this->database->nonReturnQuery(utf8_decode($sql));
            }
        }
        
           //Validar contenido de la tabla de Fases de la Propuesta de reto
            if ($getDatosDesarrollosRetos != 0) {
            for ($i = 0; $i < count($getDatosDesarrollosRetos); $i++) {
                if ($getDatosDesarrollosRetos[$i]['NewDesarrolloId']) {
                    $sql = "
                        update
                            fases_propuesta_Reto
                        set
                            fp_fase = '{$getDatosDesarrollosRetos[$i]['NewDesarrolloFase']}',
                            fp_descripcion = '{$getDatosDesarrollosRetos[$i]['NewDesarrolloDescri']}',
                            fp_inicio = '{$getDatosDesarrollosRetos[$i]['NewDesarrolloInicio']}',
                            fp_fin = '{$getDatosDesarrollosRetos[$i]['NewDesarrolloFin']}',
                            fp_responsable = '{$getDatosDesarrollosRetos[$i]['NewDesarrolloRespo']}'
                        where
                            fp_id_Reto_fk = {$getDatosDesarrollosRetos[$i]['NewDesarrolloId']}
                    ";
                } else {
                    $sql = "INSERT INTO fases_propuesta_Reto
                                                 ([fp_id_Reto_fk]
                                                ,[fp_fase]
                                                ,[fp_descripcion]
                                                ,[fp_inicio]
                                                ,[fp_fin]
                                                ,[fp_responsable])
                                  VALUES
                                        ('" . $Id_Reto . "'
                                        ,'" . $getDatosDesarrollosRetos[$i]['NewDesarrolloFase'] . "'                                    
                                        ,'" . $getDatosDesarrollosRetos[$i]['NewDesarrolloDescri'] . "'                                    
                                        ,'" . $getDatosDesarrollosRetos[$i]['NewDesarrolloInicio'] . "'    
                                        ,'" . $getDatosDesarrollosRetos[$i]['NewDesarrolloFin'] . "'  
                                        ,'" . $getDatosDesarrollosRetos[$i]['NewDesarrolloRespo'] . "')";  
                                                                                                      
                // echo $sql;
                }
                $this->database->nonReturnQuery(utf8_decode($sql));
            }
        }
        return $Id_Reto;
        
        
    }
    public function guardarDatosTabla($array_fase,$array_descripcion) {
        foreach($array_fase as $i=>$t) {
            echo $array_fase[$i]." - ". $array_descripcion[$i];
        
        }
        return $data;
    }
    //Funcion para guardar Evaluacion de ideas
    public function guardarEvaluacion($CodigoIdea,$tipo, $CodigoEvaluacion, $NombreEvaluador, $FocosInnovación, $IdeaClara, $Ideaespecifica, $ComprendeElementos, $DefinicionFinal, $Observaciones) {
        // $CodigoIdea = $this->QuitarSignos($CodigoIdea);   
        $NombreEvaluador = $this->QuitarSignos($NombreEvaluador);
        $FechaEvaluacion = $this->QuitarSignos($FechaEvaluacion);
        $FocosInnovación = $this->QuitarSignos($FocosInnovación);
        $IdeaClara = $this->QuitarSignos($IdeaClara);
        $Ideaespecifica = $this->QuitarSignos($Ideaespecifica);
        $ComprendeElementos = $this->QuitarSignos($ComprendeElementos);
        $DefinicionFinal = $this->QuitarSignos($DefinicionFinal);
        $Observaciones = $this->QuitarSignos($Observaciones);

        if ($CodigoEvaluacion) {
            $sql = "update
                        Evaluacion_Ideas
                    set
                        ev_nombre_Evaluador = '" . $NombreEvaluador . "',
                        ev_Fecha_Evaluacion = GETDATE (),
                        ev_Foco_Innova = '" . $FocosInnovación . "',
                        ev_Idea_Clara = '" . $IdeaClara . "',
                        ev_Solucion_Especifica = '" . $Ideaespecifica . "',
                        ev_Asoc_Objetivo = '" . $ComprendeElementos . "',
                        ev_Codigo_Def_Final = '" . $DefinicionFinal . "',
                        ev_Observaciones = '" . $Observaciones . "'
                    where
                        ev_Codigo_Evaluacion = " . $CodigoEvaluacion
                    ;
        } else {
            if ($tipo == "Idea") {
                $campo = "ev_Codigo_Idea";
            } else {
                $campo = "ev_Codigo_Reto";
            }
            $sql = "insert into Evaluacion_Ideas($campo,
                                     ev_nombre_Evaluador,
                                     ev_Fecha_Evaluacion,
                                     ev_Foco_Innova,
                                     ev_Idea_Clara,
                                     ev_Solucion_Especifica,
                                     ev_Asoc_Objetivo,
                                     ev_Codigo_Def_Final,
                                     ev_Observaciones)
                                    values (
                    " . $CodigoIdea . ""
                    . ",'" . $NombreEvaluador . "'"
                    . ",GETDATE ()" 
                    . ",'" . $FocosInnovación . "'"
                    . ",'" . $IdeaClara . "'"
                    . ",'" . $Ideaespecifica . "'"
                    . ",'" . $ComprendeElementos . "'"
                    . ",'" . $DefinicionFinal . "'"
                    . ",'" . $Observaciones . "')";
        }
        //echo $sql;
        $data = $this->database->nonReturnQuery(utf8_decode($sql));
        $idea = $this->database->query("select top 1 id_NombreCol, id_CorreoCol from Ideas where id_codigo_idea = $CodigoIdea");
        if ($tipo == "Idea") {
                self::correoIdea($DefinicionFinal, $CodigoIdea, @$idea[0]['id_NombreCol'], array(@$idea[0]['id_CorreoCol']));
            }
        
        return $data;             
    }
    
    //Funcion para guardar Evaluacion de ideas histórico
    public function guardarEvaluacionHistorial($CodigoIdea,$Tipo,$DefinicionFinal, $NombreEvaluador,$Observaciones) {
        $CodigoIdea = $this->QuitarSignos($CodigoIdea);   
        $NombreEvaluador = $this->QuitarSignos($NombreEvaluador);
        $Observaciones = $this->QuitarSignos($Observaciones);

         if ($Tipo == "Idea") {
                $campo = "ih_Codigo_Idea";
            } else {
                $campo = "ih_codigo_Reto";
            }   

        $sql = "insert into IdeasHistorial($campo,
                                     ih_fecha_Modificacion,
                                     ih_id_Estado,
                                     ih_Nombre_Evaluador,
                                     ih_Observacion)
                                    values (
                " . $CodigoIdea . ""
                . ",GETDATE ()" 
                . ",'" . $DefinicionFinal . "'"
                . ",'" . $NombreEvaluador . "'"
                . ",'" . $Observaciones . "')";
        
        //echo $sql;
        $data = $this->database->nonReturnQuery(utf8_decode($sql));
        return $data;             
    }

   

    public function QuitarSignos($parametro) {
        $back = "\ ";
        $es = ltrim(rtrim($back));
        $replace = "";
        $search = array("'", '"', '/', $es, '&', '<', '>');
        $parametroFinal = str_replace($search, $replace, $parametro);

        return $parametroFinal;
    }

   #metodo para mostrar las opciones de operador celular

    public function getEstadosIdeas() {
        $sql = "select df_codigo_Estado as codigo,rtrim(df_nombre) as
         estado from EstadosPropuesta where estado=1 order by df_codigo_Estado";
        $data = $this->database->query(utf8_decode($sql));
        $htmlObject = "<option value='-1'>Seleccione...</option>";
        for ($i = 0; $i < count($data); $i++) {
            $htmlObject .= "<option value='" . $data[$i]['codigo'] . "'>" . utf8_encode($data[$i]['estado']) . "</option>";
        }
        return $htmlObject;
    }

#metodo para mostrar las opciones de formularios disponibles
    public function getFormularios() {
        $sql = "select a.fo_id_pk as 'Codigo', a.fo_nombre as 'Nombre'
            from formulario a where fo_estado=1 order by fo_id_pk";
        $data = $this->database->query(utf8_decode($sql));
        $htmlObject = "<option value='-1'>Seleccione...</option>";
        for ($i = 0; $i < count($data); $i++) {
            $htmlObject .= "<option value='" . $data[$i]['Codigo'] . "'>" . utf8_encode($data[$i]['Nombre']) . "</option>";
        }
        return $htmlObject;
    }
 
    #metodo para retornar los campos y tipo para armar formularios en HTML
//    public function getCamposFormulario() {
//        $sql = "select id_formulario 'Codigo',fo_nombre as 'Nombre', fo_estado as 'Estado'
//                from formularios";
//        $datos = "";
//        $data = $this->database->query(utf8_decode($sql));
//        for ($i = 0; $i < count($data); $i++) {
//            $codformu = utf8_encode($data[$i]['Codigo']);
//            $Estado = utf8_encode($data[$i]['Estado']);
//           switch ($opcion) {
//                default :
//                    $datos.= "<campo Codigo='" .$codformu."' Estado='" . $Estado ."'></campo>";
//                    break;  
//            }
//        }
//        return $datos;
//    }

      
    public function correoIdea($estado, $cod_idea, $nomUsuario, $correos) {
        
        if (!$estado) {
            $where = "df_codigo_Estado = 6";
        } else {
            $where = "df_codigo_Estado = $estado";
        }
        
        $query = "select * from EstadosPropuesta where $where";
        
        $ep = $this->database->query($query);
        $cod_idea=  str_pad($cod_idea, 5, "0",STR_PAD_LEFT);
        $asunto = "Código Idea/Reto $cod_idea";
        
        $body = "Hola $nomUsuario,<br /><br />";
        $body .= @$ep[0]['df_Mensaje'] . "<br /><br />";
        $body .= @$ep[0]['contenido'];
        
        $body = str_replace("\r", "<br />", $body);
        $body = str_replace("#cod_idea#", $cod_idea, $body);
        
        $e = new EnvioCorreo();
        
        $res = $e->enviar_ok(
            "10.32.4.10",
            "25",
            "innovacion",
            "Ventas2018+",
            "innovacion@ventasyservicios.com.co",
            "", //fromName
            utf8_decode($asunto),
            $correos,
            array(),
            $body
        );
        return $res;
    }
    
    public function getFormulariosIdeas() {
        $sql = "select f.id_formulario, f.fo_nombre, f.fo_estado, f.fo_fecha_mod, u.nombre 'usuario_mod' from Formularios f join {$this->baseUsuarios}usuarios u on (u.identifica = f.usuario_mod collate database_default)";
        return $this->database->query($sql);
    }
    
    public function cambiarEstadoFormulario($post) {
        session_start();
        $id_formulario = $post['id_formulario'];
        $estado = $post['estado'];
        $nuevo_estado = "";
        switch ($estado) {
            case "0":
                $nuevo_estado = "1";
                break;
            case "1":
                $nuevo_estado = "0";
                break;
            default:
                break;
        }
        $sql = "update Formularios set fo_estado = $nuevo_estado, fo_fecha_mod = GETDATE(), usuario_mod = '{$_SESSION['usuario']}' where id_formulario = $id_formulario";
        $this->database->nonReturnQuery($sql);
        return;
    }

}

?>
