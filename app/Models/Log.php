<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    
protected $fillable = [
     'complet_at',
     'habit_id'
];
public $casts = [
  'complet_at' => 'datetime'
];
  public function habits(){
    return $this->belongsTo(Habits::class,'habit_id');
  }
  
}
