<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //protected $primaryKey = 'num_fak';
    protected $fillable = ['num_fak', 'сlient', 'comment', 'priority', 'archive'];
}
