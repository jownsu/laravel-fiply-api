<?php

namespace App\Services;


use App\Http\Resources\FollowCollection;
use App\Models\User;

class FollowService {

    public function getFollowing($userId)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = User::findOrFail($userId);

        $paginated = $user->following()
            ->with(['profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])
            ->wherePivot('accepted', true)
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/$userId/following");

        return FollowCollection::collection($paginated)->response()->getData(true);

    }

    public function getFollowers($userId)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = User::findOrFail($userId);

        $paginated = $user->followers()
            ->with(['profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }, 'jobPreference' => function($q){
                $q->select(['user_id', 'job_title']);
            }])
            ->wherePivot('accepted', true)
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/$userId/followers");

        return FollowCollection::collection($paginated)->response()->getData(true);
    }

    public function getFollowerRequests()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();

        $paginated = $user->followerRequests()
            ->with(['profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }, 'jobPreference' => function($q){
                $q->select(['user_id', 'job_title']);
            }])
            ->wherePivot('accepted', false)
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/followerRequests");

        return FollowCollection::collection($paginated)->response()->getData(true);
    }

    public function getFollowPendings()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();

        $paginated = $user->followPendings()
            ->with(['profile' => function($q){
                $q->select(['user_id', 'avatar', 'firstname', 'middlename', 'lastname']);
            }])
            ->wherePivot('accepted', false)
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/following");

        return FollowCollection::collection($paginated)->response()->getData(true);

    }

    public function acceptFollowRequest($userId)
    {
        $user = auth()->user();

        if(!$user->followers()->where('id', $userId)->exists()){
            return [
                'status' => false,
                'message' => 'No Follow Request'
            ];
        }

        if($user->followers()->updateExistingPivot($userId, ['accepted' => true])){
            return [
                'status' => true,
                'message' => 'Accepted'
            ];
        }

        return [
            'status' => false,
            'message' => 'Already Accepted'
        ];
    }

    public function follow($userId)
    {
        $user = User::findOrFail($userId);
        $result = $user->followers()->syncWithoutDetaching(auth()->id());
        return $result['attached'] ? true : false;
    }
    public function unFollow($userId)
    {
        $user = User::findOrFail($userId);
        $result = $user->followers()->detach(auth()->id());
        return $result ? true : false;
    }



}
