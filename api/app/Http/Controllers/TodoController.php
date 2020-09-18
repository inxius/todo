<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

use App\Todo;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new Task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'task' => 'required|string',
        ]);

        try {
            $task = new Todo;
            $task->id_task = Uuid::uuid4()->getHex();
            $task->task = $request->input('task');
            $task->status = '0';
            $task->save();
            // dd($task);

            //return successful response
            return response()->json([
                'task' => $task, 
                'message' => 'TASK CREATED'
            ], 201);
        } catch (\Throwable $th) {
            //return error message
            return response()->json([
                'message' => 'Failed!'
            ], 409);
        }
    }

    /**
     * Done selected Task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function doneTask(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'id' => 'required|string',
        ]);

        try {
            $task = Todo::find($request->input('id'));
            $task->status = '1';
            $task->save();

            //return successful response
            return response()->json([
                'task' => $task, 
                'message' => 'TASK FINISHED!'
            ], 200);
        } catch (\Throwable $th) {
            //return error message
            return response()->json([
                'message' => 'Failed!'
            ], 409);
        }
    }

    /**
     * Delete selected Task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function deleteTask(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'id' => 'required|string',
        ]);

        try {
            $task = Todo::find($request->input('id'));
            $task->status = '2';
            $task->save();

            //return successful response
            return response()->json([
                'task' => $task, 
                'message' => 'TASK DELETED!'
            ], 200);
        } catch (\Throwable $th) {
            //return error message
            return response()->json([
                'message' => 'Failed!'
            ], 409);
        }
    }

    /**
     * Show active Task.
     *
     * @return Response
     */
    public function showTodo()
    {
        try {
            $task = Todo::where('status', '0')->get()->toArray();

            //return successful response
            return response()->json([
                'task' => $task, 
            ], 200);
        } catch (\Throwable $th) {
            //return error message
            return response()->json([
                'message' => 'Failed!'
            ], 409);
        }
    }

    /**
     * Show done Task.
     *
     * @return Response
     */
    public function showDone()
    {
        try {
            $task = Todo::where('status', '1')->get()->toArray();

            //return successful response
            return response()->json([
                'task' => $task, 
            ], 200);
        } catch (\Throwable $th) {
            //return error message
            return response()->json([
                'message' => 'Failed!'
            ], 409);
        }
    }

    /**
     * Show deleted Task.
     *
     * @return Response
     */
    public function showDeleted()
    {
        try {
            $task = Todo::where('status', '2')->get()->toArray();

            //return successful response
            return response()->json([
                'task' => $task, 
            ], 200);
        } catch (\Throwable $th) {
            //return error message
            return response()->json([
                'message' => 'Failed!'
            ], 409);
        }
    }

    //
}
