<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'images'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'avatar' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img/avatar'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/avatar',
        ],
        'cover' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img/cover'),
            'visibility' => 'public',
            'url' => env('APP_URL') .'/cover',
        ],
        'logo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img/logo'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/logo',
        ],
        'post' => [
            'driver' => 'local',
            'root' => storage_path('app/public/post'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/post',
        ],
        'id' => [
            'driver' => 'local',
            'root' => storage_path('app/public/files/id'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/id',
        ],
        'resume' => [
            'driver' => 'local',
            'root' => storage_path('app/public/files/resume'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/resume',
        ],
        'placeholder' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img/placeholder'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/placeholder',
        ],
        'files' => [
            'driver' => 'local',
            'root' => storage_path('app/public/files'),
            'visibility' => 'public',
        ],
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        //public_path('storage') => storage_path('app/public'),
        public_path('avatar') => storage_path('app/public/img/avatar'),
        public_path('cover') => storage_path('app/public/img/cover'),
        public_path('logo') => storage_path('app/public/img/logo'),
        public_path('placeholder') => storage_path('app/public/img/placeholder'),
        public_path('id') => storage_path('app/public/files/id'),
        public_path('resume') => storage_path('app/public/files/resume'),
        public_path('post') => storage_path('app/public/post'),
    ],

];
