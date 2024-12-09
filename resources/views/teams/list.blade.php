<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Teams') }}
            </h2>
            @can('edit teams')
            <button id="create-team" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">
                Create
            </button>            
            @endcan
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="mb-4">
                <form method="GET" action="{{ route('teams.index') }}">
                    <label for="tournament" class="block text-sm font-medium text-gray-700">Select Tournament</label>
                    <select id="tournament" name="tournament_id" class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All Tournaments</option>
                        @foreach($tournaments as $tournament)
                            <option value="{{ $tournament->id }}" {{ request('tournament_id') == $tournament->id ? 'selected' : '' }} data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}" 
                                data-tournament-type="{{ $tournament->tournament_type }}">
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            
            <div class="mb-4" id="category-selection" style="display: {{ request('tournament_id') && $tournaments->where('id', request('tournament_id'))->first()->has_categories ? 'block' : 'none' }};">
                <form method="GET" action="{{ route('teams.index') }}">
                    <input type="hidden" name="tournament_id" value="{{ request('tournament_id') }}">
                    <label for="category" class="block text-sm font-medium text-gray-700">Select Category</label>
                    <select id="category" name="category" class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <option value="juniors" {{ request('category') == 'juniors' ? 'selected' : '' }}>Juniors</option>
                        <option value="seniors" {{ request('category') == 'seniors' ? 'selected' : '' }}>Seniors</option>
                    </select>
                </form>
            </div>            
            
            <div class="overflow-x-auto">
                <table id="teams-table" class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b">
                            {{-- <th class="px-6 py-3 text-left" width="60">#</th> --}}
                            <th class="px-6 py-3 text-left">Team Logo</th>
                            <th class="px-6 py-3 text-left">Team Name</th>
                            <th class="px-6 py-3 text-left">Head Coach</th>
                            <th class="px-6 py-3 text-left school-field">School President</th>
                            <th class="px-6 py-3 text-left school-field">Sports Director</th>
                            <th class="px-6 py-3 text-left school-field">Years in BUCAL</th>
                            <th class="px-6 py-3 text-left">Address</th>
                            @can('edit teams')
                            <th class="px-6 py-3 text-left" width="180">Created</th>
                            <th class="px-6 py-3 text-center" width="180">Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @if ($teams->isNotEmpty())
                        @foreach ($teams as $team)
                        <tr class="border-b">
                            {{-- <td class="px-6 py-3 text-left">
                                {{ $team->id }}
                            </td> --}}
                            <td class="px-6 py-3 text-left">
                                @if ($team->logo)
                                    <img src="{{ asset('storage/' . $team->logo) }}" alt="Team Logo" class="w-32 h-32 object-contain">
                                @else
                                    No Logo
                                @endif
                            </td>
                            <td class="px-6 py-3 text-left">
                                {{ $team->name }}
                            </td>
                            <td class="px-6 py-3 text-left">
                                {{ $team->head_coach_name }}
                            </td>
                            <td class="px-6 py-3 text-left school-field">
                                {{ $team->school_president }}
                            </td>
                            <td class="px-6 py-3 text-left school-field">
                                {{ $team->sports_director }}
                            </td>
                            <td class="px-6 py-3 text-left school-field">
                                {{ $team->years_playing_in_bucal }}
                            </td>
                            <td class="px-6 py-3 text-left">
                                {{ $team->address }}
                            </td>
                            @can ('edit teams')
                            <td class="px-6 py-3 text-left">
                                {{ \Carbon\Carbon::parse($team->created_at)->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex flex-col sm:flex-row sm:justify-center space-y-2 sm:space-y-0 sm:space-x-2">
                                    <a href="{{ route('teams.edit', $team->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">
                                        Edit
                                    </a>
                                    <a href="javascript:void(0);" onclick="deleteteam({{ $team->id }})" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">
                                        Delete
                                    </a>
                                </div>
                            </td>                            
                            @endcan
                        </tr>    
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="my-3">
                    {{ $teams->links() }}
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
            const tournamentSelect = document.getElementById('tournament');
            const categorySelect = document.getElementById('category-selection');
            const schoolFields = document.querySelectorAll('.school-field'); 

            function updateCategoryVisibility() {
                const selectedOption = tournamentSelect.selectedOptions[0];
                const hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';
                const tournamentType = selectedOption.dataset.tournamentType; 

                // Show or hide category selection based on tournament type
                if (hasCategories) {
                    categorySelect.style.display = 'block';
                } else {
                    categorySelect.style.display = 'none';
                }

                // Hide or show school-specific fields if the selected tournament is "school"
                if (tournamentType === 'school') {
                    schoolFields.forEach(function(field) {
                        field.style.display = 'table-cell'; // Hide fields for school tournaments
                    });
                } else {
                    schoolFields.forEach(function(field) {
                        field.style.display = 'none'; // Show fields for other tournament types
                    });
                }
            }

            tournamentSelect.addEventListener('change', function() {
                updateCategoryVisibility();
                this.form.submit(); // Submit form after changing tournament
            });

            updateCategoryVisibility(); // Initial check on page load
            });

            function deleteteam(id){
                if(confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url : '{{ route("teams.destroy") }}',
                        type: 'delete',
                        data: {id:id},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token' : '{{ csrf_token() }}'
                        },
                        success: function(response){
                            window.location.href = '{{ route("teams.index") }}';
                        }
                    });
                }
            }

        document.getElementById('create-team').addEventListener('click', function () {
            Swal.fire({
                title: 'Create Team',
                text: 'Choose how you want to create a team:',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Create Team via Upload',
                cancelButtonText: 'Create Team Manually',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the route for team creation via upload 
                    window.location.href = "{{ route('teams.bulkUploadForm') }}";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Redirect to the route for manual team creation
                    window.location.href = "{{ route('teams.create') }}";
                }
            });
        });

        </script>        
    </x-slot>
</x-app-layout>
