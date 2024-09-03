<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schedule / Create
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
                        <div>
                            <!-- Tournament -->
                            <label for="tournament_id" class="text-lg font-medium">Tournament</label>
                            <div class="my-3">
                                <select name="tournament_id" id="tournament_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Tournament</option>
                                    @foreach($tournaments as $tournament)
                                        <option value="{{ $tournament->id }}" {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}>
                                            {{ $tournament->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tournament_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Match Date and Time -->
                            <label for="match_date" class="text-lg font-medium">Match Date and Time</label>
                            <div class="my-3">
                                <input type="datetime-local" id="match_date" name="match_date" value="{{ old('match_date') }}" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('match_date')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Venue -->
                            <label for="venue" class="text-lg font-medium">Venue</label>
                            <div class="my-3">
                                <input type="text" id="venue" name="venue" placeholder="Enter Match Venue" value="{{ old('venue') }}" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('venue')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Team 1 -->
                            <label for="team1_id" class="text-lg font-medium">Team 1</label>
                            <div class="my-3">
                                <select name="team1_id" id="team1_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select Team 1</option>
                                </select>
                                @error('team1_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Team 2 -->
                            <label for="team2_id" class="text-lg font-medium">Team 2</label>
                            <div class="my-3">
                                <select name="team2_id" id="team2_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select Team 2</option>
                                </select>
                                @error('team2_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3 mt-5">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tournamentSelect = document.getElementById('tournament_id');
            const team1Select = document.getElementById('team1_id');
            const team2Select = document.getElementById('team2_id');
    
            tournamentSelect.addEventListener('change', function() {
                const tournamentId = this.value;
    
                // Clear current options
                team1Select.innerHTML = '<option value="">Select Team 1</option>';
                team2Select.innerHTML = '<option value="">Select Team 2</option>';
    
                if (tournamentId) {
                    fetch(`{{ route('teams.by_tournament') }}?tournament_id=${tournamentId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.teams.forEach(team => {
                                const option = new Option(team.name, team.id);
                                team1Select.add(option.cloneNode(true));
                                team2Select.add(option.cloneNode(true));
                            });
                        })
                        .catch(() => {
                            team1Select.add(new Option('Failed to load teams', ''));
                            team2Select.add(new Option('Failed to load teams', ''));
                        });
                }
            });
        });
    </script>
    
</x-app-layout>
