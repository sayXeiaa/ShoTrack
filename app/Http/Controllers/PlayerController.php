<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Players;
use App\Models\Teams;
use App\Models\tournaments;
use Illuminate\Validation\Rule;
use App\Imports\PlayersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrayExport;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tournamentId = $request->query('tournament_id');
        $category = $request->query('category');
        $teamId = $request->query('team_id');
        $search = $request->query('search');
    
        // Fetch teams based on tournament and category
        $teamsQuery = Teams::query();
        if ($tournamentId) {
            $teamsQuery->where('tournament_id', $tournamentId);
        }
        if ($category) {
            $teamsQuery->where('category', $category);
        }
        $teams = $teamsQuery->get();
    
        // Fetch players based on selected filters and searched player
        $playersQuery = Players::query();
        if ($tournamentId) {
            $playersQuery->whereHas('team', function($query) use ($tournamentId) {
                $query->where('tournament_id', $tournamentId);
            });
        }
        if ($category) {
            $playersQuery->where('category', $category);
        }
        if ($teamId) {
            $playersQuery->where('team_id', $teamId);
        }
        if ($search) {
            $playersQuery->where(function($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }
        $players = $playersQuery->paginate(35); 
    
        // Fetch all tournaments for filtering options
        $tournaments = Tournaments::all();
    
        // Return the view with players, tournaments, and teams data
        return view('players.list', compact('players', 'tournaments', 'teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all tournaments from the database
        $tournaments = Tournaments::all();
    
        // Fetch all teams from the database
        $teams = Teams::all();
    
        // Pass the tournaments and teams to the view
        return view('players.create', compact('tournaments', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Base rules
        $rules = [
            'tournament_id' => ['required', 'integer', Rule::exists('tournaments', 'id')],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'number' => 'required|integer|min:0|max:99',
            'team_id' => ['required', 'integer', Rule::exists('teams', 'id')],
        ];
    
        $tournamentId = $request->input('tournament_id');
    
        if ($tournamentId) {
            $tournament = Tournaments::findOrFail($tournamentId);
    
            if ($tournament->tournament_type === 'school') {
                // Rules for school tournaments
                $rules = array_merge($rules, [
                    'years_playing_in_bucal' => 'required|integer|min:0|max:6',
                    'position' => 'required|string|in:Point Guard,Shooting Guard,Small Forward,Power Forward,Center',
                    'date_of_birth' => 'required|date',
                    'height' => ['required', 'regex:/^\d{1,2}\'\d{1,2}( \d{1,2}\/\d{1,2})?$/'],
                    'weight' => 'required|integer|min:0',
                ]);
            } else {
                // Rules for non-school tournaments
                $rules = array_merge($rules, [
                    'date_of_birth' => 'nullable|date',
                    'height' => ['nullable', 'regex:/^\d{1,2}\'\d{1,2}( \d{1,2}\/\d{1,2})?$/'],
                    'weight' => 'nullable|integer|min:0',
                ]);
            }

            if ($tournament->has_categories) {
                $rules['category'] = 'required|string';
            } else {
                $rules['category'] = 'nullable';
            }
        }
    
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->route('players.create')
                            ->withInput()
                            ->withErrors($validator);
        }
    
        $player = new Players(); 
        $player->first_name = $request->input('first_name');
        $player->last_name = $request->input('last_name');
        $player->number = $request->input('number');
        $player->team_id = $request->input('team_id');
        $player->date_of_birth = $request->input('date_of_birth');
        $player->height = $request->input('height');
        $player->weight = $request->input('weight');
    
        // fields for school tournament
        if ($tournament->type === 'school') {
            $player->years_playing_in_bucal = $request->input('years_playing_in_bucal');
            $player->position = $request->input('position');
        }
    
        // Only set category if tournament has categories
        if (isset($tournament) && $tournament->has_categories) {
            $player->category = $request->input('category');
        }
    
        $player->save();
    
        return redirect()->route('players.index')
                        ->with('success', 'Player added successfully.');
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
    
    // Fetch the player to edit
    $player = Players::findOrFail($id);

    // Fetch all teams for the dropdown
    $teams = Teams::where('tournament_id', $player->team->tournament_id)
                ->where('category', $player->team->category)
                ->get();

    $categories = ['juniors', 'seniors'];

    // Return the view with the player and teams data
    return view('players.edit', compact('player', 'tournaments', 'categories', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the player or fail with a 404 error
        $player = Players::findOrFail($id);
    
        // Base validation rules
        $rules = [
            'tournament_id' => ['required', 'integer', Rule::exists('tournaments', 'id')],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'number' => 'required|integer|min:0|max:99',
            'team_id' => ['required', 'integer', Rule::exists('teams', 'id')],
        ];
    
        $tournamentId = $request->input('tournament_id');
    
        if ($tournamentId) {
            $tournament = Tournaments::findOrFail($tournamentId);
    
            if ($tournament->tournament_type === 'school') {
                // Additional rules for school tournaments
                $rules = array_merge($rules, [
                    'years_playing_in_bucal' => 'required|integer|min:0|max:6',
                    'position' => 'required|string|in:Point Guard,Shooting Guard,Small Forward,Power Forward,Center',
                    'date_of_birth' => 'required|date',
                    'height' => ['required', 'regex:/^\d{1,2}\'\d{1,2}( \d{1,2}\/\d{1,2})?$/'],
                    'weight' => 'required|integer|min:0',
                ]);
            } else {
                // Rules for non-school tournaments
                $rules = array_merge($rules, [
                    'date_of_birth' => 'nullable|date',
                    'height' => ['nullable', 'regex:/^\d{1,2}\'\d{1,2}( \d{1,2}\/\d{1,2})?$/'],
                    'weight' => 'nullable|integer|min:0',
                ]);
            }
    
            if ($tournament->has_categories) {
                $rules['category'] = 'required|string';
            } else {
                $rules['category'] = 'nullable';
            }
        }
    
        // Validate request data
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->route('players.edit', $id)
                            ->withInput()
                            ->withErrors($validator);
        }
    
        // Update player details
        $player->first_name = $request->input('first_name');
        $player->last_name = $request->input('last_name');
        $player->number = $request->input('number');
        $player->team_id = $request->input('team_id');
        $player->date_of_birth = $request->input('date_of_birth');
        $player->height = $request->input('height');
        $player->weight = $request->input('weight');
    
        if ($tournament->tournament_type === 'school') {
            $player->years_playing_in_bucal = $request->input('years_playing_in_bucal');
            $player->position = $request->input('position');
        }
    
        if (isset($tournament) && $tournament->has_categories) {
            $player->category = $request->input('category');
        }
    
        $player->save();
    
        return redirect()->route('players.index')->with('success', 'Player updated successfully.');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the player by ID
        $player = Players::find($id);
    
        // Check if player exists
        if ($player === null) {
            session()->flash('error', 'Player not found');
            return response()->json([
                'status' => false,
                'message' => 'Player not found'
            ]);
        }
    
        // Delete the player
        $player->delete();
    
        // Provide success feedback
        session()->flash('success', 'Player deleted successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Player deleted successfully'
        ]);
    }

    public function getByTeam(Request $request)
    {
        $teamId = $request->query('team_id');
        $category = $request->query('category');
    
        $query = Players::query();
    
        if ($teamId) {
            $query->where('team_id', $teamId);
        }
    
        if ($category) {
            $query->where('category', $category);
        }
    
        $players = $query->get();
    
        return response()->json(['players' => $players]);
    }
    
    public function bulkUploadForm()
    {

        $tournaments = Tournaments::all();

        return view('players.upload', compact('tournaments')); 
    }

    public function bulkUpload(Request $request)
    {
        Log::info('bulkUpload method called.');
    
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
            'tournament_id' => 'required|exists:tournaments,id',
        ]);
    
        try {
            Log::info('Request validation passed.', [
                'tournament_id' => $request->input('tournament_id'),
                'file_name' => $request->file('file')->getClientOriginalName(),
            ]);
    
            $tournamentId = $request->input('tournament_id');
            
            Log::info('Starting file import.', ['tournament_id' => $tournamentId]);
    
            // Import the file using the PlayersImport class
            Excel::import(new PlayersImport($tournamentId), $request->file('file'));
    
            Log::info('File import completed successfully.');
    
            return redirect()->route('players.index')->with('success', 'Players imported successfully.');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error during file import.', ['error' => $e->getMessage()]);

            session()->flash('error', 'Check the uploaded file. Ensure that all required fields are filled. Error: ' . $e->getMessage());

            return redirect()->route('players.bulkUploadForm')->withInput();
        }
    }

    public function downloadSchoolTemplate()
    {
        $headers = [
            ['Category', 'Team Name', 'First Name', 'Last Name', 'Jersey Number', 'Years Playing in Bucal', 'Position', 'Date of Birth', 'Height', 'Weight' ],
        ];

        // Generate and download the Excel file
        return Excel::download(new ArrayExport($headers), 'School_Tournament_Player_template.xlsx');
    }

    public function downloadNonSchoolTemplate()
    {
        $headers = [
            ['Category', 'Team Name', 'First Name', 'Last Name', 'Jersey Number', 'Date of Birth', 'Height', 'Weight'],
        ];

        // Generate and download the Excel file
        return Excel::download(new ArrayExport($headers), 'Non_School_Tournament_Player_template.xlsx');
    }
    
}
