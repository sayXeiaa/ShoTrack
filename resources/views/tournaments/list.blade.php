<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tournaments') }}
            </h2>
            @can('edit tournaments')
            <a href="{{ route('tournaments.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        {{-- <th class="px-6 py-3 text-left" width="60">#</th> --}}
                        <th class="px-6 py-3 text-left">Tournament Name</th>
                        <th class="px-6 py-3 text-left">Description</th>
                        <th class="px-6 py-3 text-left">Start Date</th>
                        <th class="px-6 py-3 text-left">End Date</th>
                        @can('edit tournaments')
                        <th class="px-6 py-3 text-left">Categories</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Address</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="180">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($tournaments->isNotEmpty())
                    @foreach ($tournaments as $tournament)
                    <tr class="border-b">
                        {{-- <td class="px-6 py-3 text-left">
                            {{ $tournament->id }}
                        </td> --}}
                        <td class="px-6 py-3 text-left">
                            {{ $tournament->name }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $tournament->description ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('Y-m-d') : 'N/A' }}
                        </td>
                        <td class="px-6 py-3 text-left">
                            {{ $tournament->end_date ? \Carbon\Carbon::parse($tournament->end_date)->format('Y-m-d') : 'N/A' }}
                        </td>
                        @can('edit tournaments')
                        <td class="px-6 py-3 text-left">
                            {{ $tournament->has_categories ? 'Yes' : 'No' }}
                        </td>

                        <td class="px-6 py-3 text-left">
                            {{ $tournament->tournament_type === 'school' ? 'School' : 'Non-School' }}
                        </td>
                        
                        <td class="px-6 py-3 text-left">
                            {{ $tournament->tournament_location }}
                        </td>

                        <td class="px-6 py-3 text-left">
                            {{ \Carbon\Carbon::parse($tournament->created_at)->format('d M, Y') }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <a href="{{route ("tournaments.edit", $tournament->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                            <a href="javascript:void(0);" onclick="deletetournament({{ $tournament->id }})" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                        </td>
                        @endcan
                    </tr>    
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
                {{ $tournaments->links() }}
            </div>
            
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletetournament(id){
                if(confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url : '{{ route("tournaments.destroy") }}',
                        type: 'delete',
                        data: {id:id},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token' : '{{ csrf_token() }}'
                        },
                        success: function(response){
                            window.location.href = '{{ route("tournaments.index") }}';
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
