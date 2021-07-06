<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Informes de las pruebas de los candidatos</title>
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
<div id="titulo" hidden="">
                    <section class="content-header">
                       <center> 
                        <h1>
                            EVALUACION PSICOCOMPETENCIAL
                        </h1>
                        <h3 id = "nombre"></h3>  
                        <h3 id = "empresa"></h3>  
                        <h4 id = "puesto"></h4>  
                        <h4>Fecha de evaluación</h4>                                    
                        <h4 id = "fecha"></h4> 

                        
                        </center>
                    </section>                    
</div>                                      
<div id="title">
                    <section class="content-header">
                        <h1>
                            Informes de las pruebas de los candidatos
                            <small>Mantemiento</small>
                        </h1>
                    </section>
</div>                    
                    <section class="content">

                      <div id="informe">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Informes</h3>

                                        <div class="box-tools">
                                            <div class="btn-group pull-right" style="margin-right: 5px">
                                                <a href="javascript:history.back()" class="btn btn-sm btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;Atras</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->

                                    <div class="box-body">
                                        <table id="admins" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Empresa</th>
                                                    <th>Candidato</th>
                                                    <th>Puesto</th>
                                                    <th>Fecha Creación</th>
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
                      </div>
                      <div id="resultado" hidden="">
                          <div id=parrafo1>
                            <p>El presente informe registra los resultados obtenidos por <b id="nompar1"> Jorge Pacheco Corrales</b> en la evaluación psicocompetencial para el puesto <b id="puepar1">Analista de tesorería</b>.</p>
                            <p>Se le aplicaron las <b>siguientes pruebas:</b></p>
                          </div>
                      </div>
                    </section>
                </div>
<div>
    <button onclick="pdf()">PDF</button>
</div>
                <script>
                    $(function () {

                        (function () {
                           
                        })();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
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
function pdf(){
    alert("hola");
    id=29;
var data = '';
        $.ajax({
            type: 'GET',
            url: "/admin/candidatospruebas/download/"+ id,
            data: data,
success: function(blob, status, xhr) {

                    var ieEDGE = navigator.userAgent.match('/Edge/g');
                    var ie = navigator.userAgent.match('/.NET/g'); // IE 11+
                    var oldIE = navigator.userAgent.match('/MSIE/g');

                    if (ie || oldIE || ieEDGE) {
                        window.navigator.msSaveBlob(blob, fileName);
                    } else {
var binaryData = [];
binaryData.push(blob);
                     fileURL= binaryData;
                        // var fileURL = window.URL.createObjectURL(new Blob(binaryData, {type: "application/pdf"}))
                        document.write('<iframe src="' + fileURL + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');
                    }
                },
            error: function(blob){
                console.log(blob);
            }
        });    
  
}
function informe(id) {

    $.ajax(
            {
                url: "/admin/candidatospruebas/informe/" + id,
                type: 'GET',
                dataType: "JSON",
                success: function (response)
                {

console.log("AAABBBB");
console.log(response.data);
              h = document.getElementById("informe");
              h.style.display = "none"; 
              h = document.getElementById("resultado");
              h.style.display = "block";               
              h = document.getElementById("title");
              h.style.display = "none"; 
              h = document.getElementById("titulo");
              h.style.display = "block"; 
              h = document.getElementById("nombre");
              h.innerHTML = response.data.nombre;
              h = document.getElementById("puesto");
              h.innerHTML = response.data.puesto;

              h = document.getElementById("nompar1");
              h.innerHTML = response.data.nombre;              
              h = document.getElementById("puepar1");
              h.innerHTML = response.data.puesto;    

              h = document.getElementById("empresa");
              h.innerHTML = response.data.empresa;
              h = document.getElementById("fecha");
              h.innerHTML = response.data.fecha;
              
                }
            });
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