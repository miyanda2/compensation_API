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
    $router->get('/compensation-csv', 'CompensationController@import'); 
    $router->post('store/compensation', 'CompensationController@store');    
    $router->put('/compensation/{id}', 'CompensationController@update') ; 
    $router->delete('/compensation/{id}', 'CompensationController@destroy'); 
    $router->post('/compensation_csv', 'CompensationController@importCompensationData'); 
    $router->post('/min/{loc}', 'CompensationController@minComp'); 
    $router->post('/max/{loc}', 'CompensationController@maxComp'); 
    $router->post('/average/{loc}', 'CompensationController@averageComp'); 
    $router->post('/retriveComp/{role}', 'CompensationController@retriveComp'); 
    $router->post('/sortPage', 'CompensationController@pagiSortFil'); 
    $router->get('/sparce', 'CompensationController@sparce'); 

});

//$router::get('import-leads', 'LeadController@index');



