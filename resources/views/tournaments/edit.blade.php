<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tournaments / Edit
            </h2>
            <a href="{{ route('tournaments.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route ('tournaments.update',$tournament->id) }}" method="post">
                        @csrf
                        <div>
                            <label for="name" class="text-lg font-medium">Tournament Name</label>
                            <div class="my-3">
                                <input value="{{ old('name', $tournament->name) }}" name="name" placeholder="Enter Tournament Name" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="description" class="text-lg font-medium">Tournament Description</label>
                            <div class="my-3">
                                <textarea name="description" placeholder="Enter Tournament Description" 
                                        class="border-gray-300 shadow-sm rounded-lg"
                                        style="width: 50ch; height: 6rem; resize: none;">
                                    {{ old('description', $tournament->description) }}
                                </textarea>
                                @error('description')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>


                            <label for="start_date" class="text-lg font-medium">Start Date</label>
                            <div class="my-3">
                                <input value="{{ old('start_date', $tournament->start_date) }}" name="start_date" placeholder="YYYY-MM-DD" type="date" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('start_date')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="end_date" class="text-lg font-medium">End Date</label>
                            <div class="my-3">
                                <input value="{{ old('end_date', $tournament->end_date) }}" name="end_date" placeholder="YYYY-MM-DD" type="date" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                                @error('end_date')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label class="text-lg font-medium">Will there be categories in the tournament?</label>
                            <div class="my-3 flex items-center space-x-4">
                                <div class="flex items-center">
                                    <input type="radio" id="has_categories_yes" name="has_categories" value="1" 
                                        {{ old('has_categories', (string) $tournament->has_categories) === '1' ? 'checked' : '' }}>
                                    <label for="has_categories_yes" class="ml-2">Yes</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="has_categories_no" name="has_categories" value="0" 
                                        {{ old('has_categories', (string) $tournament->has_categories) === '0' ? 'checked' : '' }}>
                                    <label for="has_categories_no" class="ml-2">No</label>
                                </div>
                                @error('has_categories')
                                    <p class="text-red-400 font-medium mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
