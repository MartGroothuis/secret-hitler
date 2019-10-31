<?php

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

// het aanmaken en verwijderen van rooms
Route::middleware('auth:api')->post('rooms', 'RoomController@store');
Route::middleware('auth:api')->get('rooms/delete', 'RoomController@delete');

// het joinen en leaven van rooms
Route::middleware('auth:api')->get('rooms/join/{room}', 'PlayerController@joinRoom');
Route::middleware('auth:api')->get('rooms/leave', 'PlayerController@leaveRoom');

//spelers moeten ready zijn voordat het spel kan beginnen 
Route::middleware('auth:api')->get('players/ready', 'PlayerController@playerReady');

Route::middleware('auth:api')->put('players/choose-chancellor/{Chancellor}', 'PlayerController@chooseChancellor');
Route::middleware('auth:api')->put('players/vote/{vote}', 'PlayerController@vote');


Route::middleware('auth:api')->get('rooms/cards/president', 'RoomController@getPresidentCards');
Route::middleware('auth:api')->get('rooms/cards/chancellor', 'RoomController@getChancellorCards');
Route::middleware('auth:api')->put('rooms/cards/{discardCard}', 'RoomController@discardCard');


Route::middleware('auth:api')->get('data', 'PlayerController@index');
Route::middleware('auth:api')->get('rooms/data', 'RoomController@data');



Route::middleware('auth:api')->get('rooms', 'RoomController@index');
Route::middleware('auth:api')->get('rooms/{room}', 'RoomController@show');
Route::middleware('auth:api')->post('room', 'RoomController@store');
Route::middleware('auth:api')->put('room/{room}', 'RoomController@update');
Route::middleware('auth:api')->delete('room/{room}', 'RoomController@delete');
Route::middleware('auth:api')->delete('rooms/destroy', 'RoomController@destroy');

Route::middleware('auth:api')->get('player', 'PlayerController@show');
Route::middleware('auth:api')->post('player', 'PlayerController@store');
Route::middleware('auth:api')->put('player/{player}', 'PlayerController@update');
Route::middleware('auth:api')->delete('player/{player}', 'PlayerController@delete');
Route::middleware('auth:api')->delete('players/destroy', 'PlayerController@destroy');