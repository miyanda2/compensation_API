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
    //paginate and filter accros data
    $router->get('/paginate', 'CompensationController@paginateFilt');
    //view all Data
    $router->get('viewAll/compensationData', 'CompensationController@index');  
    //sort data 
    $router->get('/sort', 'CompensationController@sortRequest'); 
    
    $router->post('store/compensationData', 'CompensationController@store'); 

    $router->put('/compensation/{id}', 'CompensationController@update') ; 

    $router->post('/upload_csv', 'CompensationController@importCompensationData');

    $router->get('/minMaxAvgcomp', 'CompensationController@minMaxAvgcomp'); 

    $router->post('/avgCompRole/{role}', 'CompensationController@avgCompRole'); 

     

    $router->get('/sparce', 'CompensationController@sparce');

    

});

//$router::get('import-leads', 'LeadController@index');



