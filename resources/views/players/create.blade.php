<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Players / Create
            </h2>
            <a href="{{ route('players.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('players.store') }}" method="post">
                        @csrf
                        <!-- Tournament Selection -->
                        <div class="mb-4">
                            <label for="tournament" class="block text-lg font-medium text-gray-700">Tournament</label>
                            <div class="my-3">
                                <select id="tournament" name="tournament_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Tournament</option>
                                    @foreach($tournaments as $tournament)
                                        <option value="{{ $tournament->id }}" 
                                            data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}" 
                                            data-tournament-type="{{ $tournament->tournament_type }}"
                                            {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}>
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
                        <div id="category-selection" class="mb-4" style="display: none;">
                            <label for="category" class="block text-lg font-medium text-gray-700">Category</label>
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
                        
                        <!-- Team Selection (Filtered by selected tournament) -->
                        <div class="mb-4">
                            <label for="team_id" class="block text-lg font-medium text-gray-700">Select Team</label>
                            <div class="my-3">
                                <select id="team_id" name="team_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('team_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Player Details Form -->
                        <label for="first_name" class="text-lg font-medium">First Name</label>
                        <div class="my-3">
                            <input value="{{ old('first_name') }}" name="first_name" placeholder="Enter Player First Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('first_name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="last_name" class="text-lg font-medium">Last Name</label>
                        <div class="my-3">
                            <input value="{{ old('last_name') }}" name="last_name" placeholder="Enter Player Last Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('last_name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="number" class="text-lg font-medium">Jersey Number</label>
                        <div class="my-3">
                            <input value="{{ old('number') }}" name="number" placeholder="Enter Player Jersey Number" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('number')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="school-fields" style="display: none;">
                            <label for="years_playing_in_bucal" class="text-lg font-medium">Years Playing in BUCAL</label>
                            <div class="my-3">
                                <input value="{{ old('years_playing_in_bucal') }}" name="years_playing_in_bucal" placeholder="Enter the number of years playing in BUCAL" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('years_playing_in_bucal')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="position" class="text-lg font-medium">Position</label>
                            <div class="my-3">
                                <select name="position" id="position" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="" disabled selected>Select Player Position</option>
                                    <option value="Point Guard" {{ old('position') == 'Point Guard' ? 'selected' : '' }}>Point Guard (PG)</option>
                                    <option value="Shooting Guard" {{ old('position') == 'Shooting Guard' ? 'selected' : '' }}>Shooting Guard (SG)</option>
                                    <option value="Small Forward" {{ old('position') == 'Small Forward' ? 'selected' : '' }}>Small Forward (SF)</option>
                                    <option value="Power Forward" {{ old('position') == 'Power Forward' ? 'selected' : '' }}>Power Forward (PF)</option>
                                    <option value="Center" {{ old('position') == 'Center' ? 'selected' : '' }}>Center (C)</option>
                                </select>
                                @error('position')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <label for="date_of_birth" class="text-lg font-medium">Date of Birth</label>
                        <div class="my-3">
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('date_of_birth')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <label for="height" class="text-lg font-medium">Height</label>
                        <div class="my-3">
                            <input value="{{ old('height') }}" name="height" placeholder="Enter Height in ft" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('height')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="weight" class="text-lg font-medium">Weight</label>
                        <div class="my-3">
                            <input value="{{ old('weight') }}" name="weight" placeholder="Enter Weight in kg" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('weight')
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
                const teamSelect = document.getElementById('team_id');
                const schoolFieldsDiv = document.getElementById('school-fields'); 

                function updateCategoryVisibility() {
                    const selectedOption = tournamentSelect.selectedOptions[0];
                    const hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';

                    if (hasCategories) {
                        categorySelectionDiv.style.display = 'block';
                    } else {
                        categorySelectionDiv.style.display = 'none';
                        categorySelect.selectedIndex = 0;
                    }
                }

                function updateSchoolFieldsVisibility() {
                    const selectedOption = tournamentSelect.selectedOptions[0];
                    const tournamentType = selectedOption.getAttribute('data-tournament-type');

                    // Show or hide the school fields section based on whether it's a school tournament
                    schoolFieldsDiv.style.display = tournamentType === 'school' ? 'block' : 'none';
                }

                function updateTeams() {
                    const tournamentId = tournamentSelect.value;
                    const category = categorySelect.value;
                    const selectedTeamId = '{{ old('team_id') }}'; 
                    teamSelect.innerHTML = '<option value="">Select a Team</option>'; // Reset teams dropdown

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
                                console.log('Teams data:', data); // Debugging statement

                                if (data.teams && data.teams.length > 0) {
                                    data.teams.forEach(team => {
                                        var option = document.createElement('option');
                                        option.value = team.id;
                                        option.textContent = team.name;

                                        // Set the previously selected team as selected
                                        if (team.id == selectedTeamId) {
                                            option.selected = true;
                                        }

                                        teamSelect.appendChild(option);
                                    });
                                } else {
                                    teamSelect.innerHTML = '<option value="">No Teams Available</option>'; // No teams found message
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('AJAX Error:', textStatus, errorThrown); // Debugging statement
                                alert('Failed to fetch teams.');
                            }
                        });
                    } else {
                        teamSelect.innerHTML = '<option value="">Select a Team</option>'; // Reset teams dropdown if no tournament selected
                    }
                }


                tournamentSelect.addEventListener('change', function() {
                    updateCategoryVisibility();
                    updateSchoolFieldsVisibility();
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