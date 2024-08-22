<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Teams / Create
            </h2>
            <a href="{{ route('teams.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route ('teams.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Team Name</label>
                            <div class="my-3">
                                <input value="{{ old('name') }}"name="name" placeholder="Enter Team Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="team_acronym" class="text-lg font-medium">Team Acronym</label>
                            <div class="my-3">
                                <input value="{{ old('team_acronym') }}"name="team_acronym" placeholder="Enter Shortened Team Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('team_acronym')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="coach_name" class="text-lg font-medium">Team Coach</label>
                            <div class="my-3">
                                <input value="{{ old('coach_name') }}" name="coach_name" placeholder="Enter Coach Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('coach_name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="assistant_coach_1" class="text-lg font-medium">Team Assistant Coach</label>
                            <div class="my-3">
                                <input value="{{ old('assistant_coach_1') }}" name="assistant_coach_1" placeholder="Enter Assistant Coach Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('assistant_coach_1')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="assistant_coach_2" class="text-lg font-medium">Team Assistant Coach</label>
                            <div class="my-3">
                                <input value="{{ old('assistant_coach_2') }}" name="assistant_coach_2" placeholder="Enter Assistant Coach Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('assistant_coach_2')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="address" class="text-lg font-medium">Address</label>
                            <div class="my-3">
                                <input value="{{ old('address') }}" name="address" placeholder="Enter Address" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('address')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="logo" class="text-lg font-medium">Team Logo</label>
                            <div class="my-3">
                                <input value="{{ old('logo') }}" type="file" id="logo" name="logo" class="border-gray-300 shadow-sm rounded-lg">
                                <img id="logo-preview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-width: 200px; max-height: 200px;">
                                @error('logo')
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
    <script>
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
    </script>
</x-app-layout>
