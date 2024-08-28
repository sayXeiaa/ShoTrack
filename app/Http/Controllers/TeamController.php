<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\teams;
use App\Models\tournaments;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    // Get the tournament ID from the request
    $tournamentId = $request->input('tournament_id');

    // Fetch teams filtered by the selected tournament if one is selected, otherwise fetch all teams
    $teams = Teams::when($tournamentId, function ($query) use ($tournamentId) {
        return $query->where('tournament_id', $tournamentId);
    })->latest()->paginate(25); // Order by created_at DESC

    // Get all tournaments for the dropdown
    $tournaments = Tournaments::all();

    return view('teams.list', [
        'teams' => $teams,
        'tournaments' => $tournaments,
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // Fetch all tournaments from the database
        $tournaments = Tournaments::all();

        // Pass the tournaments to the view
        return view('teams.create', compact('tournaments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'team_acronym' => 'required|min:2',
            'coach_name' => 'required|min:5',
            'assistant_coach_1' => 'nullable|min:5',
            'assistant_coach_2' => 'nullable|min:5',
            'address' => 'required|min:5',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($validator->passes()){
            $team = new teams();
            $team->name = $request->name;
            $team->team_acronym =$request->team_acronym;
            $team->coach_name =$request->coach_name;
            $team->assistant_coach1_name=$request->assistant_coach_1;
            $team->assistant_coach2_name =$request->assistant_coach_2;
            $team->address = $request->address;
            $team->tournament_id = $request->tournament_id;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $team->logo = $logoPath;
            }
    
            $team->save();

            return redirect()->route('teams.index')->with('success', 'Team added successfully.');
        }
        else{
            return redirect()->route('teams.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $team = Teams::findOrFail($id);
        $tournaments = Tournaments::all(); // Fetch all tournaments

        return view('teams.edit', [
            'team' => $team,
            'tournaments' => $tournaments // Pass tournaments to the view
        ]);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team = teams::findOrFail($id);
        $tournaments = Tournaments::all(); // Fetch all tournaments

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'team_acronym' => 'required|min:2',
            'coach_name' => 'required|min:5',
            'assistant_coach_1' => 'nullable|min:5',
            'assistant_coach_2' => 'nullable|min:5',
            'address' => 'required|min:5',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'tournament_id' => 'nullable|exists:tournaments,id',
        ]);

        if ($validator->passes()){
            $team->name = $request->name;
            $team->team_acronym =$request->team_acronym;
            $team->coach_name =$request->coach_name;
            $team->assistant_coach1_name=$request->assistant_coach1_name;
            $team->assistant_coach2_name =$request->assistant_coach2_name;
            $team->address = $request->address;
            $team->tournament_id = $request->tournament_id;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $team->logo = $logoPath;
            }
            
            $team->save();

            return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
        }
        else{
            return redirect()->route('teams.edit',$id)->withInput()->withErrors($validator);
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $team = teams::find($request->id);

        if($team == null){
            session()->flash('error','Team not found');
            return response()->json([
                'status' => false
            ]);
        }

        $team->delete();
        session()->flash('error','Team deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}
