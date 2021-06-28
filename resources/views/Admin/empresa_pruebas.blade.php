<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Pruebas de Empresa</title>
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
                            Pruebas de Empresa
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
                                    <form id="form-creacion" action="empresa_pruebas" method="post" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                                        {{ csrf_field() }}
                                        <div class="box-body">

                                            <div class="fields-group">

                                                <div class="col-md-12">
                                                    <div class="form-group  ">

                                                        <label for="comp_emp" class="col-sm-4  control-label">Empresa</label>

                                                        <div class="col-sm-8">
                                                            <select class="form-control" style="width: 100%;" id="con_emp" name="con_emp"  tabindex="-1" aria-hidden="true">
                                                                @foreach($empresas as $item)
                                                                <option value="{{$item->con_emp}}">{{$item->descripcion}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="tipo_comp" class="col-sm-4  control-label">Puesto</label>

                                                        <div class="col-sm-8">
                                                            <select class="form-control" style="width: 100%;" id="con_pue" name="con_pue"  tabindex="-1" aria-hidden="true">
                                                                @foreach($puestos as $item)
                                                                <option value="{{$item->con_pue}}">{{$item->descripcion}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="descripcion" class="col-sm-4  control-label">Descripción/Nombre</label>

                                                        <div class="col-sm-8">
                                                            <textarea name="descripcion" id="descripcion" class="form-control descripcion" rows="5" placeholder="Descripción"></textarea>
                                                            <input type="hidden" id="con_test" name="con_test">

                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="fecha_inicio" class="col-sm-4  control-label">Valido desde</label>

                                                        <div class="col-sm-8">
                                                            <input name="fecha_inicio" id="fecha_inicio" type="date" class="form-control fecha_inicio"  placeholder="Fecha de inicio"></textarea>
                                                        </div>
                                                    </div>                                                                     
                                                    <div class="form-group  ">

                                                        <label for="fecha_limite" class="col-sm-4  control-label">Valido hasta</label>

                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="tiempo_limite" class="col-sm-4  control-label">Tiempo Límite</label>

                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control" id="tiempo_limite" name="tiempo_limite" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="link_prueba" class="col-sm-4  control-label">Link Prueba</label>

                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="link_prueba" name="link_prueba" value="https://andamiajescr.com/admin?test=" disabled>
                                                        </div>
                                                        <input type="hidden" class="form-control" id="numsec_prueba" name="numsec_prueba" hidden="">                                                        
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
                                                    <th>Nombre</th>
                                                    <th>Puesto</th>
                                                    <th>Válido desde</th>
                                                    <th>Válido hasta</th>
                                                    <th>Tiempo Límite</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($empresa_pruebas as $id=>$json)
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
                url: "/admin/empresa_pruebas/delete/" + id,
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

    $("#descripcion").val($($($(elemento).parent().parent())[0]).find("td").eq(0).html());
 
    $("#con_pue").find('option:contains("'+$($($($(elemento).parent().parent())[0]).find("td").eq(1)[0]).text()+'")').prop('selected', true);    
    $("#fecha_inicio").val($($($(elemento).parent().parent())[0]).find("td").eq(2).html());
    $("#fecha_limite").val($($($(elemento).parent().parent())[0]).find("td").eq(3).html());    
    $("#tiempo_limite").val($($($(elemento).parent().parent())[0]).find("td").eq(4).html());    
    $(".box-title, .btn-accion").text("Editar");
    $("#numsec_prueba").val(id);
}
function agrega_test(elemento) {
    var id = $(elemento).attr('class').match(/\d+/)[0];
    document.location.href = '/admin/empresa_pruebas_detalle/'+id;
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