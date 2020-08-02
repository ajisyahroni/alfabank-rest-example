<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tweet extends Model
{
    use SoftDeletes;
    protected $fillable = ['tweet', 'time', 'user_id'];
    protected $hidden = ['updated_at', 'deleted_at', 'user_id'];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
