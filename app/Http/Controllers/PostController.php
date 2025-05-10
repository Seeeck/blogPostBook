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
}
