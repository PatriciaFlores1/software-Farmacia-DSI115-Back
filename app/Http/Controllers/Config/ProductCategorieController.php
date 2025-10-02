<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config\ProductCategorie;
use Illuminate\Support\Facades\Storage;

class ProductCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get("search");

        $categories = ProductCategorie::where("title","ilike","%".$search."%")->orderBy("id","desc")->get();

        return response()->json([
            "categories" => $categories->map(function($categorie) {
                return [
                    "id" => $categorie->id,
                    "title" => $categorie->title,
                    "state" => (int) $categorie->state,
                    "imagen" => $categorie->imagen ? env("APP_URL")."storage/".$categorie->imagen : NULL,
                    "created_at" => $categorie->created_at->format("Y-m-d h:i A"),
                ];
            }),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $is_categorie_exists = ProductCategorie::where("title",$request->title)->first();
        if($is_categorie_exists){
            return response()->json([
                "message" => 403,
                "message_text" => "LA CATEGORIA YA EXISTE"
            ]);
        }

        if($request->hasFile("image")){
            $path = Storage::putFile("categories",$request->file("image"));
            $request->request->add(["imagen" => $path]);
        }
        $categorie = ProductCategorie::create($request->all());

        return response()->json([
            "message" => 200,
            "categorie" => [
                "id" => $categorie->id,
                "title" => $categorie->title,
                "state" => (int) $categorie->state,
                "imagen" => $categorie->imagen ? env("APP_URL")."storage/".$categorie->imagen : NULL,
                "created_at" => $categorie->created_at->format("Y-m-d h:i A"),
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $is_categorie_exists = ProductCategorie::where("title",$request->title)->where("id","<>",$id)->first();
        if($is_categorie_exists){
            return response()->json([
                "message" => 403,
                "message_text" => "LA CATEGORIA YA EXISTE"
            ]);
        }
        $categorie = ProductCategorie::findOrFail($id);
        if($request->hasFile("image")){
            if($categorie->imagen){
                Storage::delete($categorie->imagen);
            }
            $path = Storage::putFile("categories",$request->file("image"));
            $request->request->add(["imagen" => $path]);
        }
        $categorie->update($request->all());

        return response()->json([
            "message" => 200,
            "categorie" => [
                "id" => $categorie->id,
                "title" => $categorie->title,
                "state" => (int) $categorie->state,
                "imagen" => $categorie->imagen ? env("APP_URL")."storage/".$categorie->imagen : NULL,
                "created_at" => $categorie->created_at->format("Y-m-d h:i A"),
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie = ProductCategorie::findOrFail($id);
        $categorie->delete();
        return response()->json([
            "message" => 200,
        ]);
    }
}
