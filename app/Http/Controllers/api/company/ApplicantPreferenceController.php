<?php

namespace App\Http\Controllers\api\company;

use App\Http\Controllers\Controller;
use App\Models\ApplicantPreference;
use App\Models\JobPreference;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicantPreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userid = $id == 'me' ? auth()->id() : $id;

        $user = User::where('id', $userid)->with('applicantPreference')->IsFollowing()->first();
        if (!$user){
            return response()->error('User Not Found');
        }

        $this->authorize('view', $user);
        return response()->success($user->jobPreference);
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
    public function update(ApplicantPreference $request, ApplicantPreference $applicantPreference)
    {
        $this->authorize('update', $applicantPreference);

        $applicantPreference->update($request->validated());

        return response()->success($applicantPreference);
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
