<?php

namespace App\Services;


use App\Http\Resources\admin\CompanyCollection;
use App\Http\Resources\admin\CompanyRequestCollection;
use App\Http\Resources\admin\JobSeekerCollection;
use App\Http\Resources\admin\JobseekerRequestCollection;
use App\Http\Resources\FollowCollection;
use App\Models\User;

class CommunityService {

    public function getUsers()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $users = User::with(['profile' => function($q){
                $q->select('user_id','firstname', 'lastname', 'avatar');
            }, 'jobPreference' => function($q){
                $q->select('user_id', 'job_title');
            }])
            ->withFilterQueries()
            ->withFollowingInfo()
            ->withFollowerInfo()
            ->withSearch()
            ->paginate($per_page);

        $users->withPath("/users");

        if(\request('search')){
            $users->appends(['search' => \request('search')]);
        }

        if(\request('q')){
            $users->appends(['q' => \request('q')]);
        }

        if(\request('per_page')){
            $users->appends(['per_page' => \request('per_page')]);
        }

        return FollowCollection::collection($users)->response()->getData(true);
    }

    public function getJobSeekers()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $users = User::with(['profile' => function($q){
            $q->select('user_id','firstname', 'lastname', 'avatar');
        }])
            ->whereHas('profile')
            ->withJobSeekerSearch()
            ->paginate($per_page);

        $users->withPath("/jobSeekers");

        if(\request('search')){
            $users->appends(['search' => \request('search')]);
        }

        if(\request('q')){
            $users->appends(['q' => \request('q')]);
        }

        if(\request('per_page')){
            $users->appends(['per_page' => \request('per_page')]);
        }
        return JobSeekerCollection::collection($users)->response()->getData(true);
    }

    public function getCompanies()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $users = User::with(['company' => function($q){
            $q->select('user_id', 'name','avatar');
        }])
            ->whereHas('company')
            ->withCompanySearch()
            ->paginate($per_page);

        $users->withPath("/companies");

        if(\request('search')){
            $users->appends(['search' => \request('search')]);
        }

        if(\request('q')){
            $users->appends(['q' => \request('q')]);
        }

        if(\request('per_page')){
            $users->appends(['per_page' => \request('per_page')]);
        }

        return CompanyCollection::collection($users)->response()->getData(true);
    }

    public function getCompanyRequests()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $users = User::with([
            'company' => function($q){
                $q->select('id', 'user_id', 'name','avatar');
            },
            'company.companyDocument'
        ])
            ->whereHas('company.companyDocument', function($q){
                $q->where('status', false)
                    ->where('valid_id', '!=', '')
                    ->where('valid_id_image_front', '!=', '')
                    ->where('valid_id_image_back', '!=', '')
                    ->where('certificate', '!=', '')
                    ->where('certificate_image', '!=', '')
                    ->whereNotNull('valid_id')
                    ->whereNotNull('valid_id_image_front')
                    ->whereNotNull('valid_id_image_back')
                    ->whereNotNull('certificate')
                    ->whereNotNull('certificate_image');
            })
            ->paginate($per_page);

        $users->withPath("/companiesRequests");

        if(\request('search')){
            $users->appends(['search' => \request('search')]);
        }

        if(\request('q')){
            $users->appends(['q' => \request('q')]);
        }

        if(\request('per_page')){
            $users->appends(['per_page' => \request('per_page')]);
        }

        return CompanyRequestCollection::collection($users)->response()->getData(true);
    }

    public function getJobSeekerRequests()
    {
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 10;

        $users = User::with([
            'profile' => function($q){
                $q->select('user_id','firstname', 'lastname', 'avatar');
            },
            'document'
            ])
            ->whereHas('document', function($q){
                $q->where('status', false)
                    ->where('valid_id', '!=', '')
                    ->where('valid_id_image_front', '!=', '')
                    ->where('valid_id_image_back', '!=', '')
                    ->whereNotNull('valid_id')
                    ->whereNotNull('valid_id_image_front')
                    ->whereNotNull('valid_id_image_back');
            })
            ->paginate($per_page);

        $users->withPath("/jobSeekerRequests");

        if(\request('search')){
            $users->appends(['search' => \request('search')]);
        }

        if(\request('q')){
            $users->appends(['q' => \request('q')]);
        }

        if(\request('per_page')){
            $users->appends(['per_page' => \request('per_page')]);
        }

        return JobseekerRequestCollection::collection($users)->response()->getData(true);
    }
}
