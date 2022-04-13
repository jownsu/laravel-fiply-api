<?php

namespace App\Services;

use App\Http\Requests\post\PostRequest;
use App\Http\Resources\post\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostService{


    public function getUserPost($userId)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $myId = auth()->id();

        $posts = Post::with([
            'user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }
            ])
            ->withCount([
                'userUpVotes AS total_upVotes',
                'userUpVotes AS is_upVoted' => function($q) use($myId) {
                    $q->where('user_id', $myId);
                }
            ])
            ->orderByUpVoted()
            ->where('user_id', $userId)
            ->latest()
            ->paginate($per_page);

        $posts->withPath("$userId/posts");

        if(\request('q')){
            $posts->appends(['q' => \request('q')]);
        }

        return PostCollection::collection($posts)->response()->getData(true);
    }

    public function getSavedPosts()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();

        $posts = $user->savedPosts()
            ->with('user.profile')
            ->withCount([
                'userUpVotes AS total_upVotes',
                'userUpVotes AS is_upVoted' => function($q) use($user) {
                    $q->where('user_id', $user->id);
                }
            ])
            ->orderByUpVoted()
            ->latest()
            ->paginate($per_page);
        $posts->withPath("me/savedPosts");

        if(\request('q')){
            $posts->appends(['q' => \request('q')]);
        }

        return PostCollection::collection($posts)->response()->getData(true);
    }

    public function getSinglePost(Post $post)
    {
        $post->load([
            'comments.user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])
            ->loadCount('userUpVotes');

        return new PostCollection($post);
    }

    public function getPosts()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;
        $userId = auth()->id();

        $posts = Post::with([
            'user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])
            ->withCount([
                'userUpVotes AS total_upVotes',
                'userUpVotes AS is_upVoted' => function($q) use($userId) {
                    $q->where('user_id', $userId);
                }
            ])
            ->latest()
            ->paginate($per_page);

        $posts->withPath('/posts');
        return PostCollection::collection($posts)->response()->getData(true);
    }

    public function createPost(PostRequest $request)
    {
        $post = new Post($request->validated());

        if($request->hasFile('image')){
            $post->image= $request->image->store('', 'post');
        }

        auth()->user()->posts()->save($post);

        return new PostCollection($post);

    }

    public function updatePost(PostRequest $request, Post $post)
    {
        $input = $request->validated();
        if($request->hasFile('image')){
            Storage::disk('post')->delete($post->image);
            $input['image'] = $request->image->store('', 'post');
        }
        $post->update($input);

        return new PostCollection($post);
    }

    public function deletePost(Post $post)
    {
        Storage::disk('post')->delete($post->image);
        return $post->delete() ? 'Post is deleted' : 'Error in deleting the post';
    }

    public function savePost($postId)
    {
        $post = Post::findOrFail($postId);
        $result = $post->userSavedPosts()->syncWithoutDetaching(auth()->id());
        return $result['attached'] ? true : false;
    }

    public function unSavePost($postId)
    {
        $post = Post::findOrFail($postId);
        $result = $post->userSavedPosts()->detach(auth()->id());
        return $result ? true : false;
    }

    public function upVote($postId)
    {
        $post = Post::findOrFail($postId);
        $result = $post->userUpVotes()->toggle(auth()->id());
        return $result['attached'] ? true : false;
    }

}
