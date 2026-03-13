<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Habits;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class HabitController extends Controller
{
    public function create_habit(Request $request){
              
      $request->validate([
        'title' => 'required|max:100',
        'description' => 'required',
        'Frequency' => 'required|in:daily,weekly,monthly',
        'target_days' => 'required|integer|min:1',
        'color' => 'required',
        'status' => 'boolean'
      ]);  
    
    $habit = Habits::create([
      'user_id' => auth()->id(),
      'title' => $request->title,
      'description' => $request->description,
      'Frequency' => $request->Frequency,
      'target_days' => $request->target_days,
      'color' => $request->color,
      'status' => $request->status
    ]);
    return response()->json($habit,201);
    }


    public function habits_all(){
       $habits = Habits::where('user_id',auth()->id())->get();
       return response()->json($habits,201);
    }
    public function habit_detail($id){
        $habit = Habits::findOrFail($id);
        return response()->json([
             'massege' => 'habit details',
             'habit' => $habit
        ]);
    }

    public function delete($id){
        $habit = Habits::findOrfail($id);
        $habit->delete();
        return response()->json([
                 'message' => 'seccssfully delete'
        ]);
    }
    public function apdate_habit(Request $request,$id){
         $habit = Habits::findOrfail($id);
         $habit->update($request->only('title','description','frequency'));
         return response()->json([
            'massage' => 'habit updated',
            'habit' => $habit
         ]);
    }
}
