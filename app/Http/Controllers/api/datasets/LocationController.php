<?php

namespace App\Http\Controllers\api\datasets;


use App\Http\Controllers\api\ApiController;
use App\Http\Resources\LocationCollection;
use App\Models\location\City;
use Illuminate\Http\Request;

class LocationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $location = City::with('province.region');

        $location->searchLimit();

        return response()->success(LocationCollection::collection($location->get()));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
