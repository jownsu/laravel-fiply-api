<?php

namespace App\Http\Controllers\api\datasets;


use App\Http\Controllers\Controller;
use App\Http\Resources\PositionLevelCollection;
use App\Models\PositionLevel;
use Illuminate\Http\Request;

class PositionLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positionLevels = PositionLevel::query()->searchLimit();

        return response()->success(PositionLevelCollection::collection($positionLevels->get()));
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

        $response = PositionLevel::create($input);
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
    public function update(Request $request, PositionLevel $positionLevel)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2']
        ]);

        $response = $positionLevel->update($input);
        return response()->success($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PositionLevel $positionLevel)
    {
        if($positionLevel->delete()){
            return response()->success('Deleted');
        }
        return response()->error('There is an error while deleting');
    }
}
