<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Game Schedules') }}
            </h2>
            <a href="{{ route('schedules.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="mb-4">
                <form method="GET" action="{{ route('schedules.index') }}">
                    <label for="tournament" class="block text-sm font-medium text-gray-700">Select Tournament</label>
                    <select id="tournament" name="tournament_id" class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">All Tournaments</option>
                        @foreach($tournaments as $tournament)
                            <option value="{{ $tournament->id }}" {{ request('tournament_id') == $tournament->id ? 'selected' : '' }} data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}">
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="mb-4" id="category-selection" style="display: {{ request('tournament_id') && $tournaments->where('id', request('tournament_id'))->first()->has_categories ? 'block' : 'none' }};">
                        <label for="category" class="block text-sm font-medium text-gray-700">Select Category</label>
                        <select id="category" name="category" class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Categories</option>
                            <option value="juniors" {{ request('category') == 'juniors' ? 'selected' : '' }}>Juniors</option>
                            <option value="seniors" {{ request('category') == 'seniors' ? 'selected' : '' }}>Seniors</option>
                        </select>
                    </div>

                    <!-- No need for a filter button -->
                </form>
            </div>

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width="60">#</th>
                        <th class="px-6 py-3 text-left">Match Date</th>
                        <th class="px-6 py-3 text-left">Time</th>
                        <th class="px-6 py-3 text-left">Venue</th>
                        <th class="px-6 py-3 text-left">Team 1</th>
                        <th class="px-6 py-3 text-left">Team 2</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="180">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($schedules->isNotEmpty())
                    @foreach ($schedules as $schedule)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-left">
                            {{ $schedule->id }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ \Carbon\Carbon::parse($schedule->date)->format('d M, Y') }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $schedule->venue }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $schedule->team1->name }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $schedule->team2->name }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ \Carbon\Carbon::parse($schedule->created_at)->format('d M, Y') }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <a href="{{ route('schedules.edit', $schedule->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                            <a href="javascript:void(0);" onclick="deleteschedule({{ $schedule->id }})" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                        </td>
                    </tr>    
                    @endforeach
                    @endif
                </tbody>
            </table>
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
