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

            <!-- Stat Type Dropdown -->
            <div class="mb-4">
                <label for="stat-type" class="block text-sm font-medium text-gray-700">Select Stat Type</label>
                <select id="stat-type" name="stat_type" class="mt-1 block w-full sm:w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="toggleStats()">
                    <option value="points" {{ request('stat_type') == 'points' ? 'selected' : '' }}>Points</option>
                    <option value="rebounds" {{ request('stat_type') == 'rebounds' ? 'selected' : '' }}>Rebounds</option>
                    <option value="assists" {{ request('stat_type') == 'assists' ? 'selected' : '' }}>Assists</option>
                    <option value="blocks" {{ request('stat_type') == 'blocks' ? 'selected' : '' }}>Blocks</option>
                    <option value="steals" {{ request('stat_type') == 'steals' ? 'selected' : '' }}>Steals</option>
                    <option value="turnovers" {{ request('stat_type') == 'turnovers' ? 'selected' : '' }}>Turnovers</option>
                    <option value="fg_percentage" {{ request('stat_type') == 'fg_percentage' ? 'selected' : '' }}>Field Goal Percentage</option>
                    <option value="two_pt_fg_made" {{ request('stat_type') == 'two_pt_fg_made' ? 'selected' : '' }}>Two-Point Field Goals Made</option>
                    <option value="two_pt_percentage" {{ request('stat_type') == 'two_pt_percentage' ? 'selected' : '' }}>Two-Point Field Goal Percentage</option>
                    <option value="three_pt_fg_made" {{ request('stat_type') == 'three_pt_fg_made' ? 'selected' : '' }}>Three-Point Field Goals Made</option>
                    <option value="three_pt_percentage" {{ request('stat_type') == 'three_pt_percentage' ? 'selected' : '' }}>Three-Point Field Goal Percentage</option>
                    <option value="personal_fouls" {{ request('stat_type') == 'personal_fouls' ? 'selected' : '' }}>Personal Fouls</option>
                    <option value="free_throw_made" {{ request('stat_type') == 'free_throw_made' ? 'selected' : '' }}>Free Throw Made</option>
                    <option value="free_throw_percentage" {{ request('stat_type') == 'free_throw_percentage' ? 'selected' : '' }}>Free Throw Percentage</option>
                    <option value="free_throw_attempt_rate" {{ request('stat_type') == 'free_throw_attempt_rate' ? 'selected' : '' }}>Free Throw Attempt Rate</option>
                    <option value="effective_field_goal_percentage" {{ request('stat_type') == 'effective_field_goal_percentage' ? 'selected' : '' }}>Effective Field Goal Percentage</option>
                    <option value="turnover_ratio" {{ request('stat_type') == 'turnover_ratio' ? 'selected' : '' }}>Turnover Ratio</option>
                    <option value="plus_minus" {{ request('stat_type') == 'plus_minus' ? 'selected' : '' }}>Plus Minus</option>
                </select>
            </div>

            <!-- Points Per Game -->
            <div id="points" class="bg-white p-6 rounded-lg shadow-md mt-8" style="display: none;">
                <h2 class="text-2xl font-semibold mb-6">Points Per Game</h2>
                <ol class="list-decimal pl-7">
                    @foreach($topPlayersByStats['points'] as $index => $player)
                        <li class="flex justify-between items-center mb-4 
                                hover:bg-gray-500 transition-colors duration-200">
                            <!-- Name and School on the left -->
                            <span class="team-initials text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <!-- Points on the right -->
                            <span class="ml-6 text-lg font-semibold text-right">
                                {{ number_format($player->average_points, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Rebounds Per Game -->
            <div id="rebounds" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Rebounds Per Game</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['rebounds'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($topPlayersByStats['rebounds']->where('id', $player->id)->first()->average_rebounds ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Assists Per Game -->
            <div id="assists" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Assists Per Game</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['assists'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($topPlayersByStats['assists']->where('id', $player->id)->first()->average_assists ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Blocks Per Game -->
            <div id="blocks" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Blocks Per Game</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['blocks'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($topPlayersByStats['blocks']->where('id', $player->id)->first()->average_blocks ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Steals Per Game -->
            <div id="steals" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Steals Per Game</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['steals'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($topPlayersByStats['steals']->where('id', $player->id)->first()->average_steals ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Turnovers Per Game -->
            <div id="turnovers" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Turnovers Per Game</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['turnovers'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($topPlayersByStats['turnovers']->where('id', $player->id)->first()->average_turnovers ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- FG Percentage --}}
            <div id="fg_percentage" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Field Goal Percentage</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['two_pt_fg_attempt'] as $index => $player)
                        @php
                            $twoPtMade = $topPlayersByStats['two_pt_fg_made']->where('id', $player->id)->first()->average_two_pt_fg_made ?? 0;
                            $twoPtAttempted = $topPlayersByStats['two_pt_fg_attempt']->where('id', $player->id)->first()->average_two_pt_fg_attempt ?? 0;
                            $threePtMade = $topPlayersByStats['three_pt_fg_made']->where('id', $player->id)->first()->average_three_pt_fg_made ?? 0;
                            $threePtAttempted = $topPlayersByStats['three_pt_fg_attempt']->where('id', $player->id)->first()->average_three_pt_fg_attempt ?? 0;
                            $totalMade = $twoPtMade + $threePtMade;
                            $totalAttempted = $twoPtAttempted + $threePtAttempted;
                            $fgPercentage = $totalAttempted > 0 ? ($totalMade / $totalAttempted) * 100 : 0;
                        @endphp
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($fgPercentage, 2) }}%
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Two-Point Field Goals Made -->
            <div id="two_pt_fg_made" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Two-Point Field Goals Made</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['two_pt_fg_made'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($topPlayersByStats['two_pt_fg_made']->where('id', $player->id)->first()->average_two_pt_fg_made ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Two-Point Percentage -->
            <div id="two_pt_percentage" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Two-Point Percentage</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['two_pt_percentage'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_two_pt_percentage ?? 0, 2) }}%
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Three-Point Field Goals Made -->
            <div id="three_pt_fg_made" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Three-Point Field Goals Made</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['three_pt_fg_made'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_three_pt_fg_made ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Three-Point Percentage -->
            <div id="three_pt_percentage" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Three-Point Percentage</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['three_pt_percentage'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_three_pt_percentage ?? 0, 2) }}%
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Personal Fouls Per Game -->
            <div id="personal_fouls" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Personal Fouls Per Game</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['personal_fouls'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_personal_fouls ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Free Throw Made -->
            <div id="free_throw_made" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Free Throw Made</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['free_throw_made'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_free_throw_made ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Free Throw Percentage -->
            <div id="free_throw_percentage" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Free Throw Percentage</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['free_throw_percentage'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_free_throw_percentage ?? 0, 2) }}%
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Free Throw Attempt Rate -->
            <div id="free_throw_attempt_rate" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Free Throw Attempt Rate</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['free_throw_attempt_rate'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_free_throw_attempt_rate ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Effective Field Goal Percentage -->
            <div id="effective_field_goal_percentage" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Effective Field Goal Percentage</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['effective_field_goal_percentage'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_effective_field_goal_percentage ?? 0, 2) }}%
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Turnover Ratio -->
            <div id="turnover_ratio" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Turnover Ratio</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['turnover_ratio'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_turnover_ratio ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Plus Minus -->
            <div id="plus_minus" class="bg-white p-4 rounded-lg shadow-md mt-6" style="display: none">
                <h2 class="text-2xl font-semibold mb-6">Plus Minus</h2>
                <ol class="list-decimal pl-5">
                    @foreach($topPlayersByStats['plus_minus'] as $index => $player)
                        <li class="flex justify-between items-center mb-2 hover:bg-gray-500 transition-colors duration-200">
                            <span class="text-left text-lg font-medium">
                                {{ $loop->iteration }}. {{ $player->first_name }} {{ $player->last_name }} 
                                ({{ $player->team_acronym ?? $player->team->name }})
                            </span>
                            <span class="ml-4 text-lg font-semibold text-right">
                                {{ number_format($player->average_plus_minus ?? 0, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

    <style>
        .hidden-section {
            display: none;
        }
        .block {
            display: block;
        }
    </style>

    <script>
        function toggleStats() {
            const statType = document.getElementById('stat-type').value;
            const sections = [
                'points',
                'rebounds',
                'assists',
                'blocks',
                'steals',
                'turnovers',
                'fg_percentage',
                'three_pt_fg_made',
                'personal_fouls',
                'two_pt_fg_made',
                'two_pt_percentage',
                'three_pt_percentage',
                'free_throw_made',
                'free_throw_percentage',
                'free_throw',
                'free_throw_attempt_rate',
                'effective_field_goal_percentage',
                'turnover_ratio',
                'plus_minus'
            ];

            // Hide all sections
            sections.forEach(section => {
                const element = document.getElementById(section);
                if (element) {
                    element.style.display = 'none';
                }
            });

            // Show selected section
            const selectedElement = document.getElementById(statType);
            if (selectedElement) {
                selectedElement.style.display = 'block';
            }
        }

        // Initialize the stat display based on the selected stat on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleStats();
        });

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
                this.form.submit(); 
            });

            updateCategoryVisibility(); 
        });
    </script>
</x-app-layout>
