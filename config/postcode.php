<?php
return [
    'database_connection_name' => 'mysql_postcode',
    'postcode_table_name' => 'postcode_nl',

    //if empty not found postcodes will not be stored
    'postcode_table_not_found' => 'postcode_not_found',


    //Postcode routes configuration
    'route' => [
        'prefix' => 'postcode',
        'middleware' => ['web'],
    ],
];