<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
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
       
         
      
        
        $user = User::where("email", $request->email)->first();
      
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "credenciales incorrectas", "code" => "401"], 401);
        };

        $token=$user->createToken("api")->plainTextToken;
       

        return response()->json([
            "user" => [
                "user" => $user->name,
                "email" => $user->email,

            ],
            "token" =>$token ]);
    }

    public function registrarUsuario(RegisterUserRequest $request)
    {

        $user = DB::table("users")->where("email", $request->email)->first();
        if (!$user) {
            $user_created = User::create([
                'name' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            event(new Registered($user_created));
            return Response(["data" => $user_created, "code" => 200], 200);
        } else {
            return Response(["message:" => "El usuario ya existe", "code" => 409], 409);
        }
    }

  
}
