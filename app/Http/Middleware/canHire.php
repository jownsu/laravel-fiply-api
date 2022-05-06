<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\HiringManager;
use App\Models\HiringManagerToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class canHire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userType)
    {

    $token = null;

    if($userType == 'hiring_manager'){
        $hiringManager = HiringManager::select('id')
            ->where('company_id', auth()->user()->company->id)
            ->where('id', $request->header('hiring_id'))
            ->with(['hiringManagerToken' => function($q){
                return $q->select('tokenable_id', 'token')
                    ->where('tokenable_type', HiringManager::class);
            }])
            ->first();
        $token = $hiringManager->hiringManagerToken->token;
    }elseif ($userType == 'company'){
        $hiringManager= Company::select('id')
        ->where('id', $request->header('hiring_id'))
        ->with(['token'=> function($q){
            $q->select('tokenable_id','token');
        }])
        ->first();
        $token = $hiringManager->token->token ?? null;
    }

/*
        $hiringManager = HiringManager::where('company_id', auth()->user()->company->id)
            ->where('id', $request->header('hiring_id'))
            ->with('hiringManagerToken')
            ->with(['hiringManagerToken' => function($q) use ($userType){
                $q->when($userType == 'hiring_manager', function($q){
                    return $q->where('tokenable_type', HiringManager::class);
                })
                ->when($userType == 'company', function($q){
                    return $q->where('tokenable_type', Company::class);
                })
                ->when($userType == 'both', function($q){
                    return $q->whereIn('tokenable_type', [Company::class, HiringManager::class]);
                });
            }])
            ->get();*/

/*        $hiringManager = HiringManagerToken::where('tokenable_id', $request->header('hiring_id'))
            ->when($userType == 'hiring_manager', function($q){
                return $q->where('tokenable_type', HiringManager::class);
            })
            ->when($userType == 'company', function($q){
                return $q->where('tokenable_type', Company::class);
            })
            ->when($userType == 'both', function($q){
                return $q->whereIn('tokenable_type', [Company::class, HiringManager::class]);
            })->first();*/


        if(!$hiringManager ||
            !$token ||
            !Hash::check(
                Crypt::decryptString($request->header('hiring_token')), $token ))
        {
            return response()->error('Unauthorized employer'  ,404);
        }

        return $next($request);
    }
}
