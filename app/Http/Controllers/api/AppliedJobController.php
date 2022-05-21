<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\job\ApplyJobRequest;
use App\Http\Resources\vote\UserCollection;
use App\Models\AppliedJob;
use App\Models\Job;
use App\Services\JobService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppliedJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Job $job)
    {
        $job->load(['userAppliedJobs.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
            }]
        );

        return response()->json([
            'job_id' => $job->id,
            'data' => UserCollection::collection($job->userAppliedJobs)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function applyJob(ApplyJobRequest $request)
    {
        $this->authorize('create', Job::class);
        $response = (new JobService())->applyJob($request->validated());
        if($response === 'error'){
            return response()->error("Answer the Questionnaire");
        }
        return response()->success($response);
    }

    public function unApplyJob(Request $request)
    {
        $this->authorize('create', Job::class);
        $validated = $request->validate(['job_id' => 'required']);
        $response = (new JobService())->unApplyJob($validated['job_id']);
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
