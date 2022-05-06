<?php

namespace App\Services;

use App\Http\Requests\post\PostRequest;
use App\Http\Resources\post\PostCollection;
use App\Http\Resources\post\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService{


    public function getUserPost($userId)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $myId = auth()->id();
        $user = User::where('id', $userId)->isFollowing()->first();

        if(!$user){
            return false;
        }

        $posts = Post::with([
            'user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
            },
            'user.company' => function($q){
                $q->select(['user_id', 'avatar', 'name']);
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
            ->when(!boolval($user->is_following) && !$user->id == $myId, function($q){
                $q->where('is_public', true);
            })
            ->latest()
            ->orderBy('id', 'asc')
            ->paginate($per_page);

        $posts->withPath("$userId/posts");

        if(\request('q')){
            $posts->appends(['q' => \request('q')]);
        }

        if(\request('per_page')){
            $posts->appends(['per_page' => \request('per_page')]);
        }

        return PostCollection::collection($posts)->response()->getData(true);
    }

    public function getSavedPosts()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();

        $posts = $user->savedPosts()
            ->with([
                'user.profile' => function($q){
                    $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
                },
                'user.company' => function($q){
                    $q->select(['user_id', 'avatar', 'name']);
                }
            ])
            ->withCount([
                'userUpVotes AS total_upVotes',
                'userUpVotes AS is_upVoted' => function($q) use($user) {
                    $q->where('user_id', $user->id);
                }
            ])
            ->orderByUpVoted()
            ->latest()
            ->orderBy('id', 'asc')
            ->paginate($per_page);
        $posts->withPath("me/savedPosts");

        if(\request('q')){
            $posts->appends(['q' => \request('q')]);
        }

        if(\request('per_page')){
            $posts->appends(['per_page' => \request('per_page')]);
        }


        return PostCollection::collection($posts)->response()->getData(true);
    }

    public function getSinglePost(Post $post)
    {
        $post->load([
            'comments.user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
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
                $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
            },
            'user.company' => function($q){
                $q->select(['user_id', 'avatar', 'name']);
            }

            ])
            ->withCount([
                'userUpVotes AS total_upVotes',
                'userUpVotes AS is_upVoted' => function($q) use($userId) {
                    $q->where('user_id', $userId);
                }
            ])
            ->latest()
            ->orderBy('id', 'asc')
            ->paginate($per_page);

        $posts->withPath('/posts');

        if(\request('per_page')){
            $posts->appends(['per_page' => \request('per_page')]);
        }

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

        return new PostResource($post);
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
