<?php

namespace App\Services;

use App\Http\Resources\job\JobCollection;
use App\Http\Resources\job\JobResource;
use App\Models\Job;

class JobService{

    public function getJobs()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $jobs = Job::select(['id', 'title', 'employment_type', 'image',  'company', 'location', 'created_at'])
                ->latest()
                ->paginate($per_page);

        $jobs->withPath('/jobs');

        return JobCollection::collection($jobs)->response()->getData(true);
    }

    public function getSingleJob(Job $job)
    {
        $job->load([
            'user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }]);

        return new JobResource($job);
    }


}
