<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Game Schedules') }}
            </h2>
            @can('edit schedules')
            <a href="{{ route('schedules.create') }}" class="bg-slate-700 text-base rounded-md text-white px-3 py-2">Create</a>
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
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xl font-semibold">{{ \Carbon\Carbon::parse($schedule->date)->format('d M, Y') }} at {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}</p>
                                <p class="text-base text-gray-500">{{ $schedule->venue }}</p>
                                <p class="text-lg mt-2">{{ $schedule->team1->name }} <span class="font-bold">vs</span> {{ $schedule->team2->name }}</p>
                            </div>

                            @can('edit schedule')
                                <div class="flex space-x-2">
                                    <a href="{{ route('schedules.edit', $schedule->id) }}" class="bg-slate-700 text-base rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                    <a href="javascript:void(0);" onclick="deleteschedule({{ $schedule->id }})" class="bg-red-600 text-base rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                                    <a href="{{ route('playerstats.create', ['schedule_id' => $schedule->id]) }}" class="bg-blue-600 text-base rounded-md text-white px-3 py-2 hover:bg-blue-500">Manage Game</a>
                                </div>
                            @endcan
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

    <x-slot name="script">
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
        </script>
    </x-slot>
</x-app-layout>
