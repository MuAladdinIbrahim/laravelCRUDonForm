<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', 'API\PostController@index')->middleware('auth:sanctum');
Route::get('/posts/{post}', 'API\PostController@show')->middleware('auth:sanctum');
Route::post('/posts','API\PostController@store')->middleware('auth:sanctum');

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});
// rKXDcnHpRP3n81R3Nz9vKnl5Ie0JnYqtZZKDlwF0NDY4aB6gIuEm4Pu97p7k2DhBgJsBynzOgxCmxIId
//uy58movgOJJJuCyLer49Qa2trw56Hsuq1VDSEYaC3W69H2RlmmjMTFJQETxuwN1LONpbqacJeSHZzV0i