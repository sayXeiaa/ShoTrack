<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/themes/default.css">
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schedules / Create
            </h2>
            <a href="{{ route('schedules.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('schedules.store') }}" method="post">
                        @csrf

                        <!-- Tournament Selection -->
                        <div>
                            <label for="tournament" class="text-lg font-medium">Tournament</label>
                            <div class="my-3">
                                <select id="tournament" name="tournament_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Tournament</option>
                                    @foreach($tournaments as $tournament)
                                        <option value="{{ $tournament->id }}"
                                                data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}">
                                            {{ $tournament->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tournament_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Category Selection (Initially Hidden) -->
                        <div id="category-selection" style="display: none;">
                            <label for="category" class="text-lg font-medium">Category</label>
                            <div class="my-3">
                                <select id="category" name="category" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Category</option>
                                    <option value="juniors">Juniors</option>
                                    <option value="seniors">Seniors</option>
                                </select>
                                @error('category')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Schedule Details Form -->
                        <label for="date" class="text-lg font-medium">Date</label>
                        <div class="my-3">
                            <input type="date" id="date" name="date" value="{{ old('date') }}" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('date')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="time" class="text-lg font-medium">Time</label>
                        <div class="my-3">
                            <input type="text" id="time" name="time" value="{{ old('time') }}" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;" placeholder="e.g., 12:00 PM">
                            @error('time')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="venue" class="text-lg font-medium">Venue</label>
                        <div class="my-3">
                            <input value="{{ old('venue') }}" name="venue" placeholder="Enter Game Venue" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('venue')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="team1" class="text-lg font-medium">Team 1</label>
                        <div class="my-3">
                            <select name="team1_id" id="team1" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                <option value="">Select Team 1</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('team1_id')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="team2" class="text-lg font-medium">Team 2</label>
                        <div class="my-3">
                            <select name="team2_id" id="team2" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                <option value="">Select Team 2</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('team2_id')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3 mt-5">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const tournamentSelect = document.getElementById('tournament');
                const categorySelect = document.getElementById('category');
                const categorySelectionDiv = document.getElementById('category-selection');
                const team1Select = document.getElementById('team1');
                const team2Select = document.getElementById('team2');

                function updateCategoryVisibility() {
                    const selectedOption = tournamentSelect.selectedOptions[0];
                    const hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';

                    if (hasCategories) {
                        categorySelectionDiv.style.display = 'block';
                    } else {
                        categorySelectionDiv.style.display = 'none';
                    }
                }

                function updateTeams() {
                    const tournamentId = tournamentSelect.value;
                    const category = categorySelect.value;
                    team1Select.innerHTML = '<option value="">Select Team 1</option>'; // Reset team1 dropdown
                    team2Select.innerHTML = '<option value="">Select Team 2</option>'; // Reset team2 dropdown

                    if (tournamentId) {
                        $.ajax({
                            url: '{{ route('teams.by_tournament') }}',
                            type: 'GET',
                            data: {
                                tournament_id: tournamentId,
                                category: category // Send category value
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data.teams && data.teams.length > 0) {
                                    data.teams.forEach(team => {
                                        var option = document.createElement('option');
                                        option.value = team.id;
                                        option.textContent = team.name;
                                        team1Select.appendChild(option.cloneNode(true)); // Add to team1
                                        team2Select.appendChild(option); // Add to team2
                                    });
                                } else {
                                    team1Select.innerHTML = '<option value="">No Teams Available</option>'; // No teams found message
                                    team2Select.innerHTML = '<option value="">No Teams Available</option>'; // No teams found message
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('AJAX Error:', textStatus, errorThrown); // Debugging statement
                                alert('Failed to fetch teams.');
                            }
                        });
                    } else {
                        team1Select.innerHTML = '<option value="">Select Team 1</option>'; // Reset team1 dropdown if no tournament selected
                        team2Select.innerHTML = '<option value="">Select Team 2</option>'; // Reset team2 dropdown if no tournament selected
                    }
                }

                tournamentSelect.addEventListener('change', function() {
                    updateCategoryVisibility();
                    updateTeams();
                });

                categorySelect.addEventListener('change', function() {
                    updateTeams(); // Update teams when category changes
                });

                // Initialize visibility and teams on page load
                updateCategoryVisibility();
                updateTeams();
            });
        </script>
    </x-slot>
</x-app-layout>
