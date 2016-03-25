<?php
//db.createUser({user: "homestead", pwd: "secret", roles: [{ role: "readWrite", db: "moldocds" }]})
return [

    'default'     => env('DB_CONNECTION', 'mongodb'),
    'connections' => [
        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => env('DB_HOST', 'localhost'),
            'port'     => env('DB_PORT', 27017),
            'database' => env('DB_DATABASE', 'moldocds'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'options'  => [
                'db' => 'moldocds' // sets the authentication database required by mongo 3
            ]
        ]
    ]
];