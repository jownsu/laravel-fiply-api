<?php

namespace App\Http\Controllers\api\company;

use App\Http\Controllers\Controller;
use App\Models\HiringManager;
use App\Models\Job;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
/*        $user = auth()->user()->company->load(['hiringManagers' => function($q){
            $q->withCount('jobs');
        }]);
        return $user;*/

        $user = auth()->user()->load(['company' => function($q){
            $q->select('user_id', 'id');
        }]);

        $hiringManagers = HiringManager::select('id')->where('company_id', $user->company->id)->get()->pluck('id');
        $jobsCount = Job::whereIn('hiring_manager_id', $hiringManagers)->count();

        return response()->success([
            'total_hiring_manager' => count($hiringManagers),
            'total_job_posts'      => $jobsCount
        ]);
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
