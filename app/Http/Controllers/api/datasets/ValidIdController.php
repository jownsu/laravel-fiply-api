<?php

namespace App\Http\Controllers\api\datasets;

use App\Http\Controllers\Controller;
use App\Models\dataset\ValidId;
use Illuminate\Http\Request;

class ValidIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->success(ValidId::all());
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
        $response = ValidId::create($input);
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
    public function update(Request $request, ValidId $validId)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2']
        ]);

        $response = $validId->update($input);
        return response()->success($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ValidId $validId)
    {
        if($validId->delete()){
            return response()->success('Deleted');
        }
        return response()->error('There is an error while deleting');
    }
}
