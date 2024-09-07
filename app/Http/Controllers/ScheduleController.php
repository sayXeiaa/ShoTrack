<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Schedule;
use App\Models\teams;
use App\Models\tournaments;
use App\Rules\Time12HourFormat;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the tournament ID and category from the request
        $tournamentId = $request->input('tournament_id');
        $category = $request->input('category');
    
        // Fetch schedules filtered by the selected tournament and category if provided
        $schedules = Schedule::with(['team1', 'team2']) // Load related teams
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
            ->latest()
            ->paginate(25);
    
        // Get all tournaments for the dropdown
        $tournaments = Tournaments::all();
    
        // Fetch categories based on the selected tournament (assuming category is a column in tournaments)
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
    
        // Create a new schedule
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch tournaments
        $tournaments = Tournaments::all();
        
        // Fetch the schedule to edit
        $schedule = Schedule::findOrFail($id);

        // Fetch all teams for the selected tournament and category
        $teams = Teams::where('tournament_id', $schedule->tournament_id)
                    ->where('category', $schedule->category)
                    ->get();

        // Categories
        $categories = ['juniors', 'seniors']; // Adjust this based on your actual categories

        // Return the view with the schedule, tournaments, categories, and teams data
        return view('schedules.edit', compact('schedule', 'tournaments', 'categories', 'teams'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Fetch the schedule instance
        $schedule = Schedule::findOrFail($id);

        // Find the tournament to check if it has categories
        $tournamentId = $request->input('tournament_id');
        $tournament = Tournaments::findOrFail($tournamentId);
        $hasCategories = $tournament->has_categories;

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

        // Only set category if the tournament has categories
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
    
}
