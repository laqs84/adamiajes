<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Prueba Empresarial</title>
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
                            {{$empresa}}
                            <small>Prueba empresarial</small>
                        </h1>
                    </section>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Comenzar</h3>

                                        <div class="box-tools">
                                            <div class="btn-group pull-right" style="margin-right: 5px">
                                                <a href="javascript:history.back()" class="btn btn-sm btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;Atras</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form id="form-creacion" action="personas_pruebas" method="post" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                                        {{ csrf_field() }}
                                        <div class="box-body">

                                            <div class="fields-group">

                                                <div class="col-md-12">

                                                    <div class="form-group  ">
                                                        <label for="nombre" class="col-sm-2  control-label">Bienvenido</label>

                                                        <div class="col-sm-4">
                                                            <input name="nombre" id="nombre" class="form-control nombre" rows="5" placeholder="Nombre"></input>
                                                            <input type="hidden" id="numsec_prueba" name="numsec_prueba" value="{{$numsec_prueba}}">
                                                            <input type="hidden" id="con_emp" name="con_emp" value="{{$con_emp}}">
                                                            <input type="hidden" id="con_persona" name="con_persona" value="{{$con_persona}}">         
                                                            <input type="hidden" id="con_test" name="con_test" value="{{$con_test}}">                                                   
                                                        </div>                                                        
                                                        <label for="puesto" class="col-sm-2  control-label">Puesto aplica</label>

                                                        <div class="col-sm-4">
                                                            <input name="puesto" id="puesto" class="form-control puesto"  placeholder="Puesto" value="{{$puesto}}"></input>

                                                        </div>

                                                    </div>
                                                  
                                                    <div class="form-group  ">

                                                        <label for="fecha_prueba" class="col-sm-2  control-label">Fecha actual</label>

                                                        <div class="col-sm-4">
                                                            <input name="fecha_actual" id="fecha_actual" type="text" class="form-control fecha_actual"  placeholder="Fecha de prueba" value="<?php echo date('d/m/Y');?>"></input>
                                                        </div>

                                                        <label for="tiempo_limite" class="col-sm-2  control-label">Tiempo Límite</label>

                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="tiempo_limite" name="tiempo_limite" value="{{$tiempo_limite}}">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.box-body -->

                                        <div class="box-footer">



                                            <div class="col-md-2">
                                            </div>
@if ($descripcion === "")
                                            <div class="col-md-8">

                                                <div class="btn-group pull-right">
                                                    <button type="submit" class="btn btn-primary btn-accion">Comenzar</button>
                                                </div>
                                            </div>
@endif                                            
                                        </div>

                                        <!-- /.box-footer -->
                                    </form>
<div id=encabezado>                                  
<div id="descripcion">

@if ($descripcion != "")
    <h2 id="desc_titel">
    {{$descripcion}}
    </h2>
@endif  
  
</div>
<div id="instrucciones">
    
@if ($instrucciones != "")
    <h3 >
    Instrucciones
    </h3>
   <h4 id="desc_instruc">
    {{$instrucciones}}
   </h4>
@endif  
  
</div>
</div>
<div id="preguntas">
   <input type="number" id="con_comp_t" hidden="">
   <h2 id = "competencia_t"></h2> 
   <input type="number" id="con_preg_t" hidden="">
   <h3 id = "pregunta_t"></h3> 
   <div id="opciones">
   </div>
</div>
@if ($descripcion != "")
                                            <div id="butcon" class="col-md-8">

                                                <div class="btn-group pull-right">
                                                    <button id = "sigacc" type="button" class="btn btn-primary btn-accion">Continuar</button>
                                                </div>
                                            </div>
                                            <div id="butenv" class="col-md-8" hidden="">

                                                <div class="btn-group pull-right">
                                                    <button id = "enviacc" type="button" class="btn btn-primary btn-accion">Enviar</button>
                                                </div>
                                            </div>                                            
@endif  
      

                            </div>
                        </div>
                    </section>

                </div>
 <script>
