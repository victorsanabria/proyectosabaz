$(document).ready(function () {
    HideElments();
    cargaDatosDinamicos();
    getDatosFormulario();
    var today = new Date();
    var validacorreo;
    
    if ($("#txtCodigoIdea").val() != "" && $("#idRol").val().trim() != 'Colaborador'){
        $("input, select, textarea").attr('disabled','disabled');
    }
    
     $("#btnEvaluar").click(function () {
         var id=$("#txtCodigoIdea").val();
         EnviarEvaluar(id);
     });
    
    function EnviarEvaluar(id) {
    window.location = '../Evaluaciones/Evaluacion.php?id=' + id + '&tipo=Idea'+ '&eval=true';
    }
    

    $("#txtFecha").datepicker({
        language: 'es',
        minDate: today,
        autoclose: true
    });
    $("#Txt_DesaInicio").datepicker({
        language: 'es',
        minDate: today,
        autoclose: true
    });
    $("#Txt_DesaFin").datepicker({
        language: 'es',
        autoclose: true
    });
     $("#Txt_Formu_Valor").datepicker({
        language: 'es',
        autoclose: true
    });
     $("#Txt_Meta_Valor").datepicker({
        language: 'es',
        autoclose: true
    });
      
    $("#cargarImagen").click(function () {
        SetCargue();
    })
    
    $("#btnNuevoDesarrollo").click(function () {
        $("#BtnModificaDesarrollo").hide();
        $("#BtnAgregarDesarrollo").show();
        $("#ModalDesarrollos").modal();
    });
    $("#BtnAgregarDesarrollo").click(function () {
        agregarDesarrollo();
    });
    $("#BtnModificaDesarrollo").click(function () {
        modificarDesarrollo();
    });
    $("#BtnCerrarDesarrollo").click(function () {
        cerrarDesarrollo();
    });
    
    
    
    //Botones para gestión de Factores de Valoración - Retos
    $("#btnNuevaValoracion").click(function () {
        $("#BtnModificaValoracion").hide();
        $("#BtnAgregarValoracion").show();
        $("#ModalValoraciones").modal();
    });
    $("#BtnAgregarValoracion").click(function () {
        agregarValoracion();
    });
    $("#BtnModificaValoracion").click(function () {
        modificarValoracion();
    });
    $("#BtnCerrarvaloracion").click(function () {
        cerrarValoracion();
    });
    
    function HideElments() {
    $("#DesarrolloIdeas").hide();
    $("#valoracionLogro").hide();
    $("#equipoTrabajoReto").hide();
    $("#PropuestaImplementacionReto").hide();
}

function SetCargue() {
    //console.log(imagen);
    $.ajax({
        url: 'CargueImagenes.php', //aqui va tu direccion donde esta tu funcion php
        type: 'POST', //aqui puede ser igual get
        cache: false,
        processData: false,
        contentType: false,
        data: new FormData($('#form1')[0]),
        beforeSend: function () {
            bootbox.dialog({
                message: '<table align="center"><tr><td>Cargando, espere un momento...</td></tr><tr><td><img src="../../img/loading.gif"/></td></tr></table>',
                title: "Cargando"
            });
        },
        error: function () {
            alert("Ha surgido un error")
        },
        success: function (data) {
            //console.log(data);
            $("#diagrama").val(data);
            $("#imgUp").attr('src',data);
            bootbox.hideAll();
            //alert(data);
        }
    })
}

//function cargaDatosDinamicos() {
//        $.ajax({
//            url: "../../controller/CapturaInformacionController.php",
//            type: "POST",
//            datatype: "xml",
//            async: false,
//            data: ({
//                'metodo': 'getCamposFormulario'
//            }),
//            success: function (xml) {
//               // var html = "";
//                $(xml).find('response').each(function () {
//                    
//                    $(this).find('registro').each(function () {
//                        if ($(this).text() == 'NOEXITOSO') {
//                        } else {
//                            $(this).find('campo').each(function () {
//                               if($(this).attr("Estado")=='1') 
//                               {
//                                    switch ($(this).attr("Codigo")) {
//
//                                        case '1':
//                                                $("#DesarrolloIdeas").show();
//                                        break;
////                                         case '2':
////                                                $("#valoracionLogro").show();
////                                             break;
//                                         case '3':
//                                                $("#equipoTrabajoReto").show();
//                                             break;   
//                                         case '4':
//                                                $("#PropuestaImplementacionReto").show();
//                                             break;   
//                                     }
//                                 }
//                            });
//                        }
//                    });
//                });
//            }
//        });
//}
  
function getDatosFormulario() {
    var idIdea = $("#txtId").val();
    if (idIdea==0)
    {
        return false;
    }
    $.ajax({
        url: "../../controller/CapturaInformacionController.php",
        type: "POST",
        datatype: "xml",
        data: ({
            'metodo': 'getDatosIdea',
            'idIdea': idIdea
        }),
        success: function (xml) {
            $(xml).find('response').each(function () {
                $(xml).find('registro').each(function () {
                    if ($(this).text() != 'NOEXITOSO') {
                        $('#txtNombreCol').val($(this).attr("NombreCol"));
                        $('#txtCedulaCol').val($(this).attr("CedulaCol"));
                        $('#slcProcesoCol').val($(this).attr("ProcesoCol"));
                        $('#txtCorreoCol').val($(this).attr("CorreoCol"));
                        $('#txtJefeCol').val($(this).attr("JefeCol"));
                        $('#txtTelefonoCol').val($(this).attr("TelefonoCol"));
                        $('#foco_oferta_valor').val($(this).attr("focoOfertaValor"));
                        GetDatosChecked('#foco_oferta_valor',$(this).attr("focoOfertaValor"));                          // $('#foco_oferta_valor').attr('checked', true);
                        GetDatosChecked('#foco_explo_funci',$(this).attr("focoExploFuncio")); 
                        GetDatosChecked('#foco_estra_propia',$(this).attr("focoEstrategiaPropia"));  
                        GetDatosChecked('#foco_aseg_procesos',$(this).attr("focoAseguraProcesos"));
                        $('#txtNombreIdea').val($(this).attr("NombreIdea"));
                        $('#txtDescripcionIdea').val($(this).attr("descripcionIdea"));
                        $('#txtAportaReto').val($(this).attr("aportaReto"));
                        $('#txtGradoNovedad').val($(this).attr("gradoNovedad"));
                        $('#imgUp').attr('src',$(this).attr("diagrama"));
                        getDesarrollosIdeas(idIdea);
                    }
                });
            });
        }
    });
}
//función para mostrar campos checked en la consulta de Ideas
function GetDatosChecked(Idchecked,retorno)
{
    if (retorno=='1')
    {
    $(Idchecked).attr('checked', true);
    }
}

    $("#btnVolver").click(function () {
        window.history.back();
    });
    
   
    $("#btnGuardar").click(function () {
        $("#btnGuardar").attr('disabled', 'disabled');
        setTimeout(function () {
            $("#btnGuardar").removeAttr('disabled');
        }, 3000);
        
        /*informacion almacenar de información*/
        var CodigoIdea = $("#txtCodigoIdea").val();
        var NombreCol = $("#txtNombreCol").val();
        var CedulaCol = $("#txtCedulaCol").val();
        var ProcesoCol = $("#slcProcesoCol").val();
        var CorreoCol = $("#txtCorreoCol").val();
        validar_email(CorreoCol);
        var JefeCol = $("#txtJefeCol").val();
        var TelefonoCol = $("#txtTelefonoCol").val();
        var focoOfertaValor = $("#foco_oferta_valor").val();
        var focoEstrategiaPropia = $("#foco_estra_propia").val();
        var focoAseguraProcesos = $("#foco_aseg_procesos").val();
        var NombreIdea = $("#txtNombreIdea").val();
        var DescripcionIdea = $("#txtDescripcionIdea").val();
        var AportaReto = $("#txtAportaReto").val();
        var GradoNovedad = $("#txtGradoNovedad").val();
        var Diagrama = $("#diagrama").val();
        if (Required('required') > 0) {
            bootbox.dialog({
                message: "Se deben completar lo campos obligatorios (marcados en color rojo)",
                title: "Campos obligatorios",
                buttons: {
                    main: {
                        label: "Aceptar",
                        className: "btn-primary",
                        callback: function () {
                        }
                    }
                }
            });
        } else
        {
        if (validar_email(CorreoCol)==false)
            {
                 bootbox.dialog({
                        message: 'La dirección de email es incorrecta,por favor verificar',
                        title: "Error ",
                        buttons: {
                            main: {
                                label: "Aceptar",
                                className: "btn-primary",
                                callback: function () {
                                }
                            }
                        }
                    });       
            }else
            {
        
            $.ajax({
                type: "POST",
                dataType: 'xml',
                url: '../../controller/CapturaInformacionController.php',
                data: ({
                    'metodo': 'guardarDatosIdea',
                    'CodigoIdea': CodigoIdea,
                    'NombreCol': NombreCol,
                    'CedulaCol': CedulaCol,
                    'ProcesoCol': ProcesoCol,
                    'CorreoCol': CorreoCol,
                    'JefeCol': JefeCol,
                    'TelefonoCol': TelefonoCol,
                    'focoOfertaValor': validafoco1(),
                    'focoExplotaFuncion': validafoco2(),
                    'focoEstrategiaPropia': validafoco3(),
                    'focoAseguraProcesos': validafoco4(),
                    'NombreIdea': NombreIdea,
                    'DescripcionIdea': DescripcionIdea,
                    'AportaReto': AportaReto,
                    'GradoNovedad': GradoNovedad,
                    'getDatosDesarrollos':getDatosDesarrollos(),
                    'Diagrama': Diagrama
                }),
                beforeSend: function () {
                    bootbox.dialog({
                        message: '<table align="center"><tr><td>Cargando, espere un momento...</td></tr><tr><td><img src="../../img/loading.gif"/></td></tr></table>',
                        title: "Cargando"
                    });
                },
                success: function (xml) {
                    bootbox.hideAll();
                    $(xml).find('registro').each(function () {
                        if ($(this).text() == 'Exitoso') {
                            var Idea=$(this).attr("Id_Idea");
                            var valor = zfill(Idea,5);
                            bootbox.dialog({
                                message: "se ha guardado la gestion correctamente.\n\
                                \n\código de idea "+ valor +"  \n\ \r\
                                Muchas gracias por participar del proceso para construir juntos; en algunos días podrás consultar, el estado de la idea con el número que te fue asignado; nos contactaremos contigo para validar el proceso a seguir"
                                        + "Saludos Equipo de innovación",
                                title: "Exito",
                                buttons: {
                                    main: {
                                        label: "Aceptar",
                                        className: "btn-primary",
                                        callback: function () {
                                            if (CodigoIdea) {
                                                window.history.back();
                                            } else {
                                                window.location = "../suscripcion/suscrip.php";
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    });
                }
                ,
                error: function (XMLHttpReq) {
                    bootbox.dialog({
                        message: 'Se ha producido el siguiente error al guardar la gestion :<br/>' + XMLHttpRequest.responseText + '<br/> Por favor comunicar a el area de tecnologia.',
                        title: "Error ",
                        buttons: {
                            main: {
                                label: "Aceptar",
                                className: "btn-primary",
                                callback: function () {
                                }
                            }
                        }
                    });
                }
            });
        }
        }
    });
    
    
    
    //función para llenar con ceros a la izquierda a un valor
    function zfill(number, width) {
        var numberOutput = Math.abs(number); /* Valor absoluto del número */
        var length = number.toString().length; /* Largo del número */
        var zero = "0"; /* String de cero */

        if (width <= length) {
            if (number < 0) {
                return ("-" + numberOutput.toString());
            } else {
                return numberOutput.toString();
            }
        } else {
            if (number < 0) {
                return ("-" + (zero.repeat(width - length)) + numberOutput.toString());
            } else {
                return ((zero.repeat(width - length)) + numberOutput.toString());
            }
        }
    }
     function validar_email(email){ 
     var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
        if (caract.test(email) == false){
        {
          //  alert("La dirección de email es incorrecta,por favor verificar.");
             return false;      
          } 
        }
        };

    // gestion de eventos clic para Desarrollo de Ideas
    $(document).on('click', ".NewDesarrolloBtnQuitar", function () {
        $(this).parent().parent().remove();
        var NumBen = parseInt($('#txtNumDesarrollos').val());
        $('#txtNumDesarrollos').val(NumBen - 1);
    });
    $(document).on('click', ".NewDesarrolloBtnVer", function () {
            $("#BtnModificaDesarrollo").show();
        $("#BtnAgregarDesarrollo").hide();
        var index = $(this).parents('tr').index();
        $('#txt_desa_fase').val($('.NewDesarrolloFase:eq(' + index + ')').attr('value'));
        $('#txt_desa_descri').val($('.NewDesarrolloDescri:eq(' + index + ')').attr('value'));
        $('#Txt_DesaInicio').val($('.NewDesarrolloInicio:eq(' + index + ')').attr('value'));
        $('#Txt_DesaFin').val($('.NewDesarrolloFin:eq(' + index + ')').attr('value'));
        $('#txt_desa_respo').val($('.NewDesarrolloRespo:eq(' + index + ')').attr('value'));
        $("#indexDesarrollo").val(index);
        $("#ModalDesarrollos").modal();
    });
    
      // Gestion de eventos clic para Factores que valoran el logro - Retos
    $(document).on('click', ".NewValoracionBtnQuitar", function () {
        $(this).parent().parent().remove();
        var NumBen = parseInt($('#txtNumValoraciones').val());
        $('#txtNumValoraciones').val(NumBen - 1);
    });
    $(document).on('click', ".NewValoracionBtnVer", function () {
        $("#BtnModificaValoracion").show();
        $("#BtnAgregarValoracion").hide();
        var index = $(this).parents('tr').index();
        $('#txt_Indic_Valor').val($('.NewValoracionIndicador:eq(' + index + ')').attr('value'));
        $('#txt_Descri_Valor').val($('.NewValoracionDescrip:eq(' + index + ')').attr('value'));
        $('#Txt_Formu_Valor').val($('.NewValoracionFormula:eq(' + index + ')').attr('value'));
        $('#Txt_Meta_Valor').val($('.NewValoracionMeta:eq(' + index + ')').attr('value'));
        $('#txt_Umbral_Valor').val($('.NewValoracionUmbral:eq(' + index + ')').attr('value'));
        $('#txt_Tiempo_Valor').val($('.NewValoracionTiempo:eq(' + index + ')').attr('value'));
        $('#Txt_Fuente_Valor').val($('.NewValoracionFuente:eq(' + index + ')').attr('value'));
        $("#indexValoracion").val(index);
        $("#ModalValoraciones").modal();
    });
    
});
function Required(Parametro) {
    var count = 0;
    $('[' + Parametro + ']').each(function () {
        if ($(this).is(':visible')) {
            if ($.trim($(this).val()) == '' || $(this).val() == '-1') {
                count++;
                $(this).css("border-color", "red");
            } else {
                $(this).css("border-color", "#CCCCCC");
            }
        }
    });
    return count;
}

function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57 || key === 0 || key === 8)
}
function soloLetras(e) {
    var key = window.Event ? e.which : e.keyCode
    return (key >= 65 && key <= 90  || key >= 97 && key <= 122 || key === 0 || key === 8 || key === 44|| key === 32)
    
}
  function validafoco1(){
    var focoOfertaValor='0';    
    if($('#foco_oferta_valor').prop('checked')){
       var focoOfertaValor='1'
    }
    return focoOfertaValor;
    };
    
    function validafoco2(){
    var focoExplotaFuncion='0';    
    if($('#foco_explo_funci').prop('checked')){
       var focoExplotaFuncion='1'
    }
    return focoExplotaFuncion;
    };
    
    function validafoco3(){
    var focoEstrategiaPropia='0';    
    if($('#foco_estra_propia').prop('checked')){
       var focoEstrategiaPropia='1'
    }
    return focoEstrategiaPropia;
    };
    
    function validafoco4(){
    var focoAseguraProcesos='0';    
    if($('#foco_aseg_procesos').prop('checked')){
       var focoAseguraProcesos='1'
    }
     return focoAseguraProcesos;
    };
    
    function limpiaFactValoracion(){
    $("#txt_desa_fase").val(''); 
    $("#txt_desa_descri").val(''); 
    $("#Txt_DesaInicio").val(''); 
    $("#Txt_DesaFin").val('');
    $("#txt_desa_respo").val('');
}
    
   

//Agregar datos a tabla de Desarrollo de Ideas
function  agregarDesarrollo() {
    if (Required('requiredDes') == 0) {
        var NumBen = parseInt($('#txtNumDesarrollos').val());
       $("#divDesarrollo").show();
        if(validarfechaMayorQue($("#Txt_DesaInicio").val(),$("#Txt_DesaFin").val()))
        {
            alert("La fecha final es superior a la fecha Inicial");
            $("#Txt_DesaFin").val('');
        }else{
            
        
        var htmlBtonVer = "<button id='btnVer' class='btn btn-facebook NewDesarrolloBtnVer' style='margin:1%;' type='submit'>\n\
                                                    <span class='glyphicon glyphicon - edit'></span> Ver\n\
                                                    </button>";
        var htmlBtonQuitar = "<button id='btnQuitar' class='btn btn-danger NewDesarrolloBtnQuitar' style='margin:1%;' type='submit'>\n\
                                                    <span class='glyphicon glyphicon - plus'></span> Quitar\n\
                                                    </button>";
        var htmltxt_desa_fase = "<h6 class='form-control  NewDesarrolloFase' value='" + $('#txt_desa_fase').val() + "'>" + $('#txt_desa_fase').val() + "</h6>";
        var htmltxt_desa_descri = "<h6  id='Pruebas_1' class='form-control NewDesarrolloDescri' value='" + $('#txt_desa_descri').val() + "'>" + $('#txt_desa_descri').val() + "</h6>";
        var htmlTxt_DesaInicio = "<h6  class='form-control NewDesarrolloInicio' value='" + $('#Txt_DesaInicio').val() + "'>" + $('#Txt_DesaInicio').val() + "</h6>";
        var htmlTxt_DesaFin = "<h6  class='form-control NewDesarrolloFin' value='" + $('#Txt_DesaFin').val() + "'>" + $('#Txt_DesaFin').val() + "</h6>";
        var htmltxt_desa_respo = "<h6  class='form-control NewDesarrolloRespo' value='" + $('#txt_desa_respo').val() + "'>" + $('#txt_desa_respo').val() + "</h6>";
        $('#tbodyDesarrollos').append('<tr><td>' +
                htmltxt_desa_fase + '</td><td>' +
                htmltxt_desa_descri + '</td><td>' +
                htmlTxt_DesaInicio + '</td><td>' +
                htmlTxt_DesaFin + '</td><td>' +
                htmltxt_desa_respo + '</td><td>' +
                htmlBtonVer + '</td><td>' +
                htmlBtonQuitar + '</td> </tr>');
        LimpiaDesa('requiredDes');
        limpiaFactValoracion();
        $('#txtNumDesarrollos').val(NumBen + 1);
        $('#ModalDesarrollos').modal('hide');
        }
    }
}
function validarfechaMayorQue(fecha,fecha2)
        {
               var xMonth=fecha.substring(0, 2);  
                var xDay=fecha.substring(3, 5);  
                var xYear=fecha.substring(6,10);  
                var yMonth=fecha2.substring(0, 2);  
                var yDay=fecha2.substring(3, 5);  
                var yYear=fecha2.substring(6,10);  
                var fechaini=new Date(xYear,xMonth,xDay);
                var fechafin=new Date(yYear,yMonth,yDay);
                if(fechafin<fechaini)
            {
                return 1;
            }
            
        }

//Modificar datos a tabla de Desarrollo de Ideas
function  modificarDesarrollo() {
    var index = $('#indexDesarrollo').val();
    if ($.trim(index) != '') {
        $('.NewDesarrolloFase:eq(' + index + ')').attr('value', $('#txt_desa_fase').val());
        $('.NewDesarrolloFase:eq(' + index + ')').html($('#txt_desa_fase').val());

        $('.NewDesarrolloDescri:eq(' + index + ')').attr('value', $('#txt_desa_descri').val());
        $('.NewDesarrolloDescri:eq(' + index + ')').html($('#txt_desa_descri').val());

        $('.NewDesarrolloInicio:eq(' + index + ')').attr('value', $('#Txt_DesaInicio').val());
        $('.NewDesarrolloInicio:eq(' + index + ')').html($('#Txt_DesaInicio').val());

        $('.NewDesarrolloFin:eq(' + index + ')').attr('value', $('#Txt_DesaFin').val());
        $('.NewDesarrolloFin:eq(' + index + ')').html($('#Txt_DesaFin').val());

        $('.NewDesarrolloRespo:eq(' + index + ')').attr('value', $('#txt_desa_respo').val());
        $('.NewDesarrolloRespo:eq(' + index + ')').html($('#txt_desa_respo').val());

        LimpiaDesa('requiredDes');
        limpiaFactValoracion();
        $('#ModalDesarrollos').modal('hide');
    }
}
function cerrarDesarrollo() {
    LimpiaDesa('requiredDes');
    limpiaFactValoracion();
    $('#ModalDesarrollos').modal('hide');
}
function LimpiaDesa(Parametro) {
    $('[' + Parametro + ']').each(function () {
        if ($.trim($(this).val()) != '') {
            $(this).val('');
        }
    });
}
function getDatosDesarrollos() {
    var dataDatosDesarrollos = Array();
    if ($(".NewDesarrolloFase").size() > 0) {
        for (var e = 0; e < $(".NewDesarrolloFase").size(); e++) {
            dataDatosDesarrollos.push({
                'NewDesarrolloId': $(".NewDesarrolloId:eq(" + e + ")").attr('value'),
                'NewDesarrolloFase': $(".NewDesarrolloFase:eq(" + e + ")").attr('value'),
                'NewDesarrolloDescri': $(".NewDesarrolloDescri:eq(" + e + ")").attr('value'),
                'NewDesarrolloInicio': $(".NewDesarrolloInicio:eq(" + e + ")").attr('value'),
                'NewDesarrolloFin': $(".NewDesarrolloFin:eq(" + e + ")").attr('value'),
                'NewDesarrolloRespo': $(".NewDesarrolloRespo:eq(" + e + ")").attr('value')
            });
        }
    } else {
        return 0;
    }
    return dataDatosDesarrollos;
}

//Agregar datos a tabla de Factores de Valoración - Retos
function  agregarValoracion() {
    if (Required('requiredDes') == 0) {
        var NumBen = parseInt($('#txtNumValoraciones').val());
       $("#divValoracion").show();
        var htmlBtonVer = "<button id='btnVer' class='btn btn-facebook NewValoracionBtnVer' style='margin:1%;' type='submit'>\n\
                                                    <span class='glyphicon glyphicon - edit'></span> Ver\n\
                                                    </button>";
        var htmlBtonQuitar = "<button id='btnQuitar' class='btn btn-danger NewValoracionBtnQuitar' style='margin:1%;' type='submit'>\n\
                                                    <span class='glyphicon glyphicon - plus'></span> Quitar\n\
                                                    </button>";
        var htmltxt_Indic_Valor = "<h6 class='form-control  NewValoracionIndicador' value='" + $('#txt_Indic_Valor').val() + "'>" + $('#txt_Indic_Valor').val() + "</h6>";
        var htmltxt_Descri_Valor = "<h6  id='Pruebas_1' class='form-control NewValoracionDescrip' value='" + $('#txt_Descri_Valor').val() + "'>" + $('#txt_Descri_Valor').val() + "</h6>";
        var htmlTxt_Formu_Valor = "<h6  class='form-control NewValoracionFormula' value='" + $('#Txt_Formu_Valor').val() + "'>" + $('#Txt_Formu_Valor').val() + "</h6>";
        var htmlTxt_Meta_Valor = "<h6  class='form-control NewValoracionMeta' value='" + $('#Txt_Meta_Valor').val() + "'>" + $('#Txt_Meta_Valor').val() + "</h6>";
        var htmltxt_Umbral_Valor = "<h6  class='form-control NewValoracionUmbral' value='" + $('#txt_Umbral_Valor').val() + "'>" + $('#txt_Umbral_Valor').val() + "</h6>";
        var htmltxt_Tiempo_Valor = "<h6  class='form-control NewValoracionTiempo' value='" + $('#txt_Tiempo_Valor').val() + "'>" + $('#txt_Tiempo_Valor').val() + "</h6>";
        var htmlTxt_Fuente_Valor = "<h6  class='form-control NewValoracionFuente' value='" + $('#Txt_Fuente_Valor').val() + "'>" + $('#Txt_Fuente_Valor').val() + "</h6>";
        $('#tbodyValoracion').append('<tr><td>' +
                htmltxt_Indic_Valor + '</td><td>' +
                htmltxt_Descri_Valor + '</td><td>' +
                htmlTxt_Formu_Valor + '</td><td>' +
                htmlTxt_Meta_Valor + '</td><td>' +
                htmltxt_Umbral_Valor + '</td><td>' +
                htmltxt_Tiempo_Valor + '</td><td>' +
                htmlTxt_Fuente_Valor + '</td><td>' +
                htmlBtonVer + '</td><td>' +
                htmlBtonQuitar + '</td> </tr>');
        LimpiaDesa('requiredDes');
        $('#txtNumValoraciones').val(NumBen + 1);
        $('#ModalValoraciones').modal('hide');
    }
}
//Modificar datos a tabla de Factores de Valoración - Retos
function  modificarValoracion() {
    var index = $('#indexValoracion').val();
    if ($.trim(index) != '') {
        $('.NewValoracionIndicador:eq(' + index + ')').attr('value', $('#txt_Indic_Valor').val());
        $('.NewValoracionIndicador:eq(' + index + ')').html($('#txt_Indic_Valor').val());

        $('.NewValoracionDescrip:eq(' + index + ')').attr('value', $('#txt_Descri_Valor').val());
        $('.NewValoracionDescrip:eq(' + index + ')').html($('#txt_Descri_Valor').val());

        $('.NewValoracionFormula:eq(' + index + ')').attr('value', $('#Txt_Formu_Valor').val());
        $('.NewValoracionFormula:eq(' + index + ')').html($('#Txt_Formu_Valor').val());

        $('.NewValoracionMeta:eq(' + index + ')').attr('value', $('#Txt_Meta_Valor').val());
        $('.NewValoracionMeta:eq(' + index + ')').html($('#Txt_Meta_Valor').val());

        $('.NewValoracionUmbral:eq(' + index + ')').attr('value', $('#txt_Umbral_Valor').val());
        $('.NewValoracionUmbral:eq(' + index + ')').html($('#txt_Umbral_Valor').val());
        
        $('.NewValoracionTiempo:eq(' + index + ')').attr('value', $('#txt_Tiempo_Valor').val());
        $('.NewValoracionTiempo:eq(' + index + ')').html($('#txt_Tiempo_Valor').val());

        $('.NewValoracionFuente:eq(' + index + ')').attr('value', $('#Txt_Fuente_Valor').val());
        $('.NewValoracionFuente:eq(' + index + ')').html($('#Txt_Fuente_Valor').val());

        LimpiaDesa('requiredDes');
        $('#ModalValoraciones').modal('hide');
    }
}
//cierra ventana modal Valoraciones - Reto
function cerrarValoracion() {
    LimpiaDesa('requiredDes');
    $('#ModalValoraciones').modal('hide');
}
//Genera get de Datos de Valoracones - Reto
function getDatosValoracion() {
    var dataDatosValoraciones = Array();
    if ($(".NewValoracionIndicador").size() > 0) {
        for (var e = 0; e < $(".NewValoracionIndicador").size(); e++) {
            dataDatosValoraciones.push({
                'NewValoracionIndicador': $(".NewValoracionIndicador:eq(" + e + ")").attr('value'),
                'NewValoracionDescrip': $(".NewValoracionDescrip:eq(" + e + ")").attr('value'),
                'NewValoracionFormula': $(".NewValoracionFormula:eq(" + e + ")").attr('value'),
                'NewValoracionMeta': $(".NewValoracionMeta:eq(" + e + ")").attr('value'),
                'NewValoracionUmbral': $(".NewValoracionUmbral:eq(" + e + ")").attr('value'),
                'NewValoracionTiempo': $(".NewValoracionTiempo:eq(" + e + ")").attr('value'),
                'NewValoracionFuente': $(".NewValoracionFuente:eq(" + e + ")").attr('value')
            });
        }
    } else {
        return 0;
    }
    return dataDatosValoraciones;
}

function getDesarrollosIdeas(idIdea) {
    $.ajax({
        type: "POST",
        dataType: 'xml',
        async: false,
        url: '../../controller/CapturaInformacionController.php',
        data: ({
            'metodo': 'getDesarrollosIdeas',
            'idIdea': idIdea
        }),
        beforeSend: function () {
            bootbox.dialog({
                message: '<table align="center"><tr><td>Consultando, espere un momento...</td></tr><tr align="center"><td><img src="../../images/Cargando_Flechas.gif" style="width: 30%"/></td></tr></table>',
                title: "Consultando!"
            });
        },
        success: function (xml) {
            bootbox.hideAll();
            $(xml).find('response').each(function () {
                $(this).find('registro').each(function () {
                    if ($(this).text() === 'NOEXITOSO') {

                    } else {
                        $('#divDesarrollo').show();
                        /*var htmlBtonVer = "<button id='btnVer' class='btn btn-facebook NewDesarrolloBtnVer' style='margin:1%;' type='submit'  >\n\
                                                    <span class='glyphicon glyphicon - edit'></span> Ver\n\
                                                    </button>";*/
                        var htmlBtonVer = "";
                        /*var htmlBtonQuitar = "<button id='btnQuitar' class='btn btn-danger' style='margin:1%;' type='submit'>\n\
                                                    <span class='glyphicon glyphicon - plus'></span> Quitar\n\
                                                    </button>";*/
                        var htmlBtonQuitar = "";
                        var htmltxt_desa_fase = "<input type='hidden' value='"+$(this).attr('di_id_pk')+"' class='NewDesarrolloId' /><h6 class='form-control  NewDesarrolloFase' value='" + $(this).attr('di_fase') + "'>" + $(this).attr('di_fase') + "</h6>";
                        var htmltxt_desa_descri = "<h6  id='Pruebas_1' class='form-control NewDesarrolloDescri' value='" + $(this).attr('di_descripcion') + "'>" + $(this).attr('di_descripcion') + "</h6>";
                        var htmlTxt_DesaInicio = "<h6  class='form-control NewDesarrolloInicio' value='" + $(this).attr('di_inicio') + "'>" + $(this).attr('di_inicio') + "</h6>";
                        var htmlTxt_DesaFin = "<h6  class='form-control NewDesarrolloFin' value='" + $(this).attr('di_fin') + "'>" + $(this).attr('di_fin') + "</h6>";
                        var htmltxt_desa_respo = "<h6  class='form-control NewDesarrolloRespo' value='" + $(this).attr('di_responsable') + "'>" + $(this).attr('di_responsable') + "</h6>";
                        $('#tbodyDesarrollos').append('<tr><td>' +
                                htmltxt_desa_fase + '</td><td>' +
                                htmltxt_desa_descri + '</td><td>' +
                                htmlTxt_DesaInicio + '</td><td>' +
                                htmlTxt_DesaFin + '</td><td>' +
                                htmltxt_desa_respo + '</td><td>' +
                                htmlBtonVer + '</td><td>'+
                                htmlBtonQuitar + '</td> </tr>');
                    }
                });
            });
        }
    });

}
