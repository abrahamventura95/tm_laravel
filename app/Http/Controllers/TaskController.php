<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Task;
use App\Subtask;

class TaskController extends Controller
{
    /**
     * Create a task
     */
    public function create(Request $request){
        $request->validate([
            'tag' => 'required|string',
            'priority' => 'required|in:1,2,3,4,5'
        ]);

        Task::create([
            'user_id' => auth()->user()->id,
            'tag' => $request->tag,
            'priority' => $request->priority
        ]);

        return response()->json([
            'message' => 'Successfully created task!'
        ], 201);
    }
    /**
     * Show all user`s tasks
     */
    public function get(Request $request){
    	return Task::where('user_id','=',auth()->user()->id)
    			   ->orderBy('status','asc')
    			   ->orderBy('created_at','desc')
    			   ->get();
    }
    /**
     * Show takes by tag
     */
    public function getByTag($tag, Request $request){
    	return Task::where('user_id','=',auth()->user()->id)
    			   ->where('tag','LIKE','%'.$tag.'%')
    			   ->orderBy('status', 'asc')
    			   ->orderBy('created_at','desc')
    			   ->get();
    }
    /**
     * Show a task
     */
    public function show($id){
    	$task = Task::find($id);
        $subtask = Subtask::where('task_id','=',$task->id)
                          ->orderBy('status','asc')
                          ->get();
        $resp = array('task' => $task, 'subtasks' => $subtask);
    	if($task->user_id = auth()->user()->id) return $resp;
    	else return response()->json([
	            					'message' => 'Unauthorized!'
	        					], 401);
    }
    /**
     * Edit a Task
     */
    public function edit($id, Request $request){
    	$task = Task::find($id);
    	$request->validate([
            'tag' => 'string',
            'priority' => 'in:1,2,3,4,5',
			'status' => 'boolean'
        ]);
		if(isset($request->tag)){
		    $task->tag = $request->tag; 
		}
		if(isset($request->priority)){
		    $task->priority = $request->priority; 
		}
		if(isset($request->status)){
		    $task->status = $request->status; 
		}
        if($task->user_id = auth()->user()->id){
        	$task->save();
        }
        return $task;
    }

    /**
     * Delete a task
     */
    public function delete($id){
    	$task = Task::find($id);
        if(isset($task) && $task->user_id == auth()->user()->id){
        	$task->delete();
	        return response()->json([
	            'message' => 'Successfully deleted!'
	        ], 201);
    	}else{
    		return response()->json([
	            'message' => 'Unauthorized to deleted!'
	        ], 401);
    	}
    }
    //SUB TAKS

     /**
     * Create a subtask
     */
    public function createSub($idtask, Request $request){
        $request->validate([
            'tag' => 'required|string'
        ]);
        $task = Task::find($idtask);
        if($task->user_id == auth()->user()->id){
            Subtask::create([
                'task_id' => $idtask,
                'tag' => $request->tag
            ]);

            return response()->json([
                'message' => 'Successfully created subtask!'
            ], 201);
        }else{
            return response()->json([
                'message' => 'Unauthorized!'
            ], 201);
            
        }
    }

    /**
     * Edit a subtask
     */
    public function editSub($id, Request $request){
        $subtask = Subtask::find($id);
        $task = Task::find($subtask->task_id);
        $request->validate([
            'tag' => 'string',
            'status' => 'boolean'
        ]);
        if(isset($request->tag)){
            $subtask->tag = $request->tag; 
        }
        if(isset($request->status)){
            $subtask->status = $request->status; 
        }
        if($task->user_id = auth()->user()->id){
            $subtask->save();
        }
        return $subtask;
    }

    /**
     * Delete a task
     */
    public function deleteSub($id){
        $subtask = Subtask::find($id);
        $task = Task::find($subtask->task_id);
        if(isset($task) && $task->user_id == auth()->user()->id){
            $subtask->delete();
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
