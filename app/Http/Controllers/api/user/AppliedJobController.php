<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\job\JobPendingResource;
use App\Services\JobService;
use Illuminate\Http\Request;

class AppliedJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = (new JobService())->getUserAppliedJob();

        return response()->successPaginated($jobs);
    }

    public function pendingJob()
    {
        $jobs = (new JobService())->getUserPendingJob();

        return response()->successPaginated($jobs);
    }

    public function rejectedJob()
    {
        $jobs = (new JobService())->getUserRejectedJob();
        return response()->successPaginated($jobs);
    }

    public function passedJobs()
    {
        $jobs = (new JobService())->getUserPassedAppliedJob();
        return response()->successPaginated($jobs);
    }

    public function showPendingJob($id)
    {

        $user = auth()->user();

        $jobs = $user->jobsApplied()
                ->wherePivot('status', true)
                ->wherePivot('reject', false)
                ->wherePivot('result', false)
                ->where('job_id', $id)
                ->first();
        if(!$jobs){
            return response()->error('Pending Job not found');
        }

        return new JobPendingResource($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
