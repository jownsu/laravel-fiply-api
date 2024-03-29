<?php

namespace App\Http\Controllers\api\datasets;


use App\Http\Controllers\api\ApiController;
use App\Http\Resources\UniversityCollection;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universities = University::query()->searchLimit();

        return response()->success(UniversityCollection::collection($universities->get()));
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

        $response = University::create($input);

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
    public function update(Request $request, University $university)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2']
        ]);

        $response = $university->update($input);

        return response()->success($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(University $university)
    {
        if($university->delete()){
            return response()->success('Deleted');
        }
        return response()->error('There is an error while deleting');
    }
}
