<?php

namespace App\Services;


use App\Http\Resources\FollowCollection;
use App\Models\User;

class CommunityService {

    public function getUsers()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $users = User::with(['profile' => function($q){
            $q->select('user_id','firstname', 'middlename', 'lastname', 'avatar');
        }, 'jobPreference' => function($q){
                $q->select('user_id', 'job_title');
            }])
            ->withFilterQueries()
            ->withFollowInfo()
            ->withSearch()
            ->paginate($per_page);

        $users->withPath("/users");

        if(\request('search')){
            $users->appends(['search' => \request('search')]);
        }

        if(\request('q')){
            $users->appends(['q' => \request('q')]);
        }

        return FollowCollection::collection($users)->response()->getData(true);
    }

}
