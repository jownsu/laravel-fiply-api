<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\vote\UserCollection;
use App\Models\Post;
use App\Services\JobService;
use App\Services\PostService;
use Illuminate\Http\Request;

class UpVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */


    public function index(Post $post)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $upvotes = $post->userUpVotes()
                    ->with([
                        'profile' => function($q){
                            $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
                        },
                        'company' => function($q){
                            $q->select(['user_id', 'avatar', 'name']);
                    }])
                    ->paginate($per_page);

        if(\request('per_page')){
            $upvotes->appends(['per_page' => \request('per_page')]);
        }


        return response()->successPaginated(UserCollection::collection($upvotes)->response()->getData(true));

    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function upVote(Request $request)
    {
        $validated = $request->validate(['post_id' => 'required']);
        $response = (new PostService())->upVote($validated['post_id']);
        return response()->success($response);
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
