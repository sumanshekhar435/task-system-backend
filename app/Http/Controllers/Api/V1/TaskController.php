<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\TaskAssignedEvent;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'DESC')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'deadline' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        $task = Task::create($request->all());
        TaskAssignedEvent::dispatch($task);

        return response()->json(['status' => 'success', 'message' => 'Task Create Successful', 'task' => $task], 201);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'deadline' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $task->update($request->all());
        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['status' => true, 'message' => 'Task deleted successfully'], 200);
    }
}
