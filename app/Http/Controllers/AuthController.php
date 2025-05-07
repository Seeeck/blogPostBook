<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(LoginRequest $request)
    {




        $user = User::where("email", $request->email)->get()->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "credenciales incorrectas o no existe el usuario", "code" => "401"], 401);
        };

        if (!$user->email_verified_at) {
            return response()->json(["message" => "El usuario debe confirmar el correo", "code" => "401"], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken("api")->plainTextToken;


        return response()->json([
            "message" => "Ingresado correctamente",
            "user" => [
                "username" => $user->name,
                "email" => $user->email,

            ],
            "token" => $token,
            "code" => 200
        ]);
    }

    public function registrarUsuario(RegisterUserRequest $request)
    {

        try {
           
                $user = DB::table("users")->where("email", $request->email)->first();
                if (!$user) {
                  

                    $user_created = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]);


                    event(new Registered($user_created));
                    return Response(["message" => "Usuario creado", "data" => $user_created, "code" => 200,], 200);
                } else {
                    return Response(["message:" => "El usuario ya existe", "code" => 409], 409);
                }
          
        } catch (Exception $e) {

            return Response(["meesage" => "error al crear usuario", "Exception" => $e, "code" => 500,], 500);
        }
    }
}
