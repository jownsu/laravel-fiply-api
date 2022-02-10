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

        $posts = Post::with([
            'user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])
            ->where('user_id', $userId)
            ->paginate($per_page);

        $posts->withPath("$userId/posts");

        return PostCollection::collection($posts)->response()->getData(true);
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
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $posts = Post::with([
            'user.profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])
            ->latest()
            ->paginate($per_page);

        $posts->withPath('/posts');


        return PostCollection::collection($posts)->response()->getData(true);
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
            Storage::delete(Post::IMG_PATH . DIRECTORY_SEPARATOR . $post->image);
            $input['image'] = $request->image->store(Post::IMG_PATH);
        }
        $post->update($input);

        return new PostCollection($post);
    }

    public function deletePost(Post $post)
    {
        Storage::delete(Post::IMG_PATH . DIRECTORY_SEPARATOR . $post->image);
        return $post->delete() ? 'Post is deleted' : 'Error in deleting the post';
    }



}
