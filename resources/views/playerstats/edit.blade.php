<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Edit Player Stats') }}
            </h2>
            <a href="{{ route('schedules.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('playerstats.update', $player_stats->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        {{-- <label for="2ptfgm" class="text-lg font-medium">2 Point Field Goal Made</label>
                        <div class="my-3">
                            <input id="2ptfgm" value="{{ old('2ptfgm', $player_stats->two_pt_fg_made) }}" name="f2ptfgm" placeholder="Enter 2 Point Field Goal Made" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('f2ptfgm')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 2 Point Field Goal Attempt -->
                        <label for="2ptfga" class="text-lg font-medium">2 Point Field Goal Attempt</label>
                        <div class="my-3">
                            <input id="2ptfga" value="{{ old('2ptfga', $player_stats->two_pt_fg_attempt) }}" name="f2ptfga" placeholder="Enter 2 Point Field Goal Attempt" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('f2ptfga')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 3 Point Field Goal Made -->
                        <label for="3ptfgm" class="text-lg font-medium">3 Point Field Goal Made</label>
                        <div class="my-3">
                            <input id="3ptfgm" value="{{ old('3ptfgm', $player_stats->three_pt_fg_made) }}" name="f3ptfgm" placeholder="Enter 3 Point Field Goal Made" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('f3ptfgm')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 3 Point Field Goal Attempt -->
                        <label for="3ptfga" class="text-lg font-medium">3 Point Field Goal Attempt</label>
                        <div class="my-3">
                            <input id="3ptfga" value="{{ old('3ptfga', $player_stats->three_pt_fg_attempt) }}" name="f3ptfga" placeholder="Enter 3 Point Field Goal Attempt" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('f3ptfga')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <!-- Defensive Rebounds -->
                        <label for="def_rebounds" class="text-lg font-medium">Defensive Rebounds</label>
                        <div class="my-3">
                            <input id="def_rebounds" value="{{ old('def_rebounds', $player_stats->defensive_rebounds) }}" name="defensive_rebounds" placeholder="Enter Defensive Rebounds" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('defensive_rebounds')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Offensive Rebounds -->
                        <label for="off_rebounds" class="text-lg font-medium">Offensive Rebounds</label>
                        <div class="my-3">
                            <input id="off_rebounds" value="{{ old('off_rebounds', $player_stats->offensive_rebounds) }}" name="offensive_rebounds" placeholder="Enter Offensive Rebounds" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('offensive_rebounds')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Assists -->
                        <label for="assists_made" class="text-lg font-medium">Assists</label>
                        <div class="my-3">
                            <input id="assists_made" value="{{ old('assists_made', $player_stats->assists) }}" name="assists_made" placeholder="Enter Assists Made" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('assists')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <!-- Free Throw Made -->
                        <label for="ft_made" class="text-lg font-medium">Free Throw Made</label>
                        <div class="my-3">
                            <input id="ft_made" value="{{ old('ft_made', $player_stats->free_throw_made) }}" name="free_throw_made" placeholder="Enter Free Throw Made" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('free_throw_made')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Free Throw Attempt -->
                        <label for="ft_attempt" class="text-lg font-medium">Free Throw Attempt</label>
                        <div class="my-3">
                            <input id="ft_attempt" value="{{ old('ft_attempt', $player_stats->free_throw_attempt) }}" name="free_throw_attempt" placeholder="Enter Free Throw Attempt" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('free_throw_attempt')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <!-- Steals -->
                        <label for="steals" class="text-lg font-medium">Steals</label>
                        <div class="my-3">
                            <input id="steals" value="{{ old('steals', $player_stats->steals) }}" name="steals" placeholder="Enter Steals" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('steals')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Blocks -->
                        <label for="blocks" class="text-lg font-medium">Blocks</label>
                        <div class="my-3">
                            <input id="blocks" value="{{ old('blocks', $player_stats->blocks) }}" name="blocks" placeholder="Enter Blocks" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('blocks')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Turnovers -->
                        <label for="turnovers" class="text-lg font-medium">Turnovers</label>
                        <div class="my-3">
                            <input id="turnovers" value="{{ old('turnovers', $player_stats->turnovers) }}" name="turnovers" placeholder="Enter Turnovers" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('turnovers')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Personal Fouls -->
                        <label for="fouls" class="text-lg font-medium">Personal Fouls</label>
                        <div class="my-3">
                            <input id="fouls" value="{{ old('fouls', $player_stats->personal_fouls) }}" name="fouls" placeholder="Enter Personal Fouls" type="text" class="border-gray-300 shadow-sm rounded-lg" style="width: 50ch;">
                            @error('fouls')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3 mt-5">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
