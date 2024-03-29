<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\post\PostRequest;
use App\Http\Requests\post\PostUpdateRequest;
use App\Http\Resources\post\PostCollection;
use App\Models\Job;
use App\Models\Post;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = (new PostService())->getPosts();
        return response()->successPaginated($post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $post = (new PostService())->createPost($request);
        return response()->success(new PostCollection($post));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = (new PostService())->getSinglePost($post);
        return response()->success($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post = (new PostService())->updatePost($request, $post);
        return response()->success($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $response = (new PostService())->deletePost($post);
        return response()->success($response);
    }

    public function setAudience(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $input = $request->validate([
            'is_public' => ['required', 'boolean']
        ]);

        $post->is_public = $input['is_public'];
        $post->save();

        return response()->success($post);
    }
}
