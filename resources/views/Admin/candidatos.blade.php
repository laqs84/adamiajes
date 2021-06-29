<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Candidatos</title>
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
                            Candidatos
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
                                    <form action="candidatos" method="post" id="crear_admin" class="form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data" pjax-container="">
                                        @csrf <!-- {{ csrf_field() }} -->
                                        <div class="box-body">

                                            <div class="fields-group">

                                                <div class="col-md-12">
                                                    <div class="form-group  ">

                                                        <label for="con_emp" class="col-sm-2  control-label">Empresas</label>

                                                        <div class="col-sm-8">
                                                            <select class="form-control" style="width: 100%;" id="con_emp" name="con_emp"  tabindex="-1" aria-hidden="true">
                                                                <option value="0">Selecciona una Empresa</option>
                                                                @foreach($empresas as $item)
                                                                <option data-user="{{$item->email}}" value="{{$item->con_emp}}">{{$item->descripcion}}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" id="con_persona" name="con_persona" value="" class="form-control name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="tipo_identificacion" class="col-sm-2 asterisk control-label">Tipo Identificación</label>

                                                        <div class="col-sm-8">
                                                            <select id="tipo_identificacion" name="tipo_identificacion"  class="form-control">
                                                                <option value="0">Selecciona un Tipo Identificación</option>
                                                                
                                                                <option value="01">Cédula Física</option>

                                                                <option value="02">Cédula Jurídica</option>

                                                                <option value="03">DIMEX</option>

                                                                <option value="04">NITE</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="num_identificacion" class="col-sm-2 asterisk control-label">Número identificación</label>

                                                        <div class="col-sm-8">

                                                            <input type="text" id="num_identificacion" name="num_identificacion" value="" class="form-control name">

                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="nombres" class="col-sm-2  control-label">Nombre Completo</label>

                                                        <div class="col-sm-8">
                                                            <input type="text" id="nombres" name="nombres" class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="apellido1" class="col-sm-2 asterisk control-label">Apellido 1</label>

                                                        <div class="col-sm-8">
                                                            <input type="text" id="apellido1" name="apellido1" value="" class="form-control">

                                                        </div>
                                                    </div>
                                                    <div class="form-group  ">

                                                        <label for="apellido2" class="col-sm-2 asterisk control-label">Apellido 2</label>

                                                        <div class="col-sm-8">
                                                            <input type="text" id="apellido2" name="apellido2" value="" class="form-control">

                                                        </div>

                                                    </div>
                                                
                                                <div class="form-group  ">

                                                    <label for="email" class="col-sm-2  control-label">Email</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" id="email" name="email" value="" class="form-control">

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
                                        <table id="admins" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Empresa</th>
                                                    <th>Tipo de Identificación</th>
                                                    <th>Número identificación</th>
                                                    <th>Nombre Completo</th>
                                                    <th>Apellido 1</th>
                                                    <th>Apellido 2</th>
                                                    <th>Email</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($candidatos as $id=>$json)
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
                    $(function () {

                        (function () {
                            $('#tipo_identificacion').on('change', function() {
                        var x = this.value;

                        if (x == "01") {
                            document.getElementById("num_identificacion").setAttribute("maxlength", 9);

                        }
                        if (x == "02") {
                            document.getElementById("num_identificacion").setAttribute("maxlength", 10);

                        }
                        if (x == "03") {
                            document.getElementById("num_identificacion").setAttribute("maxlength", 12);

                        }
                        if (x == "04") {
                            document.getElementById("num_identificaciontipo_identificacion").setAttribute("maxlength", 12);

                        }
                    })
                            
                        })();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var endpoint = "localhost:8000/admin/";
                        $('#admins').DataTable(
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

                    function eliminar(elemento) {
                        console.log($(elemento));

                        var id = $(elemento).attr('class').match(/\d+/)[0];
                        $.ajax(
                                {
                                    url: "/admin/candidatos/delete/" + id,
                                    type: 'DELETE',
                                    dataType: "JSON",
                                    data: {
                                        "id": id
                                    },
                                    success: function ()
                                    {

                                        var table = $('#admins').DataTable();
                                        table.row($($(elemento).parent()).parents('tr')).remove().draw();
                                    }
                                });

                    }

                    function detalle(elemento) {
                        var id = $(elemento).attr('class').match(/\d+/)[0];

                        $("#con_emp").find('option:contains("' + $($($($(elemento).parent().parent())[0]).find("td").eq(0)[0]).text() + '")').prop('selected', true);
                        $("#tipo_identificacion").val($($($(elemento).parent().parent())[0]).find("td").eq(1).html());
                        $("#num_identificacion").val($($($(elemento).parent().parent())[0]).find("td").eq(2).html());
                        $("#nombres").val($($($(elemento).parent().parent())[0]).find("td").eq(3).html());
                        $("#apellido1").val($($($(elemento).parent().parent())[0]).find("td").eq(4).html());
                        $("#apellido2").val($($($(elemento).parent().parent())[0]).find("td").eq(5).html());
                        $("#email").val($($($(elemento).parent().parent())[0]).find("td").eq(6).html());
                        $(".box-title, .btn-accion").text("Editar");
                        $("#con_persona").val(id);
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
        <div id="kvFileinputModal" class="file-zoom-dialog modal fade" tabindex="-1" aria-labelledby="kvFileinputModalLabel"><div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detailed Preview</h5>
                        <span class="kv-zoom-title"></span>
                        <div class="kv-zoom-actions"><button type="button" class="btn btn-sm btn-kv btn-default btn-outline-secondary btn-toggleheader" title="Toggle header" data-toggle="button" aria-pressed="false" autocomplete="off"><i class="glyphicon glyphicon-resize-vertical"></i></button><button type="button" class="btn btn-sm btn-kv btn-default btn-outline-secondary btn-fullscreen" title="Toggle full screen" data-toggle="button" aria-pressed="false" autocomplete="off"><i class="glyphicon glyphicon-fullscreen"></i></button><button type="button" class="btn btn-sm btn-kv btn-default btn-outline-secondary btn-borderless" title="Toggle borderless mode" data-toggle="button" aria-pressed="false" autocomplete="off"><i class="glyphicon glyphicon-resize-full"></i></button><button type="button" class="btn btn-sm btn-kv btn-default btn-outline-secondary btn-close" title="Close detailed preview" data-dismiss="modal" aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></button></div>
                    </div>
                    <div class="modal-body">
                        <div class="floating-buttons"></div>
                        <div class="kv-zoom-body file-zoom-content krajee-default"></div>
                        <button type="button" class="btn btn-navigate btn-prev" title="View previous file"><i class="glyphicon glyphicon-triangle-left"></i></button> <button type="button" class="btn btn-navigate btn-next" title="View next file"><i class="glyphicon glyphicon-triangle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>