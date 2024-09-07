<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Teams / Edit
            </h2>
            <a href="{{ route('teams.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('teams.update', $team->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- or PATCH, depending on your routes setup -->
                        <div>
                            <label for="tournament_id" class="text-lg font-medium">Tournament</label>
                            <div class="my-3">
                                <select name="tournament_id" id="tournament_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Tournament</option>
                                    @foreach($tournaments as $tournament)
                                        <option value="{{ $tournament->id }}" data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}" {{ $tournament->id == $team->tournament_id ? 'selected' : '' }}>
                                            {{ $tournament->name }}
                                        </option>                                    
                                    @endforeach
                                </select>
                                @error('tournament_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="category-field" style="display: {{ $team->tournament->has_categories ? 'block' : 'none' }};">
                                <label for="category" class="text-lg font-medium">Category</label>
                                <div class="my-3">
                                    <select name="category" id="category" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                        <option value="">Select a Category</option>
                                        <option value="Juniors" {{ $team->category == 'Juniors' ? 'selected' : '' }}>Juniors</option>
                                        <option value="Seniors" {{ $team->category == 'Seniors' ? 'selected' : '' }}>Seniors</option>
                                    </select>
                                    @error('category')
                                        <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <label for="name" class="text-lg font-medium">Team Name</label>
                            <div class="my-3">
                                <input value="{{ old('name', $team->name) }}" name="name" placeholder="Enter Team Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="team_acronym" class="text-lg font-medium">Team Acronym</label>
                            <div class="my-3">
                                <input value="{{ old('team_acronym', $team->team_acronym) }}" name="team_acronym" placeholder="Enter Shortened Team Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('team_acronym')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="head_coach_name" class="text-lg font-medium">Team Head Coach</label>
                            <div class="my-3">
                                <input value="{{ old('head_coach_name', $team->head_coach_name) }}" name="head_coach_name" placeholder="Enter Coach Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('head_coach_name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="school_president" class="text-lg font-medium">School President</label>
                            <div class="my-3">
                                <input value="{{ old('school_president', $team->school_president) }}" name="school_president" placeholder="Enter School President Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('school_president')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="sports_director" class="text-lg font-medium">Sports Director</label>
                            <div class="my-3">
                                <input value="{{ old('sports_director', $team->sports_director) }}" name="sports_director" placeholder="Enter Sports Director Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('sports_director')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="years_playing_in_bucal" class="text-lg font-medium">Years Playing in BUCAL</label>
                            <div class="my-3">
                                <input value="{{ old('years_playing_in_bucal', $team->years_playing_in_bucal) }}" name="years_playing_in_bucal" placeholder="Enter the number of years playing in BUCAL" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('years_playing_in_bucal"')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="address" class="text-lg font-medium">Address</label>
                            <div class="my-3">
                                <input value="{{ old('address', $team->address) }}" name="address" placeholder="Enter Address" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('address')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="logo" class="text-lg font-medium">Team Logo</label>
                            <div class="my-3">
                                @if ($team->logo)
                                    <img src="{{ asset('storage/' . $team->logo) }}" alt="Current Team Logo" class="w-24 h-24 object-cover mb-2">
                                @else
                                    <p>No Logo</p>
                                @endif
                                <input type="file" id="logo" name="logo" class="border-gray-300 shadow-sm rounded-lg">
                                <img id="logo-preview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-width: 200px; max-height: 200px;">
                                @error('logo')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('tournament_id').addEventListener('change', function(event) {
            var selectedOption = event.target.selectedOptions[0];
            var hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';
            var categoryField = document.getElementById('category-field');

            if (hasCategories) {
                categoryField.style.display = 'block'; // Show category field
            } else {
                categoryField.style.display = 'none'; // Hide category field
            }
        });

        document.getElementById('logo').addEventListener('change', function(event) {
            var reader = new FileReader();
            var file = event.target.files[0];
            var preview = document.getElementById('logo-preview');

            if (file) {
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show the image preview
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none'; // Hide the image preview
            }
        });

        // Initialize category field visibility based on the current tournament
        document.addEventListener('DOMContentLoaded', function() {
            var tournamentSelect = document.getElementById('tournament_id');
            var selectedOption = tournamentSelect.querySelector('option[selected]');
            var hasCategories = selectedOption ? selectedOption.getAttribute('data-has-categories') === 'true' : false;
            var categoryField = document.getElementById('category-field');

            if (hasCategories) {
                categoryField.style.display = 'block'; // Show category field if tournament has categories
            } else {
                categoryField.style.display = 'none'; // Hide category field if tournament does not have categories
            }
        });
    </script>
</x-app-layout>
