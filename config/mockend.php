<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mockend Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here, you may specify which filesystem disk config file is stored.
    |
    */

    'disk' => env('MOCKEND_DISK', 'base'),

    /*
    |--------------------------------------------------------------------------
    | Mockend Config file
    |--------------------------------------------------------------------------
    |
    | Here, you may specify config file path.
    |
    */

    'file_path' => env('MOCKEND_FILE_PATH', '.mocked.json'),

];
