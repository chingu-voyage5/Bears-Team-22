<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'email', 'token','invited_role','user_id'
    ];

    protected $dates = [
        'accepted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
