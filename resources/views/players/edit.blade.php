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
                    <form action="{{ route('players.update', $player->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="team_id" class="text-lg font-medium">Team</label>
                            <div class="my-3">
                                <select name="team_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ $player->team_id == $team->id ? 'selected' : '' }}>
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
                                <input value="{{ old('first_name', $player->first_name) }}" name="first_name" placeholder="Enter Player First Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('first_name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="last_name" class="text-lg font-medium">Last Name</label>
                            <div class="my-3">
                                <input value="{{ old('last_name', $player->last_name) }}" name="last_name" placeholder="Enter Player Last Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('last_name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="number" class="text-lg font-medium">Jersey Number</label>
                            <div class="my-3">
                                <input value="{{ old('number', $player->number) }}" name="number" placeholder="Enter Player Jersey Number" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('number')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="position" class="text-lg font-medium">Position</label>
                            <div class="my-3">
                                <select name="position" id="position" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
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

                            <label for="date_of_birth" class="text-lg font-medium">Date of Birth</label>
                            <div class="my-3">
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $player->date_of_birth ? \Carbon\Carbon::parse($player->date_of_birth)->format('Y-m-d') : '') }}" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('date_of_birth')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <label for="height" class="text-lg font-medium">Height (cm)</label>
                            <div class="my-3">
                                <input value="{{ old('height', $player->height) }}" name="height" placeholder="Enter Height" type="number" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('height')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="weight" class="text-lg font-medium">Weight (kg)</label>
                            <div class="my-3">
                                <input value="{{ old('weight', $player->weight) }}" name="weight" placeholder="Enter Weight" type="number" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('weight')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3 mt-5">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>