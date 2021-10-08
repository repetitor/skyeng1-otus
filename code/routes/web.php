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

//$router->get('/', function () use ($router) {
//    return $router->app->version();
//});

$router->get('/', function () use ($router) {
    return 'Please use REST API ';
});
$router->get('/test-redis', 'ExampleController@testRedis');


$router->group(['prefix' => 'api2'], function() use ($router) {
    $router->group(['prefix' => 'v1'], function() use ($router) {
        $router->post('/student/{id:\d+}/rate-task', 'API\V1\Student\StudentController@rateTask');
        $router->get(
            '/aggregation/{aggregation_type}/student/{student_id:\d+}',
            'API\V1\Aggregation\AggregationController@getAggregationForstudentByType'
        );
    });
});//*/
