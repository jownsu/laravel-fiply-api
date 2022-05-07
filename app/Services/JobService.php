<?php

namespace App\Services;

use App\Http\Requests\job\JobRequest;
use App\Http\Resources\company\job\ApplicantCollection;
use App\Http\Resources\job\JobCollection;
use App\Http\Resources\company\job\JobCollection as CompanyJobCollection;
use App\Http\Resources\user\JobCollection as UserJobCollection;
use App\Http\Resources\job\JobResource;
use App\Models\AppliedJob;
use App\Models\HiringManager;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\True_;

class JobService{

    public function getJobs()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $jobs = Job::withUserApplied()
                ->withUserSaved()
                ->withSearch()
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

        if(\request('search')){
            $jobs->appends(['search' => \request('search')]);
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
                $q->select('id', 'user_id', 'name', 'location', 'avatar');
            },
        ])->loadCount('questions');

        return new JobResource($job);
    }

    public function getHMJobs(){
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $jobs = Job::select('id', 'hiring_manager_id', 'title', 'updated_at', )
            ->with(['hiringManager' => function($q){
                $q->select('id', 'firstname', 'lastname', 'avatar');
            }])
            ->withCount(['users' => function ($q){
                $q->where('status', false)->where('reject', false);
            }])
            ->where('hiring_manager_id', \request()->header('hiring_id'))
            ->latest()
            ->orderBy('id', 'asc')
            ->paginate($per_page);

        $jobs->withPath("/hm/jobs");

        if(\request('per_page')){
            $jobs->appends(['per_page' => \request('per_page')]);
        }

        return CompanyJobCollection::collection($jobs)->response()->getData(true);
    }

    public function getApplicants($job)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $applicants = $job->userAppliedJobs()
            ->wherePivot('status', false)
            ->wherePivot('reject', false)
            ->with(['profile' => function($q){
                $q->select('id', 'user_id', 'firstname', 'lastname', 'avatar');
            }])
            ->latest()
            ->orderBy('id', 'asc')
            ->paginate($per_page);

        $applicants->withPath("/jobs/{$job->id}/applicants");

        if(\request('per_page')){
            $applicants->appends(['per_page' => \request('per_page')]);
        }


        return ApplicantCollection::collection($applicants)->response()->getData(true);
    }

    public function getUserAppliedJob($type = 'applied')
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();

        $jobs = $user->jobsApplied()
            ->wherePivot('status', $type == 'pending')
            ->wherePivot('reject', $type == 'reject')
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
        $jobs->withPath("me/appliedPendingJobs");

            if(\request('per_page')){
                $jobs->appends(['per_page' => \request('per_page')]);
            }


        return UserJobCollection::collection($jobs)->response()->getData(true);
    }

    public function getUserSavedJob()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();


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

        return UserJobCollection::collection($jobs)->response()->getData(true);
    }

    public function createJob(JobRequest $request)
    {
        $hiringManager = HiringManager::where('id', $request->header('hiring_id'))
            ->where('company_id', auth()->user()->company->id)
            ->first();

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

    public function applyJob($input)
    {
        $userId = auth()->id();
        $job = Job::with(['questions' => function($q){
            $q->select('job_id', 'id');
        }])->findOrFail($input['job_id']);

        $questionIds = $job->questions->pluck('id');

        if((count($job->questions) ? true : false) && !isset($input['answers'])){
            return 'error';
        }

        $appliedJob = AppliedJob::firstOrNew(
            [
                'user_id' => $userId,
                'job_id' => $job->id,
            ],
        );

        if(!$appliedJob->id){
            $appliedJob->save();

            if(isset($input['answers']))
            {
 /*               $answers = array_map(function($val) use ($userId, $questionIds, $appliedJob){
                    if(in_array($val['question_id'], $questionIds->toArray())){
                        //$val['user_id'] = $userId;
                        //$val['applied_job_id'] = $appliedJob->id;
                        return $val;
                    }
                }, $input['answers']);*/

                $answers = array_filter($input['answers'], function($val) use($questionIds){
                    return in_array($val['question_id'], $questionIds->toArray());
                });

                $appliedJob->jobResponses()->createMany($answers);
            }

            return true;
        }
        return false;
    }

    public function unApplyJob($jobId)
    {
        $job = Job::findOrFail($jobId);
        $result = $job->userAppliedJobs()->detach(auth()->id());
        return $result ? true : false;
    }

}