$(document).ready(function () {
    sessionStorage.clear();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var endpoint = "localhost:8000/admin/";

});
</script>
        <script>
      function create_radio(numero,detalle){
          div = document.getElementById("opciones");
          var lab = document.createElement("Label");
          lab.innerHTML = detalle + "   ";
          var para = document.createElement("input");
          lab.setAttribute("for","opcion-" + numero);
          para.type = "radio";
          para.name = "opcion";
          para.id = "opcion-" + numero;
          para.setAttribute("valor",numero);
          document.body.appendChild(lab);
          lab.appendChild(para);        
          opciones.appendChild(lab);    
          var hr = document.createElement("hr");
          opciones.appendChild(hr);
      }
      // Department Change

      tipo_calificacion = 0;
      finaliza = 0;
      listtest = "";
      keyact = 0;

      $('#enviacc').click(function(){

        for (const key in sessionStorage) {
          console.log(`${key}: ${sessionStorage.getItem(key)}`);
          if(key.substr(0, 5)=="resp-"){
            item = sessionStorage.getItem(key);
          $.ajax({
            url: 'updatePrueba/'+item,
            type: 'get',
            dataType: 'json',
            success: function(response){
 console.log(response);

            }
          })
          }
        }
      });

      $('#sigacc').click(function(){
        var id = $('#con_test').val();
        $("#instrucciones").hide();

         // AJAX request 
         var BreakException = {};
         console.log("sigacc " + keyact);
        if(keyact==0){
            console.log("keyact 0 " + id);
          $.ajax({
            url: 'getPreguntas/'+id,
            type: 'get',
            dataType: 'json',
            success: function(response){

            res = response.data;
            keycurrent = 0;
            totreg = Object.keys(res).length;

            Object.keys(res).forEach(function(key) {

              console.log('Key : ' + key + ', Value : ' + res[key])
              res2 = res[key];
              keyact = key;
              Object.keys(res2).forEach(function(key2) {
                if(key2=="tipo_calificacion"){
                  tipo_calificacion = res2[key2];
                }
                if(key2=="con_comp"){                  
                  $('#con_comp_t').val(res2[key2]);
                }
                if(key2=="competencia_desc"){               
                  $('#competencia_t').text(res2[key2]);
                }  
                if(key2=="con_preg"){
console.log("con_preg = " + keycurrent + " " + res2[key2])                    ;
                  if(keycurrent==0){
                    keycurrent = res2[key2];
                  }
                  else{
                    if(keycurrent!=res2[key2]){     
                    console.log("Salir")                   ;
                    throw BreakException;
                    }
                  }
                  $('#con_preg_t').val(res2[key2]);

                }
                if(key2=="pregunta_desc"){
                  $('#pregunta_t').text(res2[key2]);
                }                                
                if(key2=="con_opci"){
                  con_opcion = res2[key2];
                }
                if(key2=="opcion_desc"){
                  if(tipo_calificacion=="Puntaje"){ //puntaje
                    create_radio(con_opcion,res2[key2]);
                  }    
                  if(tipo_calificacion=="Frecuencia"){ //puntaje
                    createradio = 1;
                    create_radio(con_opcion,res2[key2]);
                  }   
                  if(tipo_calificacion=="Balance"){ //puntaje
                    createradio = 1;
                    create_radio(con_opcion,res2[key2]);
                  }                                                         
                }                

                console.log('Key2 : ' + key2 + ', Value2 : ' + res2[key2])

              })
            })
            }
          });            
        }
        else{
var all = document.getElementsByName("opcion");
console.log(all);
numchecks = 0;
for (var i=0, max=all.length; i < max; i++) {
     // Do something with the element here
  if(all[i].checked)   {
    numchecks++;
    con_testv = document.getElementById("con_test").value;
    numsec_pruebav = document.getElementById("numsec_prueba").value;
    con_personav = document.getElementById("con_persona").value;
    con_pregv = document.getElementById("con_preg_t").value;
    con_opcv = document.getElementById(all[i].id).getAttribute("valor");
    con_compv = document.getElementById("con_comp_t").value;
    con_empv = document.getElementById("con_emp").value;

    respuesta = "resp-" + con_pregv;
    sessionStorage.setItem(respuesta, JSON.stringify({con_test: con_testv,numsec_prueba: numsec_pruebav, con_persona: con_personav, con_emp : con_empv, con_comp : con_compv, con_preg : con_pregv, con_opc : con_opcv}));
for (const key in sessionStorage) {
    console.log(`${key}: ${sessionStorage.getItem(key)}`);
}
  }
}
if(numchecks==0){
    alert("Disculpe, debe elegir una opcion para avanzar");
    return;
}

            if(finaliza==1){
              if(listtest==""){
                listtest = id;
              }
              else{
                str2 = "," + id;
                listtest = listtest.concat(str2);
              }
              console.log("Finalizooooooooooooooo");
          $.ajax({
            url: 'getNextTest/'+listtest,
            type: 'get',
            dataType: 'json',
            success: function(response){
 
              h = document.getElementById("desc_titel");
              h.innerHTML = response.data.descripcion;

              if(response.data.instrucciones!=""){
                h = document.getElementById("desc_instruc");
                h.innerHTML = response.data.instrucciones;
                $("#instrucciones").show();
              }              
              else{

              }
              $('#con_test').val(response.data.con_test);
              $('#competencia_t').text("");
              $('#pregunta_t').text("");
              $('#opciones').empty();
              finaliza=0;
              keyact = 0;
              if(response.data.con_test == 0){
                h = document.getElementById("desc_titel");
                h.innerHTML = "Felicidades ha finalizado la prueba";
                h = document.getElementById("desc_instruc");
                h.innerHTML = "Haga click en Enviar para completar la prueba";
                $("#instrucciones").show();          
                b = document.getElementById("butenv");
                b.style.display = "block";      
                b = document.getElementById("butcon");
                b.style.display = "none";      

              }
            }
          })
            }
console.log("keyact else");

            keycurrent = 0;
            
            $('#opciones').empty();
            createradio = 0;
            Object.keys(res).forEach(function(key) {

              console.log('Key : ' + key + ', Value : ' + res[key])
              res2 = res[key];
        console.log("Verifica: " + keyact + " " + key);
        console.log(typeof keyact);
        console.log(typeof key);
              if(parseInt(keyact)<=parseInt(key)){

              console.log("Entro");
              
              Object.keys(res2).forEach(function(key2) {
                if(key2=="tipo_calificacion"){
                  tipo_calificacion = res2[key2];
                }
                if(key2=="con_comp"){                  
                  $('#con_comp_t').val(res2[key2]);
                }
                if(key2=="competencia_desc"){               
                  $('#competencia_t').text(res2[key2]);
                }  
                if(key2=="con_preg"){
                    console.log("-->" + key + " " + key2 + " " + res2[key2] + " * " + keycurrent + " -- " +keyact);
                  if(keycurrent==0){
                    keycurrent = res2[key2];
                  }
                  else{
                    if(keycurrent!=res2[key2]){
                        keyact = key;
                    console.log("Salir")                   ;
                    throw BreakException;
                    }
                  }
                  $('#con_preg_t').val(res2[key2]);
                }
                if(key2=="pregunta_desc"){
                  $('#pregunta_t').text(res2[key2]);
                }                                
                if(key2=="con_opci"){
                  con_opcion = res2[key2];
                }
                if(key2=="opcion_desc"){
                  if(tipo_calificacion=="Puntaje"){ //puntaje
                    createradio = 1;
                    create_radio(con_opcion,res2[key2]);
                  }  
                  if(tipo_calificacion=="Frecuencia"){ //puntaje
                    createradio = 1;
                    create_radio(con_opcion,res2[key2]);
                  }              
                  if(tipo_calificacion=="Balance"){ //puntaje
                    createradio = 1;
                    create_radio(con_opcion,res2[key2]);
                  }                                                               
                }                

                console.log("key : " + key + " " + 'Key2 : ' + key2 + ', Value2 : ' + res2[key2])
                if(totreg - 1 == key){
                    console.log("finaliza");
                    finaliza=1;
                }
              })
          }
            })


        }

      });
        </script>
            </div>

            {!! Admin::script() !!}
        {!! Admin::html() !!}

        </div>

        <button id="totop" title="Ir Arriba" style="display: none;"><i class="fa fa-chevron-up"></i></button>



<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
    LA.user = @json($_user_);
</script>

<!-- REQUIRED JS SCRIPTS -->


{!! Admin::js() !!}
    </body>
</html>