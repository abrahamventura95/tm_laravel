<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Habit;
use App\Habitday as Day;

class HabitController extends Controller
{
    /**
     * Create an habit
     */
    public function create(Request $request){
        $request->validate([
            'tag' => 'required|string',
            'alarm' => 'required|boolean'
        ]);

        Habit::create([
            'user_id' => auth()->user()->id,
            'tag' => $request->tag,
            'alarm' => $request->alarm
        ]);

        return response()->json([
            'message' => 'Successfully created appointment!'
        ], 201);
    }
    /**
     * Show all user`s habits
     */
    public function get(Request $request){
    	return Habit::where('user_id','=',auth()->user()->id)
    			    ->orderBy('status','asc')
    			    ->orderBy('created_at','desc')
    			    ->get();
    }
    /**
     * Show takes by tag
     */
    public function getByTag($tag, Request $request){
    	return Habit::where('user_id','=',auth()->user()->id)
    			    ->where('tag','LIKE','%'.$tag.'%')
    			    ->orderBy('status', 'asc')
    			    ->orderBy('created_at','desc')
    			    ->get();
    }
    /**
     * Show an habit
     */
    public function show($id){
    	$habit = Habit::find($id);
    	$days = Day::where('habit_id','=',$id)->get();
    	$resp = array('habit' => $habit, 'days' => $days);
    	if($habit->user_id = auth()->user()->id) return $resp;
    	else return response()->json([
	            					'message' => 'Unauthorized!'
	        					], 401);
    }
    /**
     * Edit an habit
     */
    public function edit($id, Request $request){
    	$habit = Habit::find($id);
    	$request->validate([
            'tag' => 'string',
            'alarm' => 'boolean',
			'status' => 'boolean'
        ]);
		if(isset($request->tag)){
		    $habit->tag = $request->tag; 
		}
		if(isset($request->alarm)){
		    $habit->alarm = $request->alarm; 
		}
		if(isset($request->status)){
		    $habit->status = $request->status; 
		}
        if($habit->user_id = auth()->user()->id){
        	$habit->save();
        }
        return $habit;
    }

    /**
     * Delete an habit
     */
    public function delete($id){
    	$habit = Habit::find($id);
        if(isset($habit) && $habit->user_id == auth()->user()->id){
        	$habit->delete();
	        return response()->json([
	            'message' => 'Successfully deleted!'
	        ], 201);
    	}else{
    		return response()->json([
	            'message' => 'Unauthorized to deleted!'
	        ], 401);
    	}
    }

    //Days

    /**
     * Create an habitDay
     */
    public function createDay($id, Request $request){
        $request->validate([
            'tag' => 'required|string',
            'frequency' => 'required|integer',
            'day' => 'required|string|
            		  in:monday,tuesday,wednesday,
            		  	 thursday,friday,saturday,
            		  	 sunday,everyday',
            'time' =>'required'
        ]);
        $habit = Habit::find($id);
        if($habit->user_id === auth()->user()->id){
        	Day::create([
	            'habit_id' => $id,
	            'tag' => $request->tag,
	            'frecuency' => $request->frequency,
	            'day' => $request->day,
	            'time' => $request->time,
	        ]);

	        return response()->json([
	            'message' => 'Successfully created habitDay!'
	        ], 201);
        }else{
        	return response()->json([
	            'message' => 'Unauthorized!'
	        ], 401);
        }
        
    }
    /**
     * Edit an habitDay
     */
    public function editDay($id, Request $request){
    	$day = Day::find($id);
    	$habit = Habit::find($day->habit_id);
    	$request->validate([
            'tag' => 'string',
            'frequency' => 'integer',
			'day' => 'in:monday,tuesday,wednesday,
            		  	 thursday,friday,saturday,
            		  	 sunday,everyday',
			'time' => 'timezone'
        ]);
		if(isset($request->tag)){
		    $day->tag = $request->tag; 
		}
		if(isset($request->frequency)){
		    $day->frequency = $request->frequency; 
		}
		if(isset($request->day)){
		    $day->day = $request->day; 
		}
		if(isset($request->time)){
		    $day->time = $request->time; 
		}
        if($habit->user_id = auth()->user()->id){
        	$day->save();
        }
        return $day;
    }

    /**
     * Delete an habitDay
     */
    public function deleteDay($id){
    	$day = Day::find($id);
    	$habit = Habit::find($day->habit_id);
        if(isset($day) && $habit->user_id == auth()->user()->id){
        	$day->delete();
	        return response()->json([
	            'message' => 'Successfully deleted!'
	        ], 201);
    	}else{
    		return response()->json([
	            'message' => 'Unauthorized to deleted!'
	        ], 401);
    	}
    }
}
