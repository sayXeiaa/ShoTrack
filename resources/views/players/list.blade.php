<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('PLAYERS') }}
            </h2>
            @can('edit players')
            <a href="{{ route('players.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="mb-4">
                <form method="GET" action="{{ route('players.index') }}" id="filter-form" class="flex items-center space-x-4">
                    <div class="flex-1">
                        <label for="tournament" class="block text-sm font-medium text-gray-700">Select Tournament</label>
                        <select id="tournament" name="tournament_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Tournaments</option>
                            @foreach($tournaments as $tournament)
                                <option value="{{ $tournament->id }}" 
                                    {{ request('tournament_id') == $tournament->id ? 'selected' : '' }}
                                    data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}">
                                    {{ $tournament->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex-1">
                        <label for="team" class="block text-sm font-medium text-gray-700">Select Team</label>
                        <select id="team" name="team_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Teams</option>
                            <!-- Teams  -->
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Players</label>
                        <input type="text" name="search" placeholder="Search by Name" value="{{ request('search') }}" class="border rounded px-2 py-1 w-full" id="search-input" />
                    </div>
                </form>
            </div>
            
            <div class="mb-4" id="category-selection" style="display: {{ request('tournament_id') && $tournaments->where('id', request('tournament_id'))->first()->has_categories ? 'block' : 'none' }};">
                <form method="GET" action="{{ route('players.index') }}" id="category-form">
                    <input type="hidden" name="tournament_id" value="{{ request('tournament_id') }}">
                    <label for="category" class="block text-sm font-medium text-gray-700">Select Category</label>
                    <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg" style="width: 395px; height: 37.1px;">
                        <option value="">All Categories</option>
                        <option value="juniors" {{ request('category') == 'juniors' ? 'selected' : '' }}>Juniors</option>
                        <option value="seniors" {{ request('category') == 'seniors' ? 'selected' : '' }}>Seniors</option>
                    </select>
                </form>
            </div>
            

            <table id="players-table" class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">First Name</th>
                        <th class="px-6 py-3 text-left">Last Name</th>
                        <th class="px-6 py-3 text-left">Number</th>
                        <th class="px-6 py-3 text-left">Position</th>
                        <th class="px-6 py-3 text-left">Date of Birth</th>
                        <th class="px-6 py-3 text-left">Age</th>
                        <th class="px-6 py-3 text-left">Height</th>
                        <th class="px-6 py-3 text-left">Weight</th>
                        <th class="px-6 py-3 text-left">Years Playing</th> 
                        {{-- <th class="px-6 py-3 text-left">Created</th> --}}
                        @can('edit players')
                        <th class="px-6 py-3 text-center" width="180">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($players->isNotEmpty())
                        @foreach ($players as $player)
                            <tr class="border-b">
                                {{-- <td class="px-6 py-3 text-left">{{ $player->id }}</td> --}}
                                <td class="px-6 py-3 text-left">{{ $player->first_name }}</td>
                                <td class="px-6 py-3 text-left">{{ $player->last_name }}</td>
                                <td class="px-6 py-3 text-left">{{ $player->number }}</td>
                                <td class="px-6 py-3 text-left">{{ $player->position }}</td>
                                <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($player->date_of_birth)->format('d M, Y') }}</td>
                                <td class="px-6 py-3 text-left">{{ $player->age }} </td>
                                <td class="px-6 py-3 text-left">{{ $player->height }} ft</td>
                                <td class="px-6 py-3 text-left">{{ $player->weight }} kg</td>
                                <td class="px-6 py-3 text-left">{{ $player->years_playing_in_bucal }}</td>
                                {{-- <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($player->created_at)->format('d M, Y') }}</td> --}}
                                @can ('edit players')
                                <td class="px-6 py-3 text-center">
                                    <a href="{{ route('players.edit', $player->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                    <a href="javascript:void(0);" onclick="deletePlayer({{ $player->id }})" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                                </td>
                                @endcan
                            </tr>    
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
                {{ $players->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const tournamentSelect = document.getElementById('tournament');
            const categorySelect = document.getElementById('category');
            const teamSelect = document.getElementById('team');
            const categorySelection = document.getElementById('category-selection');
            const playersTableBody = document.querySelector('#players-table tbody');
    
        function updateCategoryVisibility() {
            const selectedOption = tournamentSelect.selectedOptions[0];
            const hasCategories = selectedOption.getAttribute('data-has-categories') === 'true';
    
            categorySelection.style.display = hasCategories ? 'block' : 'none';
        }
    
        function updateTeams() {
            const tournamentId = tournamentSelect.value;
            const category = categorySelect.value;
    
            fetch(`{{ route('teams.by_tournament') }}?tournament_id=${tournamentId}&category=${category}`)
                .then(response => response.json())
                .then(data => {
                teamSelect.innerHTML = '<option value="">All Teams</option>';
                    data.teams.forEach(team => {
                    const option = document.createElement('option');
                    option.value = team.id;
                    option.textContent = team.name;
                    teamSelect.appendChild(option);
                        });
                })
                    .catch(error => console.error('Error fetching teams:', error));
        }
    
        function updatePlayers() {
            const teamId = teamSelect.value;
            const category = categorySelect.value;
    
            // Fetch players based on both team and category
            fetch(`{{ route('players.by_team') }}?team_id=${teamId}&category=${category}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching players:', data.error);
                        return;
                    }
    
                    playersTableBody.innerHTML = ''; // Clear existing rows
    
                    data.players.forEach(player => {
                        const tr = document.createElement('tr');
                        tr.classList.add('border-b');
                        tr.innerHTML = `
                            <td class="px-6 py-3 text-left">${player.first_name}</td>
                            <td class="px-6 py-3 text-left">${player.last_name}</td>
                            <td class="px-6 py-3 text-left">${player.number}</td>
                            <td class="px-6 py-3 text-left">${player.position}</td>
                            <td class="px-6 py-3 text-left">${new Date(player.date_of_birth).toLocaleDateString()}</td>
                            <td class="px-6 py-3 text-left">${player.age}</td>
                            <td class="px-6 py-3 text-left">${player.height} ft</td>
                            <td class="px-6 py-3 text-left">${player.weight} kg</td>
                            <td class="px-6 py-3 text-left">${player.years_playing_in_bucal}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="/players/${player.id}/edit" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                <a href="javascript:void(0);" onclick="deletePlayer(${player.id})" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                            </td>
                        `;
                        playersTableBody.appendChild(tr);
                        });
                })
                    .catch(error => console.error('Error fetching players:', error));
        }
    
        tournamentSelect.addEventListener('change', function() {
            updateCategoryVisibility();
            updateTeams();

            this.form.submit();
        });
    
        categorySelect.addEventListener('change', function() {
            updateTeams();
            updatePlayers(); // Update players when category changes
        });
    
        teamSelect.addEventListener('change', updatePlayers);
            // Initial setup on page load
            updateCategoryVisibility();
            updateTeams();
        });
    
    function deletePlayer(id) {
        if (confirm("Are you sure you want to delete?")) {
            $.ajax({
                url: '{{ route("players.destroy", ":id") }}'.replace(':id', id),
                type: 'DELETE',
                data: { id: id },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.href = '{{ route("players.index") }}';
                },
                error: function(xhr) {
                    alert("An error occurred while deleting the player.");
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
    const tournamentSelect = document.getElementById('tournament');
    const categorySelect = document.getElementById('category');
    const teamSelect = document.getElementById('team');
    const searchInput = document.getElementById('search-input');
    const filterForm = document.getElementById('filter-form');
    const playersTableBody = document.querySelector('#players-table tbody');
    let debounceTimeout;

    // Function to fetch filtered players
    function fetchFilteredPlayers() {
        const tournamentId = tournamentSelect.value;
        const category = categorySelect ? categorySelect.value : '';
        const teamId = teamSelect.value;
        const searchValue = searchInput.value;

        fetch(`{{ route('players.index') }}?tournament_id=${tournamentId}&category=${category}&team_id=${teamId}&search=${encodeURIComponent(searchValue)}`)
            .then(response => response.text())
            .then(html => {
                playersTableBody.innerHTML = new DOMParser().parseFromString(html, 'text/html').querySelector('#players-table tbody').innerHTML;
            })
            .catch(error => console.error('Error fetching players:', error));
    }

    // Remove search input
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(fetchFilteredPlayers, 300);
    });

    // Trigger filtering when any filter changes
    tournamentSelect.addEventListener('change', function() {
        fetchFilteredPlayers();
    });

    categorySelect?.addEventListener('change', function() {
        fetchFilteredPlayers();
    });

    teamSelect.addEventListener('change', function() {
        fetchFilteredPlayers();
    });

});
    
    </script>
    </x-slot>

</x-app-layout>