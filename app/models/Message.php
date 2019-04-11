<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $hidden = ['id'];
    protected $guarded = ['id'];
}
