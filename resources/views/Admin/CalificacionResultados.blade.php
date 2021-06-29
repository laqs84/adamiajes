<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Calificación Resultados </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        @if(!is_null($favicon = Admin::favicon()))
        <link rel="shortcut icon" href="{{$favicon}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
        @endif

        {!! Admin::css() !!}

        <script src="{{ Admin::jQuery() }}"></script>
        {!! Admin::headerJs() !!}
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">

        @if($alert = config('admin.top_alert'))
        <div style="text-align: center;padding: 5px;font-size: 12px;background-color: #ffffd5;color: #ff0000;">
            {!! $alert !!}
        </div>
        @endif

        <div class="wrapper">
            @include('partials.header')

            @include('partials.sidebar')


            <div class="content-wrapper" id="pjax-container">
                {!! Admin::style() !!}
                <div id="app">
                    <section class="content-header">
                        <h1>
                            Calificación Resultados
                            <small>Mantemiento</small>
                        </h1>
                    </section>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Crear</h3>

                                        <div class="box-tools">
                                            <div class="btn-group pull-right" style="margin-right: 5px">
                                                <a href="javascript:history.back()" class="btn btn-sm btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;Atras</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form id="form-creacion" action="calificacion_resultados" method="post" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                                        @csrf <!-- {{ csrf_field() }} -->
                                        <div class="box-body">

                                            <div class="fields-group">

                                                <div class="col-md-12">
                                                    <div class="form-group  ">

                                                        <label for="tipo_comp" class="col-sm-2  control-label">Tipo Competencia</label>

                                                        <div class="col-sm-10">
                                                            <select class="form-control" style="width: 100%;" id="con_tipo" name="con_tipo"  tabindex="-1" aria-hidden="true">
                                                                @foreach($CompetenciasTipos as $item)
                                                                <option value="{{$item->con_tipo}}">{{$item->descripcion}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                  
                                                    <div class="form-group  ">

                                                        <label for="tipo_puntuacion" class="col-sm-2  control-label">Tipo Puntuación</label>

                                                        <div class="col-sm-10">
                                                            <select class="form-control" style="width: 100%;" id="tipo_puntuacion" name="tipo_puntuacion"  tabindex="-1" aria-hidden="true">
                                                              <option value="PC">Por Competencia</option>
                                                              <option value="PTC">Por total de competencias</option>
                                                              <option value="PNEL">Por niveles esperados logrados</option>
                                                              <option value="PES">Por escala de sinceridad</option>                                                              
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="con_comp" class="col-sm-2  control-label">Competencia</label>

                                                        <div class="col-sm-10">
                                                            <select class="form-control" style="width: 100%;" id="con_comp" name="con_comp"  tabindex="-1" aria-hidden="true">
                                                                <option value="0">Ninguna</option>
                                                                @foreach($Competencias as $item)
                                                                <option value="{{$item->con_comp}}">{{$item->descripcion}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>                                                      
                                                    <div class="form-group  ">

                                                        <div class="col-sm-6">
                                                            <label for="rango_inicial" class="  control-label">Rango inicial</label>
                                                            <input name="rango_inicial" id="rango_inicial" type="number" class="form-control rango_inicial"  placeholder="Rango inicial"></input>
                                                        </div>

                                                    
                                                        <div class="col-sm-6">
                                                          <label for="rango_final" class="control-label">Rango final</label>
                                                            <input name="rango_final" id="rango_final" type="number" class="form-control rango_final" placeholder="Rango final"></input>
                                                        </div>
                                                    </div>

                                                    <div class="form-group  ">

                                                        <div class="col-sm-6">
                                                            <label for="predominancia_resultado" class="  control-label">Predominancia del Resultado</label>
                                                            <textarea name="predominancia_resultado" id="predominancia_resultado" class="form-control predominancia_resultado" rows="5" placeholder="Predominancia Resultado"></textarea>
                                                            <input type="hidden" id="con_puntaje" name="con_puntaje">
                                                        </div>

                                                    
                                                        <div class="col-sm-6">
                                                          <label for="resultado_descriptivo" class="control-label">Resultado Descriptivo</label>
                                                            <textarea name="resultado_descriptivo" id="resultado_descriptivo" class="form-control resultado_descriptivo" rows="5" placeholder="Resultado descriptivo"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <div class="col-sm-6">
                                                            <label for="comportamiento_descriptivo" class="  control-label">Comportamiento descriptivo</label>
                                                            <textarea name="comportamiento_descriptivo" id="comportamiento_descriptivo" class="form-control comportamiento_descriptivo" rows="5" placeholder="Comportamiento descriptivo"></textarea>
                                                        </div>

                                                    
                                                        <div class="col-sm-6">
                                                          <label for="recomendacion" class="control-label">Recomendación</label>
                                                            <textarea name="recomendacion" id="recomendacion" class="form-control recomendacion" rows="5" placeholder="Recomendación"></textarea>
                                                        </div>
                                                    </div>     
                                                    <div class="form-group  ">
                                                        <div class="col-sm-12">
                                                             <label for="aplicar_rr_no_ni" class="col-sm-6  control-label">Recomendaciones adicionales acumuladas</label>
                                                            <input type="checkbox" class="form-check-input" name="aplicar_rr_no_ni1" id="aplicar_rr_no_ni1">  
                                                            <input type="hidden" id="aplicar_rr_no_ni" name="aplicar_rr_no_ni">

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.box-body -->

                                        <div class="box-footer">



                                            <div class="col-md-2">
                                            </div>

                                            <div class="col-md-8">

                                                <div class="btn-group pull-right">
                                                    <button type="submit" class="btn btn-primary btn-accion">Crear</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /.box-footer -->
                                    </form>

                                    <div class="box-body table-responsive">
                                        <table id="competencias" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Tipo de Competencias</th>
                                                    <th>Tipo Puntuación</th>
                                                    <th>Competencia</th>
                                                    <th>Rango inicial</th><!-- comment -->
                                                    <th>Rango final</th><!-- comment -->
                                                    <th>Recomendacion acumulada</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($CalificacionResultados as $id=>$json)
                                                <tr>
                                                    @foreach ($json as $key=>$val)

                                                    <td>{!! html_entity_decode($val) !!}</td>

                                                    @endforeach
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                </div>
 <script>
$(document).ready(function () {
    $("#aplicar_rr_no_ni1").prop("checked", false);
    $("#aplicar_rr_no_ni").val("off");
    $('#aplicar_rr_no_ni1').click(function() {
    if (!$(this).is(':checked')) {
      $("#aplicar_rr_no_ni").val("off");
      $("#aplicar_rr_no_ni1").prop("checked", false);
    }
    else{
      $("#aplicar_rr_no_ni").val("on");
      $("#aplicar_rr_no_ni1").prop("checked", true);
    }
  });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//
      // Department Change
      $('#con_tipo').change(function(){

         // Department id
         var id = $(this).val();

         // Empty the dropdown
         $('#con_comp').find('option').not(':first').remove();

         // AJAX request 
         $.ajax({
           url: 'getCompetencias/'+id,
           type: 'get',
           dataType: 'json',
           success: function(response){
console.log(response);
             var len = 0;
             if(response['data'] != null){
               len = response['data'].length;
             }

             if(len > 0){
               // Read data and create <option >
               for(var i=0; i<len; i++){

                 var con_comp = response['data'][i].con_comp;
                 var descripcion = response['data'][i].descripcion;

                 var option = "<option value='"+con_comp+"'>"+descripcion+"</option>"; 

                 $("#con_comp").append(option); 
               }
             }

           }
        });
      });
//    
    var endpoint = "localhost:8000/admin/";
    $('#competencias').DataTable(
            {
                responsive: true,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },

            });
});
</script>
        <script>


function eliminar(elemento) {
    console.log($(elemento));

    var id = $(elemento).attr('class').match(/\d+/)[0];
    $.ajax(
            {
                url: "/admin/calificacion_resultados/delete/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id
                },
                success: function ()
                {

                    var table = $('#competencias').DataTable();
                    table.row($($(elemento).parent()).parents('tr')).remove().draw();
                }
            });

}
function detalle(elemento) {
    var id = $(elemento).attr('class').match(/\d+/)[0];
    $("#con_tipo").find('option:contains("'+$($($($(elemento).parent().parent())[0]).find("td").eq(0)[0]).text()+'")').prop('selected', true);
    $("#tipo_puntuacion").find('option:contains("'+$($($($(elemento).parent().parent())[0]).find("td").eq(1)[0]).text()+'")').prop('selected', true);
    $("#con_comp").find('option:contains("'+$($($($(elemento).parent().parent())[0]).find("td").eq(2)[0]).text()+'")').prop('selected', true);
    $("#rango_inicial").val($($($(elemento).parent().parent())[0]).find("td").eq(3).html());
    $("#rango_final").val($($($(elemento).parent().parent())[0]).find("td").eq(4).html());
    $("#predominancia_resultado").val($($($(elemento).parent().parent())[0]).find("td").eq(5).html());
    $("#resultado_descriptivo").val($($($(elemento).parent().parent())[0]).find("td").eq(6).html());
    $("#comportamiento_descriptivo").val($($($(elemento).parent().parent())[0]).find("td").eq(7).html());
    if($($($(elemento).parent().parent())[0]).find("td").eq(9).html() == "Aplicar recomendaciones por resultados de nivel obtenido"){
        $("#aplicar_rr_no_ni").val("on");
        $("#aplicar_rr_no_ni1").prop("checked", true);
    }
    else{
        $("#aplicar_rr_no_ni").val("off");
        $("#aplicar_rr_no_ni1").prop("checked", false);
    }
        
    $("#recomendacion").val($($($(elemento).parent().parent())[0]).find("td").eq(8).html());
    
    $(".box-title, .btn-accion").text("Editar");
    $("#con_puntaje").val(id);
}
function pregunta(elemento) {
    var id = $(elemento).attr('class').match(/\d+/)[0];
    document.location.href = '/admin/recomendaciones/'+id;
}
        </script>
            </div>
            {!! Admin::script() !!}
        {!! Admin::html() !!}
            

        </div>
        
        <button id="totop" title="Ir Arriba" style="display: none;"><i class="fa fa-chevron-up"></i></button>
        
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
    LA.user = @json($_user_);
</script>

<!-- REQUIRED JS SCRIPTS -->


{!! Admin::js() !!}
       
    </body>
</html>