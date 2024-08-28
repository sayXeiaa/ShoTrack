<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Players;
use App\Models\Teams;
use Illuminate\Validation\Rule;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $teams = Teams::all();
        $players = Players::when($request->team_id, function($query) use ($request) {
            return $query->where('team_id', $request->team_id);
        })->paginate(25);

        return view('players.list', compact('teams', 'players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Fetch all teams from the database
         $teams = Teams::all();

         // Pass the teams to the view
         return view('players.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'number' => 'required|integer|min:0|max:99', 
            'position' => 'required|string|in:Point Guard,Shooting Guard,Small Forward,Power Forward,Center',
            'date_of_birth' => 'required|date', 
            'height' => 'required|integer|min:0',
            'weight' => 'required|integer|min:0',
            'team_id' => ['required', 'integer', Rule::exists('teams', 'id')],
        ]);

        if ($validator->passes()) {
            $player = new Players();
            $player->first_name = $request->first_name;
            $player->last_name = $request->last_name;
            $player->number = $request->number;
            $player->position = $request->position;
            $player->date_of_birth = $request->date_of_birth;
            $player->height = $request->height;
            $player->weight = $request->weight;
            $player->team_id = $request->team_id;

            $player->save();

            return redirect()->route('players.index')->with('success', 'Player added successfully.');
        } else {
            return redirect()->route('players.create')->withInput()->withErrors($validator);
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
    // Fetch the player to edit
    $player = Players::findOrFail($id);

    // Fetch all teams for the dropdown
    $teams = Teams::all();

    // Return the view with the player and teams data
    return view('players.edit', compact('player', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $player = Players::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'number' => 'required|integer|min:0|max:99', 
            'position' => 'required|string|in:Point Guard,Shooting Guard,Small Forward,Power Forward,Center',
            'date_of_birth' => 'required|date', 
            'height' => 'required|integer|min:0',
            'weight' => 'required|integer|min:0',
            'team_id' => ['required', 'integer', Rule::exists('teams', 'id')],
        ]);

        if ($validator->passes()) {
            $player->first_name = $request->first_name;
            $player->last_name = $request->last_name;
            $player->number = $request->number;
            $player->position = $request->position;
            $player->date_of_birth = $request->date_of_birth;
            $player->height = $request->height;
            $player->weight = $request->weight;
            $player->team_id = $request->team_id;

            $player->save();

            return redirect()->route('players.index')->with('success', 'Player updated successfully.');
        } else {
            return redirect()->route('players.edit', $id)->withInput()->withErrors($validator);
        }
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
    
}
