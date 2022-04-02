<?php

namespace App\Services;

use App\Http\Requests\comment\CommentRequest;
use App\Http\Resources\post\CommentCollection;

class CommentService {

    public function getPostComments($post)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $comments = $post->comments()
                        ->with('user.profile')
                        ->latest()
                        ->paginate($per_page);

        $comments->withPath("/posts/{$post->id}/comments");

        return CommentCollection::collection($comments)->response()->getData(true);
    }

    public function createComment(CommentRequest $request, $post)
    {
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->comment
        ]);

        return $comment;
    }

    public function deleteComment($comment)
    {
        if($comment->delete()){
            return 'Comment was deleted';
        }
        return 'There is an error while deleting the comment';
    }









}
