<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Recipes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipes::all();
        return response(['recipes' => ProjectResource::collection($recipes), 'message' => 'Retrieved recipes successfully!'], 200);

    }

    /**
     * Store a newly created resource in storage.
     * here we have to pass in the ingredients as part of the arguments
     * and then we use it to create an array and store it as that
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'ingredients' => 'required|max:255',

        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }


        $stack = explode(",", $data['ingredients']);


        $recipes = Recipes::create($data);
        $recipes->ingredients = $stack;
        $recipes->save();
        return response(['project' => new ProjectResource($recipes), 'message' => 'Created successfully'], 201);

    }

    /**
     * Display the specified resource.
     * the id argument is auto magic
     *
     * @param \App\Models\Recipes $recipes
     * @return \Illuminate\Http\Response
     */
    public function show(Recipes $recipes, $id)
    {

        $recipes = Recipes::find($id);
        return response(['recipe' => new ProjectResource($recipes), 'message' => 'Retrieved recipe successfully'], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Recipes $recipes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipes $recipes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Recipes $recipes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipes $recipes)
    {
        //
    }
}
