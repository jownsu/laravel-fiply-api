<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\vote\UserCollection;
use App\Models\Job;
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
    public function store(Job $job)
    {
        $result = $job->userSavedJobs()->toggle(auth()->id());

        return response()->json([
            'data' => $result['attached'] ? true : false
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
