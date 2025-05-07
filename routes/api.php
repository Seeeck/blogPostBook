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

Route::middleware("auth:sanctum")->post("/verifyToken", function (Request $request) {

  

    if ($request->user()->name == $request->username && $request->user()->email == $request->email) {

        return response()->json(["message" => "Usuario autenticado", "code" => 200], 200);
    } else {
        return response()->json(["message" => "Usuario no autenticado", "code" => 401], 401);
    }
});

Route::get('/login', function () {
    return response()->json(["message" => "Usuario no autenticado", "code" => 401], 401); // o una vista como view('auth.login')
})->name('login');

//Autenticacion
Route::post("/login", [AuthController::class, "login"]);

Route::post("/registrarUsuario", [AuthController::class, "registrarUsuario"]);

//Verificación de correo
Route::get('/email/verify', function () {
    return Response(["message:" => "email enviado a su correo", "code" => 200]);
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailConfirmationController::class, "verify"])
    ->middleware(['signed'])->name('verification.verify');
