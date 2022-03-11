<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\EducationalBackroundRequest;
use App\Http\Resources\user\EducationalBackgroundCollection;
use App\Models\EducationalBackground;
use App\Models\User;
use Illuminate\Http\Request;

class EducationalBackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userid = $id == 'me' ? auth()->id() : $id;
        $user = User::findOrFail($userid)->load('educationalBackgrounds');

        return response()->success(EducationalBackgroundCollection::collection($user->educationalBackgrounds));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EducationalBackroundRequest $request)
    {
        $educationalBackground = auth()->user()->educationalBackgrounds()->create($request->validated());

        return response()->success( new EducationalBackgroundCollection($educationalBackground));
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
    public function update(EducationalBackroundRequest $request, EducationalBackground $educationalBackground)
    {
        $this->authorize('update', $educationalBackground);

        $educationalBackground->update($request->validated());

        return response()->success(new EducationalBackgroundCollection($educationalBackground));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationalBackground $educationalBackground)
    {
        $this->authorize('delete', $educationalBackground);

        $educationalBackground->delete();

        return response()->success('Deleted');

    }
}
