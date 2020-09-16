<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Appointment as Apmnt;

class AppointController extends Controller
{
    /**
     * Create an appointment
     */
    public function create(Request $request){
        $request->validate([
            'tag' => 'required|string',
            'place' => 'required|string',
            'topic' => 'required|string'
        ]);

        Apmnt::create([
            'user_id' => auth()->user()->id,
            'tag' => $request->tag,
            'place' => $request->place,
            'time' => $request->time,
            'topic' => $request->topic
        ]);

        return response()->json([
            'message' => 'Successfully created appointment!'
        ], 201);
    }
    /**
     * Show all user`s appointments
     */
    public function get(Request $request){
    	return Apmnt::where('user_id','=',auth()->user()->id)
    			    ->orderBy('status','asc')
    			    ->orderBy('created_at','desc')
    			    ->get();
    }
    /**
     * Show takes by appointment
     */
    public function getByTag($tag, Request $request){
    	return Apmnt::where('user_id','=',auth()->user()->id)
    			    ->where('tag','LIKE','%'.$tag.'%')
    			    ->orderBy('status', 'asc')
    			    ->orderBy('created_at','desc')
    			    ->get();
    }
    /**
     * Show an appointment
     */
    public function show($id){
    	$apmnt = Apmnt::find($id);
    	if($apmnt->user_id = auth()->user()->id) return $apmnt;
    	else return response()->json([
	            					'message' => 'Unauthorized!'
	        					], 401);
    }
    /**
     * Edit an appointment
     */
    public function edit($id, Request $request){
    	$apmnt = Apmnt::find($id);
    	$request->validate([
            'tag' => 'string',
            'topic' => 'string',
            'place' => 'string',
            'time' => 'timezone',
			'status' => 'boolean'
        ]);
		if(isset($request->tag)){
		    $apmnt->tag = $request->tag; 
		}
		if(isset($request->topic)){
		    $apmnt->topic = $request->topic; 
		}
		if(isset($request->place)){
		    $apmnt->place = $request->place; 
		}
		if(isset($request->time)){
		    $apmnt->time = $request->time; 
		}
		if(isset($request->status)){
		    $apmnt->status = $request->status; 
		}
        if($apmnt->user_id = auth()->user()->id){
        	$apmnt->save();
        }
        return $apmnt;
    }

    /**
     * Delete an appointment
     */
    public function delete($id){
    	$apmnt = Apmnt::find($id);
        if(isset($apmnt) && $apmnt->user_id == auth()->user()->id){
        	$apmnt->delete();
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
