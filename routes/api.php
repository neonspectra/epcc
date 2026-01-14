<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\HighLevelCreatorController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

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

Route::get('/version', function() {
    return [
        'version'     => config('epcc.displayVersion'),
        'versionName' => config('epcc.displayVersionName'),
        'releaseDate' => config('epcc.releaseDate')->format('F Y'),
//            Use this once Laravel allows Carbon 2: 'releaseDate' => config('epcc.releaseDate')->isoFormat('MMMM G')
        'versionNumberMin' => config('epcc.versionNumberMin'),
    ];
});

Route::prefix('creator')->group(function () {
    Route::get('/', [HighLevelCreatorController::class, 'get']);
    Route::post('/', [HighLevelCreatorController::class, 'store']);
    Route::get('/validate', [HighLevelCreatorController::class, 'validateCharacter']);
    Route::get('/save', [HighLevelCreatorController::class, 'save']);
    Route::post('/load', [HighLevelCreatorController::class, 'update']);
});
Route::prefix('character')->group(function () {
    Route::get('', [CharacterController::class, 'get']);
});
