<?php

namespace App\Imports;

use App\Models\Players;
use App\Models\Teams;
use App\Models\Tournaments;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PlayersImport implements ToModel, WithHeadingRow, WithValidation
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
            '*.category' => 'nullable|string|in:Juniors,Seniors',
            '*.first_name' => 'required|string|max:255',
            '*.last_name' => 'required|string|max:255',
            '*.jersey_number' => 'required|integer|min:0',
            '*.years_playing_in_bucal' => 'nullable|integer|min:0',
            '*.position' => 'nullable|string|max:255',
            '*.date_of_birth' => 'nullable|date', 
            '*.height' => 'nullable|string|max:10',
            '*.weight' => 'nullable|integer|min:0',
            '*.team_name' => 'required|string|max:255',
        ];
    }

    /**
     * Map each row to a Player model instance.
     *
     * @param array $row
     * @return Players|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        $tournament = Tournaments::find($this->tournamentId);

        if (!$tournament) {
            throw new \Exception("Tournament not found for ID: {$this->tournamentId}");
        }

        $team = Teams::where('name', $row['team_name'])
            ->where('tournament_id', $this->tournamentId)
            ->first();

        if (!$team) {
            throw new \Exception("Team '{$row['team_name']}' not found in the tournament ID: {$this->tournamentId}");
        }

        $dateOfBirth = $this->parseDateOfBirth($row['date_of_birth'] ?? null);

        return new Players([
            'category' => $tournament->has_categories ? $row['category'] : null,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'number' => $row['jersey_number'],
            'years_playing_in_bucal' => $row['years_playing_in_bucal'] ?? null,
            'position' => $row['position'] ?? null,
            'date_of_birth' => $dateOfBirth,
            'height' => $row['height'] ?? null,
            'weight' => $row['weight'] ?? null,
            'team_id' => $team->id,
        ]);
    }

    /**
     * Parses the date of birth from the row and converts it to 'Y-m-d' format.
     *
     * @param string|null $date
     * @return string|null
     */
    private function parseDateOfBirth(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            return Carbon::createFromFormat('m/d/Y', trim($date))->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error('Invalid date_of_birth format', ['raw_date' => $date, 'error' => $e->getMessage()]);
            throw new \Exception("Invalid date format for date_of_birth: '{$date}'. Expected format: m/d/Y");
        }
    }
}
