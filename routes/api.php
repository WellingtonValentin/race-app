<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/runners', 'RunnerController');
Route::apiResource('/competitions', 'CompetitionController');
Route::apiResource('/runner-competitions', 'RunnerCompetitionController');
Route::apiResource('/competition-results', 'CompetitionResultController');
Route::get('/classification', 'CompetitionResultController@competitionClassification');
Route::get('/classification-by-age', 'CompetitionResultController@competitionClassificationByAge');
