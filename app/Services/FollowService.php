<?php

namespace App\Services;


use App\Http\Resources\FollowCollection;
use App\Http\Resources\FollowRequestCollection;
use App\Models\User;

class FollowService {

    public function getFollowing($userId)
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = User::where('id', $userId)->isFollowing()->first();

        if(auth()->user()->cannot('view', $user)){
            return false;
        }

        $paginated = $user->following()
            ->with([
                'profile' => function($q){
                    $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
                },
                'company' => function($q){
                    $q->select(['user_id', 'avatar', 'name']);
                }
            ])
            ->withFollowingInfo()
            ->withFollowerInfo()
            ->withSearch()
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

        if(auth()->user()->cannot('view', $user)){
            return false;
        }

        $paginated = $user->followers()
            ->with([
                'profile' => function($q){
                    $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
                },
                'company' => function($q){
                    $q->select(['user_id', 'avatar', 'name']);
                },
                'jobPreference' => function($q){
                    $q->select(['user_id', 'job_title']);
                }
            ])
            ->withFollowingInfo()
            ->withFollowerInfo()
            ->withSearch()
            ->wherePivot('accepted', true)
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/$userId/followers");

        if(\request('search')){
            $paginated->appends(['search' => \request('search')]);
        }

        return FollowCollection::collection($paginated)->response()->getData(true);
    }

    public function getFollowerRequests()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();

        $paginated = $user->followerRequests()
            ->with([
                'profile' => function($q){
                    $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
                },
                'company' => function($q){
                    $q->select(['user_id', 'avatar', 'name']);
                },
                'jobPreference' => function($q){
                    $q->select(['user_id', 'job_title']);
                }
            ])
            ->wherePivot('accepted', false)
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/me/followerRequests");

        if(\request('search')){
            $paginated->appends(['search' => \request('search')]);
        }

        return FollowRequestCollection::collection($paginated)->response()->getData(true);
    }

    public function getFollowPendings()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $user = auth()->user();

        $paginated = $user->followPendings()
            ->with([
                'profile' => function($q){
                    $q->select(['user_id', 'avatar', 'firstname', 'lastname']);
                },
                'company' => function($q){
                    $q->select(['user_id', 'avatar', 'name']);
                },
            ])
            ->wherePivot('accepted', false)
            ->latest()
            ->paginate($per_page);

        $paginated->withPath("/me/followPendings");

        return FollowRequestCollection::collection($paginated)->response()->getData(true);

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
            'status' => true,
            'message' => 'Already Accepted'
        ];
    }

    public function follow($userId)
    {
        $user = User::findOrFail($userId);
        $result = $user->followers()->syncWithoutDetaching(auth()->id());
        return $result['attached']
        ? [
            'status' => true,
            'message' => 'Follow request sent'
        ]
        : [
            'status' => false,
            'message' => 'Follow request already sent'
        ];
    }
    public function unFollow($userId)
    {
        $user = User::findOrFail($userId);

        $result = $user->followers()->detach(auth()->id());
        return $result
        ? [
            'status' => true,
            'message' => 'Unfollowed'
        ]
        : [
            'status' => false,
            'message' => 'Unfollowed already'
        ];
    }

    public function removeFollower($userId)
    {
        $user = User::findOrFail($userId);

        $result = $user->following()->detach(auth()->id());
        return $result
            ? [
                'status' => true,
                'message' => 'Removed as follower'
            ]
            : [
                'status' => false,
                'message' => 'Removed Already'
            ];
    }



}
