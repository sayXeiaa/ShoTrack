<?php

namespace App\Imports;

use App\Models\Teams;
use App\Models\Tournaments;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class TeamsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $tournamentId;

    /**
     * Constructor to initialize the tournament ID.
     *
     * @param int $tournamentId
     */
    public function __construct($tournamentId)
    {
        $this->tournamentId = $tournamentId;
    }

    /**
     * Validation rules for each row in the import.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.team_name' => 'required|string|min:5', 
            '*.head_coach_name' => 'required|string|max:255',
            '*.address' => 'required|string|min:5',
            '*.category' => 'nullable|string|in:Juniors,Seniors', 
            '*.team_acronym' => 'nullable|string|max:7',
            '*.school_president' => 'nullable|string|max:255',
            '*.sports_director' => 'nullable|string|max:255',
            '*.years_playing_in_bucal' => 'nullable|integer|min:0',
            '*.ranking' => 'nullable|integer|min:0', 
        ];
    }

    /**
     * Map each row to a Team model instance.
     *
     * @param array $row
     * @return Teams|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        // Fetch the tournament by ID passed during import initialization
        $tournament = Tournaments::find($this->tournamentId);

        if (!$tournament) {
            throw new \Exception("Tournament not found for ID: {$this->tournamentId}");
        }

        Log::info('Creating team with tournament ID', [
            'team_name' => $row['team_name'],
            'tournament_id' => $this->tournamentId,
        ]);

        // Create a new Team instance with the necessary data
        return new Teams([
            'name' => $row['team_name'], 
            'head_coach_name' => $row['head_coach_name'],
            'address' => $row['address'],
            'category' => $tournament->has_categories ? $row['category'] : null,
            'team_acronym' => $tournament->tournament_type === 'school' ? $row['team_acronym'] : null,
            'school_president' => $tournament->tournament_type === 'school' ? $row['school_president'] : null,
            'sports_director' => $tournament->tournament_type === 'school' ? $row['sports_director'] : null,
            'years_playing_in_bucal' => $tournament->tournament_type === 'school' ? $row['years_playing_in_bucal'] : null,
            'wins' => 0, 
            'losses' => 0, 
            'games_played' => 0, 
            'ranking' => $row['ranking'] ?? 0, 
            'tournament_id' => $this->tournamentId, 
        ]);
    }
}
