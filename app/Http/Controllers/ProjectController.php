<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Project;



class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('ApiAuth');
    }

    
    public function index()
    {
        $projects = Project::where('user_id', Auth::user()->id)->get();
        // Project::all(['user_id', Auth::user()->id]);

        return response()->json([
            'status' => 'success',
            'projects' => $projects,
        ]);
    }


    public function filter(Request $request){
        $projects = Project::query();

        if(!is_null($request->title)) {
            $projects->orWhere("title", "LIKE", "%{$request->title}%");
        }

        if(!is_null($request->description)) {
            $projects->orWhere("description", "LIKE", "%{$request->description}%");
        }
        
        if (!is_null($request->limit) || !is_null($request->page) ) {
            // pardefault  limit 10 and page 1
            $projects->paginate($request->limit ?? 10 , $columns = ['*'], $pageName = 'page' , $request->page ?? 1) ; 
        }
        $projects = $projects->get();
        return response()->json([
            'status' => 'success',
            'taches' => $projects,
        ]);
    }

    public function store(Request $request)
    {

        // Log::info("request Auth::user()" , [Auth::user()->id]);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $Project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id

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
        if (Auth::user()->id == $Project->user_id ){
            return response()->json([
                'status' => 'success',
                'Project' => $Project,
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'you are not allow to see this project',
            ], 401);
        }
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
