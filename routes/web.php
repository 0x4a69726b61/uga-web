<?php

use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RequiresAdminPrivileges;
use Illuminate\Support\Facades\Route;

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

Route::get("/", [PresentationController::class, "index"])->name("index");


Route::middleware(RedirectIfAuthenticated::class)
    ->prefix("/authentication")
    ->name("authentication.")
    ->group(function () {
        Route::get("/", [AuthenticationController::class, "gate"])->name("gate");
        Route::post("/login", [AuthenticationController::class, "login"])->name("login");
        Route::post("/register", [AuthenticationController::class, "register"])->name("register");
    });

Route::middleware(Authenticate::class)
    ->group(function () {
        Route::get("/authentication/logout", [AuthenticationController::class, "logout"])->name("authentication.logout");
    });

Route::middleware(RequiresAdminPrivileges::class)
    ->prefix("/administration")
    ->name("administration.")
    ->group(function () {
        Route::get("/", [AdministrationController::class, "index"])->name("index");

        Route::resource("universities", UniversityController::class);
        Route::resource("users", UserController::class);
    });
