<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\vote\UserCollection;
use App\Http\Resources\vote\VoteCollection;
use App\Http\Resources\vote\VoteColletion;
use App\Models\Post;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */


    public function index(Post $post)
    {
        $votes = $post->load(['UserVotes.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }]
        );

        return response()->json([
            'post_id' => $post->id,
            'data' => UserCollection::collection($post->userVotes)
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
