<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\tournaments;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = tournaments::latest()->paginate(25); //order by created_at DESC
        return view('tournaments.list', [
            'tournaments' => $tournaments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'description' => 'nullable|min:5',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'has_categories' => 'required|boolean',
            'tournament_type' => 'required|in:school,non-school',
            'tournament_location' => 'nullable|string|max:255',
        ]);

        if ($validator->passes()){
            $tournament = new tournaments();
            $tournament->has_categories = $request->input('has_categories', false);
            $tournament->name = $request->name;
            $tournament->description =$request->description;
            $tournament->start_date = $request->start_date;
            $tournament->end_date = $request->end_date;
            $tournament->tournament_type = $request->tournament_type;
            $tournament->tournament_location = $request->tournament_location;
            $tournament->save();

            return redirect()->route('tournaments.index')->with('success', 'Tournament added successfully.');
        }
        else{
            return redirect()->route('tournaments.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tournament = tournaments::findOrFail($id);
        return view('tournaments.edit',[
            'tournament' =>$tournament
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tournament = tournaments::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'description' => 'nullable|min:5',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'has_categories' => 'required|boolean',
            'tournament_type' => 'required|in:school,non-school',
            'tournament_location' => 'nullable|string|max:255',
        ]);

        if ($validator->passes()){
            $tournament->name = $request->name;
            $tournament->description =$request->description;
            $tournament->start_date = $request->start_date;
            $tournament->end_date = $request->end_date;
            $tournament->has_categories = $request->input('has_categories', false);
            $tournament->tournament_type = $request->tournament_type;
            $tournament->tournament_location = $request->tournament_location;
            $tournament->save();

            return redirect()->route('tournaments.index')->with('success', 'Tournament updated successfully.');
        }
        else{
            return redirect()->route('tournaments.edit',$id)->withInput()->withErrors($validator);
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $tournament = tournaments::find($request->id);

        if($tournament == null){
            session()->flash('error','Tournament not found');
            return response()->json([
                'status' => false
            ]);
        }

        $tournament->delete();
        session()->flash('error','Tournament deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
    public function getDetails($id)
    {
    $tournament = tournaments::find($id);
    
    if ($tournament) {
        $teams = $tournament->teams;
        return response()->json(['teams' => $teams]);
    }
    
    return response()->json(['teams' => []], 404);
}
}
