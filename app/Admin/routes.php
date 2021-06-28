<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'CompetenciasController@index')->name('home');
    //Competencias
    Route::get('competencias', 'CompetenciasController@index')->name('competencias.index');
    Route::delete('competencias/delete/{id}', 'CompetenciasController@delete')->name('competencias.delete');
    Route::post('competencias', 'CompetenciasController@store')->name('competencias.store');
    
    //Competencias Niveles
    Route::get('competenciasniveles', 'CompetenciasNivelesController@index')->name('competenciasniveles.index');
    Route::delete('competenciasniveles/delete/{id}', 'CompetenciasNivelesController@delete')->name('competenciasniveles.delete');
    Route::post('competenciasniveles', 'CompetenciasNivelesController@store')->name('competenciasniveles.store');
    
    //Preguntas
    Route::get('preguntas/{id}', 'PreguntasController@index')->name('preguntas.index');
    Route::get('preguntas', 'PreguntasController@index')->name('preguntas.index');
    Route::delete('preguntas/delete/{id}', 'PreguntasController@delete')->name('preguntas.delete');
    Route::post('preguntas/{id}', 'PreguntasController@store')->name('preguntas.store');
    Route::post('preguntas', 'PreguntasController@store')->name('preguntas.store');
    
    //Preguntas Opciones
    Route::get('preguntas-opciones/{id}/{idpreg}', 'PreguntasOpcionesController@index')->name('preguntas_opciones.index');
    Route::get('preguntas-opciones', 'PreguntasOpcionesController@index')->name('preguntas-opciones.index');
    Route::delete('preguntas-opciones/delete/{id}', 'PreguntasOpcionesController@delete')->name('preguntas-opciones.delete');
    Route::post('preguntas-opciones/{id}/{idpreg}', 'PreguntasOpcionesController@store')->name('preguntas-opciones.store');
    Route::post('preguntas-opciones', 'PreguntasOpcionesController@store')->name('preguntas-opciones.store');

    //$router->get('/', 'CalificacionResultadosController@index')->name('home');
    //Calificacion resultados
    Route::get('calificacion_resultados', 'CalificacionResultadosController@index')->name('calificacion_resultados.index');
    Route::delete('calificacion_resultados/delete/{id}', 'CalificacionResultadosController@delete')->name('calificacion_resultados.delete');
    Route::post('calificacion_resultados', 'CalificacionResultadosController@store')->name('calificacion_resultados.store');
    Route::get('/getCompetencias/{id}', 'CalificacionResultadosController@getCompetencias');

    
    //Recomendaciones
    Route::get('recomendaciones/{id}', 'RecomendacionesController@index')->name('recomendaciones.index');
    Route::get('recomendaciones', 'RecomendacionesController@index')->name('recomendaciones.index');
    Route::delete('recomendaciones/delete/{id}', 'RecomendacionesController@delete')->name('recomendaciones.delete');
    Route::post('recomendaciones/{id}', 'RecomendacionesController@store')->name('recomendaciones.store');
    Route::post('recomendaciones', 'RecomendacionesController@store')->name('recomendaciones.store');
    
    //Empresas
    
    Route::get('empresas', 'EmpresasController@index')->name('empresas.index');
    
    Route::delete('empresas/delete/{id}', 'EmpresasController@delete')->name('empresas.delete');
    Route::post('empresas', 'EmpresasController@store')->name('empresas.store');
    
    //Empresas Puestos competencias
    Route::get('empresaspuestoscompetencias', 'EmpresasPuestosCompetenciasController@index')->name('empresaspuestoscompetencias.index');
    Route::get('empresaspuestoscompetencias/{id}', 'EmpresasPuestosCompetenciasController@index')->name('empresaspuestoscompetencias.index');
    Route::delete('empresaspuestoscompetencias/delete/{id}', 'EmpresasPuestosCompetenciasController@delete')->name('empresaspuestoscompetencias.delete');
    Route::post('empresaspuestoscompetencias/{id}', 'EmpresasPuestosCompetenciasController@store')->name('empresaspuestoscompetencias.store');
    Route::get('empresaspuestoscompetencias/getDetalles/', 'EmpresasPuestosCompetenciasController@getDetalles');
    
     //Empresas Niveles
    Route::get('empresasniveles', 'EmpresasNivelesController@index')->name('empresasniveles.index');
    Route::delete('empresasniveles/delete/{id}', 'EmpresasNivelesController@delete')->name('empresasniveles.delete');
    Route::post('empresasniveles', 'EmpresasNivelesController@store')->name('empresasniveles.store');

    //Empresas pruebas
    Route::get('empresa_pruebas', 'EmpresaPruebasController@index')->name('empresa_pruebas.index');
    
    Route::delete('empresa_pruebas/delete/{id}', 'EmpresaPruebasController@delete')->name('empresa_pruebas.delete');
    Route::post('empresa_pruebas', 'EmpresaPruebasController@store')->name('empresa_pruebas.store');

    //Empresas pruebas detalle
    Route::get('empresa_pruebas_detalle/{id}', 'EmpresaPruebasDetalleController@index')->name('empresa_pruebas_detalle.index');
    
    Route::delete('empresa_pruebas_detalle/delete/{id}', 'EmpresaPruebasDetalleController@delete')->name('empresa_pruebas_detalle.delete');
    Route::post('empresa_pruebas_detalle/{id}', 'EmpresaPruebasDetalleController@store')->name('empresa_pruebas_detalle.store');

    //Empresas pruebas base
    Route::get('empresas_pruebas_base', 'EmpresasPruebasBaseController@index')->name('empresas_pruebas_base.index');
    
    Route::delete('empresas_pruebas_base/delete/{id}', 'EmpresasPruebasBaseController@delete')->name('empresas_pruebas_base.delete');
    Route::post('empresas_pruebas_base', 'EmpresasPruebasBaseController@store')->name('empresas_pruebas_base.store');

    //Empresas pruebas base detalle
    Route::get('emp_pru_base_detalle/{id}', 'EmpresasPruebasBaseDetalleController@index')->name('emp_pru_base_detalle.index');
    
    Route::delete('emp_pru_base_detalle/delete/{id}', 'EmpresasPruebasBaseDetalleController@delete')->name('emp_pru_base_detalle.delete');
    Route::post('emp_pru_base_detalle/{id}', 'EmpresasPruebasBaseDetalleController@store')->name('emp_pru_base_detalle.store');

    //Personas pruebas
    Route::get('personas_pruebas/{id}/{per}', 'PersonasPruebasController@index')->name('personas_pruebas.index');
    
    Route::delete('personas_pruebas/delete/{id}', 'PersonaPruebasController@delete')->name('persona_pruebas.delete');
    Route::post('persona_pruebas', 'PersonaPruebasController@store')->name('persona_pruebas.store');

    
     //Empresas tipos
    Route::get('competenciastipos', 'CompetenciasTiposController@index')->name('competenciastipos.index');
    Route::delete('competenciastipos/delete/{id}', 'CompetenciasTiposController@delete')->name('competenciastipos.delete');
    Route::post('competenciastipos', 'CompetenciasTiposController@store')->name('competenciastipos.store');
    
    //Puestos
    Route::get('puestos', 'PuestosController@index')->name('puestos.index');
    Route::delete('puestos/delete/{id}', 'PuestosController@delete')->name('puestos.delete');
    Route::post('puestos', 'PuestosController@store')->name('puestos.store');
    
    //Puestos Clasificaciones
    Route::get('puestosclasificaciones', 'PuestosClasificacionController@index')->name('puestosclasificaciones.index');
    Route::delete('puestosclasificaciones/delete/{id}', 'PuestosClasificacionController@delete')->name('puestosclasificaciones.delete');
    Route::post('puestosclasificaciones', 'PuestosClasificacionController@store')->name('puestosclasificaciones.store');
});
