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
/*        if(!$request->input('hiring_token')){
            return response()->error('Hiring Token Not Found',404);
        }
        if(!$request->input('hiring_id')){
            return response()->error('ID Not Found',404);
        }*/
        if($userType == 'hiring_manager'){
            $type = HiringManager::class ;
            $who = 'Hiring Manager';
        }

        if($userType == 'company'){
            $type = Company::class;
            $who = 'Company Admin';
        }

        $accessToken = HiringManagerToken::where('tokenable_id',$request->header('hiring_id'))
            ->where('tokenable_type', $type)
            ->first();

        if(!$accessToken || !Hash::check(Crypt::decryptString($request->header('hiring_token')) ,$accessToken->token)){
            return response()->error("Unauthorized $who" ,404);
        }

        return $next($request);
    }
}
