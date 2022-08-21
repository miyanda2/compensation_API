<?php



/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix'=>'/'], function () use ($router){
    $router->get('view/compensation', 'CompensationController@index');  
    $router->post('store/compensation', 'CompensationController@store');    
    $router->put('/compensation/{id}', 'CompensationController@update') ; 
    $router->post('/upload_csv', 'CompensationController@importCompensationData'); 
    $router->get('/minMaxAvgcomp', 'CompensationController@minMaxAvgcomp'); 
    $router->post('/avgCompRole/{role}', 'CompensationController@avgCompRole'); 
    $router->get('/paginate', 'CompensationController@paginateFilt'); 
    $router->get('/sparce', 'CompensationController@sparce'); 
    $router->get('/sort', 'CompensationController@sortRequest'); 

});

//$router::get('import-leads', 'LeadController@index');



