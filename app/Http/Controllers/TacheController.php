<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TacheController extends Controller
{

    public function __construct()
    {
        // middleware for verifid user login or not
        $this->middleware('ApiAuth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tache =[];

        if(Auth::user()->id == 1){
            $tache = Tache::where('admin', Auth::user()->id)->get();


        }else if (Auth::user()->id == 2){
            $tache = Tache::where('member', Auth::user()->id)->get();
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'taches' => $tache,
        ]);
    }


        /**
     * Display a listing of the resource.
     */
    public function filter(Request $request)
    {

        $tache = Tache::query();

        if(!is_null($request->status)) {
            $tache->orWhere("status", "LIKE", "%{$request->status}%");
        }
    
        if (!is_null($request->start_at)) {
            $tache->orWhere('start_at', '>=', $request->start_at);
        }
    
        if (!is_null($request->end_at)) {
            $tache->orWhere('end_at', '<=', $request->end_at);
        }

        
        if (!is_null($request->limit) || !is_null($request->page) ) {
            // pardefault  limit 10 and page 1
            $tache->paginate($request->limit ?? 10 , $columns = ['*'], $pageName = 'page' , $request->page ?? 1) ; 
        }

        Log::info("tachetachetache" , [$tache]);

        $tache = $tache->get();
        return response()->json([
            'status' => 'success',
            'taches' => $tache,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }
      

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'required|date',

        ]);

        if(Auth::user()->role_id == 1){
            $tache = Tache::create([
                'admin' => Auth::user()->id,
                "member"=>$request->member,
                "start_at"=>$request->start_at,
                "end_at"=>$request->end_at,
                "project_id"=>$request->project_id,
                "description"=>$request->description,
                "status"=> $request->status
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'tache created successfully',
                'tache' => $tache,
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'you are not allow to ths acotion',
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tache = Tache::find($id);
        if (Auth::user()->id != $tache->admin  && Auth::user()->id  != $tache->member){
            $tache = Tache::where('member', Auth::user()->id)->get();
            return response()->json([
                'status' => 'success',
                'Project' => $tache,
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'you are not allow to see this tache',
            ], 401);
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tache $tache)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , $id)
    {
        $tache = Tache::find($id);
        // verification if his own and admin
        if($tache->admin == Auth::user()->id){
            $tache->start_at = $request->start_at;
            $tache->end_at = $request->end_at;
            $tache->description = $request->description;
            $tache->status = $request->status;
            $tache->save();
            return response()->json([
                'status' => 'success',
                'message' => 'tache updated successfully',
                'tache' => $tache,
            ]);
           // verification if his own and member
        }else if ($tache->member == Auth::user()->id){
            $tache->status = $request->status;
            $tache->save();
            return response()->json([
                'status' => 'success',
                'message' => 'tache updated successfully',
                'tache' => $tache,
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'you are not allow to ths acotion',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tache $tache)
    {
        //
    }
}
