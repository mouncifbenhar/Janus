<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habits extends Model
{

 protected $fillable = [
        'title',
        'description',
        'Frequency',
        'target_days',
        'color',
        'status',
        'user_id'
    ];


public function user(){   
    return $this->belongsTo(User::class,'user_id');
}
public function log(){
    return $this->hasMany(Log::class);
}
}
