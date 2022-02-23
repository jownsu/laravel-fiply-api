<?php

namespace App\Services;

use App\Http\Requests\job\JobRequest;
use App\Http\Resources\job\JobCollection;
use App\Http\Resources\job\JobResource;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;

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

    public function createJob(JobRequest $request)
    {
        $job = new Job($request->validated());

        if($request->hasFile('image')){
            $job->image= $request->image->store(Job::IMG_PATH);
        }

        auth()->user()->posts()->save($job);

        return new JobResource($job);

    }

    public function updateJob(JobRequest $request, Job $job)
    {
        $input = $request->validated();
        if($request->hasFile('image')){
            Storage::delete(Job::IMG_PATH . DIRECTORY_SEPARATOR . $job->image);
            $input['image'] = $request->image->store(Job::IMG_PATH);
        }
        $job->update($input);

        return new JobResource($job);
    }

    public function deleteJob(Job $job)
    {
        Storage::delete(Job::IMG_PATH . DIRECTORY_SEPARATOR . $job->image);
        return $job->delete() ? 'Job is deleted' : 'Error in deleting the job';
    }

}
