<?php

namespace App\Http\Controllers\api\company;

use App\Http\Controllers\Controller;
use App\Http\Requests\job\JobRequest;
use App\Http\Resources\company\job\ApplicantCollection;
use App\Http\Resources\company\job\ApplicantResource;
use App\Http\Resources\company\job\JobResource;
use App\Models\AppliedJob;
use App\Models\Job;
use App\Services\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = (new JobService())->getHMJobs();
        return response()->successPaginated($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        $this->authorize('create',Job::class);
        $job = (new JobService())->createJob($request);
        return response()->success($job);
    }


    public function show(Job $job)
    {
        $this->authorize('view', $job);

        $job->loadCount('users');
        return  response()->success(new JobResource($job));
    }

    public function getApplicants(Job $job)
    {
        $this->authorize('view', $job);

        $applicants = (new JobService())->getApplicants($job);

        return response()->successPaginated($applicants);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        $this->authorize('update', $job);

        $post = (new JobService())->updateJob($request, $job);

        return response()->success($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $response = (new JobService())->deleteJob($job);

        return response()->success($response);
    }

    public function jobResponse($jobId, $applyId)
    {
        $job = AppliedJob::select('id', 'user_id', 'job_id')
            ->where('job_id', $jobId)
            ->where('id', $applyId)
            ->with([
                'user' => function($q){
                    $q->select('id');
                },
                'user.profile' => function($q){
                    $q->select('user_id','firstname', 'lastname', 'location', 'avatar');
                },
                'user.experiences' => function($q){
                    $q->select('user_id', 'id', 'job_title', 'company', 'starting_date', 'completion_date');
                },
                'user.educationalBackgrounds' => function($q){
                    $q->select('user_id', 'id', 'university', 'degree', 'starting_date', 'completion_date');
                },
                'user.document' => function($q){
                    $q->select('user_id', 'resume');
                },
                'jobResponses.question' => function($q){
                    $q->select('id', 'question');
                }
            ])
            ->first();

        if(!$job){
            return response()->error('Object not found');
        }

        return  response()->success(new ApplicantResource($job));
    }
}
