<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('LEADERBOARDS') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="mb-4">
                <form method="GET" action="{{ route('leaderboards.index') }}">
                    <label for="tournament" class="block text-sm font-medium text-gray-700">Select Tournament</label>
                    <select id="tournament" name="tournament_id" class="mt-1 block w-1/4 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All Tournaments</option>
                        @foreach($tournaments as $tournament)
                            <option value="{{ $tournament->id }}" {{ request('tournament_id') == $tournament->id ? 'selected' : '' }} data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}">
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            
            <div class="mb-4" id="category-selection" style="display: {{ request('tournament_id') && $tournaments->where('id', request('tournament_id'))->first()->has_categories ? 'block' : 'none' }};">
                <form method="GET" action="{{ route('leaderboards.index') }}">
                    <input type="hidden" name="tournament_id" value="{{ request('tournament_id') }}">
                    <label for="category" class="block text-sm font-medium text-gray-700">Select Category</label>
                    <select id="category" name="category" class="mt-1 block w-1/4 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <option value="juniors" {{ request('category') == 'juniors' ? 'selected' : '' }}>Juniors</option>
                        <option value="seniors" {{ request('category') == 'seniors' ? 'selected' : '' }}>Seniors</option>
                    </select>
                </form>
            </div>            

            <div id="boxScore" class="content-section">
                <div class="text-lg ml-2 flex space-x-4">
                    <div class="table-wrapper">
                        <table class="min-w-full stats-table border-collapse border border-gray-300">
                            <thead class="bg-[#314795]">
                                <tr class="text-white">
                                    <!-- Table headers here -->
                                    <th class="border px-4 py-2">TEAM</th>
                                    <th class="border px-4 py-2">GP</th>
                                    <th class="border px-4 py-2">W</th>
                                    <th class="border px-4 py-2">L</th>
                                    <th class="border px-4 py-2">MIN</th>
                                    <th class="border px-4 py-2">FGM</th>
                                    <th class="border px-4 py-2">FGA</th>
                                    <th class="border px-4 py-2">FG%</th>
                                    <th class="border px-4 py-2">2PM</th>
                                    <th class="border px-4 py-2">2PA</th>
                                    <th class="border px-4 py-2">2P%</th>
                                    <th class="border px-4 py-2">3PM</th>
                                    <th class="border px-4 py-2">3PA</th>
                                    <th class="border px-4 py-2">3P%</th>
                                    <th class="border px-4 py-2">FTM</th>
                                    <th class="border px-4 py-2">FTA</th>
                                    <th class="border px-4 py-2">FT%</th>
                                    <th class="border px-4 py-2">OREB</th>
                                    <th class="border px-4 py-2">DREB</th>
                                    <th class="border px-4 py-2">REB</th>
                                    <th class="border px-4 py-2">AST</th>
                                    <th class="border px-4 py-2">STL</th>
                                    <th class="border px-4 py-2">BLK</th>
                                    <th class="border px-4 py-2">TO</th>
                                    <th class="border px-4 py-2">PF</th>
                                    <th class="border px-4 py-2">PTS</th>
                                    <th class="border px-4 py-2">OREB%</th>
                                    <th class="border px-4 py-2">DREB%</th>
                                    <th class="border px-4 py-2">TO RATIO</th>
                                    <th class="border px-4 py-2">FTA RATE</th>
                                    {{-- <th class="border px-4 py-2">+/–</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teams as $team)
                                    @if ($team->teamStats->isNotEmpty())  <!-- Check if the team has stats -->
                                        @php
                                            $totalFGM = 0;
                                            $totalFGA = 0;
                                            $totalMinutes = 0;
                                            $totalPoints = 0;
                                            $totalGames = $team->teamStats->count();  // Unique schedules count
            
                                            // Accumulate the stats
                                            foreach ($team->teamStats as $stat) {
                                                $totalFGM += ($stat->two_pt_fg_made ?? 0) + ($stat->three_pt_fg_made ?? 0);
                                                $totalFGA += ($stat->two_pt_fg_attempt ?? 0) + ($stat->three_pt_fg_attempt ?? 0);
                                                $totalMinutes += $stat->minutes ?? 0;
                                                $totalPoints += $stat->points ?? 0;
                                            }
            
                                            // Calculate averages
                                            $avgFGP = $totalFGA > 0 ? ($totalFGM / $totalFGA) * 100 : 0;
                                            $avgMinutes = $totalGames > 0 ? $totalMinutes / $totalGames : 0;
                                            $avgPoints = $totalGames > 0 ? $totalPoints / $totalGames : 0;
                                        @endphp
                                        <tr class="hover:bg-gray-400">
                                            <td class="flex items-center space-x-4">
                                                <img src="{{ asset('storage/' . $team->logo) }}" alt="Team Logo" class="w-12 h-12 object-contain">
                                                <span>{{ $team->name }}</span>
                                            </td>                                            
                                            <td>{{ $totalGames }}</td>
                                            <td>{{ $team->wins ?? 0 }}</td>
                                            <td>{{ $team->losses ?? 0 }}</td>
                                            <td class="border px-4 py-2">
                                                {{ floor($avgMinutes / 60) }}:{{ str_pad($avgMinutes % 60, 2, '0', STR_PAD_LEFT) }}
                                            </td>                                            
                                            <td class="border px-4 py-2">{{ $totalFGM }}</td>
                                            <td class="border px-4 py-2">{{ $totalFGA }}</td>
                                            <td class="border px-4 py-2">{{ number_format($avgFGP, 1) }}%</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('two_pt_fg_made') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('two_pt_fg_attempt') }}</td>
                                            <td class="border px-4 py-2">{{ number_format($team->teamStats->sum('two_pt_percentage'), 1) }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('three_pt_fg_made') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('three_pt_fg_attempt') }}</td>
                                            <td class="border px-4 py-2">{{ number_format($team->teamStats->sum('three_pt_percentage'), 1) }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('free_throw_made') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('free_throw_attempt') }}</td>
                                            <td class="border px-4 py-2">{{ number_format($team->teamStats->sum('free_throw_percentage'), 1) }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('offensive_rebounds') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('defensive_rebounds') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('rebounds') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('assists') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('steals') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('blocks') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('turnovers') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('personal_fouls') }}</td>
                                            <td class="border px-4 py-2">{{ $team->teamStats->sum('points') }}</td>
                                            <td class="border px-4 py-2">{{ number_format($team->teamStats->sum('offensive_rebound_percentage'), 1) }}%</td>
                                            <td class="border px-4 py-2">{{ number_format($team->teamStats->sum('defensive_rebound_percentage'), 1) }}%</td>
                                            <td class="border px-4 py-2">{{ number_format($team->teamStats->sum('turnover_ratio'), 2) }}</td>
                                            <td class="border px-4 py-2">{{ number_format($team->teamStats->sum('free_throw_attempt_rate'), 2) }}</td>
                                            {{-- <td class="border px-4 py-2">{{ number_format($team->teamStats->sum('plus_minus'), 2) }}</td> --}}
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="28" class="text-center">No stats available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>           
        </div>
    </div>
    
    <style>
        .container {
            margin-left: 2px; /* Reduce margin to maximize the space */
            margin-right: 2px;
        }
    
        .table-wrapper {
            width: 100%;
            max-width: 100%; /* Set max width for the table wrapper */
            overflow-x: auto; /* Allow horizontal scrolling if needed */
        }
    
        .stats-table {
            width: 100%;
            border-collapse: collapse; /* Collapse borders for a cleaner look */
            table-layout: auto; /* Allow automatic layout for variable content */
            font-size: 0.75rem; /* Smaller font size to fit content */
        }
    
        .stats-table th,
        .stats-table td {
            padding: 2px; /* Reduced padding for narrower columns */
            word-wrap: break-word;
            text-align: center; /* Center-align for better readability */
            border: 1px solid #ddd; /* Add border for each cell */
        }
    
        .stats-table th {
            font-size: 0.8rem; /* Slightly larger header font */
            font-weight: bold; /* Bold header text */
        }
    </style>

    <x-slot name="script">
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
        const tournamentSelect = document.getElementById('tournament');
        const categorySelect = document.getElementById('category-selection');

        function updateCategoryVisibility() {
            const selectedOption = tournamentSelect.selectedOptions[0];
            const hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';

            if (hasCategories) {
                categorySelect.style.display = 'block';
            } else {
                categorySelect.style.display = 'none';
            }
        }

        tournamentSelect.addEventListener('change', function() {
            updateCategoryVisibility();
            this.form.submit(); // Submit form after changing tournament
        });

        updateCategoryVisibility(); // Initial check on page load
    });
    </script>
    </x-slot>

</x-app-layout>