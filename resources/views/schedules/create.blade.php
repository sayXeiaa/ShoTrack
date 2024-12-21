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
                                                data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}"
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
                        <div id="category-selection" style="display: none;">
                            <label for="category" class="text-lg font-medium">Category</label>
                            <div class="my-3">
                                <select id="category" name="category" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Category</option>
                                    <option value="juniors" {{ old('category') == 'juniors' ? 'selected' : '' }}>Juniors</option>
                                    <option value="seniors" {{ old('category') == 'seniors' ? 'selected' : '' }}>Seniors</option>
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
                                    <option value="{{ $team->id }}" {{ old('team1_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>                            
                            @error('team1_id')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="team1Color" class="text-lg font-medium">Team 1 Color</label>
                        <div class="my-3">
                            <select name="team1_color" id="team1Color" class="team-color-dropdown border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                <option value="">Select Color</option>
                                <option value="light">Light</option>
                                <option value="dark">Dark</option>
                            </select>                            
                            @error('team1_color')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>                    

                        <label for="team2" class="text-lg font-medium">Team 2</label>
                        <div class="my-3">
                            <select name="team2_id" id="team2" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                <option value="">Select Team 2</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team2_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>                            
                            @error('team2_id')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="team2Color" class="text-lg font-medium">Team 2 Color</label>
                        <div class="my-3">
                            <select name="team2_color" id="team2Color" class="team-color-dropdown border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                <option value="">Select Color</option>
                                <option value="light">Light</option>
                                <option value="dark">Dark</option>
                            </select>                            
                            @error('team2_color')
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
        const team1ColorSelect = document.getElementById("team1Color");
        const team2ColorSelect = document.getElementById("team2Color");

        function updateCategoryVisibility() {
            const selectedOption = tournamentSelect.selectedOptions[0];
            const hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';

            // If the selected tournament has no categories, reset and hide the category dropdown
            if (hasCategories) {
                categorySelectionDiv.style.display = 'block'; // Show category dropdown
            } else {
                categorySelectionDiv.style.display = 'none'; // Hide category dropdown

                // Clear the category selection (reset to default value)
                categorySelect.value = ''; // Reset to the default value (Select Category)
            }
        }

        function updateTeams() {
            const tournamentId = tournamentSelect.value;
            const category = categorySelect.value;

            // Reset dropdowns before updating
            team1Select.innerHTML = '<option value="">Select Team 1</option>';
            team2Select.innerHTML = '<option value="">Select Team 2</option>';

            // Retrieve previously selected teams
            const oldTeam1 = "{{ old('team1_id') }}";
            const oldTeam2 = "{{ old('team2_id') }}";

            // Log selected tournament and category
            console.log('Selected Tournament:', tournamentId);
            console.log('Selected Category:', category);

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
                        //Log the received data
                        console.log('AJAX Response:', data);

                        if (data.teams && data.teams.length > 0) {
                            // Populate teams into the dropdowns
                            data.teams.forEach(team => {
                                const option1 = document.createElement('option');
                                option1.value = team.id;
                                option1.textContent = team.name;
                                
                                // Set as selected if matches old value
                                if (team.id == oldTeam1) {
                                    option1.selected = true;
                                }
                                team1Select.appendChild(option1);

                                const option2 = document.createElement('option');
                                option2.value = team.id;
                                option2.textContent = team.name;

                                // Set as selected if matches old value
                                if (team.id == oldTeam2) {
                                    option2.selected = true;
                                }
                                team2Select.appendChild(option2);
                            });
                        } else {
                            // If no teams available, show message
                            team1Select.innerHTML = '<option value="">No Teams Available</option>';
                            team2Select.innerHTML = '<option value="">No Teams Available</option>';
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        alert('Failed to fetch teams.');

                        // Reset dropdowns on error
                        team1Select.innerHTML = '<option value="">Select Team 1</option>';
                        team2Select.innerHTML = '<option value="">Select Team 2</option>';
                    }
                });
            }
        }

        function filterTeams() {
            const selectedTeam1 = team1Select.value;
            const selectedTeam2 = team2Select.value;

            // Filter options for team2 based on team1 selection
            Array.from(team2Select.options).forEach(option => {
                option.style.display = (option.value === selectedTeam1 && selectedTeam1) ? 'none' : 'block';
            });

            // Filter options for team1 based on team2 selection
            Array.from(team1Select.options).forEach(option => {
                option.style.display = (option.value === selectedTeam2 && selectedTeam2) ? 'none' : 'block';
            });
        }

        function filterColors() {
            const selectedColor1 = team1ColorSelect.value;
            const selectedColor2 = team2ColorSelect.value;

            // Filter options for team2 based on team1 selection
            Array.from(team2ColorSelect.options).forEach(option => {
                option.style.display = (option.value === selectedColor1 && selectedColor1) ? 'none' : 'block';
            });

            // Filter options for team1 based on team2 selection
            Array.from(team1ColorSelect.options).forEach(option => {
                option.style.display = (option.value === selectedColor2 && selectedColor2) ? 'none' : 'block';
            });
        }

        team1ColorSelect.addEventListener("change", filterColors);
        team2ColorSelect.addEventListener("change", filterColors);

        tournamentSelect.addEventListener('change', function() {
            updateCategoryVisibility();
            updateTeams();
        });

        categorySelect.addEventListener('change', function() {
            updateTeams();
        });

        team1Select.addEventListener('change', filterTeams);
        team2Select.addEventListener('change', filterTeams);

        // Initialize visibility and teams on page load
        updateCategoryVisibility();
        updateTeams();
        filterColors();
    });
    </script>
    </x-slot>
    
</x-app-layout>