<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Game Results') }}
            </h2>
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
            
            <div class="text-lg font-bold ml-2 flex flex-wrap gap-2 sm:gap-4 flex-col sm:flex-row">
                <button class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300 active-btn" data-type="boxScore">
                    Box Score
                </button>
                <button class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300" data-type="playByPlay">
                    Play-By-Play
                </button>
                <button class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300" data-type="teamComparison">
                    Team Comparison
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
                        <div class="overflow-x-auto">
                            <table class="min-w-full stats-table border-collapse border border-gray-300">
                                <thead class="bg-[#314795]">
                                    <tr class="text-white">
                                        <th class="border px-4 py-2 w-32">PLAYER</th>
                                        <th class="border px-4 py-2 w-12 sm:16">MIN</th>
                                        <th class="border px-4 py-2 w-12 sm:16">FGM</th>
                                        <th class="border px-4 py-2 w-12 sm:16">FGA</th> 
                                        <th class="border px-4 py-2 w-14 sm:16">FG%</th>
                                        <th class="border px-4 py-2 w-12 sm:16">2PM</th>
                                        <th class="border px-4 py-2 w-12 sm:16">2PA</th>
                                        <th class="border px-4 py-2 w-14 sm:16">2P%</th>
                                        <th class="border px-4 py-2 w-12 sm:16">3PM</th>
                                        <th class="border px-4 py-2 w-12 sm:16">3PA</th>
                                        <th class="border px-4 py-2 w-14 sm:16">3P%</th>
                                        <th class="border px-4 py-2 w-12 sm:16">FTM</th>
                                        <th class="border px-4 py-2 w-12 sm:16">FTA</th>
                                        <th class="border px-4 py-2 w-14 sm:16">FT%</th>
                                        <th class="border px-4 py-2 w-12 sm:16">OREB</th>
                                        <th class="border px-4 py-2 w-12 sm:16">DREB</th>
                                        <th class="border px-4 py-2 w-12 sm:16">REB</th>
                                        <th class="border px-4 py-2 w-12 sm:16">AST</th>
                                        <th class="border px-4 py-2 w-12 sm:16">STL</th>
                                        <th class="border px-4 py-2 w-12 sm:16">BLK</th>
                                        <th class="border px-4 py-2 w-12 sm:16">TO</th>
                                        <th class="border px-4 py-2 w-12 sm:16">PF</th>
                                        <th class="border px-4 py-2 w-12 sm:16">PTS</th>
                                        <th class="border px-4 py-2 w-12 sm:16">+/–</th>
                                        @can('edit statistics')
                                        <th class="px-6 py-3 text-center" width="180">Action</th>
                                        @endcan
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
                                                    $number = $stat->player->number;
                                                @endphp
                                                <div class="flex items-left">
                                                    <span class="text-gray-500 w-12 text-left">#{{ $number }}</span>
                                                    <span class="text-left font-bold">{{ $initial }}. {{ $lastName }}</span>
                                                </div>
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
                                        @can ('edit statistics')
                                        <td class="px-6 py-3 text-center">
                                            <a href="{{ route('playerstats.edit', $stat->id) }}" class="bg-slate-700 text-xs rounded-md text-white px-2 py-1 hover:bg-slate-600 mr-4">Edit</a>
                                            <a href="javascript:void(0)" onclick="deletePlayerStat({{ $stat->id }})" class="bg-red-600 text-xs rounded-md text-white px-2 py-1 hover:bg-red-500">Delete</a>
                                        </td>
                                        @endcan
                                        
                                    </tr>
                                    @endforeach
                                
                                    {{-- Display Remaining Players --}}
                                    @foreach ($remainingPlayersTeam1 as $player)
                                    <tr class="hover:bg-gray-400">
                                        <td class="border px-4 py-2">
                                            @php
                                                $initial = strtoupper(substr($player->first_name, 0, 1)); // Get initial of first name
                                                $lastName = $player->last_name; // Get last name
                                                $number = $stat->player->number;
                                            @endphp
                                            <div class="flex items-left">
                                                <span class="text-gray-500 w-12 text-left">#{{ $number }}</span>
                                                <span class="text-left font-bold">{{ $initial }}. {{ $lastName }}</span>
                                            </div>
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
                                        @can ('edit statistics')
                                        <td class="px-6 py-3 text-center">
                                            <a href="{{ route('playerstats.edit', ['id' => $player->id]) }}" class="bg-slate-700 text-xs rounded-md text-white px-2 py-1 hover:bg-slate-600">Edit</a>
                                        </td>
                                        @endcan
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
                            <div class="overflow-x-auto">
                                <table class="min-w-full stats-table border-collapse border border-gray-300">
                                    <thead class="bg-[#314795]">
                                        <tr class="text-white">
                                            <th class="border px-4 py-2 w-32">PLAYER</th>
                                            <th class="border px-4 py-2 w-12 sm:16">MIN</th>
                                            <th class="border px-4 py-2 w-12 sm:16">FGM</th>
                                            <th class="border px-4 py-2 w-12 sm:16">FGA</th> 
                                            <th class="border px-4 py-2 w-14 sm:16">FG%</th>
                                            <th class="border px-4 py-2 w-12 sm:16">2PM</th>
                                            <th class="border px-4 py-2 w-12 sm:16">2PA</th>
                                            <th class="border px-4 py-2 w-14 sm:16">2P%</th>
                                            <th class="border px-4 py-2 w-12 sm:16">3PM</th>
                                            <th class="border px-4 py-2 w-12 sm:16">3PA</th>
                                            <th class="border px-4 py-2 w-14 sm:16">3P%</th>
                                            <th class="border px-4 py-2 w-12 sm:16">FTM</th>
                                            <th class="border px-4 py-2 w-12 sm:16">FTA</th>
                                            <th class="border px-4 py-2 w-14 sm:16">FT%</th>
                                            <th class="border px-4 py-2 w-12 sm:16">OREB</th>
                                            <th class="border px-4 py-2 w-12 sm:16">DREB</th>
                                            <th class="border px-4 py-2 w-12 sm:16">REB</th>
                                            <th class="border px-4 py-2 w-12 sm:16">AST</th>
                                            <th class="border px-4 py-2 w-12 sm:16">STL</th>
                                            <th class="border px-4 py-2 w-12 sm:16">BLK</th>
                                            <th class="border px-4 py-2 w-12 sm:16">TO</th>
                                            <th class="border px-4 py-2 w-12 sm:16">PF</th>
                                            <th class="border px-4 py-2 w-12 sm:16">PTS</th>
                                            <th class="border px-4 py-2 w-12 sm:16">+/–</th>
                                            @can ('edit statistics')
                                            <th class="px-6 py-3 text-center" width="180">Action</th>
                                            @endcan
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
                                                        $number = $stat->player->number;
                                                    @endphp
                                                    <div class="flex items-left">
                                                        <span class="text-gray-500 w-12 text-left">#{{ $number }}</span>
                                                        <span class="text-left font-bold">{{ $initial }}. {{ $lastName }}</span>
                                                    </div>
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
                                            @can ('edit statistics')
                                            <td class="px-6 py-3 text-center">
                                                <a href="{{ route('playerstats.edit', $stat->id) }}" class="bg-slate-700 text-xs rounded-md text-white px-2 py-1 hover:bg-slate-600 mr-4">Edit</a>
                                                <a href="javascript:void(0)" onclick="deletePlayerStat({{ $stat->id }})" class="bg-red-600 text-xs rounded-md text-white px-2 py-1 hover:bg-red-500">Delete</a>
                                            </td>
                                            @endcan
                                        </tr>
                                        @endforeach
                                    
                                        {{-- Display Remaining Players --}}
                                        @foreach ($remainingPlayersTeam2 as $player)
                                        <tr class="hover:bg-gray-400">
                                            <td class="border px-8 py-2">
                                                @php
                                                    $initial = strtoupper(substr($player->first_name, 0, 1)); // Get initial of first name
                                                    $lastName = $player->last_name; // Get last name
                                                    $number = $stat->player->number;
                                                @endphp
                                                <div class="flex items-left">
                                                    <span class="text-gray-500 w-12 text-left">#{{ $number }}</span>
                                                    <span class="text-left font-bold">{{ $initial }}. {{ $lastName }}</span>
                                                </div>
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
                                            @can ('edit statistics')
                                            <td class="px-6 py-3 text-center">
                                                <a href="{{ route('playerstats.edit', ['id' => $player->id]) }}" class="bg-slate-700 text-xs rounded-md text-white px-2 py-1 hover:bg-slate-600">Edit</a>
                                            </td>
                                            @endcan
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    @endif
            </div>

            <div id="playByPlay" class="content-section hidden bg-gray-50 p-6 rounded-lg shadow-md my-6">
                <h2 class="text-2xl font-bold mb-6 text-center text-black">Play-by-Play</h2>
                <div class="flex space-x-2 mb-6 justify-center">
                    <button class="quarter-button nav-btn bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-[#314795] transition duration-200" data-quarter="1">Q1</button>
                    <button class="quarter-button nav-btn bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-[#314795] transition duration-200" data-quarter="2">Q2</button>
                    <button class="quarter-button nav-btn bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-[#314795] transition duration-200" data-quarter="3">Q3</button>
                    <button class="quarter-button nav-btn bg-gray-400 text-white font-semibold py-2 px-4 rounded hover:bg-[#314795] transition duration-200" data-quarter="4">Q4</button>
                </div>
                <div id="play-by-play-list">
                    @foreach($playByPlayData as $play)
                        @php
                            // Check if the player exists and format the 
                            $playerNumber = $play->player ? $play->player->number : 'N/A';
                            $playerName = $play->player ? strtoupper(substr($play->player->first_name, 0, 1)) . '. ' . $play->player->last_name : 'Unknown Player';
                        @endphp
                        <div class="play-entry flex items-center justify-between p-4 border-b border-gray-200 hover:bg-gray-400 transition-colors duration-200" data-quarter="{{ $play->quarter }}">
                            <div class="flex-1 text-left">
                                <span class="text-gray-500 text-sm block">#{{ $playerNumber }}</span>
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
                $totalFreeThrowsMadeTeam1 = $playerStatsTeam1->sum('free_throw_made');
                $totalFreeThrowsMadeTeam1 = $playerStatsTeam1->sum('free_throw_made');
                $totalFoulsTeam1 = $playerStatsTeam1->sum('personal_fouls') 
                                + $playerStatsTeam1->sum('technical_fouls') 
                                + $playerStatsTeam1->sum('unsportsmanlike_fouls') 
                                + $playerStatsTeam1->sum('disqualifying_fouls');
                $totalDefensiveReboundsTeam1 = $playerStatsTeam1->sum('defensive_rebounds');
                $totalOffensiveReboundsTeam1 = $playerStatsTeam1->sum('offensive_rebounds');


                $totalFGMTeam1 = $playerStatsTeam1->sum(function($stat) {
                    return $stat->two_pt_fg_made + $stat->three_pt_fg_made;
                });

                $totalFGATeam1 = $playerStatsTeam1->sum(function($stat) {
                    return $stat->two_pt_fg_attempt + $stat->three_pt_fg_attempt;
                });

                $totalFGPercentageTeam1 = ($totalFGATeam1 > 0) ? number_format(($totalFGMTeam1 / $totalFGATeam1) * 100, 1) : 0.0;

                $total2PMTeam1 = $playerStatsTeam1->sum('two_pt_fg_made');
                $total2PATeam1 = $playerStatsTeam1->sum('two_pt_fg_attempt');
                $total2ptPercentageTeam1 = ($total2PATeam1 > 0) ? number_format(($total2PMTeam1 / $total2PATeam1) * 100, 1) : 0.0;

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
                $totalFreeThrowsMadeTeam2 = $playerStatsTeam2->sum('free_throw_made');          
                $totalFreeThrowsMadeTeam1 = $playerStatsTeam1->sum('free_throw_made');
                $totalFoulsTeam2 = $playerStatsTeam2->sum('personal_fouls') 
                                + $playerStatsTeam2->sum('technical_fouls') 
                                + $playerStatsTeam2->sum('unsportsmanlike_fouls') 
                                + $playerStatsTeam2->sum('disqualifying_fouls');
                $totalDefensiveReboundsTeam2 = $playerStatsTeam2->sum('defensive_rebounds');
                $totalOffensiveReboundsTeam2 = $playerStatsTeam2->sum('offensive_rebounds');


                $totalFGMTeam2 = $playerStatsTeam2->sum(function($stat) {
                    return $stat->two_pt_fg_made + $stat->three_pt_fg_made;
                });

                $totalFGATeam2 = $playerStatsTeam2->sum(function($stat) {
                    return $stat->two_pt_fg_attempt + $stat->three_pt_fg_attempt;
                });

                $total2ptTeam2 = $playerStatsTeam1->sum(function($stat) {
                    return $stat->two_pt_fg_made;
                });

                $totalFGPercentageTeam2 = ($totalFGATeam2 > 0) ? number_format(($totalFGMTeam2 / $totalFGATeam2) * 100, 1) : 0.0;

                $total2PMTeam2 = $playerStatsTeam2->sum('two_pt_fg_made');
                $total2PATeam2 = $playerStatsTeam2->sum('two_pt_fg_attempt');
                $total2ptPercentageTeam2 = ($total2PATeam2 > 0) ? number_format(($total2PMTeam2 / $total2PATeam2) * 100, 1) : 0.0;

                $total3PMTeam2 = $playerStatsTeam2->sum('three_pt_fg_made');
                $total3PATeam2 = $playerStatsTeam2->sum('three_pt_fg_attempt');
                $total3ptPercentageTeam2 = ($total3PATeam2 > 0) ? number_format(($total3PMTeam2 / $total3PATeam2) * 100, 1) : 0.0;

                $totalFTMadeTeam2 = $playerStatsTeam2->sum('free_throw_made');
                $totalFTAttemptTeam2 = $playerStatsTeam2->sum('free_throw_attempt');
                $totalFreeThrowPercentageTeam2 = ($totalFTAttemptTeam2 > 0) ? number_format(($totalFTMadeTeam2 / $totalFTAttemptTeam2) * 100, 1) : 0.0;
            @endphp

            <div id="teamComparison" class="content-section hidden bg-gray-50 p-6 rounded-lg shadow-md my-6">
                <h2 class="text-2xl font-bold mb-6 text-center text-black">Team Comparison</h2>
                
                <!-- Team Names -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b">
                    <div class="font-extrabold text-lg text-black">{{ $schedule->team1->name }}</div>
                    <div class="font-semibold text-black">Team Name</div>
                    <div class="font-extrabold text-lg text-black">{{ $schedule->team2->name }}</div>
                </div>

                <!-- Data Rows -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-xl text-black">{{ $totalPointsTeam1 }}</div>
                    <div class="font-semibold text-black">Score</div>
                    <div class="font-medium text-xl text-black">{{ $totalPointsTeam2 }}</div>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{  $total2PMTeam1 }} / {{ $total2PATeam1 }}</div>
                    <div class="font-semibold text-black">2-Point Field Goals</div>
                    <div class="font-medium text-black">{{ $total2PMTeam2}} / {{ $total2PATeam2 }}</div>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $total2ptPercentageTeam1 }}%</div>
                    <div class="font-semibold text-black">2-Point Percentage</div>
                    <div class="font-medium text-black">{{ $total2ptPercentageTeam2 }}%</div>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $total3PMTeam1 }} / {{ $total3PATeam1 }}</div>
                    <div class="font-semibold text-black">3-Point Shots</div>
                    <div class="font-medium text-black">{{ $total3PMTeam2 }} / {{ $total3PATeam2 }}</div>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $total3ptPercentageTeam1 }}%</div>
                    <div class="font-semibold text-black">3-Point Percentage</div>
                    <div class="font-medium text-black">{{ $total3ptPercentageTeam2 }}%</div>
                </div>

                <!-- Additional Statistics -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalFGMTeam1 }} / {{ $totalFGATeam1 }}</div>
                    <div class="font-semibold text-black">Field Goals</div>
                    <div class="font-medium text-black">{{ $totalFGMTeam2 }} / {{ $totalFGATeam2 }}</div>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalFGPercentageTeam1 }}%</div>
                    <div class="font-semibold text-black">Field Goal Percentage</div>
                    <div class="font-medium text-black">{{ $totalFGPercentageTeam2 }}%</div>
                </div>

                <!-- Defensive Rebounds -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalDefensiveReboundsTeam1 }}</div>
                    <div class="font-semibold text-black">Defensive Rebounds</div>
                    <div class="font-medium text-black">{{ $totalDefensiveReboundsTeam2 }}</div>
                </div>

                <!-- Offensive Rebounds -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalOffensiveReboundsTeam1 }}</div>
                    <div class="font-semibold text-black">Offensive Rebounds</div>
                    <div class="font-medium text-black">{{ $totalOffensiveReboundsTeam2 }}</div>
                </div>

                <!-- Assists -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalAssistsTeam1 }}</div>
                    <div class="font-semibold text-black">Assists</div>
                    <div class="font-medium text-black">{{ $totalAssistsTeam2 }}</div>
                </div>

                <!-- Steals -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalStealsTeam1 }}</div>
                    <div class="font-semibold text-black">Steals</div>
                    <div class="font-medium text-black">{{ $totalStealsTeam2 }}</div>
                </div>

                <!-- Blocks -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalBlocksTeam1 }}</div>
                    <div class="font-semibold text-black">Blocks</div>
                    <div class="font-medium text-black">{{ $totalBlocksTeam2 }}</div>
                </div>

                <!-- Turnovers -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalTurnoversTeam1 }}</div>
                    <div class="font-semibold text-black">Turnovers</div>
                    <div class="font-medium text-black">{{ $totalTurnoversTeam2 }}</div>
                </div>

                <!-- Points Off Turnover -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalPointsOffTurnoverTeam1 }}</div>
                    <div class="font-semibold text-black">Points Off Turnover</div>
                    <div class="font-medium text-black">{{ $totalPointsOffTurnoverTeam2}}</div>
                </div>

                <!-- Fastbreak Points -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalFastBreakPointsTeam1 }}</div>
                    <div class="font-semibold text-black">Fast Break Points</div>
                    <div class="font-medium text-black">{{ $totalFastBreakPointsTeam2 }}</div>
                </div>

                <!-- 2nd Chance Points -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalSecondChancePointsTeam1 }}</div>
                    <div class="font-semibold text-black">2nd Chance Points</div>
                    <div class="font-medium text-black">{{ $totalSecondChancePointsTeam2 }}</div>
                </div>

                <!-- Starter Points -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalStarterPointsTeam1 }}</div>
                    <div class="font-semibold text-black">Starter Points</div>
                    <div class="font-medium text-black">{{ $totalStarterPointsTeam2 }}</div>
                </div>

                <!-- Bench Points -->
                <div class="grid grid-cols-3 gap-4 text-center py-3 border-b hover:bg-gray-400">
                    <div class="font-medium text-black">{{ $totalBenchPointsTeam1 }}</div>
                    <div class="font-semibold text-black">Bench Points</div>
                    <div class="font-medium text-black">{{ $totalBenchPointsTeam2 }}</div>
                </div>
            </div>

            <div id="gameChart" class="content-section hidden">
                <div class="flex justify-center my-6">
                    <button id="toggleComparisonChart" class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Show Team Comparison
                    </button>
                    <button id="togglePercentagesChart" class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300 ml-4">
                        Show Percentages
                    </button>
                </div>  
            
                <!-- Team Comparison Chart -->
                <div id="teamComparisonChartContainer">
                    <canvas id="teamComparisonChart" width="400" height="200"></canvas>
                </div>
            
                <!-- Percentages Chart -->
                <div id="percentagesChartContainer" class="hidden">
                    <canvas id="percentagesChart" width="400" height="200"></canvas>
                </div>
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
    let teamComparisonChartInstance = null;
    let percentagesChartInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Click the box score button by default
        const boxScoreButton = document.querySelector('.nav-btn[data-type="boxScore"]');
        boxScoreButton.click();
    });

    // Event listener for navigation buttons
    document.querySelectorAll('.nav-btn[data-type="boxScore"], .nav-btn[data-type="playByPlay"], .nav-btn[data-type="gameChart"], .nav-btn[data-type="teamComparison"]').forEach(button => {
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
                section.classList.add('hidden'); 
            });

            // Show the selected content section
            const selectedSection = document.getElementById(selectedType);
            if (selectedSection) {
                selectedSection.classList.remove('hidden');
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
                filterPlayByPlayData(undefined);
            }

            if (selectedType === 'gameChart') {
                document.getElementById("gameChart").classList.remove("hidden");

                // Set default button active (Show Team Comparison)
                document.getElementById("toggleComparisonChart").classList.remove('bg-gray-400');
                document.getElementById("toggleComparisonChart").classList.add('bg-[#314795]');
                document.getElementById("togglePercentagesChart").classList.remove('bg-[#314795]');
                document.getElementById("togglePercentagesChart").classList.add('bg-gray-400');

                // Show the team comparison chart by default
                loadTeamComparisonChart();
            }

            // Show the team comparison section
            if (selectedType === 'teamComparison') {
                const teamComparisonSection = document.getElementById('teamComparison');
                if (teamComparisonSection) {
                    teamComparisonSection.classList.remove('hidden'); 
                }
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
        const canvas = document.getElementById('teamComparisonChart').getContext('2d');
        
        // Destroy the previous chart instance if it exists
        if (teamComparisonChartInstance) {
            teamComparisonChartInstance.destroy();
        }

        // Fetch actual data
        const teamStats = {
            "{{ $schedule->team1->name }}": {
                pts: {{ $totalPointsTeam1 }},
                rebs: {{ $totalReboundsTeam1 }},
                assists: {{ $totalAssistsTeam1 }},
                stl: {{ $totalStealsTeam1 }},
                blk: {{ $totalBlocksTeam1 }},
                to: {{ $totalTurnoversTeam1 }},
                ftm: {{ $totalFreeThrowsMadeTeam1 }},
                fouls: {{ $totalFoulsTeam1 }},
                twoPm: {{ $total2PMTeam1 }},
                threePm: {{ $total3PMTeam1 }},
                fgm: {{ $totalFGMTeam1 }},
            },
            "{{ $schedule->team2->name }}": {
                pts: {{ $totalPointsTeam2 }},
                rebs: {{ $totalReboundsTeam2 }},
                assists: {{ $totalAssistsTeam2 }},
                stl: {{ $totalStealsTeam2 }},
                blk: {{ $totalBlocksTeam2 }},
                to: {{ $totalTurnoversTeam2 }},
                ftm: {{ $totalFreeThrowsMadeTeam2 }},
                fouls: {{ $totalFoulsTeam2 }},
                twoPm: {{  $total2PMTeam2 }},
                threePm: {{ $total3PMTeam2 }},
                fgm: {{ $totalFGMTeam2 }},
            }
        };

        const statsLabels = ['pts', 'fgm', 'twoPm', 'threePm', 'rebs', 'assists', 'stl', 'blk', 'to', 'ftm', 'fouls',];
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

        
        // Create the chart
        teamComparisonChartInstance = new Chart(canvas,{
            type: 'bar',
            data: {
                labels: ['PTS','FG MADE', '2PTS', '3PTS', 'REBS', 'ASSISTS', 'STEALS', 'BLOCKS', 'TURNOVERS', 'FREE THROWS','FOULS',], // Stats labels
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
                            text: 'Type of Stat'
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

    function loadPercentagesChart() {
        const canvas = document.getElementById('percentagesChart').getContext('2d');
        
        // Destroy the previous chart instance if it exists
        if (percentagesChartInstance) {
            percentagesChartInstance.destroy();
        }

        // Fetch actual data
        const teamStats = {
            "{{ $schedule->team1->name }}": {
                twoPt: {{ $total2ptPercentageTeam1 }},
                fg: {{ $totalFGPercentageTeam1 }},
                threeP: {{ $total3ptPercentageTeam1 }},
                ft: {{ $totalFreeThrowPercentageTeam1 }}
            },
            "{{ $schedule->team2->name }}": {
                twoPt: {{ $total2ptPercentageTeam2 }},
                fg: {{ $totalFGPercentageTeam2 }},
                threeP: {{ $total3ptPercentageTeam2 }},
                ft: {{ $totalFreeThrowPercentageTeam2 }}
            }
        };

        const statsLabels = ['fg', 'twoPt', 'threeP', 'ft'];
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

        // Create the chart
        percentagesChartInstance = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: ['FG%', '2PT%', '3PT%', 'FT%'], // Stats labels
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
                            text: 'Type of Stat'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Percentage'
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
                        text: 'Percentages Statistics'
                    }
                },
                indexAxis: 'y', // Keep for vertical layout if desired
            }
        });

        // Make the canvas visible after rendering the chart
        document.getElementById('percentagesChart').classList.remove('hidden');
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

    // Event listeners for the chart toggle buttons
    document.querySelector("#toggleComparisonChart").addEventListener("click", function () {
        // Load team comparison chart
        loadTeamComparisonChart();

        // Toggle button styles
        this.classList.add("bg-[#314795]");
        this.classList.remove("bg-gray-400");
        document.getElementById("togglePercentagesChart").classList.add("bg-gray-400");
        document.getElementById("togglePercentagesChart").classList.remove("bg-[#314795]");

        // Show team comparison chart and hide percentages chart
        document.getElementById("teamComparisonChartContainer").classList.remove("hidden");
        document.getElementById("percentagesChartContainer").classList.add("hidden");
    });

    document.querySelector("#togglePercentagesChart").addEventListener("click", function () {
        // Load percentages chart
        loadPercentagesChart();

        // Toggle button styles
        this.classList.add("bg-[#314795]");
        this.classList.remove("bg-gray-400");
        document.getElementById("toggleComparisonChart").classList.add("bg-gray-400");
        document.getElementById("toggleComparisonChart").classList.remove("bg-[#314795]");

        // Show percentages chart and hide team comparison chart
        document.getElementById("percentagesChartContainer").classList.remove("hidden");
        document.getElementById("teamComparisonChartContainer").classList.add("hidden");
    });

</script>
</x-app-layout>