<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Preguntas</title>
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
                            Preguntas
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
                                    <form id="form-creacion" action="/admin/preguntas" method="post" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                                        @csrf <!-- {{ csrf_field() }} -->
                                        <div class="box-body">

                                            <div class="fields-group">

                                                <div class="col-md-12">
                                                    <div class="form-group  ">

                                                        <label for="descripcion" class="col-sm-2  control-label">Descripci??n</label>

                                                        <div class="col-sm-8">
                                                            <textarea name="descripcion" id="descripcion" class="form-control descripcion" rows="5" placeholder="Descripci??n"></textarea>
                                                            <input type="hidden" id="con_preg" name="con_preg">
                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="tipo_comp" class="col-sm-2  control-label">Competencias</label>

                                                        <div class="col-sm-8">
                                                            <select class="form-control" style="width: 100%;" id="con_comp" name="con_comp"  tabindex="-1" aria-hidden="true">
                                                                @foreach($competencias as $item)
                                                                <option value="{{$item->con_comp}}">{{$item->descripcion}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group  ">

                                                        <label for="preg_asoc" class="col-sm-2  control-label">Pregunta Asociada</label>

                                                        <div class="col-sm-8">
                                                            <select class="form-control" style="width: 100%;" id="preg_asoc" name="preg_asoc"  tabindex="-1" aria-hidden="true">
                                                               <option value="0">Ninguna</option>
                                                                @foreach($preguntas1 as $item)
                                                                <option value="{{$item->con_preg}}">{{$item->descripcion}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">
                                                        <div class="col-sm-12">
                                                             <label for="aplicar_rr_no_ni" class="col-sm-6  control-label">Score</label>
                                                            <input type="checkbox" class="form-check-input" name="score1" id="score1">  
                                                            <input type="hidden" id="score" name="score">

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

                                    <div class="box-body">
                                        <table id="preguntas" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Descripci??n</th>
                                                    <th>Competencias</th>
                                                    <th>Pregunta Asociada</th>
                                                    <th>Score</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($preguntas as $id=>$json)
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
    
    $("#score1").prop("checked", false);
    $("#score").val("off");
    $('#score1').click(function() {
    if (!$(this).is(':checked')) {
      $("#score").val("off");
      $("#score1").prop("checked", false);
    }
    else{
      $("#score").val("on");
      $("#score1").prop("checked", true);
    }
  });
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#preguntas').DataTable(
            {
                language: {
                    "decimal": "",
                    "emptyTable": "No hay informaci??n",
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
                url: "/admin/preguntas/delete/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id
                },
                success: function ()
                {
                    
                    var table = $('#preguntas').DataTable();
                    table.row($($(elemento).parent()).parents('tr')).remove().draw();
                }
            });

}
function detalle(elemento) {
    
//$(select).html('');
$('#preg_asoc').empty();
var data = @json($preguntas1) ;
var options = "";
options += "<option value'0'>Ninguna</option>";
for (var i = 0; i < data.length; i++) {
  options += `<option value=${data[i].con_preg}>${data[i].descripcion}</option>`;//<--string 
                                                             //interpolation
}
    $("#preg_asoc").append(options);
    var id = $(elemento).attr('class').match(/\d+/)[0];
     $("#descripcion").val($($($(elemento).parent().parent())[0]).find("td").eq(0).html());
     $("#con_comp").find('option:contains("'+$($($($(elemento).parent().parent())[0]).find("td").eq(1)[0]).text()+'")').prop('selected', true);
     $("#preg_asoc").find('option:contains("'+$($($($(elemento).parent().parent())[0]).find("td").eq(0)[0]).text()+'")').remove();
     if($($($(elemento).parent().parent())[0]).find("td").eq(2).html() == "Si"){
        $("#aplicar_rr_no_ni").val("on");
        $("#aplicar_rr_no_ni1").prop("checked", true);
    }
    else{
        $("#aplicar_rr_no_ni").val("off");
        $("#aplicar_rr_no_ni1").prop("checked", false);
    }
     $(".box-title, .btn-accion").text("Editar");
     $("#con_preg").val(id);
}
function pregunta(elemento) {
    var preg = $(elemento).attr('data-pregunta');
    var id = $(elemento).attr('class').match(/\d+/)[0];
    document.location.href = '/admin/preguntas-opciones/'+id+'/'+preg;
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