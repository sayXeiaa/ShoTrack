<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Schedule;
use App\Models\teams;
use App\Models\tournaments;
use App\Rules\Time12HourFormat;
use App\Models\Score;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $tournamentId = $request->input('tournament_id');
    $category = $request->input('category');

    // Fetch schedules filtered by the selected tournament and category if provided
    $schedules = Schedule::with(['team1', 'team2', 'scores.team']) // Load related teams and scores
        ->when($tournamentId, function ($query) use ($tournamentId) {
            return $query->where('tournament_id', $tournamentId);
        })
        ->when($category, function ($query) use ($category, $tournamentId) {
            return $query->whereHas('team1', function ($q) use ($category, $tournamentId) {
                $q->where('category', $category)->where('tournament_id', $tournamentId);
            })->orWhereHas('team2', function ($q) use ($category, $tournamentId) {
                $q->where('category', $category)->where('tournament_id', $tournamentId);
            });
        })
        ->orderBy('date', 'asc')
        ->paginate(25);

    $tournaments = Tournaments::all(); 
    $categories = $tournamentId ? $tournaments->where('id', $tournamentId)->pluck('category')->unique() : collect();

    return view('schedules.list', [
        'schedules' => $schedules,
        'tournaments' => $tournaments,
        'categories' => $categories,
    ]);
}
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tournamentId = $request->query('tournament_id');
        $tournaments = Tournaments::all();
        $teams = [];

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
        // Validation rules
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|exists:tournaments,id',
            'date' => 'required|date',
            'time' => ['required', new Time12HourFormat],
            'venue' => 'required|string|max:255',
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id',
            'category' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('schedules.create')->withInput()->withErrors($validator);
        }
    
        // Fetch the tournament to check if it has categories
        $tournamentId = $request->input('tournament_id');
        $tournament = Tournaments::findOrFail($tournamentId);
        $hasCategories = $tournament->has_categories;
    
        // Convert 12-hour time format to 24-hour format
        $time12Hour = $request->input('time');
        $dateTime = \DateTime::createFromFormat('g:i A', $time12Hour);
        $time24Hour = $dateTime ? $dateTime->format('H:i') : null;
    
        $schedule = new Schedule();
        $schedule->tournament_id = $request->tournament_id;
        $schedule->date = $request->date;
        $schedule->time = $time24Hour;
        $schedule->venue = $request->venue;
        $schedule->team1_id = $request->team1_id;
        $schedule->team2_id = $request->team2_id;
    
        // Only set category if the tournament has categories
        if ($hasCategories) {
            $schedule->category = $request->input('category');
        }
    
        $schedule->save();
    
        return redirect()->route('schedules.index')->with('success', 'Game schedule added successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);
    
        return view('playerstats.create', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tournaments = Tournaments::all();
        
        $schedule = Schedule::findOrFail($id);

        // Fetch all teams for the selected tournament and category
        $teams = Teams::where('tournament_id', $schedule->tournament_id)
                    ->where('category', $schedule->category)
                    ->get();

        // Categories
        $categories = ['juniors', 'seniors'];

        return view('schedules.edit', compact('schedule', 'tournaments', 'categories', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);

        // Find the tournament to check if it has categories
        $tournamentId = $request->input('tournament_id');
        $tournament = Tournaments::findOrFail($tournamentId);
        $hasCategories = $tournament->has_categories;

        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|exists:tournaments,id',
            'date' => 'required|date',
            'time' => ['required', new Time12HourFormat],
            'venue' => 'required|string|max:255',
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id',
            'category' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('schedules.edit', $id)->withInput()->withErrors($validator);
        }

        // Convert 12-hour format to 24-hour format
        $time12Hour = $request->input('time');
        $dateTime = \DateTime::createFromFormat('g:i A', $time12Hour);
        $time24Hour = $dateTime ? $dateTime->format('H:i') : null;

        // Update the schedule
        $schedule->tournament_id = $request->tournament_id;
        $schedule->date = $request->date;
        $schedule->time = $time24Hour;
        $schedule->venue = $request->venue;
        $schedule->team1_id = $request->team1_id;
        $schedule->team2_id = $request->team2_id;

        if ($hasCategories) {
            $schedule->category = $request->input('category');
        } else {
            $schedule->category = null; // Clear the category if the tournament doesn't have categories
        }

        $schedule->save();

        return redirect()->route('schedules.index')->with('success', 'Game schedule updated successfully.');
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

    public function showMatch($schedule_id) {
        $schedule = Schedule::find($schedule_id); 
        $teamA = Teams::find($schedule->teamA_id);
        $teamB = Teams::find($schedule->teamB_id);
        
        return view('match', compact('schedule', 'teamA', 'teamB'));
    }

    public function storeGameTime(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|integer|exists:schedules,id',
            'current_quarter' => 'required|integer',
            'game_time' => 'required|string',
            'total_elapsed_time' => 'required|integer',
            'quarter_elapsed_time' => 'required|integer',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        $schedule->current_quarter = $request->current_quarter;
        $schedule->total_elapsed_time = $request->total_elapsed_time;
        $schedule->quarter_elapsed_time = $request->quarter_elapsed_time;

        $totalGameTime = 2400; 
        $remaining_game_time = max(0, $totalGameTime - $schedule->total_elapsed_time);
        $schedule->remaining_game_time = $remaining_game_time;

        $schedule->save();

        return response()->json(['message' => 'Game time updated successfully']);
    }

    public function getGameDetails($scheduleId) {
        $schedule = Schedule::find($scheduleId);
        
        if ($schedule) {
            $quarterLength = 600; 

            // Calculate the remaining time based on the current quarter
            $currentQuarter = $schedule->current_quarter;
            $totalElapsedTime = $schedule->total_elapsed_time;

            // Calculate time spent in the current quarter
            $timeSpentInCurrentQuarter = $totalElapsedTime - (($currentQuarter - 1) * $quarterLength);
            $timeSpentInCurrentQuarter = max(0, min($timeSpentInCurrentQuarter, $quarterLength));

            // Calculate remaining game time in the current quarter
            $remaining_game_time = max(0, $quarterLength - $timeSpentInCurrentQuarter);

            return response()->json([
                'remaining_game_time' => $remaining_game_time,
                'total_elapsed_time' => $schedule->total_elapsed_time,
                'current_quarter' => $currentQuarter,
                'quarter_elapsed_time' => $timeSpentInCurrentQuarter // Return the quarter's elapsed time
            ]);
        } else {
            return response()->json(['error' => 'Schedule not found.'], 404);
        }
    }

    public function getScores($scheduleId)
    {
        // Fetch the latest scores for the given schedule ID from the scores table
        $scoreEntry = Score::where('schedule_id', $scheduleId)
                        ->orderBy('created_at', 'desc')
                        ->first();

        if ($scoreEntry) {
            return response()->json([
                'scores' => [
                    'team_a' => $scoreEntry->team_a_score,
                    'team_b' => $scoreEntry->team_b_score,
                ],
            ]);
        }

        // Default response if no entries are found
        return response()->json([
            'scores' => [
                'team_a' => 0,
                'team_b' => 0,
            ],
        ]);
    }

}
