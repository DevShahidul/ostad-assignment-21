<?php

namespace App\Http\Controllers;
use App\Models\Todo;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // Middleware for JWT Token Authentication
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    // Fetch User's Todos
    public function index(Request $request)
    {
        $userId = Auth::id();
        $todos = Todo::where('user_id', $userId)->get();
        return response()->json($todos, 200);
    }

    // Create a Todo
    public function store(TodoRequest $request)
    {
        $userId = Auth::id();
        $todo = new Todo([
            'user_id' => $userId,
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->completed,
        ]);

        $todo->save();

        return response()->json(['message' => 'Todo created successfully'], 201);
    }

    // Update a Todo
    public function update(TodoRequest $request, $id)
    {
        $userId = Auth::id();
        $todo = Todo::where('user_id', $userId)->findOrFail($id);
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->completed,
        ]);

        return response()->json(['message' => 'Todo updated successfully'], 200);
    }

    // Delete a Todo
    public function destroy($id)
    {
        $userId = Auth::id();
        $todo = Todo::where('user_id', $userId)->findOrFail($id);
        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully'], 200);
    }
}
