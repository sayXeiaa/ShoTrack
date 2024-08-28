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
                    <form action="{{ route ('players.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="team_id" class="text-lg font-medium">Team</label>
                            <div class="my-3">
                                <select name="team_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                    <option value="">Select a Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>                                
                                @error('team_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="name" class="text-lg font-medium">First Name</label>
                            <div class="my-3">
                                <input value="{{ old('first_name') }}" name="first_name" placeholder="Enter Player First Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('first_name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="name" class="text-lg font-medium">Last Name</label>
                            <div class="my-3">
                                <input value="{{ old('last_name') }}" name="last_name" placeholder="Enter Player Last Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('last_name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="name" class="text-lg font-medium">Jersey Number</label>
                            <div class="my-3">
                                <input value="{{ old('number') }}" name="number" placeholder="Enter Player Jersey Number" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('number')
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

                            <label for="date_of_birth" class="text-lg font-medium">Date of Birth</label>
                            <div class="my-3">
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('date_of_birth')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <label for="height" class="text-lg font-medium">Height</label>
                            <div class="my-3">
                                <input value="{{ old('height') }}" name="height" placeholder="Enter Height in cm" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
