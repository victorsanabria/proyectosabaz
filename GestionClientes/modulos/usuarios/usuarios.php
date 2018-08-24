<?php
session_start();
include '../../class/CapturaInformacion.class.php';
$modulo = new CapturaInformacion();
if (!isset($_SESSION['usuario'])) {

    header('Location: ../../pages/AccesoDenegado.php');
} else {
    if (isset($_REQUEST['id'])) {
        $codigoidea = ($_REQUEST['id']);
        $eval = ($_REQUEST['eval']);
    }
    $Asesor = $_SESSION['usuario'];
    $modulo = new CapturaInformacion();
    $result = $modulo->getDatosUsuario($Asesor);
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge" content="IE=8">
            <title>suscripción</title>
            <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />  
            <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css" /> 	
            <link href="../../css/jquery.dataTables.css" rel="stylesheet" type="text/css" />  
            <link href="../../css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />                               
            <script src="../../js/jquery1.9.js"></script>           
            <script src="../../js/jquery.numeric.js"></script>    
            <script src="../../js/jquery.min.js"></script> 
            <script src="../../js/jquery.dataTables.js"></script>                   
            <script src="../../js/bootstrap-datepicker.js"></script>      
            <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
            <script src="../../js/bootstrap-datepicker.js" type="text/javascript"></script>     
            <script src="../../js/bootbox.min.js" type="text/javascript"></script>  
        <input type="hidden" id="txtId" value="<?php echo $codigoidea ?>"/> 
        <input type="hidden" id="eval" value="<?php echo $eval ?>"/>
        <script src="js/suscrip.js" type="text/javascript"></script>   
       <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <style>
                .form-control {
                    border-radius: 11px;
                    box-shadow: 0px 2px 12px;
                }
            </style>
    </head>
            <body>  
            <input type="hidden" name="indexDesarrollo" id="indexDesarrollo" value="">
            <input type="hidden" name="indexValoracion" id="indexValoracion" value="">
            <table style="width: 80%" align="center">
                <tr>
                    <td>
                        <div class="panel panel-primary">
                            <table style="width: 90%" align='center'>
                                <tr>
                                    <td colspan="3">
                                        <table style="width: 90%" align="center">                                   
                                            <tr>
                                                <td colspan="4">
                                                    <h3>Suscripción de Usuarios del Sistema</h3>
                                                    <hr style="height: 1px; width:100%; background-color: #5e79e4"></hr>  
                                                </td>
                                            </tr>
                                        </table>
                                        </br></br>
                                        <table style="width: 90%" align="center">  <!-- id="datosBasicos"-->                                                          
                                            <tr>

                                                <td>
                                                    Código de Usuario:
                                                </td>
                                                <td>
                                                    <input maxlength='80' readonly='readonly' style='width: 250px; height: 25px' type='text' class='form-control input-sm' id='txtCodigoIdea'>
                                                    <input type="hidden" id="idRol" value="<?php echo $result[0]['rol']; ?>"/>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Nombre Usuario: 
                                                </td>
                                                <td>
                                                    <input  id="txtNombreCol" maxlength="35" style="width: 250px; height: 25px" type="text" class="form-control input-sm" required="required" value="" onKeyPress="return soloLetras(event)">
                                                </td>
                                            
                                                <td>
                                                     Identificacíon:  
                                                </td>
                                                <td>
                                                    <input id="txtCedulaCol" style="width: 250px; height: 25px" type="number_format" class="form-control input-sm"  required="required" onKeyPress="return soloNumeros(event)" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Area:
                                                </td>
                                                <td>
                                                    <select id="slcProcesoCol"   required="required" style="width: 250px; height: 25px" class="form-control input-sm" > 
                                                        <option>Seleccione...</option>
                                                        <option value="Cobranza"> Cobranza</option>
                                                        <option value="Servicio al Cliente">Servicio al Cliente</option>
                                                        <option value="BPO">BPO</option>
                                                        <option value="Ventas">Ventas</option>
                                                        <option value="Areas de apoyo">Areas de apoyo</option>
                                                        <option value="Otras Áreas">Otras Áreas</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    Correo Electrónico:
                                                </td>
                                                <td>
                                                    <input id="txtCorreoCol" style="width: 250px; height: 25px" type="email" class="form-control input-sm"  required="required" value="" >
                                                </td>	
                                            </tr>
                                            <tr>
                                                <td>
                                                    Contraseña: 
                                                </td>
                                                <td>
                                                    <input maxlength="25" style="width: 250px; height: 25px" type="text" class="form-control input-sm" id="txtJefeCol" required="required" value="" onKeyPress="return soloLetras(event)">
                                                </td>

                                                <td>
                                                    Teléfono de contacto:
                                                </td>
                                                <td>
                                                    <input maxlength="25" style="width: 250px; height: 25px" type="number_format" class="form-control input-sm" id="txtTelefonoCol" required="required"  onKeyPress="return soloNumeros(event)" >
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <br>
                                        <!--<div class="container" >-->
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#info"><img src="../../images/info_idea.png" style="width:auto;height:50px"/></a></li>
                                                <li><a data-toggle="tab" href="#desarrollo"><img src="../../images/desa_idea.png" style="width:auto;height:50px"/></a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="info" class="tab-pane fade in active">
                                                    <table class="table" style="width:70%" align="center">
                                                        <tr>
                                                            <td>
                                                        <center><p><strong>Foco 1</strong><input type="checkbox" id="foco_oferta_valor" style="width:50px" value="0" ></p></center><br>
                                                                <justify><p><strong> Ampliar la oferta de valor con productos y servicios vanguardistas que generen valor 
                                                                        a los clientes y mejoren la experiencia de sus clientes</strong></p></justify>
                                                            </td>

                                                            <td>
                                                            <center><p><strong>Foco 2<input type="checkbox" id="foco_explo_funci" style="width:50px" value="0" ></strong></p></center><br>
                                                            <justify><p><strong>Explotar las funcionalidades de las herramientas tecnológicas  capitalizando el uso de las soluciones IT vigentes</strong></p></justify>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                        <center><p><strong>Foco 3<input type="checkbox" id="foco_estra_propia" style="width:50px" value="0" ></strong></p></center><br>
                                                                <justify><p><strong>Desarrollar estrategias propias de crecimiento a todo nivel superando el espectro del grupo AVAL</strong></p></justify>
                                                            </td>
                                                            <td>
                                                            <center><p><strong>Foco 4<input type="checkbox" id="foco_aseg_procesos" style="width:50px" value="0" ></strong></p></center><br>
                                                            <justify><p><strong> Asegurar los procesos en la organización, haciéndolos versátiles  y ágiles para sobre cumplir los requerimientos del cliente</strong></p></justify>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div id="desarrollo" class="tab-pane fade" align="center">
                                                    <!--div para agregar información de formulario desarrollo de idea-->
                                                    <div id="DesarrolloIdeas" style="width:90%" align="center">          
                                                        <font color="#3A50F8"><strong>Desarrollo de Ideas</strong></font><br>

                                                        <div id="divDesarrollo" style="overflow-y: auto; ">
                                                            <div class="row" align="left" style="width: 100%;">                                             
                                                                <div class="col-md-2">
                                                                    <br>
                                                                    N&uacute;mero de Desarrollos:                                                     
                                                                    <br>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <br>
                                                                    <input type="text" disabled="disabled" class="form-control" id="txtNumDesarrollos" required="required" style="width:23%" value="0"/>                                                     
                                                                    <br>
                                                                </div>
                                                            </div> 
                                                            <div class="row" align="left" style="width: 100%;"> 
                                                                <div class="col-md-12">
                                                                    <table id="tblDesarrollos" class="table table-bordered table-striped" style="width: 100%" align="center" >
                                                                        <thead>
                                                                        <th>Fase</th>
                                                                        <th>Descripción</th>
                                                                        <th>Inicio</th>
                                                                        <th>Fin</th>
                                                                        <th>Responsable</th>
                                                                        <th>Ver</th>
                                                                        <th>Quitar</th>
                                                                        </thead>
                                                                        <tbody id="tbodyDesarrollos">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div id="ModalDesarrollos"  class="modal fade" role="dialog"> 
                                                                <div class="modal-dialog" style="width: 95%;">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            <h4 class="modal-title" style="font-weight: bold;">Datos del Desarrollo de Idea</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row" align="left" style="width: 100%;background: #D2E4E8;"> 
                                                                                <div class="col-md-1">
                                                                                </div>
                                                                                <div class="col-md-3">                              
                                                                                    Fase:
                                                                                    <input class="form-control"  id="txt_desa_fase" style="width: 150px; height: 25px" type="text"  requiredDes="requiredDes" onKeyPress="return soloNumeros(event)"/>                                         
                                                                                </div>
                                                                                <div class="col-md-5">                                                    
                                                                                    Descripción:
                                                                                    <textarea class="form-control input-sm"  id="txt_desa_descri" style="width: 400px; height: 100px" type="textarea"  requiredDes="requiredDes"/>                                                     
                                                                                    </textarea>
                                                                                </div>
                                                                                <div class="col-md-3">                                                    
                                                                                    Inicio:
                                                                                    <input class="form-control" id="Txt_DesaInicio" maxlength="17" readonly="readonly" style="width: 150px; height: 25px" type="text" class="form-control input-sm"  value=""/>                                                              
                                                                                    <br>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" align="left" style="width: 100%;background: #D2E4E8;"> 
                                                                                <div class="col-md-1">
                                                                                </div>
                                                                                <div class="col-md-3">                              
                                                                                    Fin:
                                                                                    <input class="form-control" id="Txt_DesaFin"  maxlength="17"  readonly="readonly" style="width: 150px; height: 25px" type="text" id="TxtDesaFin" value=""/>                            
                                                                                </div>
                                                                                <div class="col-md-3">                                                    
                                                                                    Responsable:
                                                                                    <input class="form-control" id="txt_desa_respo" style="width: 150px; height: 25px" requiredDes="requiredDes" type="text"/>                                                     
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="modal-footer">
                                                                            <div class="row" align="left" style="width: 100%;"> 
                                                                                <div class="col-md-1">                                                                                    
                                                                                </div>                        
                                                                                <div class="col-md-3">                                                                                    
                                                                                    <button style="display: none;" id="BtnAgregarDesarrollo" type="button" class="btn btn-info">Agregar Desarrollo</button>
                                                                                    <?php if (!$codigoidea) { ?>
                                                                                        <button style="display: none;" id="BtnModificaDesarrollo" type="button" class="btn btn-info">Modificar Desarrollo</button>
                                                                                    <?php } ?>
                                                                                    <br>
                                                                                </div>                        
                                                                                <div class="col-md-5">                                                                                    
                                                                                </div>                        
                                                                                <div class="col-md-3">                                                                                    
                                                                                    <button id="BtnCerrarDesarrollo" type="button" class="btn btn-default" >Cerrar</button>
                                                                                    <br>
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" align="right" style="width: 100%;">                                             
                                                            <div class="col-md-1">
                                                            </div>
                                                            <div class="col-md-10">
                                                                <br>
                                                                <?php //if (!$codigoidea) { ?>
                                                                    <button id="btnNuevoDesarrollo" class="btn btn-tumblr" style="margin:1%;" type="submit">
                                                                        <span class="glyphicon glyphicon-plus"></span>Nuevo Desarrollo</button>                                    
                                                                    <br>                                                            
                                                                <?php //    } ?>
                                                            </div>                        
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>


                                            <br>        
<!--                                            <table style="width:80%" align="center">	
                                                <tr>
                                                <strong><font color="#3A50F8">Nombre de la Idea</font>
                                                    <i> Utiliza la creatividad, impacto, recordación.</i></strong>
                                                </tr>
                                                <tr>
                                                <textarea id="txtNombreIdea" COLS="100" ROWS="15" align="right"  style="width: 800px; height: 200px;font-size:14px" type="text" required="required" class="form-control input-sm"  >
                                                </textarea>
                                                </tr>
                                                <br>
                                                <tr>
                                                <strong><font color="#3A50F8">Descripción de la Idea</font>
                                                    <i> Describir con claridad el contexto, situación actual, partes interesadas, lo que se pretende resolver.</i></strong>
                                                </tr>
                                                <tr>	
                                                <textarea align="Center"  COLS="100" ROWS="15" style="width: 800px; height: 200px;font-size:14px" type="textarea" required="required" class="form-control input-sm" id="txtDescripcionIdea" >
                                                </textarea>
                                                <br>   
                                                </tr>
                                                <tr>
                                                <strong><i>Cómo la idea pretende resolver el reto, de que forma lo hará, que utiliza.</i></strong>
                                                <tr>
                                                <textarea align="center" COLS="100" ROWS="15"  style="width: 800px; height: 200px;font-size:14px" type="textarea" required="required" class="form-control input-sm" id="txtAportaReto" >
                                                </textarea>
                                                </tr>
                                                <br/>
                                                <tr>
                                                <strong><font color="#3A50F8">Grado de Novedad</font>
                                                    <i>Razones por las que la idea es novedosa, innovadora.</i></strong>
                                                </tr>
                                                <tr>
                                                <textarea align="center" COLS="100" ROWS="15"style="width: 800px; height: 200px;font-size:14px" type="textarea" required="required" class="form-control input-sm" id="txtGradoNovedad" >
                                                </textarea>
                                                </tr> 
                                                <br>
                                                <tr>
                                                <strong><font color="#3A50F8">Diagrama de la idea</font></strong><br>
                                                </tr>
                                                <tr>
                                                <strong><label for="imagen">Imagen:</label></strong>  
                                                    <div class="form-control input-sm" style="width:800px;height:300px">
                                                        <img id="imgUp" style="max-height: 24em"/>
                                                    </div>
                                                    <div id="form" enctype="multipart/form-data">
                                                        <form id="form1" action="suscrip.php" enctype="multipart/form-data" method="post">

                                                            <input id="imagen" name="imagen" size="30" type="file" />
                                                            <input type="button" id="cargarImagen" value="Cargar Imagen"  />
                                                        </form>
                                                        <input type="hidden" id="diagrama"></input>
                                                    </div>
                                                </tr>
                                            </table><br>-->
                                        <!--</div>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                            <table style="width:100%">
                                                <tr colspan="3" align='Center'>
                                                <br/>
                                                <td>
                                                    <?php //if ($codigoidea && trim($result[0]['rol']) != 'Colaborador') { ?>
<!--                                                        <button id='btnVolver' type="button" class="btn btn-facebook" align="center">                                                         
                                                            Volver <span class="glyphicon glyphicon"></span>         
                                                        </button>-->
<!--                                                        <button id="btnEvaluar" type="button" class="btn btn-facebook">
                                                            Evaluar <span class="glyphicon glyphicon"></span>  
                                                        </button>  -->
                                                    <?php //} else { ?>
                                                        <input id='btnGuardar' type="image" src="../../images/enviar.png" style="width:auto;height:auto" align="center">                                                         
                                                        <span class="glyphicon glyphicon"></span>   
                                                    <?php //} ?>
                                                </td>
                                                <br/>
                                                </tr>
                                            </table>
                                    </td>    
                                </tr>
                            </table> 

                        </div>
                    </td>
                </tr>        
            </table>
        </body>
        </html> 
    <?php
}
//}
?>
