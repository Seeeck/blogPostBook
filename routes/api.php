<?php


// routes/api.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailConfirmationController;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Autenticacion
Route::post("/login", [AuthController::class, "login"]);

Route::post("/registrarUsuario", [AuthController::class, "registrarUsuario"]);

//Verificación de correo
Route::get('/email/verify', function () {
    return Response(["message:"=>"email enviado a su correo","code"=>200]);
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailConfirmationController::class,"verify"])
->middleware(['signed'])->name('verification.verify');