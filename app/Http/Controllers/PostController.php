<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePostRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //


    public function RegistrarPost(SavePostRequest $request)
    {
        try {

            DB::beginTransaction();

            if ($request->hasFile('imagen')) {
                $ruta = $request->file('imagen')->store('imagenes', 'public');
                DB::table('posts')->insert([
                    'message' => $request->mensaje,
                    'pathImage' => $ruta,
                    'user_id' => $request->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                DB::commit();
                return response()->json(["message" => "Post creado", "rutaImagen" => $ruta, "code" => 200], 200);
            } else {
                DB::table('posts')->insert([
                    'message' => $request->mensaje,
                    'user_id' => $request->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                DB::commit();
                return response()->json(["message" => "Post creado", "code" => 200], 200);
            }
        } catch (Exception $e) {
            return response()->json(["message" => "Error al", "code" => 500], 500);
        }
    }

    public function obtenerPosts(Request $request)
    {
        try {
            //por cada post devolver el nombre de usuario
          
            $data = DB::table("posts")
            ->join("users","users.id","=","posts.user_id")
            ->select("posts.*","users.name")
            ->orderBy("posts.created_at", "desc")->paginate(5);
            return response()->json(["message" => "Publicaciones cargadas", "data" => $data, "code" => 200], 200);
        } catch (Exception $e) {
            return response()->json(["message" => "Error al obtener publicaciones", "code" => 500], 500);
        }
    }
}
