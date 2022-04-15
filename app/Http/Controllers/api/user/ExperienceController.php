<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\ExperienceRequest;
use App\Http\Resources\user\ExperienceCollection;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userid = $id == 'me' ? auth()->id() : $id;

        $user = User::where('id', $userid)->with('experiences')->IsFollowing()->first();
        if (!$user){
            return response()->error('User Not Found');
        }

        $this->authorize('view', $user);

        return response()->success(ExperienceCollection::collection($user->experiences));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExperienceRequest $request)
    {
        $experience = auth()->user()->experiences()->create($request->validated());

        return response()->success(new ExperienceCollection($experience));
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
    public function update(ExperienceRequest $request, Experience $experience)
    {
        $this->authorize('update', $experience);

        $experience->update($request->validated());

        return response()->success(new ExperienceCollection($experience));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        $this->authorize('delete', $experience);

        $experience->delete();

        return response()->success('Deleted');
    }
}
