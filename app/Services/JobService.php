<?php

namespace App\Services;

use App\Http\Requests\job\JobRequest;
use App\Http\Resources\job\JobCollection;
use App\Http\Resources\user\JobCollection as UserJobCollection;
use App\Http\Resources\job\JobResource;
use App\Models\HiringManager;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\True_;

class JobService{

    public function getJobs()
    {

        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $jobs = Job::withUserApplied()
                ->withUserSaved()
                ->with([
                    'hiringManager'=> function($q){
                        $q->select('id', 'company_id');
                    },
                    'hiringManager.company' => function($q){
                        $q->select('id', 'name', 'location', 'avatar');
                    },
                ])
                ->select(['id', 'hiring_manager_id','title', 'employment_type', 'location', 'created_at',])
                ->latest()
                ->orderBy('id', 'asc')
                ->paginate($per_page);

        $jobs->withPath('/jobs');

        if(\request('per_page')){
            $jobs->appends(['per_page' => \request('per_page')]);
        }


        return JobCollection::collection($jobs)->response()->getData(true);
    }

    public function getSingleJob(Job $job)
    {
        $job->load([
            'userAppliedJobs' => function($q){
                return $q->where('user_id', auth()->id())->select('user_id')->count();
            },
            'userSavedJobs' => function($q){
                return $q->where('user_id', auth()->id())->select('user_id')->count();
            },
            'hiringManager'=> function($q){
                $q->select('id', 'company_id', 'firstname', 'lastname', 'avatar');
            },
            'hiringManager.company' => function($q){
                $q->select('id', 'name', 'location', 'avatar');
            },
        ])->loadCount('questions');

        return new JobResource($job);
    }

    public function getUserJob($type = 'applied')
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();

        if($type == 'saved'){
            $jobs = $user->jobsSaved()
                ->with([
                    'hiringManager'=> function($q){
                        $q->select('id', 'company_id');
                    },
                    'hiringManager.company' => function($q){
                        $q->select('id', 'name', 'location', 'avatar');
                    },
                ])
                ->latest()
                ->orderBy('id', 'asc')
                ->paginate($per_page);
            $jobs->withPath("me/savedJobs");

            if(\request('per_page')){
                $jobs->appends(['per_page' => \request('per_page')]);
            }
        }else{
            $jobs = $user->jobsApplied()
                ->with([
                    'hiringManager'=> function($q){
                        $q->select('id', 'company_id');
                    },
                    'hiringManager.company' => function($q){
                        $q->select('id', 'name', 'location', 'avatar');
                    },
                ])
                ->latest()
                ->orderBy('id', 'asc')
                ->paginate($per_page);
            $jobs->withPath("me/appliedJobs");

            if(\request('per_page')){
                $jobs->appends(['per_page' => \request('per_page')]);
            }
        }

        return UserJobCollection::collection($jobs)->response()->getData(true);
    }

    public function createJob(JobRequest $request)
    {
        $hiringManager = HiringManager::where('id', $request->header('hiring_id'))->first();

        $job = $hiringManager->jobs()->create($request->validated());

        if($request->has('questions'))
        {
            $job->questions()->createMany($request->questions);
        }


        return $job;
    }

    public function updateJob(JobRequest $request, Job $job)
    {
        $input = $request->validated();

        $job->update($input);

        return $job;
    }

    public function deleteJob(Job $job)
    {
        return $job->delete() ? 'Job is deleted' : 'Error in deleting the job';
    }

    public function saveJob($jobId)
    {
        $job = Job::findOrFail($jobId);
        $result = $job->userSavedJobs()->syncWithoutDetaching(auth()->id());
        return $result['attached'] ? true : false;
    }

    public function unSaveJob($jobId)
    {
        $job = Job::findOrFail($jobId);
        $result = $job->userSavedJobs()->detach(auth()->id());
        return $result ? true : false;
    }

    public function applyJob($jobId)
    {
        $job = Job::findOrFail($jobId);
        $result = $job->userAppliedJobs()->syncWithoutDetaching(auth()->id());
        return $result['attached'] ? true : false;
    }

    public function unApplyJob($jobId)
    {
        $job = Job::findOrFail($jobId);
        $result = $job->userAppliedJobs()->detach(auth()->id());
        return $result ? true : false;
    }

}
