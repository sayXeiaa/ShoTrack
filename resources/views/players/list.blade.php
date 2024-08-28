<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Players') }}
            </h2>
            <a href="{{ route('players.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="mb-4">
                <form method="GET" action="{{ route('players.index') }}">
                    <label for="team" class="block text-sm font-medium text-gray-700">Select Team</label>
                    <select id="team" name="team_id" onchange="this.form.submit()" class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">All Teams</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        {{-- <th class="px-6 py-3 text-left" width="60">#</th> --}}
                        <th class="px-6 py-3 text-left">First Name</th>
                        <th class="px-6 py-3 text-left">Last Name</th>
                        <th class="px-6 py-3 text-left">Number</th>
                        <th class="px-6 py-3 text-left">Position</th>
                        <th class="px-6 py-3 text-left">Date of Birth</th>
                        <th class="px-6 py-3 text-left">Age</th>
                        <th class="px-6 py-3 text-left">Height</th>
                        <th class="px-6 py-3 text-left">Weight</th>
                        {{-- <th class="px-6 py-3 text-left" width="180">Created</th> --}}
                        <th class="px-6 py-3 text-center" width="180">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($players->isNotEmpty())
                    @foreach ($players as $player)
                    <tr class="border-b">
                        {{-- <td class="px-6 py-3 text-left">
                            {{ $player->id }}
                        </td> --}}
                        <td class="px-6 py-3 text-left">
                            {{ $player->first_name }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $player->last_name }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $player->number }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $player->position }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ \Carbon\Carbon::parse($player->date_of_birth)->format('d M, Y') }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ \Carbon\Carbon::parse($player->date_of_birth)->age }} years
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $player->height }} cm
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $player->weight }} kg
                        </td>
                        {{-- <td class="px-6 py-3 text-left">
                            {{ \Carbon\Carbon::parse($player->created_at)->format('d M, Y') }}
                        </td> --}}
                        <td class="px-6 py-3 text-center">
                            <a href="{{ route('players.edit', $player->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                            <a href="javascript:void(0);" onclick="deletePlayer({{ $player->id }})" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                        </td>
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
            function deletePlayer(id) {
                if (confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: '{{ route("players.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                window.location.href = '{{ route("players.index") }}';
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert("An error occurred while deleting the player.");
                        }
                    });
                }
            }
        </script>        
    </x-slot>
</x-app-layout>
