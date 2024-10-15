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
                                    <th class="border px-4 py-2">+/–</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teams as $team)
                                    @if ($team->teamStats->isNotEmpty())  <!-- Check if the team has stats -->
                                        @php
                                            $latestStats = $team->teamStats->last(); // or use $team->teamStats->first() if you want the earliest
                                            $totalFGM = ($latestStats->two_pt_fg_made ?? 0) + ($latestStats->three_pt_fg_made ?? 0);
                                            $totalFGA = ($latestStats->two_pt_fg_attempt ?? 0) + ($latestStats->three_pt_fg_attempt ?? 0);
                                            $totalFGP = $totalFGA > 0 ? ($totalFGM / $totalFGA) * 100 : 0;
                                        @endphp
                                        <tr class="hover:bg-gray-400">
                                            <td class="flex items-center space-x-4">
                                                <img src="{{ asset('storage/' . $team->logo) }}" alt="Team Logo" class="w-12 h-12 object-contain">
                                                <span>{{ $team->name }}</span>
                                            </td>                                            
                                            <td>{{ $latestStats->games_played ?? 0 }}</td>
                                            <td>{{ $latestStats->wins ?? 0 }}</td>
                                            <td>{{ $latestStats->losses ?? 0 }}</td>
                                            <td class="border px-4 py-2">
                                                {{ floor($latestStats->minutes / 60) }}:{{ str_pad($latestStats->minutes % 60, 2, '0', STR_PAD_LEFT) }}
                                            </td>                                            
                                            <td class="border px-4 py-2">{{ $totalFGM }}</td>
                                            <td class="border px-4 py-2">{{ $totalFGA }}</td>
                                            <td class="border px-4 py-2">{{ number_format($totalFGP, 1) }}%</td>
                                            <td class="border px-4 py-2">{{ $latestStats->two_pt_fg_made ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->two_pt_fg_attempt ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->two_pt_percentage ?? '0.0%' }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->three_pt_fg_made ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->three_pt_fg_attempt ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->three_pt_percentage ?? '0.0%' }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->free_throw_made ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->free_throw_attempt ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->free_throw_percentage ?? '0.0%' }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->offensive_rebounds ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->defensive_rebounds ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->rebounds ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->assists ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->steals ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->blocks ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->turnovers ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->personal_fouls ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ $latestStats->points ?? 0 }}</td>
                                            <td class="border px-4 py-2">{{ number_format($latestStats->offensive_rebound_percentage ?? 0, 1) }}%</td>
                                            <td class="border px-4 py-2">{{ number_format($latestStats->defensive_rebound_percentage ?? 0, 1) }}%</td>
                                            <td class="border px-4 py-2">{{ number_format($latestStats->turnover_ratio ?? 0, 2) }}</td>
                                            <td class="border px-4 py-2">{{ number_format($latestStats->free_throw_attempt_rate ?? 0, 2) }}</td>
                                            <td class="border px-4 py-2">{{ number_format($latestStats->plus_minus ?? 0, 2) }}</td>
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