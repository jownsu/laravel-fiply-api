<?php

namespace App\Http\Controllers\api\datasets;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmploymentTypeCollection;
use App\Models\EmploymentType;
use Illuminate\Http\Request;

class EmploymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employmentTypes = EmploymentType::query()->searchLimit();

        return response()->success(EmploymentTypeCollection::collection($employmentTypes->get()));
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

        $response = EmploymentType::create($input);
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
    public function update(Request $request, EmploymentType $employmentType)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2']
        ]);

        $response = $employmentType->update($input);

        return response()->success($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmploymentType $employmentType)
    {
        if($employmentType->delete()){
            return response()->success('Deleted');
        }
        return response()->error('There is an error while deleting');
    }
}
