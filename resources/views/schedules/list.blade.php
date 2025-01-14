@php
function getInitials($teamName) {
    return collect(explode(' ', $teamName))
        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');
}
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Game Schedules') }}
            </h2>
            @can('edit schedules')
                <button id="create-schedule" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">
                    Create
                </button> 
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="mb-4">
                <form method="GET" action="{{ route('schedules.index') }}">
                    <select id="tournament" name="tournament_id" class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-lg border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-lg rounded-md">
                        <option value="">All Tournaments</option>
                        @foreach($tournaments as $tournament)
                            <option value="{{ $tournament->id }}" {{ request('tournament_id') == $tournament->id ? 'selected' : '' }} data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}">
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="mb-4" id="category-selection" style="display: {{ request('tournament_id') && $tournaments->where('id', request('tournament_id'))->first()->has_categories ? 'block' : 'none' }};">
                        <select id="category" name="category" class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-lg border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-lg rounded-md">
                            <option value="">All Categories</option>
                            <option value="juniors" {{ request('category') == 'juniors' ? 'selected' : '' }}>Juniors</option>
                            <option value="seniors" {{ request('category') == 'seniors' ? 'selected' : '' }}>Seniors</option>
                        </select>
                    </div>
                </form>
            </div>

            @if ($schedules->isNotEmpty())
                @foreach ($schedules as $schedule)

                <div class="bg-white shadow-md rounded-lg mb-4 p-6">
                    <!-- Parent Container -->
                    <div class="flex flex-col sm:flex-row justify-between">
                        <!-- Schedule Details -->
                        <div class="flex-1">
                            <p class="text-lg sm:text-xl font-semibold">
                                {{ \Carbon\Carbon::parse($schedule->date)->format('M d, Y') }} at 
                                {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}
                            </p>
                            <p class="text-sm sm:text-base text-gray-500">
                                {{ $schedule->venue }}
                            </p>
                            {{ $schedule->team1->name }}{{ $schedule->team1_color ? " (" . ucfirst($schedule->team1_color) . ")" : '' }} 
                            <span class="font-bold">vs</span> 
                            {{ $schedule->team2->name }}{{ $schedule->team2_color ? " (" . ucfirst($schedule->team2_color) . ")" : '' }}
                        </div>
                
                        <!-- Scores Box -->
                        <div class="mt-6 sm:mt-0 flex justify-end sm:justify-start">
                            <div class="bg-gray-100 border border-gray-300 rounded-lg p-2 w-full max-w-sm">
                                <div class="text-center">
                                    <div class="grid grid-cols-6 gap-1">
                                        <!-- Team Names Column -->
                                        <div class="font-bold"></div> <!-- Empty for Quarter Labels Alignment -->
                                        <div class="font-bold">1</div>
                                        <div class="font-bold">2</div>
                                        <div class="font-bold">3</div>
                                        <div class="font-bold">4</div>
                                        <div class="font-bold">Final</div>
                        
                                        <!-- Team 1 Initials -->
                                        <div class="team-initials">{{ getInitials($schedule->team1->name) }}</div>
                                        <div>{{ $schedule->scores->where('quarter', 1)->where('team_id', $schedule->team1->id)->sum('score') }}</div>
                                        <div>{{ $schedule->scores->where('quarter', 2)->where('team_id', $schedule->team1->id)->sum('score') }}</div>
                                        <div>{{ $schedule->scores->where('quarter', 3)->where('team_id', $schedule->team1->id)->sum('score') }}</div>
                                        <div>{{ $schedule->scores->where('quarter', 4)->where('team_id', $schedule->team1->id)->sum('score') }}</div>
                                        <div>{{ $schedule->scores->where('team_id', $schedule->team1->id)->sum('score') }}</div> <!-- Total for Team 1 -->
                        
                                        <!-- Team 2 Initials -->
                                        <div class="team-initials">{{ getInitials($schedule->team2->name) }}</div>
                                        <div>{{ $schedule->scores->where('quarter', 1)->where('team_id', $schedule->team2->id)->sum('score') }}</div>
                                        <div>{{ $schedule->scores->where('quarter', 2)->where('team_id', $schedule->team2->id)->sum('score') }}</div>
                                        <div>{{ $schedule->scores->where('quarter', 3)->where('team_id', $schedule->team2->id)->sum('score') }}</div>
                                        <div>{{ $schedule->scores->where('quarter', 4)->where('team_id', $schedule->team2->id)->sum('score') }}</div>
                                        <div>{{ $schedule->scores->where('team_id', $schedule->team2->id)->sum('score') }}</div> <!-- Total for Team 2 -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                
                    <div class="flex flex-wrap justify-between items-center mt-2">
                        <!-- Action Buttons -->
                        <div class="flex space-x-2 mt-4 mb-2 sm:-mt-4 justify-center sm:justify-start">
                            @can('edit schedules')
                            <a href="{{ route('schedules.edit', $schedule->id) }}" class="bg-slate-700 text-base rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                            <a href="javascript:void(0);" onclick="deleteschedule({{ $schedule->id }})" class="bg-red-600 text-base rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                            @endcan
                            @can('manage statistics')
                            @if (!$schedule->is_completed)
                            <a href="{{ route('playerstats.create', ['schedule_id' => $schedule->id]) }}" class="bg-blue-600 text-base rounded-md text-white px-3 py-2 hover:bg-blue-500">
                                Manage Game
                            </a>
                            @endif
                            @endcan
                        </div>
                    
                        <!-- View Box Score -->
                        <a href="{{ route('playerstats.index', ['schedule_id' => $schedule->id, 'team1_id' => $schedule->team1_id, 'team2_id' => $schedule->team2_id]) }}" 
                            class="bg-blue-600 text-white text-sm font-medium rounded-md px-4 py-2 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 sm:mr-48 sm:text-right inline-block text-left mt-2 sm:mt-0 transition">
                            View Box Score
                        </a>             
                    </div>
                
                </div>
                
                @endforeach
            @else
                <p class="text-lg text-gray-600">No schedules available.</p>
            @endif

            <div class="my-3">
                {{ $schedules->links() }}
            </div>
        </div>
    </div>

    <style>
        .team-initials {
            width: 3rem; 
            height: 2rem; 
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 0.25rem; 
        }
    </style>
    

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const tournamentSelect = document.getElementById('tournament');
                const categorySelect = document.getElementById('category');
                const categorySelection = document.getElementById('category-selection');

                function updateCategoryVisibility() {
                    const selectedOption = tournamentSelect.selectedOptions[0];
                    const hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';

                    categorySelection.style.display = hasCategories ? 'block' : 'none';
                }

                // Initial setup on page load
                updateCategoryVisibility();

                tournamentSelect.addEventListener('change', function() {
                    updateCategoryVisibility();
                    this.form.submit(); // Submit the form on change
                });

                categorySelect.addEventListener('change', function() {
                    this.form.submit(); // Submit the form on change
                });
            });

            function deleteschedule(id) {
                if (confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: '{{ route("schedules.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.href = '{{ route("schedules.index") }}';
                        }
                    });
                }
            }

            document.getElementById('create-schedule').addEventListener('click', function () {
            Swal.fire({
                title: 'Create Schedule',
                text: 'Choose how you want to create a schedule:',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Create Schedule via Upload',
                cancelButtonText: 'Create Schedule Manually',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the route for team creation via upload 
                    window.location.href = "{{ route('schedules.bulkUploadForm') }}";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Redirect to the route for manual team creation
                    window.location.href = "{{ route('schedules.create') }}";
                }
            });
        });

        </script>
    </x-slot>
</x-app-layout>
