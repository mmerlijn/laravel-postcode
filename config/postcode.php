<?php
return [
    'database_connection_name' => env('postcode_db_connection', 'mysql_postcode'),
    'postcode_table_name' => env('postcode_table', 'postcode_nl'),

    //if empty not found postcodes will not be stored
    'postcode_table_not_found' => 'postcode_not_found',


    //Postcode routes configuration
    'route' => [
        'prefix' => 'postcode',
        'middleware' => ['web'],
    ],
];