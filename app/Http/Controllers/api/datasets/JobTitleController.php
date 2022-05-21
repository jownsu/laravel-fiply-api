<?php

namespace App\Http\Controllers\api\datasets;


use App\Http\Controllers\api\ApiController;
use App\Http\Resources\JobTitleCollection;
use App\Models\job\JobCategory;
use App\Models\job\JobTitle;
use Illuminate\Http\Request;

class JobTitleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobTitles = JobTitle::query()->searchLimit();

        return response()->success(JobTitleCollection::collection($jobTitles->get()));
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
            'job_category_id' => ['required']
        ]);

        $category = JobCategory::findOrFail($input['job_category_id']);

        $response = $category->jobTitles()->create(['name' => $input['name']]);

        return response()->success($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(JobTitle $jobTitle)
    {
        return $jobTitle->jobCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobTitle $jobTitle)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2'],
        ]);

        $response = $jobTitle->update($input);
        return response()->success($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobTitle $jobTitle)
    {
        if($jobTitle->delete()){
            return response()->success('Deleted');
        }
        return response()->error('There is an error while deleting');
    }
}
