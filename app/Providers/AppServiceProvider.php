<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //custom response
        Response::macro('success', function($data, $status_code = 200){
            return response()->json([
               'data'    => $data
            ], $status_code);
        });

        Response::macro('error', function($error_msg = 'error', $status_code = 404){
            return response()->json([
                'message'    => $error_msg
            ], $status_code);
        });

        Response::macro('successPaginated', function($data, $status_code = 200){
            return response()->json($data, $status_code);
        });


    }
}
