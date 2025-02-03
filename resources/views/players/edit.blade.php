<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Player
            </h2>
            <a href="{{ route('players.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('players.update', $player->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <!-- Tournament (Editable but not submitted) -->
                        <div>
                            <label for="tournament_id" class="text-lg font-medium">Tournament</label>
                            <div class="my-3">
                                <select id="tournament_id" name="tournament_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Tournament</option>
                                    @foreach($tournaments as $tournament)
                                        <option value="{{ $tournament->id }}"
                                                data-tournament-type="{{ $tournament->tournament_type }}"
                                                data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}"
                                                {{ $player->team && $player->team->tournament_id == $tournament->id ? 'selected' : '' }}>
                                            {{ $tournament->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                            <div id="category-selection" style="display: {{ $player->team && $player->team->tournament->has_categories ? 'block' : 'none' }};">
                                <label for="category" class="text-lg font-medium">Category</label>
                                <div class="my-3">
                                    <select id="category" name="category" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                        <option value="">Select a Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('category', $player->category) == $category ? 'selected' : '' }}>
                                                {{ ucfirst($category) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <label for="team_id" class="text-lg font-medium">Team</label>
                            <div class="my-3">
                                <select id="team_id" name="team_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('team_id', $player->team_id) == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>                                
                                @error('team_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="first_name" class="text-lg font-medium">First Name</label>
                            <div class="my-3">
                                <input id="first_name" value="{{ old('first_name', $player->first_name) }}" name="first_name" placeholder="Enter Player First Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('first_name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="last_name" class="text-lg font-medium">Last Name</label>
                            <div class="my-3">
                                <input id="last_name" value="{{ old('last_name', $player->last_name) }}" name="last_name" placeholder="Enter Player Last Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('last_name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="number" class="text-lg font-medium">Jersey Number</label>
                            <div class="my-3">
                                <input id="number" value="{{ old('number', $player->number) }}" name="number" placeholder="Enter Player Jersey Number" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('number')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="school-fields" style="display: none;">
                                <label for="years_playing_in_bucal" class="text-lg font-medium">Years Playing in BUCAL</label>
                                <div class="my-3">
                                    <input value="{{ old('years_playing_in_bucal', $player->years_playing_in_bucal) }}" name="years_playing_in_bucal" placeholder="Enter the number of years playing in BUCAL" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    @error('years_playing_in_bucal')
                                        <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                            <label for="position" class="text-lg font-medium">Position</label>
                            <div class="my-3">
                                <select id="position" name="position" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="" disabled>Select Player Position</option>
                                    <option value="Point Guard" {{ old('position', $player->position) == 'Point Guard' ? 'selected' : '' }}>Point Guard (PG)</option>
                                    <option value="Shooting Guard" {{ old('position', $player->position) == 'Shooting Guard' ? 'selected' : '' }}>Shooting Guard (SG)</option>
                                    <option value="Small Forward" {{ old('position', $player->position) == 'Small Forward' ? 'selected' : '' }}>Small Forward (SF)</option>
                                    <option value="Power Forward" {{ old('position', $player->position) == 'Power Forward' ? 'selected' : '' }}>Power Forward (PF)</option>
                                    <option value="Center" {{ old('position', $player->position) == 'Center' ? 'selected' : '' }}>Center (C)</option>
                                </select>
                                @error('position')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            </div>

                            <label for="date_of_birth" class="text-lg font-medium">Date of Birth</label>
                            <div class="my-3">
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $player->date_of_birth ? \Carbon\Carbon::parse($player->date_of_birth)->format('Y-m-d') : '') }}" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('date_of_birth')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <label for="height" class="text-lg font-medium">Height</label>
                            <div class="my-3">
                                <input id="height" value="{{ old('height', $player->height) }}" name="height" placeholder="Enter Height (e.g., 5'7)" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('height')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="weight" class="text-lg font-medium">Weight (kg)</label>
                            <div class="my-3">
                                <input id="weight" value="{{ old('weight', $player->weight) }}" name="weight" placeholder="Enter Weight" type="number" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('weight')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3 mt-5">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const tournamentSelect = document.getElementById('tournament_id');
                const categorySelect = document.getElementById('category');
                const categorySelectionDiv = document.getElementById('category-selection');
                const teamSelect = document.getElementById('team_id');
                const schoolFieldsDiv = document.getElementById('school-fields');
        
                // Function to update the visibility of the category dropdown
                function updateCategoryVisibility() {
                    const selectedOption = tournamentSelect.selectedOptions[0];
                    const hasCategories = selectedOption ? selectedOption.getAttribute('data-has-categories') === 'true' : false;
        
                    if (hasCategories) {
                        categorySelectionDiv.style.display = 'block';
                    } else {
                        categorySelectionDiv.style.display = 'none';
                        categorySelect.selectedIndex = 0; // Reset category selection
                    }
                }
        
                // Function to fetch and populate teams based on tournament and category
                function updateTeams() {
                    const tournamentId = tournamentSelect.value;
                    const category = categorySelect.value;
        
                    // Reset teams dropdown
                    teamSelect.innerHTML = '<option value="">Select a Team</option>';
        
                    if (tournamentId) {
                        $.ajax({
                            url: '{{ route('teams.by_tournament') }}',
                            type: 'GET',
                            data: {
                                tournament_id: tournamentId,
                                category: category // Pass selected category
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log('Teams data:', data);
        
                                if (data.teams && data.teams.length > 0) {
                                    data.teams.forEach(team => {
                                        const option = document.createElement('option');
                                        option.value = team.id;
                                        option.textContent = team.name;
        
                                        // Preserve the previously selected team
                                        if (team.id == {{ $player->team_id }}) {
                                            option.selected = true;
                                        }
        
                                        teamSelect.appendChild(option);
                                    });
                                } else {
                                    teamSelect.innerHTML = '<option value="">No Teams Available</option>';
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('AJAX Error:', textStatus, errorThrown);
                                alert('Failed to fetch teams.');
                            }
                        });
                    }
                }
        
                // Function to update the visibility of school fields
                function updateSchoolFields() {
                    var schoolFields = document.getElementById('school-fields');
                    const selectedOption = tournamentSelect.selectedOptions[0];
                    var tournamentType = selectedOption ? selectedOption.getAttribute('data-tournament-type') : '';
        
                    schoolFields.style.display = (tournamentType === 'school') ? 'block' : 'none';
                }
        
                // Event listeners for tournament and category dropdowns
                tournamentSelect.addEventListener('change', function() {
                    updateCategoryVisibility();
                    updateTeams();
                    updateSchoolFields();
                });
        
                categorySelect.addEventListener('change', function() {
                    updateTeams(); // Update teams when category changes
                });
        
                // Initialize visibility and populate teams on page load
                updateCategoryVisibility();
                updateTeams();
                updateSchoolFields();
            });
        </script>        
    </x-slot>
    
</x-app-layout>
