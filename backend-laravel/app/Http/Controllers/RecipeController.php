<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Validator;


class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->query('id');
        $title = preg_quote($request->query('title'), '~');
        $getParam = $request->query('getParam');


        switch ($getParam) {
            case '1':
                return Recipe::findOrFail($id);
            case '2':
                return !isset($id) ? Recipe::all() : Recipe::where('authorid', $id)->get();
            case '3':
                return $title != "" ? Recipe::where('title', 'like', '%' . $title . '%')->get() : Recipe::all();
            default:
                break;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $recipe = new Recipe;

        $newRecipe = json_decode($request->getContent(), true);

        $validation = Validator::make($request->all(), [
            'author' => 'required',
            'authorid' => 'required',
            'ingredients' => 'required',
            'preparationMode' => 'required',
            'description' => 'required',
            'url' => 'required',
            'title' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $recipe->author = $newRecipe['author'];
        $recipe->authorid = $newRecipe['authorid'];
        $recipe->ingredients = $newRecipe['ingredients'];
        $recipe->preparationMode = $newRecipe['preparationMode'];
        $recipe->description = $newRecipe['description'];
        $recipe->url = $newRecipe['url'];
        $recipe->title = $newRecipe['title'];
        $recipe->save();

        return response()->json([
            'Status' => 'Success',
            'Message' => 'Recipe successfully registered!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return Recipe::find($request->query('id'))->update(json_decode($request->getContent(), true));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Recipe::findOrFail($request->query('id'))->delete();
    }
}
