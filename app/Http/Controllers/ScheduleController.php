<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Schedule;
use App\Models\teams;
use App\Models\tournaments;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    // Get the tournament ID from the request
    $tournamentId = $request->input('tournament_id');

    // Fetch schedules filtered by the selected tournament if one is selected, otherwise fetch all schedules
    $schedules = Schedule::with(['team1', 'team2']) // Load related teams
        ->when($tournamentId, function ($query) use ($tournamentId) {
            return $query->where('tournament_id', $tournamentId);
        })
        ->latest()
        ->paginate(25);

    // Get all tournaments for the dropdown
    $tournaments = Tournaments::all();

    return view('schedules.list', [
        'schedules' => $schedules,
        'tournaments' => $tournaments,
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $tournamentId = $request->query('tournament_id');
    $tournaments = Tournaments::all();
    $teams = []; // Default to an empty array

    if ($tournamentId) {
        $teams = Teams::where('tournament_id', $tournamentId)->get();
    }

    return view('schedules.create', compact('tournaments', 'teams'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|exists:tournaments,id', // Ensure tournament_id exists in the tournaments table
            'match_date' => 'required|date',        // Ensure match_date is a valid date
            'venue' => 'required|string|max:255',   // Allow up to 255 characters for venue
            'team1_id' => 'required|exists:teams,id', // Ensure team1_id exists in the teams table
            'team2_id' => 'required|exists:teams,id', // Ensure team2_id exists in the teams table (nullable)
        ]);        

        if ($validator->passes()){
            $schedule = new Schedule();
            $schedule->tournament_id = $request->tournament_id; 
            $schedule->match_date = $request->match_date;
            $schedule->venue =$request->venue;
            $schedule->team1_id =$request->team1_id;
            $schedule->team2_id =$request->team2_id;

            $schedule->save();

            return redirect()->route('schedules.index')->with('success', 'Game schedule added successfully.');
        }
        else{
            return redirect()->route('schedules.create')->withInput()->withErrors($validator);
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
    // Fetch the schedule by ID
    $schedule = Schedule::findOrFail($id);
    
    // Fetch all tournaments
    $tournaments = Tournaments::all();

    // Fetch all teams for the selected tournament
    $teams = Teams::where('tournament_id', $schedule->tournament_id)->get();

    return view('schedules.edit', [
        'schedule' => $schedule,
        'tournaments' => $tournaments, // Pass tournaments to the view
        'teams' => $teams, // Pass teams to the view
    ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = schedule::findOrFail($id);
        $tournaments = Tournaments::all(); // Fetch all tournaments

        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|exists:tournaments,id', // Ensure tournament_id exists in the tournaments table
            'match_date' => 'required|date',        // Ensure match_date is a valid date
            'venue' => 'required|string|max:255',   // Allow up to 255 characters for venue
            'team1_id' => 'required|exists:teams,id', // Ensure team1_id exists in the teams table
            'team2_id' => 'required|exists:teams,id', // Ensure team2_id exists in the teams table (nullable)
        ]);        

        if ($validator->passes()){
            $schedule->tournament_id = $request->tournament_id; 
            $schedule->match_date = $request->match_date;
            $schedule->venue =$request->venue;
            $schedule->team1_id =$request->team1_id;
            $schedule->team2_id =$request->team2_id;

            $schedule->save();

            return redirect()->route('schedules.index')->with('success', 'Game schedule added successfully.');
        }
        else{
            return redirect()->route('schedules.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $schedule = Schedule::find($request->id);

        if($schedule == null){
            session()->flash('error','Schedule not found');
            return response()->json([
                'status' => false
            ]);
        }

        $schedule->delete();
        session()->flash('error','Schedule deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
    
}
