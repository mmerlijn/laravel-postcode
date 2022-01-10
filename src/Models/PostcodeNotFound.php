<?php

namespace mmerlijn\laravelPostcode\Models;

class PostcodeNotFound extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'postcode', 'number'
    ];

    public function getConnection()
    {
        $this->connection = config('postcode.database_connection_name');
        return parent::getConnection();
    }

    public function getTable()
    {
        return config('postcode.postcode_table_not_found');
    }
}