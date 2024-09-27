<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Game Results') }}
            </h2>
            {{-- @can('edit schedules')
                <a href="{{ route('schedules.create') }}" class="bg-slate-700 text-base rounded-md text-white px-3 py-2">Create</a>
            @endcan --}}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <!-- Box Score Header -->
            {{-- <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">Box Score</h1>
                <h2 class="text-xl mt-2">
                    <span class="font-semibold">{{ $schedule->team1->name }}</span> vs. 
                    <span class="font-semibold">{{ $schedule->team2->name }}</span>
                </h2>
            </div> --}}

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">Box Score</h1>
                <h2 class="text-xl mt-2 flex items-center justify-center">
                    <!-- Team 1 Section -->
                    <div class="flex flex-col items-center mr-4">
                        <img src="{{ asset('storage/' . $schedule->team1->logo) }}" alt="Logo of {{ $schedule->team1->name }}" style="max-width: 100px;" />
                        <span class="font-semibold">{{ $schedule->team1->name }}</span>
                    </div>
            
                    <!-- Scores Section -->
                    <span class="text-lg font-bold">{{ $teamAScore }}</span>
                    <span class="mx-8">vs.</span>
                    <span class="text-lg font-bold">{{ $teamBScore }}</span>
            
                    <!-- Team 2 Section -->
                    <div class="flex flex-col items-center ml-4">
                        <img src="{{ asset('storage/' . $schedule->team2->logo) }}" alt="Logo of {{ $schedule->team2->name }}" style="max-width: 100px;" />
                        <span class="font-semibold">{{ $schedule->team2->name }}</span>
                    </div>
                </h2>
            </div>
            
            
            
            
            <!-- Team 1 Player Statistics -->
            <h2 class="text-xl font-semibold mt-6 ml-2 mb-4">Player Statistics for {{ $schedule->team1->name }}</h2>
            @if ($playerStatsTeam1->isNotEmpty() || $remainingPlayersTeam1->isNotEmpty())
                <div class="bg-white shadow-md rounded-lg mb-4 mx-auto p-6 container">
                    {{-- <h3 class="text-lg font-semibold mb-6">Player Statistics</h3> --}}
                    <div class="table-wrapper">
                        <table class="min-w-full stats-table border-collapse border border-gray-300">
                            <thead class="bg-[#314795]">
                                <tr class="text-white">
                                    <th class="border px-4 py-2 w-24">PLAYER</th>
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
                                    <th class="border px-4 py-2">+/–</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($playerStatsTeam1 as $stat)
                                <tr class="hover:bg-gray-400">
                                    <td class="border px-4 py-2">
                                        @if($stat->player)
                                            @php
                                                $initial = strtoupper(substr($stat->player->first_name, 0, 1)); // Get initial of first name
                                                $lastName = $stat->player->last_name; // Get last name
                                            @endphp
                                            {{ $initial }}. {{ $lastName }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">{{ $stat->minutes }}</td>
                                    <td class="border px-4 py-2">{{ $stat->two_pt_fg_made + $stat->three_pt_fg_made }}</td>
                                    <td class="border px-4 py-2">{{ $stat->two_pt_fg_attempt + $stat->three_pt_fg_attempt }}</td>
                                    <td class="border px-4 py-2">
                                        @php
                                            $totalFGM = $stat->two_pt_fg_made + $stat->three_pt_fg_made;
                                            $totalFGA = $stat->two_pt_fg_attempt + $stat->three_pt_fg_attempt;
                                        @endphp
                                        @if ($totalFGA > 0)
                                            {{ number_format(($totalFGM / $totalFGA) * 100, 1) }}%
                                        @else
                                            0.0%
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">{{ $stat->two_pt_fg_made }}</td>
                                    <td class="border px-4 py-2">{{ $stat->two_pt_fg_attempt }}</td>
                                    <td class="border px-4 py-2">{{ number_format($stat->two_pt_percentage, 1)}}%</td>
                                    <td class="border px-4 py-2">{{ $stat->three_pt_fg_made }}</td>
                                    <td class="border px-4 py-2">{{ $stat->three_pt_fg_attempt }}</td>
                                    <td class="border px-4 py-2">{{ number_format($stat->three_pt_percentage, 1)}}%</td>
                                    <td class="border px-4 py-2">{{ $stat->free_throw_made }}</td>
                                    <td class="border px-4 py-2">{{ $stat->free_throw_attempt }}</td>
                                    <td class="border px-4 py-2">{{ number_format($stat->free_throw_percentage, 1) }}%</td>
                                    <td class="border px-4 py-2">{{ $stat->offensive_rebounds }}</td>
                                    <td class="border px-4 py-2">{{ $stat->defensive_rebounds }}</td>
                                    <td class="border px-4 py-2">{{ $stat->rebounds }}</td>
                                    <td class="border px-4 py-2">{{ $stat->assists }}</td>
                                    <td class="border px-4 py-2">{{ $stat->steals }}</td>
                                    <td class="border px-4 py-2">{{ $stat->blocks }}</td>
                                    <td class="border px-4 py-2">{{ $stat->turnovers }}</td>
                                    <td class="border px-4 py-2">{{ $stat->personal_fouls }}</td>
                                    <td class="border px-4 py-2">{{ $stat->points }}</td>
                                    <td class="border px-4 py-2">{{ $stat->plus_minus }}</td>
                                </tr>
                                @endforeach
                            
                                {{-- Display Remaining Players --}}
                                @foreach ($remainingPlayersTeam1 as $player)
                                <tr class="hover:bg-gray-400">
                                    <td class="border px-4 py-2">
                                        @php
                                            $initial = strtoupper(substr($player->first_name, 0, 1)); // Get initial of first name
                                            $lastName = $player->last_name; // Get last name
                                        @endphp
                                        {{ $initial }}. {{ $lastName }}
                                    </td>
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for MIN -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for FGM -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for FGA -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for FG% -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for 2PM -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for 2PA -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for 2P% -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for 3PM -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for 3PA -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for 3P% -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for FTM -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for FTA -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for FT% -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for OREB -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for DREB -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for REB -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for AST -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for STL -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for BLK -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for TO -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for PF -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for PTS -->
                                    <td class="border px-4 py-2">0</td> <!-- Placeholder for +/- -->
                                </tr>
                                @endforeach
                            </tbody>
                            
                                    </table>
                                </div>
                            </div>
                        @endif
                <!-- Team 2 Player Statistics -->
                <h2 class="text-xl font-semibold mt-6 ml-2 mb-4">Player Statistics for {{ $schedule->team1->name }}</h2>
                @if ($playerStatsTeam2->isNotEmpty() || $remainingPlayersTeam2->isNotEmpty())
                    <div class="bg-white shadow-md rounded-lg mb-4 mx-auto p-6 container">
                        {{-- <h3 class="text-lg font-semibold mb-6">Player Statistics</h3> --}}
                        <div class="table-wrapper">
                            <table class="min-w-full stats-table border-collapse border border-gray-300">
                                <thead class="bg-[#314795]">
                                    <tr>
                                        <th class="border px-4 py-2 w-24">PLAYER</th>
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
                                        <th class="border px-4 py-2">+/–</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($playerStatsTeam2 as $stat)
                                    <tr class="hover:bg-gray-400">
                                        <td class="border px-4 py-2">
                                            @if($stat->player)
                                                @php
                                                    $initial = strtoupper(substr($stat->player->first_name, 0, 1)); // Get initial of first name
                                                    $lastName = $stat->player->last_name; // Get last name
                                                @endphp
                                                {{ $initial }}. {{ $lastName }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $stat->minutes }}</td>
                                        <td class="border px-4 py-2">{{ $stat->two_pt_fg_made + $stat->three_pt_fg_made }}</td>
                                        <td class="border px-4 py-2">{{ $stat->two_pt_fg_attempt + $stat->three_pt_fg_attempt }}</td>
                                        <td class="border px-4 py-2">
                                            @php
                                                $totalFGM = $stat->two_pt_fg_made + $stat->three_pt_fg_made;
                                                $totalFGA = $stat->two_pt_fg_attempt + $stat->three_pt_fg_attempt;
                                            @endphp
                                            @if ($totalFGA > 0)
                                                {{ number_format(($totalFGM / $totalFGA) * 100, 1) }}%
                                            @else
                                                0.0%
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $stat->two_pt_fg_made }}</td>
                                        <td class="border px-4 py-2">{{ $stat->two_pt_fg_attempt }}</td>
                                        <td class="border px-4 py-2">{{ number_format($stat->two_pt_percentage, 1)}}%</td>
                                        <td class="border px-4 py-2">{{ $stat->three_pt_fg_made }}</td>
                                        <td class="border px-4 py-2">{{ $stat->three_pt_fg_attempt }}</td>
                                        <td class="border px-4 py-2">{{ number_format($stat->three_pt_percentage, 1)}}%</td>
                                        <td class="border px-4 py-2">{{ $stat->free_throw_made }}</td>
                                        <td class="border px-4 py-2">{{ $stat->free_throw_attempt }}</td>
                                        <td class="border px-4 py-2">{{ number_format($stat->free_throw_percentage, 1) }}%</td>
                                        <td class="border px-4 py-2">{{ $stat->offensive_rebounds }}</td>
                                        <td class="border px-4 py-2">{{ $stat->defensive_rebounds }}</td>
                                        <td class="border px-4 py-2">{{ $stat->rebounds }}</td>
                                        <td class="border px-4 py-2">{{ $stat->assists }}</td>
                                        <td class="border px-4 py-2">{{ $stat->steals }}</td>
                                        <td class="border px-4 py-2">{{ $stat->blocks }}</td>
                                        <td class="border px-4 py-2">{{ $stat->turnovers }}</td>
                                        <td class="border px-4 py-2">{{ $stat->personal_fouls }}</td>
                                        <td class="border px-4 py-2">{{ $stat->points }}</td>
                                        <td class="border px-4 py-2">{{ $stat->plus_minus }}</td>
                                    </tr>
                                    @endforeach
                                
                                    {{-- Display Remaining Players --}}
                                    @foreach ($remainingPlayersTeam2 as $player)
                                    <tr class="hover:bg-gray-400">
                                        <td class="border px-4 py-2">
                                            @php
                                                $initial = strtoupper(substr($player->first_name, 0, 1)); // Get initial of first name
                                                $lastName = $player->last_name; // Get last name
                                            @endphp
                                            {{ $initial }}. {{ $lastName }}
                                        </td>
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for MIN -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for FGM -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for FGA -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for FG% -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for 2PM -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for 2PA -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for 2P% -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for 3PM -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for 3PA -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for 3P% -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for FTM -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for FTA -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for FT% -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for OREB -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for DREB -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for REB -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for AST -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for STL -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for BLK -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for TO -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for PF -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for PTS -->
                                        <td class="border px-4 py-2">0</td> <!-- Placeholder for +/- -->
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                                        </table>
                                    </div>
                                </div>
                            @endif

        </div>
    </div>
    <style>
    .container {
    margin-left: 5px; /* Reduce margin to maximize the space */
    margin-right: 5px;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: hidden; /* Hide any overflow */
    }

    .stats-table {
        width: 100%;
        table-layout: fixed; /* Fixed table layout to keep columns within the width */
        font-size: 0.8rem; /* Smaller font size to fit content */
    }

    .stats-table th, .stats-table td {
        padding: 4px; /* Reduced padding for narrower columns */
        word-wrap: break-word;
        text-align: center; /* Center-align for better readability */
    }

    .stats-table th {
        font-size: 0.85rem; /* Slightly larger header font */
    }
    </style>
</x-app-layout>
