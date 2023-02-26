<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;


class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    
    public function index()
    {
        $projects = Project::all();
        return response()->json([
            'status' => 'success',
            'projects' => $projects,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $Project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Project created successfully',
            'Project' => $Project,
        ]);
    }

    public function show($id)
    {
        $Project = Project::find($id);
        return response()->json([
            'status' => 'success',
            'Project' => $Project,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $Project = Project::find($id);
        $Project->title = $request->title;
        $Project->description = $request->description;
        $Project->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully',
            'Project' => $Project,
        ]);
    }

    public function destroy($id)
    {
        $Project = Project::find($id);
        $Project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully',
            'Project' => $Project,
        ]);
    }
}
