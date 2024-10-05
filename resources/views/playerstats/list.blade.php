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

            <div class="text-center mb-8">
                {{-- <h1 class="text-3xl font-bold">Box Score</h1> --}}
                <h2 class="text-xl mt-2 flex items-center justify-center">
                    <!-- Team 1 Section -->
                    <div class="flex flex-col items-center mr-4">
                        <img src="{{ asset('storage/' . $schedule->team1->logo) }}" alt="Logo of {{ $schedule->team1->name }}" style="max-width: 100px;" />
                        <span class="font-semibold justify-center">{{ $schedule->team1->name }}</span>
                    </div>
            
                    <!-- Scores Section -->
                    <span class="text-lg font-bold justify-center">{{ $teamAScore }}</span>
                    <span class="mx-8">vs.</span>
                    <span class="text-lg font-bold justify-center">{{ $teamBScore }}</span>
            
                    <!-- Team 2 Section -->
                    <div class="flex flex-col items-center ml-4">
                        <img src="{{ asset('storage/' . $schedule->team2->logo) }}" alt="Logo of {{ $schedule->team2->name }}" style="max-width: 100px;" />
                        <span class="font-semibold justify-center">{{ $schedule->team2->name }}</span>
                    </div>
                </h2>
            </div>
            
            <div class="text-lg font-bold ml-2 flex space-x-4">
                <button class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300 active-btn" data-type="boxScore">
                    Box Score
                </button>
                <button class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300" data-type="playByPlay">
                    Play-By-Play
                </button>
                <button class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300" data-type="gameChart">
                    Game Chart
                </button>
            </div>
            
            <!-- Team 1 Player Statistics -->
            <div id="boxScore" class="content-section">
                <h2 class="text-xl font-semibold mt-6 ml-2 mb-4">Player Statistics for {{ $schedule->team1->name }}</h2>
                @if ($playerStatsTeam1->isNotEmpty() || $remainingPlayersTeam1->isNotEmpty())
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md my-6">
                        {{-- <h3 class="text-lg font-semibold mb-6">Player Statistics</h3> --}}
                        <div class="table-wrapper">
                            <table class="min-w-full stats-table border-collapse border border-gray-300">
                                <thead class="bg-[#314795]">
                                    <tr class="text-white">
                                        <th class="border px-4 py-2 w-32">PLAYER</th>
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
                                        <th class="border px-4 py-2 w-12">OREB</th>
                                        <th class="border px-4 py-2">DREB</th>
                                        <th class="border px-4 py-2">REB</th>
                                        <th class="border px-4 py-2">AST</th>
                                        <th class="border px-4 py-2">STL</th>
                                        <th class="border px-4 py-2">BLK</th>
                                        <th class="border px-4 py-2">TO</th>
                                        <th class="border px-4 py-2">PF</th>
                                        <th class="border px-4 py-2">PTS</th>
                                        <th class="border px-4 py-2">+/–</th>
                                        <th class="px-6 py-3 text-center" width="180">Action</th>
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
                                        <td class="border px-4 py-2">
                                            {{ floor($stat->minutes / 60) }}:{{ str_pad($stat->minutes % 60, 2, '0', STR_PAD_LEFT) }}
                                        </td>                                        
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
                                        <td class="px-6 py-3 text-center">
                                            <a href="{{ route('playerstats.edit', $stat->id) }}" class="bg-slate-700 text-xs rounded-md text-white px-2 py-1 hover:bg-slate-600 mr-4">Edit</a>
                                            <a href="javascript:void(0)" onclick="deletePlayerStat({{ $stat->id }})" class="bg-red-600 text-xs rounded-md text-white px-2 py-1 hover:bg-red-500">Delete</a>
                                        </td>
                                        
                                        
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
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td>
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td>
                                        <td class="border px-4 py-2">0</td>
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td>
                                        <td class="border px-4 py-2">0</td>
                                        <td class="border px-4 py-2">0</td>
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="border px-4 py-2">0</td>
                                        <td class="border px-4 py-2">0</td> 
                                        <td class="px-6 py-3 text-center">
                                            <a href="{{ route('playerstats.edit', ['id' => $player->id]) }}" class="bg-slate-700 text-xs rounded-md text-white px-2 py-1 hover:bg-slate-600">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                                        </table>
                                    </div>
                                </div>
                            @endif
                    <!-- Team 2 Player Statistics -->
                    <h2 class="text-xl font-semibold mt-6 ml-2 mb-4">Player Statistics for {{ $schedule->team2->name }}</h2>
                    @if ($playerStatsTeam2->isNotEmpty() || $remainingPlayersTeam2->isNotEmpty())
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md my-6">
                            {{-- <h3 class="text-lg font-semibold mb-6">Player Statistics</h3> --}}
                            <div class="table-wrapper">
                                <table class="min-w-full stats-table border-collapse border border-gray-300">
                                    <thead class="bg-[#314795]">
                                        <tr class="text-white">
                                            <th class="border px-4 py-2 w-32">PLAYER</th>
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
                                            <th class="border px-4 py-2 w-12">OREB</th>
                                            <th class="border px-4 py-2">DREB</th>
                                            <th class="border px-4 py-2">REB</th>
                                            <th class="border px-4 py-2">AST</th>
                                            <th class="border px-4 py-2">STL</th>
                                            <th class="border px-4 py-2">BLK</th>
                                            <th class="border px-4 py-2">TO</th>
                                            <th class="border px-4 py-2">PF</th>
                                            <th class="border px-4 py-2">PTS</th>
                                            <th class="border px-4 py-2">+/–</th>
                                            <th class="px-6 py-3 text-center" width="180">Action</th>
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
                                            <td class="border px-4 py-2">
                                                {{ floor($stat->minutes / 60) }}:{{ str_pad($stat->minutes % 60, 2, '0', STR_PAD_LEFT) }}
                                            </td>                                            
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
                                            <td class="px-6 py-3 text-center">
                                                <a href="{{ route('playerstats.edit', $stat->id) }}" class="bg-slate-700 text-xs rounded-md text-white px-2 py-1 hover:bg-slate-600 mr-4">Edit</a>
                                                <a href="javascript:void(0)" onclick="deletePlayerStat({{ $stat->id }})" class="bg-red-600 text-xs rounded-md text-white px-2 py-1 hover:bg-red-500">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    
                                        {{-- Display Remaining Players --}}
                                        @foreach ($remainingPlayersTeam2 as $player)
                                        <tr class="hover:bg-gray-400">
                                            <td class="border px-8 py-2">
                                                @php
                                                    $initial = strtoupper(substr($player->first_name, 0, 1)); // Get initial of first name
                                                    $lastName = $player->last_name; // Get last name
                                                @endphp
                                                {{ $initial }}. {{ $lastName }}
                                            </td>
                                            <td class="border px-4 py-2">0</td>
                                            <td class="border px-4 py-2">0</td>
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td>
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td>
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td>
                                            <td class="border px-4 py-2">0</td>
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td> 
                                            <td class="border px-4 py-2">0</td>
                                            <td class="px-6 py-3 text-center">
                                                <a href="{{ route('playerstats.edit', ['id' => $player->id]) }}" class="bg-slate-700 text-xs rounded-md text-white px-2 py-1 hover:bg-slate-600">Edit</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    @endif
            </div>

            <div id="playByPlay" class="content-section hidden bg-gray-50 p-6 rounded-lg shadow-md my-6">
                <h3 class="font-semibold text-xl text-gray-800 mb-4">Play-by-Play</h3>
                <div class="flex space-x-2 mb-6 justify-center">
                    <button class="quarter-button nav-btn bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-[#314795] transition duration-200" data-quarter="1">Q1</button>
                    <button class="quarter-button nav-btn bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-[#314795] transition duration-200" data-quarter="2">Q2</button>
                    <button class="quarter-button nav-btn bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-[#314795] transition duration-200" data-quarter="3">Q3</button>
                    <button class="quarter-button nav-btn bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-[#314795] transition duration-200" data-quarter="4">Q4</button>
                </div>
                <div id="play-by-play-list">
                    @foreach($playByPlayData as $play)
                        @php
                            // Check if the player exists and format the name
                            $playerName = $play->player ? strtoupper(substr($play->player->first_name, 0, 1)) . '. ' . $play->player->last_name : 'Unknown Player';
                        @endphp
                        <div class="play-entry flex items-center justify-between p-4 border-b border-gray-200 hover:bg-gray-100 transition-colors duration-200" data-quarter="{{ $play->quarter }}">
                            <div class="flex-1 text-left">
                                <span class="font-semibold text-gray-800">{{ $playerName }}</span>:
                            </div>
                            <div class="flex-1 text-center">
                                <span class="text-gray-700">{{ $play->action_text }}</span>
                                <span class="text-sm text-gray-500 block">at {{ $play->game_time }} (Q{{ $play->quarter }})</span>
                            </div>
                            <div class="flex-1 text-right">
                                <span class="font-bold text-gray-900">{{ $play->team_A_score }} - {{ $play->team_B_score }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            @php
                // Team 1 Statistics
                $totalPointsTeam1 = $playerStatsTeam1->sum('points');
                $totalReboundsTeam1 = $playerStatsTeam1->sum('rebounds');
                $totalAssistsTeam1 = $playerStatsTeam1->sum('assists');
                $totalStealsTeam1 = $playerStatsTeam1->sum('steals');
                $totalBlocksTeam1 = $playerStatsTeam1->sum('blocks');
                $totalTurnoversTeam1 = $playerStatsTeam1->sum('turnovers');

                $totalFGMTeam1 = $playerStatsTeam1->sum(function($stat) {
                    return $stat->two_pt_fg_made + $stat->three_pt_fg_made;
                });

                $totalFGATeam1 = $playerStatsTeam1->sum(function($stat) {
                    return $stat->two_pt_fg_attempt + $stat->three_pt_fg_attempt;
                });

                $totalFGPercentageTeam1 = ($totalFGATeam1 > 0) ? number_format(($totalFGMTeam1 / $totalFGATeam1) * 100, 1) : 0.0;

                $total3PMTeam1 = $playerStatsTeam1->sum('three_pt_fg_made');
                $total3PATeam1 = $playerStatsTeam1->sum('three_pt_fg_attempt');
                $total3ptPercentageTeam1 = ($total3PATeam1 > 0) ? number_format(($total3PMTeam1 / $total3PATeam1) * 100, 1) : 0.0;

                $totalFTMadeTeam1 = $playerStatsTeam1->sum('free_throw_made');
                $totalFTAttemptTeam1 = $playerStatsTeam1->sum('free_throw_attempt');
                $totalFreeThrowPercentageTeam1 = ($totalFTAttemptTeam1 > 0) ? number_format(($totalFTMadeTeam1 / $totalFTAttemptTeam1) * 100, 1) : 0.0;

                // Team 2 Statistics
                $totalPointsTeam2 = $playerStatsTeam2->sum('points');
                $totalReboundsTeam2 = $playerStatsTeam2->sum('rebounds');
                $totalAssistsTeam2 = $playerStatsTeam2->sum('assists');
                $totalStealsTeam2 = $playerStatsTeam2->sum('steals');
                $totalBlocksTeam2 = $playerStatsTeam2->sum('blocks');
                $totalTurnoversTeam2 = $playerStatsTeam2->sum('turnovers');

                $totalFGMTeam2 = $playerStatsTeam2->sum(function($stat) {
                    return $stat->two_pt_fg_made + $stat->three_pt_fg_made;
                });

                $totalFGATeam2 = $playerStatsTeam2->sum(function($stat) {
                    return $stat->two_pt_fg_attempt + $stat->three_pt_fg_attempt;
                });

                $totalFGPercentageTeam2 = ($totalFGATeam2 > 0) ? number_format(($totalFGMTeam2 / $totalFGATeam2) * 100, 1) : 0.0;

                $total3PMTeam2 = $playerStatsTeam2->sum('three_pt_fg_made');
                $total3PATeam2 = $playerStatsTeam2->sum('three_pt_fg_attempt');
                $total3ptPercentageTeam2 = ($total3PATeam2 > 0) ? number_format(($total3PMTeam2 / $total3PATeam2) * 100, 1) : 0.0;

                $totalFTMadeTeam2 = $playerStatsTeam2->sum('free_throw_made');
                $totalFTAttemptTeam2 = $playerStatsTeam2->sum('free_throw_attempt');
                $totalFreeThrowPercentageTeam2 = ($totalFTAttemptTeam2 > 0) ? number_format(($totalFTMadeTeam2 / $totalFTAttemptTeam2) * 100, 1) : 0.0;
            @endphp

            <div id="gameChart" class="content-section hidden">
                <canvas id="teamComparisonChart" width="400" height="200"></canvas>
            </div>
        

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

    #teamComparisonChart {
    width: 100%;  /* or a specific width like '400px' */
    height: 400px;  /* or a specific height */
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script >
    document.addEventListener('DOMContentLoaded', function() {
        // Click the box score button by default
        const boxScoreButton = document.querySelector('.nav-btn[data-type="boxScore"]');
        boxScoreButton.click();
    });

    // Event listener for navigation buttons
    document.querySelectorAll('.nav-btn[data-type="boxScore"], .nav-btn[data-type="playByPlay"], .nav-btn[data-type="gameChart"]').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.nav-btn').forEach(btn => {
                btn.classList.remove('bg-[#314795]');
                btn.classList.add('bg-gray-400');
            });

            // Add active class to the clicked button
            this.classList.remove('bg-gray-400');
            this.classList.add('bg-[#314795]');

            // Get the selected content type from the clicked button
            const selectedType = this.getAttribute('data-type');

            // Hide all content sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.add('hidden'); // Hide the section
            });

            // Show the selected content section
            const selectedSection = document.getElementById(selectedType);
            if (selectedSection) {
                selectedSection.classList.remove('hidden'); // Show the selected section
            }

            // Reset quarter buttons when switching from play-by-play to other sections
            if (selectedType === 'playByPlay') {
                // Select Q1 by default when switching to play-by-play
                const quarter1Button = document.querySelector('.quarter-button[data-quarter="1"]');
                if (quarter1Button) {
                    quarter1Button.click(); // Simulate a click to select Q1
                }
            } else {
                document.querySelectorAll('.quarter-button').forEach(qBtn => {
                    qBtn.classList.remove('active');
                    qBtn.classList.add('bg-gray-400');
                });
                // Optionally hide play entries when switching away
                filterPlayByPlayData(undefined);
            }

            if (selectedType === 'gameChart') {
                loadTeamComparisonChart();
            }
        });
    });

    // Event listener for quarter buttons
    document.querySelectorAll('.quarter-button').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all quarter buttons
            document.querySelectorAll('.quarter-button').forEach(qBtn => {
                qBtn.classList.remove('bg-[#314795]');
                qBtn.classList.add('bg-gray-400');
            });

            // Add active class to the clicked quarter button
            this.classList.remove('bg-gray-400');
            this.classList.add('bg-[#314795]');

            // Get the selected quarter
            const selectedQuarter = this.getAttribute('data-quarter');

            // Filter play-by-play data based on the selected quarter
            filterPlayByPlayData(selectedQuarter);
        });
    });

    //Filter play-by-play data based on the selected quarter
    function filterPlayByPlayData(quarter) {
        const playEntries = document.querySelectorAll('.play-entry');

        playEntries.forEach(entry => {
            // Get the quarter from the entry and compare it directly
            const entryQuarter = entry.getAttribute('data-quarter'); 
            if (entryQuarter === quarter || quarter === undefined) {
                entry.style.display = 'flex'; // Show entry
            } else {
                entry.style.display = 'none'; // Hide entry
            }
        });
    }

    function loadTeamComparisonChart() {
        // Fetch actual data
        const teamStats = {
            "{{ $schedule->team1->name }}": {
                pts: {{ $totalPointsTeam1 }},
                rebs: {{ $totalReboundsTeam1 }},
                assists: {{ $totalAssistsTeam1 }},
                stl: {{ $totalStealsTeam1 }},
                blk: {{ $totalBlocksTeam1 }},
                to: {{ $totalTurnoversTeam1 }},
                fg: {{ $totalFGPercentageTeam1 }},
                threeP: {{ $total3ptPercentageTeam1 }},
                ft: {{ $totalFreeThrowPercentageTeam1 }}
            },
            "{{ $schedule->team2->name }}": {
                pts: {{ $totalPointsTeam2 }},
                rebs: {{ $totalReboundsTeam2 }},
                assists: {{ $totalAssistsTeam2 }},
                stl: {{ $totalStealsTeam2 }},
                blk: {{ $totalBlocksTeam2 }},
                to: {{ $totalTurnoversTeam2 }},
                fg: {{ $totalFGPercentageTeam2 }},
                threeP: {{ $total3ptPercentageTeam2 }},
                ft: {{ $totalFreeThrowPercentageTeam2 }}
            }
        };

        const statsLabels = ['pts', 'rebs', 'assists', 'stl', 'blk', 'to', 'fg', 'threeP', 'ft'];
        const teamAData = [];
        const teamBData = [];
        const teamAColors = [];
        const teamBColors = [];
        const teamAName = "{{ $schedule->team1->name }}"; 
        const teamBName = "{{ $schedule->team2->name }}"; 

        // Populate data and determine colors based on comparisons
        statsLabels.forEach(stat => {
            const teamAValue = teamStats[teamAName][stat];
            const teamBValue = teamStats[teamBName][stat];

            teamAData.push(teamAValue);
            teamBData.push(teamBValue);

            // Set Team A color based on comparison with Team B
            teamAColors.push(teamAValue > teamBValue ? 'rgba(49, 71, 149, 1)' : 'rgba(156, 163, 175, 1)'); // bg-[#314795] or bg-gray-400
            
            // Set Team B color based on comparison with Team A
            teamBColors.push(teamBValue > teamAValue ? 'rgba(49, 71, 149, 1)' : 'rgba(156, 163, 175, 1)'); // bg-[#314795] or bg-gray-400
        });

        const ctx = document.getElementById('teamComparisonChart').getContext('2d');

        // Create the chart
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['PTS', 'REBS', 'ASSISTS', 'STEALS', 'BLOCKS', 'TURNOVERS', 'FG%', '3P%', 'FT%'], // Stats labels
                datasets: [
                    {
                        label: teamAName, // Use actual team name
                        data: teamAData,
                        backgroundColor: teamAColors,
                    },
                    {
                        label: teamBName, // Use actual team name
                        data: teamBData,
                        backgroundColor: teamBColors,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Statistics'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Statistics'
                        },
                        stacked: false // Ensure bars are side by side
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Team Comparison Statistics'
                    }
                },
                indexAxis: 'x', // Keep for horizontal layout if desired
            }
        });
    }

    function deletePlayerStat(id) {
        if (confirm("Are you sure you want to delete?")) {
            $.ajax({
                url: '{{ route("playerstats.destroy", ":id") }}'.replace(':id', id),
                type: 'DELETE',
                data: { id: id },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.success);
                        window.location.href = '{{ route("schedules.index") }}';
                    }
                },
                error: function(xhr) {
                    alert("An error occurred while deleting the player stat.");
                }
            });
        }
    }
</script>
</x-app-layout>