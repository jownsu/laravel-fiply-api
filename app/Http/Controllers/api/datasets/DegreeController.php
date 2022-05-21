<?php

namespace App\Http\Controllers\api\datasets;

use App\Http\Controllers\Controller;
use App\Http\Resources\DegreeCollection;
use App\Models\Degree;
use App\Models\DegreeCategory;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $degrees = Degree::query()->searchLimit();

        return response()->success(DegreeCollection::collection($degrees->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2'],
            'degree_category_id' => ['required']
        ]);

        $category = DegreeCategory::findOrFail($input['degree_category_id']);

        $response = $category->degrees()->create(['name' => $input['name']]);

        return response()->success($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Degree $degree)
    {
        return response()->success( new DegreeCollection($degree->degreeCategory));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Degree $degree)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2'],
        ]);

        $response = $degree->update($input);
        return response()->success($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Degree $degree)
    {
        if($degree->delete()){
            return response()->success('Deleted');
        }
        return response()->error('There is an error while deleting');
    }
}
