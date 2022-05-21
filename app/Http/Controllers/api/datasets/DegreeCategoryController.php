<?php

namespace App\Http\Controllers\api\datasets;

use App\Http\Controllers\Controller;
use App\Http\Resources\DegreeCategoryCollection;
use App\Models\DegreeCategory;
use Illuminate\Http\Request;

class DegreeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $degreeCategories = DegreeCategory::query()->searchLimit();

        return response()->success(DegreeCategoryCollection::collection($degreeCategories->get()));
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
            'name' => ['required', 'min:2']
        ]);

        $response = DegreeCategory::create($input);
        return response()->success($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DegreeCategory $degreeCategory)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2']
        ]);

        $response = $degreeCategory->update($input);
        return response()->success($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DegreeCategory $degreeCategory)
    {
        if($degreeCategory->delete()){
            return response()->success('Deleted');
        }
        return response()->error('There is an error while deleting');
    }
}
