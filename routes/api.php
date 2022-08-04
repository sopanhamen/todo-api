<?php

use Illuminate\Http\Request;
use App\Modules\Auth\AuthController;
use App\Modules\Country\CountryController;
use App\Modules\Province\ProvinceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->get('/logs', fn () => redirect('/telescope'))->middleware('auth:web');

$router->group(['prefix' => 'auth'], function ($router) {
    // $router->post('register', [AuthController::class, 'register']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/logout', [AuthController::class, 'logout']);
    $router->get('/me', [AuthController::class, 'me']);
    $router->get('/permissions', [AuthController::class, 'permissions']);
    $router->put('/update-profile', [AuthController::class, 'updateProfile']);
});

$router->post('/forget-password', [AuthController::class, 'forgetPassword']);
$router->post('/update-password', [AuthController::class, 'updatePassword']);


$router->apiResource('/provinces', ProvinceController::class);
$router->apiResource('/countries', CountryController::class);
$router->post('/countries/exports', [CountryController::class, 'exports'])->name('countries.exports');
