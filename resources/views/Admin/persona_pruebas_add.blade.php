<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{$titulo}}</title>
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
                            {{$titulo}}
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
                                    <form id="form-creacion" action="persona_pruebas_add" method="post" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                                        @csrf <!-- {{ csrf_field() }} -->
                                        <div class="box-body">

                                            <div class="fields-group">

                                                <div class="col-md-12">
                                                    <div class="form-group  ">

                                                        <label for="con_persona" class="col-sm-2  control-label">Candidatos</label>

                                                        <div class="col-sm-8">
                                                            <select class="form-control" style="width: 100%;" id="con_persona" name="con_persona"  tabindex="-1" aria-hidden="true">
 
                                                            </select>
                                                            <input type="hidden" id="numsec_prueba" name="numsec_prueba" value="{{$numsec_prueba}}">
                                                            <input type="hidden" id="con_emp" name="con_emp" value="{{$con_emp}}">
                                                                                                               
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
                                        <table id="competencias" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Link</th>
                                                    <th>Secuencial</th>
                                                    <th>Persona</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($persona_pruebas as $id=>$json)
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#con_persona").select2({
      placeholder: 'Seleccione una persona',     
      ajax: {
           url: 'getPersonas',
           type: 'post',
           dataType: 'json',
        data: function(params){
             return {
              numsec_prueba : document.getElementById("numsec_prueba").value,
              search: params.term // search term
            };

console.log(query);
      // Query parameters will be ?search=[term]&type=public

        },

        processResults: function(data) {
            console.log(data);            
          return {
              results:data              
          };  
        },
        cache : true,
        success    : function (data) {
          console.log( data );

          
        },
        error    : function (data) {
          console.log( data );

          
        }        
    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
      }      
    }   
            );        
    var endpoint = "localhost:8000/admin/";
    $('#competencias').DataTable(
            {
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
                url: "/admin/persona_pruebas_add/delete/" + id,
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
    debugger;
    var id = $(elemento).attr('class').match(/\d+/)[0];
    $("#con_emp").find('option:contains("'+$($($($(elemento).parent().parent())[0]).find("td").eq(0)[0]).text()+'")').prop('selected', true);
    $("#con_test").find('option:contains("'+$($($($(elemento).parent().parent())[0]).find("td").eq(2)[0]).text()+'")').prop('selected', true);
    $(".box-title, .btn-accion").text("Editar");
    $("#con_detpru").val(id);
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