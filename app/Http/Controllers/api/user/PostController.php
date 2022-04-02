<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\post\PostRequest;
use App\Http\Resources\post\PostCollection;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, $id)
    {
        $userid = $id == 'me' ? auth()->id() : $id;

        $posts = (new PostService())->getUserPost($userid);

        return response()->successPaginated($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*    public function show(Post $post)
    {
        $post = (new PostService())->getSinglePost($post);
        return response()->success($post);
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

    }
}
