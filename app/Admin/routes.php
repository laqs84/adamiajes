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
    
    //Empresas
    Route::get('empresas', 'EmpresasController@index')->name('empresas.index');
    
    Route::delete('empresas/delete/{id}', 'EmpresasController@delete')->name('empresas.delete');
    Route::post('empresas', 'EmpresasController@store')->name('empresas.store');
    
    //Empresas Puestos competencias
    Route::get('empresaspuestoscompetencias', 'EmpresasPuestosCompetenciasController@index')->name('empresaspuestoscompetencias.index');
    Route::get('empresaspuestoscompetencias/{id}', 'EmpresasPuestosCompetenciasController@index')->name('empresaspuestoscompetencias.index');
    Route::delete('empresaspuestoscompetencias/delete/{id}', 'EmpresasPuestosCompetenciasController@delete')->name('empresaspuestoscompetencias.delete');
    Route::post('empresaspuestoscompetencias', 'EmpresasPuestosCompetenciasController@store')->name('empresaspuestoscompetencias.store');
    
     //Empresas Niveles
    Route::get('empresasniveles', 'EmpresasNivelesController@index')->name('empresasniveles.index');
    Route::delete('empresasniveles/delete/{id}', 'EmpresasNivelesController@delete')->name('empresasniveles.delete');
    Route::post('empresasniveles', 'EmpresasNivelesController@store')->name('empresasniveles.store');
    
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
