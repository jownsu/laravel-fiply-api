<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class SavedPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = (new PostService())->getSavedPosts();
        return response()->successPaginated($posts);
    }

    public function savePost(Request $request)
    {
        $validated = $request->validate(['post_id' => 'required']);
        $response = (new PostService())->savePost($validated['post_id']);
        return response()->success($response);
    }

    public function unSavePost(Request $request)
    {
        $validated = $request->validate(['post_id' => 'required']);
        $response = (new PostService())->unSavePost($validated['post_id']);
        return response()->success($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Post $post)
    {

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
