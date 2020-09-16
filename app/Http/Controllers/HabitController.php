<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Habit;

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
    	if($habit->user_id = auth()->user()->id) return $habit;
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

}
