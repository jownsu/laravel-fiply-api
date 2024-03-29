<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowCollection;
use App\Models\User;
use App\Services\FollowService;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function following($id)
    {
        $userId = $id == 'me' ? auth()->id() : $id;

        $response = (new FollowService())->getFollowing($userId);

        if(!$response){
            return response()->error('Your not authorized to see this', 404);
        }

        return response()->successPaginated($response);
    }
    public function followers($id)
    {
        $userId = $id == 'me' ? auth()->id() : $id;
        $response = (new FollowService())->getFollowers($userId);

        if(!$response){
            return response()->error('Your not authorized to see this', 404);
        }

        return response()->successPaginated($response);
    }

    public function follow(Request $request)
    {
        $validated = $request->validate(['user_id' => 'required']);
        $response = (new FollowService())->follow($validated['user_id']);
        if($response['status']){
            return response()->json([
                'data' => $response['status'],
                'message' => $response['message']
            ]);
        }
        return response()->json([
            'data' => $response['status'],
            'message' => $response['message']
        ]);
    }

    public function unFollow(Request $request)
    {
        $validated = $request->validate(['user_id' => 'required']);
        $response = (new FollowService())->unFollow($validated['user_id']);
        if($response['status']){
            return response()->json([
                'data' => $response['status'],
                'message' => $response['message']
            ]);
        }
        return response()->json([
            'data' => $response['status'],
            'message' => $response['message']
        ]);
    }

    public function removeFollower(Request $request)
    {
        $validated = $request->validate(['user_id' => 'required']);
        $response = (new FollowService())->removeFollower($validated['user_id']);
        if($response['status']){
            return response()->json([
                'data' => $response['status'],
                'message' => $response['message']
            ]);
        }
        return response()->json([
            'data' => $response['status'],
            'message' => $response['message']
        ]);
    }

    public function followerRequests()
    {
        $followers = (new FollowService())->getFollowerRequests();
        return response()->successPaginated($followers);
    }

    public function followPendings()
    {
        $followers = (new FollowService())->getFollowPendings();
        return response()->successPaginated($followers);
    }

    public function acceptFollowRequest(Request $request)
    {
        $validated = $request->validate(['user_id' => 'required']);
        $response = (new FollowService())->acceptFollowRequest($validated['user_id']);
        if($response['status']){
            return response()->json([
                'data' => $response['status'],
                'message' => $response['message']
            ]);
        }
        return response()->error($response['message']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
