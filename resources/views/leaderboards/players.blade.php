<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('PLAYER LEADERBOARDS') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="mb-4">
                <form method="GET" action="{{ route('leaderboards.players') }}">
                    <label for="tournament" class="block text-sm font-medium text-gray-700">Select Tournament</label>
                    <select id="tournament" name="tournament_id" class="mt-1 block w-full sm:w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
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
                <form method="GET" action="{{ route('leaderboards.players') }}">
                    <input type="hidden" name="tournament_id" value="{{ request('tournament_id') }}">
                    <label for="category" class="block text-sm font-medium text-gray-700">Select Category</label>
                    <select id="category" name="category" class="mt-1 block w-full sm:w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <option value="juniors" {{ request('category') == 'juniors' ? 'selected' : '' }}>Juniors</option>
                        <option value="seniors" {{ request('category') == 'seniors' ? 'selected' : '' }}>Seniors</option>
                    </select>
                </form>
            </div> 

            <div class="bg-gray-50 p-4 md:p-6 rounded-lg shadow-md my-6">

                <!-- Stats Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Points Per Game -->
                    <div>
                        <h2 class="text-lg font-semibold">Points Per Game</h2>
                        <ol class="list-decimal mt-2 ml-0"> 
                            @foreach($topPlayersByStats['points'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($player->average_points, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Rebounds Per Game -->
                    <div>
                        <h2 class="text-lg font-semibold">Rebounds Per Game</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['rebounds'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left"> 
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4"> 
                                        {{ number_format($topPlayersByStats['rebounds']->where('id', $player->id)->first()->average_rebounds ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Assists Per Game -->
                    <div>
                        <h2 class="text-lg font-semibold">Assists Per Game</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['assists'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4"> 
                                        {{ number_format($topPlayersByStats['assists']->where('id', $player->id)->first()->average_assists ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Blocks Per Game -->
                    <div>
                        <h2 class="text-lg font-semibold">Blocks Per Game</h2>
                        <ol class="list-decimal mt-2 ml-0"> 
                            @foreach($topPlayersByStats['blocks'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left"> 
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4"> 
                                        {{ number_format($topPlayersByStats['blocks']->where('id', $player->id)->first()->average_blocks ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Steals Per Game -->
                    <div>
                        <h2 class="text-lg font-semibold">Steals Per Game</h2>
                        <ol class="list-decimal mt-2 ml-0"> 
                            @foreach($topPlayersByStats['steals'] as $index => $player)
                                <li class="flex justify-between items-center mb-1"> 
                                    <span class="flex-grow text-left"> 
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4"> 
                                        {{ number_format($topPlayersByStats['steals']->where('id', $player->id)->first()->average_steals ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Turnovers Per Game -->
                    <div>
                        <h2 class="text-lg font-semibold">Turnovers Per Game</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['turnovers'] as $index => $player)
                                <li class="flex justify-between items-center mb-1"> 
                                    <span class="flex-grow text-left"> 
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4"> 
                                        {{ number_format($topPlayersByStats['turnovers']->where('id', $player->id)->first()->average_turnovers ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- FG Percentage --}}
                    <div>
                        <h3 class="text-lg font-semibold">Field Goal Percentage</h3>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['two_pt_fg_attempt'] as $index => $player)
                                @php
                                    // Retrieve made and attempted values for the current player
                                    $twoPtMade = $topPlayersByStats['two_pt_fg_made']->where('id', $player->id)->first()->average_two_pt_fg_made ?? 0;
                                    $twoPtAttempted = $topPlayersByStats['two_pt_fg_attempt']->where('id', $player->id)->first()->average_two_pt_fg_attempt ?? 0;
                                    $threePtMade = $topPlayersByStats['three_pt_fg_made']->where('id', $player->id)->first()->average_three_pt_fg_made ?? 0;
                                    $threePtAttempted = $topPlayersByStats['three_pt_fg_attempt']->where('id', $player->id)->first()->average_three_pt_fg_attempt ?? 0;
                    
                                    // Calculate total made and attempted
                                    $totalMade = $twoPtMade + $threePtMade;
                                    $totalAttempted = $twoPtAttempted + $threePtAttempted;
                    
                                    // Calculate FG% and format it
                                    $fgPercentage = $totalAttempted > 0 ? ($totalMade / $totalAttempted) * 100 : 0; // Prevent division by zero
                                @endphp
                    
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($fgPercentage, 2) }}%
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Two point fg Made --}}
                    <div>
                        <h2 class="text-lg font-semibold">Two-Point Field Goals Made</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['two_pt_fg_made'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($topPlayersByStats['two_pt_fg_made']->where('id', $player->id)->first()->average_two_pt_fg_made ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Three-Point Field Goals Made -->
                    <div>
                        <h2 class="text-lg font-semibold">Three-Point Field Goals Made</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['three_pt_fg_made'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($topPlayersByStats['three_pt_fg_made']->where('id', $player->id)->first()->average_three_pt_fg_made ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Fouls Per Game --}}
                    <div>
                        <h2 class="text-lg font-semibold">Personal Fouls Per Game</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['personal_fouls'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($topPlayersByStats['personal_fouls']->where('id', $player->id)->first()->average_personal_fouls ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Free Throw Percentage -->
                    <div>
                        <h2 class="text-lg font-semibold">Free Throw Percentage</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['free_throw_percentage'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($topPlayersByStats['free_throw_percentage']->where('id', $player->id)->first()->average_free_throw_percentage ?? 0, 2) }}%
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Free Throw Attempt Rate -->
                    <div>
                        <h2 class="text-lg font-semibold">Free Throw Attempt Rate</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['free_throw_attempt_rate'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($topPlayersByStats['free_throw_attempt_rate']->where('id', $player->id)->first()->average_free_throw_attempt_rate ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Effective Field Goal Percentage -->
                    <div>
                        <h2 class="text-lg font-semibold">Effective Field Goal Percentage</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['effective_field_goal_percentage'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($topPlayersByStats['effective_field_goal_percentage']->where('id', $player->id)->first()->average_effective_field_goal_percentage ?? 0, 2) }}%
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Turnover Ratio -->
                    <div>
                        <h2 class="text-lg font-semibold">Turnover Ratio</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['turnover_ratio'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($topPlayersByStats['turnover_ratio']->where('id', $player->id)->first()->average_turnover_ratio ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                    
                    <!-- Plus Minus -->
                    <div>
                        <h2 class="text-lg font-semibold">Plus Minus</h2>
                        <ol class="list-decimal mt-2 ml-0">
                            @foreach($topPlayersByStats['plus_minus'] as $index => $player)
                                <li class="flex justify-between items-center mb-1">
                                    <span class="flex-grow text-left">
                                        {{ $player->first_name }} {{ $player->last_name }} ({{ $player->team_acronym ?? 'Unknown Team' }})
                                    </span>
                                    <span class="ml-4">
                                        {{ number_format($topPlayersByStats['plus_minus']->where('id', $player->id)->first()->average_plus_minus ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const tournamentSelect = document.getElementById('tournament');
                const categorySelect = document.getElementById('category-selection');

                function updateCategoryVisibility() {
                    const selectedOption = tournamentSelect.selectedOptions[0];
                    const hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';

                    categorySelect.style.display = hasCategories ? 'block' : 'none';
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
