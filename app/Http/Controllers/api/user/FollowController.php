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
    public function follows($id)
    {
        $userId = $id == 'me' ? auth()->id() : $id;

        $follows = (new FollowService())->getFollows($userId);

        return response()->successPaginated($follows);
    }
    public function followers($id)
    {

        $userId = $id == 'me' ? auth()->id() : $id;

        $followers = (new FollowService())->getFollowers($userId);

        return response()->successPaginated($followers);
    }

    public function follow(User $user)
    {
        $result = $user->followers()->toggle(auth()->id());

        return response()->json([
            'data' => $result['attached'] ? true : false
        ]);
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
