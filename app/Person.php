<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'age',
        'phone_number',
    ];
}
