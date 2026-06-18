<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index() 
    {

        $query = Task::query();

        // Filter by status
        if (request()->has('status')) {
            $query->where('status', request('status'));
        }

        // Search by title
        if (request()->has('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        // Pagination
        $tasks = $query->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Tasks retrieved successfully',
            'data' => $tasks
        ]);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function store(StoreTaskRequest $request) 
    {
        $task = Task::create($request->validated());

        return response()->json($task, 201);
    }

    public function update(
        UpdateTaskRequest $request,
        Task $task
    ) 
    {
        $task->update($request->validated());

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}
