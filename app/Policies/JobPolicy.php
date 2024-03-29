<?php

namespace App\Policies;

use App\Models\AppliedJob;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Job $job)
    {
        return ( $job->hiringManager->company->id == $user->company->id )
            ? Response::allow()
            : Response::deny('This Job Post does not belong to this company');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {

        $account_level = $user->account_level();

        $userId = auth()->id();

        $applyCount = AppliedJob::where('user_id', $userId)->whereDate('created_at', Carbon::today())->count();

        if($account_level['account_level']  == User::VERIFIED) {
            return Response::allow();
        }

        if($account_level['account_level'] == User::SEMI_VERIFIED){
            return $applyCount >= 3
                ? Response::deny('3 Apply Job per day is the limit for Semi Verified Users')
                : Response::allow();
        }

        return Response::deny('Account must be semi verified');

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Job $job)
    {
        return \request()->header('hiring_id') == $job->hiring_manager_id
            ? Response::allow()
            : Response::deny('The user do not own this Job Post');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Job $job)
    {
        return \request()->header('hiring_id') == $job->hiring_manager_id
            ? Response::allow()
            : Response::deny('The user do not own this Job Post');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Job $job)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Job $job)
    {
        //
    }
}
