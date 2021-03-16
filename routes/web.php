<?php

use App\Http\Controllers\CompanyuserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('loginpage');
});

Route::resource('users', UserController::class);
Route::resource('teams', TeamController::class);

Route::get('/manager', function(){
    
    if(Auth::check()){
        return view('layouts.welcome');
    }else{
        return redirect()->back();
    }
})->name('manager');

Route::post('/userteams/data', [CompanyuserController::class, 'getTeamUsers'])->name('get_user_teams');
Route::post('/users/data', [UserController::class, 'getUsers'])->name('get_users');

Auth::routes();
