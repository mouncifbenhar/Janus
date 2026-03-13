<?php

namespace App\Http\Controllers;

use App\Models\Habits;
use App\Models\Log;
use Illuminate\Support\Carbon;

class Logcontroller extends Controller
{
    public function mark_completed($id){

       $date = Carbon::today();
       $habit = Habits::findOrFail($id);

       $exists = Log::where('habit_id',$habit->id)->whereDate('complet_at',$date)->exists();

        if($exists){
            return response()->json([
            'message' => 'habit already completed today'
             ],400);
        }
       $log = Log::create([
          'habit_id' => $habit->id,
          'complet_at' => $date
       ]);
       return response()->json([
            'massege' => 'the habit mark as completed',
            'log' => $log
       ],201);
    }
    public function log_Historique($id){
        $habit = Habits::findOrFail($id);
        $logs = Log::where('habit_id',$habit->id)->get();
        return response()->json([
            'habit' => $habit->title,
            'logs' =>  $logs
        ],201);
    }
    public function delete_log($h_id,$l_id){
         
      $habit = Habits::findOrFail($h_id);
      $log = Log::findOrFail($l_id);
      if($habit->id == $log->habit_id){
         $log->delete();
         return response()->json([
          'massege' => 'delete seccssfylly'
         ],201);
      }
    }

    public function stats($id){
    
     $date = Carbon::today();
     $habit = Habits::findOrFail($id);

     $logs = Log::where('habit_id',$habit->id)->orderBy('complet_at','desc')->get();
     $total = $logs->count();

    $streak = 0;
    foreach($logs as $log){
        
      if($log->complet_at->isSameDay($date)){

         $streak ++;
         $date->subDay();

       }else{
        
          break;

       }
    }
    $current = 1;
    $longest = 1;
    foreach ($logs as $i => $log){
     if($i == 0){
       continue;
     }
     if($log->complet_at->diffInDays($log->complet_at->subDay())){
       $current++;
     }else{
        $current = 1;
     }
     
     $longest =  max($longest, $current);

    }

    $completion_rate = $longest / $habit->target_days;

     return response()->json([
        'habit' => $habit->title,
        'massege' => 'Statistiques',
        'total_completions' => $total,
        'current_streak' => $streak,
        'longest_streak' =>  $longest,
        'completion_rate' => $completion_rate."%"
     ],201);

    }
































}
