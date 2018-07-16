<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightLog extends Model
{
    protected $fillable = ['user_id', 'weight', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
