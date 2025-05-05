<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SanctumTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    //Sirve para reestablecer la base de datos
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            "email" => "franco@gmail.com",
            "name" => "franco"
        ]);

        $response = $this->post('api/login', [
            "email" => $user->email,
            "password" => $user->password
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "user" => ["user", "email"],
            "token"
        ]);
    }

    public function test_user_can_see_auth_routes(): void
    {

        //Se crea usuario
        $user = User::factory()->create([
            "email" => "franco@gmail.com",
            "name" => "franco"
        ]);
      
        //Se logea , se obtiene el usuario y se obtiene el token
        $response = $this->post('api/login', [
            "email" => $user->email,
            "password" => $user->password
        ]);

        //Frontend
        //se obtiene el token
        $token = $response->json("token");
        //se soobrescribe 
        //se manda el token a la ruta que tiene midddleware
        //obtiene el usuario que ya estaba escrito
        $response = $this->withHeader("Authorization", "Bearer {$token}")
            ->get("/api/user");

        
    }

    public function test_user_can_register():void{
       

        $response=$this->post("api/registrarUsuario",[
            "nombre"=>"franco",
            "email"=>"francozc80@gmail.com",
            "password"=>"12345678910",
            "password_confirmation"=>"12345678910"
        ]);

        

        
        $response->assertJsonStructure(["data"=>["name","email","updated_at","created_at","id"],"code"]);

       

    }

   
}
