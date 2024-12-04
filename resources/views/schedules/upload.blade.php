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
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <!-- SweetAlert Error Notification -->
                    @if(session('error'))
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: "{{ session('error') }}",
                            icon: 'error',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-[#314795] text-white px-4 py-2 rounded'
                            },
                            buttonsStyling: false 
                        });
                    </script>
                    @endif
                    <form action="{{ route('schedules.bulkUpload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Tournament Selection -->
                        <label for="tournament_id" class="text-lg font-medium">Tournament</label>
                        <div class="my-3">
                            <select name="tournament_id" id="tournament_id" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
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

                        <!-- Upload Section -->
                        <div id="upload-section" class="hidden">
                            <label class="text-lg font-medium">Download the excel template below:</label>
                            <br><br>
                            <a id="template-download" href="#" class="bg-[#314795] text-white p-2 rounded transition-transform transform hover:scale-105 focus:outline-none">
                                Download Template
                            </a>
                            
                            <div class="mt-8">
                                <label class="text-lg font-medium">Upload the CSV or Excel file containing schedule data:</label> 
                                <div class="my-3 flex items-center">
                                    <input type="file" name="file" id="bulk-upload" class="border-gray-300 shadow-sm rounded-lg" required>
                                </div>
                                @error('file')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-green-600 text-sm rounded-md text-white px-5 py-2 mt-4">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tournamentSelect = document.getElementById('tournament_id');
        const uploadSection = document.getElementById('upload-section');
        const templateDownloadLink = document.getElementById('template-download');

        // Define routes dynamically using Laravel Blade
        const schoolTemplateRoute = "{{ route('schedules.template.download.school') }}";
        const nonSchoolTemplateRoute = "{{ route('schedules.template.download.nonSchool') }}";

        // Function to handle visibility and update download link
        const updateVisibility = () => {
            const selectedOption = tournamentSelect.options[tournamentSelect.selectedIndex];
            const tournamentType = selectedOption?.getAttribute('data-tournament-type'); 

            if (tournamentType === 'school') {
                uploadSection.classList.remove('hidden');
                templateDownloadLink.href = schoolTemplateRoute;
            } else if (tournamentType === 'non-school') {
                uploadSection.classList.remove('hidden');
                templateDownloadLink.href = nonSchoolTemplateRoute;
            } else {
                uploadSection.classList.add('hidden');
                templateDownloadLink.href = '#';
            }
        };

        // Run on page load to restore state
        updateVisibility();

        // Run on change to handle user selection
        tournamentSelect.addEventListener('change', updateVisibility);
    });
</script>

</x-app-layout>