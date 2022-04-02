<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\vote\UserCollection;
use App\Models\Job;
use App\Services\JobService;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Job $job)
    {
        $job->load(['UserSavedJobs.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }]
        );

        return response()->json([
            'job_id' => $job->id,
            'data' => UserCollection::collection($job->userSavedJobs)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function saveJob(Request $request)
    {
        $validated = $request->validate(['job_id' => 'required']);
        $response = (new JobService())->saveJob($validated['job_id']);
        return response()->success($response);
    }

    public function unSaveJob(Request $request)
    {
        $validated = $request->validate(['job_id' => 'required']);
        $response = (new JobService())->unSaveJob($validated['job_id']);
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
