<?php

use Illuminate\Http\Request;
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
$router->apiResource('/provinces', ProvinceController::class);
$router->apiResource('/countries', CountryController::class);
$router->post('/countries/exports', [CountryController::class, 'exports'])->name('countries.exports');

// Route::middleware('auth')->get('/user', function (Request $request) {
//     return $request->user();
// });
