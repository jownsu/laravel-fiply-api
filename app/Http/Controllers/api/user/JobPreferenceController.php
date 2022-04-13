<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\JobPreferenceRequest;
use App\Http\Resources\user\JobPreferenceCollection;
use App\Models\JobPreference;
use App\Models\User;
use Illuminate\Http\Request;

class JobPreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userid = $id == 'me' ? auth()->id() : $id;
        $user = User::findOrFail($userid)->load('jobPreference');
        return response()->success($user->jobPreference);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobPreferenceRequest $request)
    {

        $jobPreference = auth()->user()->jobPreference;

        if(is_null($jobPreference)){
            $jobPreference = auth()->user()->jobPreference()->create($request->validated());
        }else{
            $jobPreference->fill($request->validated());
        }

        $jobPreference->save();


        return response()->success($jobPreference);

        //

        //return response()->success($jobPreference);
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
    public function update(JobPreferenceRequest $request, JobPreference $jobPreference)
    {
        $this->authorize('update', $jobPreference);

        $jobPreference->update($request->validated());

        return response()->success($jobPreference);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPreference $jobPreference)
    {
        $this->authorize('delete', $jobPreference);

        return response()->success($jobPreference->delete());
    }
}
