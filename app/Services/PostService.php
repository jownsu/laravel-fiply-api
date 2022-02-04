<?php

namespace App\Services;

use App\Http\Requests\post\PostRequest;
use App\Http\Resources\post\PostCollection;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class PostService{


    public function getUserPost()
    {
        $posts = Post::with([
            'user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])->where('user_id', auth()->id())->get();

        return PostCollection::collection($posts);
    }

    public function getSinglePost(Post $post)
    {
        $post->load([
            'comments.user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }]);

        return new PostCollection($post);
    }

    public function getPosts()
    {
        $posts = Post::with([
            'user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            },
            'comments.user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])->where('user_id', auth()->id())->get();

        return PostCollection::collection($posts);
    }

    public function createPost(PostRequest $request)
    {
        $post = new Post($request->validated());

        if($request->hasFile('image')){
            $post->image= $request->image->store(Post::IMG_PATH);
        }

        auth()->user()->posts()->save($post);

        return new PostCollection($post);
    }

    public function updatePost(PostRequest $request, Post $post)
    {
        $input = $request->validated();
        if($request->hasFile('image')){
            Storage::delete(Post::IMG_PATH . '/' . $post->image);
            $input['image'] = $request->image->store(Post::IMG_PATH);
        }
        $post->update($input);

        return new PostCollection($post);
    }

    public function deletePost(Post $post)
    {
        Storage::delete(Post::IMG_PATH . '/' . $post->image);
        return $post->delete() ? 'Post is deleted' : 'Error in deleting the post';
    }



}
