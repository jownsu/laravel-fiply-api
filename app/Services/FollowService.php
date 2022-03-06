<?php

namespace App\Services;


use App\Http\Resources\FollowCollection;
use App\Models\User;

class FollowService {

    public function getFollows($userId)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = User::findOrFail($userId);

        /*        $user->load( ['follows.profile' => function($q){
                    $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
                }]);*/

        $paginated = $user->follows()
            ->with(['profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/$userId/follows");

        return FollowCollection::collection($paginated)->response()->getData(true);

    }

    public function getFollowers($userId)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;


        $user = User::findOrFail($userId);

        /*        $user->load( ['follows.profile' => function($q){
                    $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
                }]);*/

        $paginated = $user->followers()
            ->with(['profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/$userId/followers");

        return FollowCollection::collection($paginated)->response()->getData(true);

    }






}
