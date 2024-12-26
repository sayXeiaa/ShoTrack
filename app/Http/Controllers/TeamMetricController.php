<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teams;
use App\Models\Schedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\TeamMetric;

class TeamMetricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log incoming request data for debugging
        Log::info('Received data:', $request->all());
    
        // Validate request data
        $validated = $request->validate([
            'team_id' => 'required|integer|exists:teams,id',
            'type_of_stat' => 'required|string',
            'result' => 'required|string|in:made,missed',
            'schedule_id' => 'required|integer|exists:schedules,id',
            'game_time' => 'required|string',
            'quarter' => 'required|integer|min:1|max:4',
        ]);
    
        $pointsOffTurnover = 0;
        $fastBreakPoints = 0;
        $secondChancePoints = 0;
    
        // Calculate points if result is made
        if ($validated['result'] === 'made') {
            switch ($validated['type_of_stat']) {
                case 'two_point_off_turnover':
                    $pointsOffTurnover = 2;
                    break;
                case 'three_point_off_turnover':
                    $pointsOffTurnover = 3;
                    break;
                case 'two_point_fastbreak':
                    $fastBreakPoints = 2;
                    break;
                case 'three_point_fastbreak':
                    $fastBreakPoints = 3;
                    break;
                case 'one_point_second_chance':
                    $secondChancePoints = 1;
                    break;
                case 'two_point_second_chance':
                    $secondChancePoints = 2;
                    break;
                case 'three_point_second_chance':
                    $secondChancePoints = 3;
                    break;
            }
        }
    
        // Check if a record already exists for the given schedule and team
        $teamMetric = TeamMetric::where('schedule_id', $validated['schedule_id'])
            ->where('team_id', $validated['team_id'])
            ->first();
    
        if ($teamMetric) {
            // Update existing record 
            $teamMetric->update([
                'points_off_turnover' => $teamMetric->points_off_turnover + $pointsOffTurnover,
                'fast_break_points' => $teamMetric->fast_break_points + $fastBreakPoints,
                'second_chance_points' => $teamMetric->second_chance_points + $secondChancePoints,
            ]);
        } else {
            // Create a new team metric record if none exists
            $teamMetric = TeamMetric::create([
                'team_id' => $validated['team_id'],
                'schedule_id' => $validated['schedule_id'],
                'type_of_stat' => $validated['type_of_stat'],
                'points_off_turnover' => $pointsOffTurnover,
                'fast_break_points' => $fastBreakPoints,
                'second_chance_points' => $secondChancePoints,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Team metric recorded successfully.',
            'data' => $teamMetric,
        ], 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
