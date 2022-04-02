<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\comment\CommentRequest;
use App\Http\Resources\post\CommentCollection;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Post $post)
    {
        $post = $post->load(['comments'])->loadCount('userUpVotes');

        return response()->json([

            'details' => [
                            'post_id'         => $post->id,
                            'upVotes_count'   => $post->user_up_votes_count,
                        ],
            'data'     => CommentCollection::collection($post->comments)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->comment
        ]);

        return response()->success($comment);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update([
            'content' => $request->comment
        ]);

        return response()->success($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->success('Comment Deleted');
    }
}
