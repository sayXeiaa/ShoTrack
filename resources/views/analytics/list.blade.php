<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics') }}
        </h2>
    </x-slot>



    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
            <label for="tournament" class="block text-sm font-medium text-gray-700">Select Tournament</label>
            <select id="tournament" name="tournament_id"
                class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">All Tournaments</option>
                @foreach ($tournaments as $tournament)
                    <option value="{{ $tournament->id }}"
                        data-has-categories="{{ $tournament->has_categories ? 'true' : 'false' }}">
                        {{ $tournament->name }}
                    </option>
                @endforeach
            </select>

            <div class="mb-4" id="category-selection" style="display:none;">
                <label for="category" class="block text-sm font-medium text-gray-700">Select Category</label>
                <select id="category" name="category"
                    class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">All Categories</option>
                    <option value="juniors">Juniors</option>
                    <option value="seniors">Seniors</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label for="scheduleSelect" class="block text-sm font-medium text-gray-700">Select Game:</label>
            <select id="scheduleSelect"
                class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Choose a Game</option>
            </select>
        </div>

        
<div class="space-y-4">
    <div class="space-y-4 bg-white-400 dark:bg-gray-900 border-2 border-gray-300 rounded-lg shadow-xl p-4">

            <div id="team1NameDisplay" class="text-gray-900 dark:text-white text-2xl leading-none font-bold">No team
                selected</div>




            <!-- Add overflow-x-auto here for horizontal scrolling -->
            <div class="overflow-x-auto mt-4">
                <div class="flex space-x-4 w-max mb-4">
                    <!-- Points Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Points</p>
                                </div>
                            </div>
                        </div>
                        <div id="point-chart-a"></div>
                    </div>

                    <!-- Assists Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Assists</p>
                                </div>
                            </div>
                        </div>
                        <div id="assist-chart-a"></div>
                    </div>

                    <!-- Rebounds Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Rebounds
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="rebound-chart-a"></div>
                    </div>

                    <!-- Steals Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Steals</p>
                                </div>
                            </div>
                        </div>
                        <div id="steal-chart-a"></div>
                    </div>

                    <!-- Blocks Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Blocks</p>
                                </div>
                            </div>
                        </div>
                        <div id="block-chart-a"></div>
                    </div>

                    <!-- Personal Fouls Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Personal
                                        Fouls
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="perfoul-chart-a"></div>
                    </div>

                    <!-- Turnovers Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Turnovers
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="turnover-chart-a"></div>
                    </div>

                    <!-- Offensive Rebounds Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Offensive
                                        Rebounds</p>
                                </div>
                            </div>
                        </div>
                        <div id="offensive_rebounds-chart-a"></div>
                    </div>

                    <!-- Defensive Rebounds Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Defensive
                                        Rebounds</p>
                                </div>
                            </div>
                        </div>
                        <div id="defensive_rebounds-chart-a"></div>
                    </div>

                    <!-- Two Point FG Attempt Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Two Point
                                        FG
                                        Attempt</p>
                                </div>
                            </div>
                        </div>
                        <div id="two_pt_fg_attempt-chart-a"></div>
                    </div>

                    <!-- Two Point FG Made Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Two Point
                                        FG
                                        Made</p>
                                </div>
                            </div>
                        </div>
                        <div id="two_pt_fg_made-chart-a"></div>
                    </div>

                    <!-- Three Point FG Attempt Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Three Point
                                        FG
                                        Attempt</p>
                                </div>
                            </div>
                        </div>
                        <div id="three_pt_fg_attempt-chart-a"></div>
                    </div>

                    <!-- Three Point FG Made Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Three Point
                                        FG
                                        Made</p>
                                </div>
                            </div>
                        </div>
                        <div id="three_pt_fg_made-chart-a"></div>
                    </div>

                    <!-- Two Point Percentage Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Two Point
                                        Percentage</p>
                                </div>
                            </div>
                        </div>
                        <div id="two_pt_percentage-chart-a"></div>
                    </div>

                    <!-- Three Point Percentage Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Three
                                        Point
                                        Percentage</p>
                                </div>
                            </div>
                        </div>
                        <div id="three_pt_percentage-chart-a"></div>
                    </div>

                    <!-- Free Throw Attempt Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Free Throw
                                        Attempt</p>
                                </div>
                            </div>
                        </div>
                        <div id="free_throw_attempt-chart-a"></div>
                    </div>

                    <!-- Free Throw Made Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Free Throw
                                        Made</p>
                                </div>
                            </div>
                        </div>
                        <div id="free_throw_made-chart-a"></div>
                    </div>

                    <!-- Free Throw Percentage Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Free Throw
                                        Percentage</p>
                                </div>
                            </div>
                        </div>
                        <div id="free_throw_percentage-chart-a"></div>
                    </div>

                    <!-- Free Throw Attempt Rate Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Free Throw
                                        Attempt Rate</p>
                                </div>
                            </div>
                        </div>
                        <div id="free_throw_attempt_rate-chart-a"></div>
                    </div>

                    <!-- Plus-Minus Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Plus-Minus
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="plus_minus-chart-a"></div>
                    </div>

                    <!-- Effective FG Percentage Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Effective
                                        FG
                                        Percentage</p>
                                </div>
                            </div>
                        </div>
                        <div id="effective_field_goal_percentage-chart-a"></div>
                    </div>

                    <!-- Turnover Ratio Box -->
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between mb-5">
                            <div class="grid gap-4 grid-cols-2">
                                <div>
                                    <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Turnover
                                        Ratio
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="turnover_ratio-chart-a"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="space-y-4 bg-white-400 dark:bg-gray-900 border-2 border-gray-300 rounded-lg shadow-xl p-4">
            <div id="team2NameDisplay" class="text-gray-900 dark:text-white text-2xl leading-none font-bold">No team
                selected</div>




            <!-- Add overflow-x-auto here for horizontal scrolling -->
            <div class="overflow-x-auto mt-4">
                <div class="flex space-x-4 w-max mb-4">

                    <!-- Add overflow-x-auto here for horizontal scrolling -->
                    <div class="overflow-x-auto">
                        <div class="flex space-x-4 w-max">
                            <!-- Points Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Points</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="point-chart-b"></div>
                            </div>

                            <!-- Assists Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Assists
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="assist-chart-b"></div>
                            </div>

                            <!-- Rebounds Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Rebounds
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="rebound-chart-b"></div>
                            </div>

                            <!-- Steals Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Steals</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="steal-chart-b"></div>
                            </div>

                            <!-- Blocks Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Blocks</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="block-chart-b"></div>
                            </div>

                            <!-- Personal Fouls Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Personal
                                                Fouls
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="perfoul-chart-b"></div>
                            </div>

                            <!-- Turnovers Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Turnovers
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="turnover-chart-b"></div>
                            </div>

                            <!-- Offensive Rebounds Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Offensive
                                                Rebounds</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="offensive_rebounds-chart-b"></div>
                            </div>

                            <!-- Defensive Rebounds Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Defensive
                                                Rebounds</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="defensive_rebounds-chart-b"></div>
                            </div>

                            <!-- Two Point FG Attempt Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Two Point
                                                FG
                                                Attempt</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="two_pt_fg_attempt-chart-b"></div>
                            </div>

                            <!-- Two Point FG Made Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Two Point
                                                FG
                                                Made</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="two_pt_fg_made-chart-b"></div>
                            </div>

                            <!-- Three Point FG Attempt Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Three
                                                Point FG
                                                Attempt</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="three_pt_fg_attempt-chart-b"></div>
                            </div>

                            <!-- Three Point FG Made Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Three
                                                Point FG
                                                Made</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="three_pt_fg_made-chart-b"></div>
                            </div>

                            <!-- Two Point Percentage Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Two Point
                                                Percentage</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="two_pt_percentage-chart-b"></div>
                            </div>

                            <!-- Three Point Percentage Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Three
                                                Point
                                                Percentage</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="three_pt_percentage-chart-b"></div>
                            </div>

                            <!-- Free Throw Attempt Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Free Throw
                                                Attempt</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="free_throw_attempt-chart-b"></div>
                            </div>

                            <!-- Free Throw Made Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Free Throw
                                                Made</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="free_throw_made-chart-b"></div>
                            </div>

                            <!-- Free Throw Percentage Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Free Throw
                                                Percentage</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="free_throw_percentage-chart-b"></div>
                            </div>

                            <!-- Free Throw Attempt Rate Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Free Throw
                                                Attempt Rate</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="free_throw_attempt_rate-chart-b"></div>
                            </div>

                            <!-- Plus-Minus Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Plus-Minus
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="plus_minus-chart-b"></div>
                            </div>

                            <!-- Effective FG Percentage Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Effective
                                                FG
                                                Percentage</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="effective_field_goal_percentage-chart-b"></div>
                            </div>

                            <!-- Turnover Ratio Box -->
                            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between mb-5">
                                    <div class="grid gap-4 grid-cols-2">
                                        <div>
                                            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">
                                                Turnover
                                                Ratio
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="turnover_ratio-chart-b"></div>
                            </div>

                        </div>
                    </div>
                </div>


                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            const tournamentSelect = $('#tournament');
                            const categorySelect = $('#category');
                            const categorySelection = $('#category-selection');
                            const scheduleSelect = $('#scheduleSelect');

                            function updateCategoryVisibility() {
                                const selectedOption = tournamentSelect.find('option:selected');
                                const hasCategories = selectedOption.data('has-categories') === true;

                                if (hasCategories) {
                                    categorySelection.show();
                                } else {
                                    categorySelection.hide();
                                }
                            }

                            updateCategoryVisibility();

                            tournamentSelect.on('change', function() {
                                const tournamentId = $(this).val();
                                const categoryId = categorySelect.val();

                                updateCategoryVisibility();

                                if (tournamentId) {
                                    $.ajax({
                                        url: `/schedules-by-tournament/${tournamentId}?category=${categoryId}`,
                                        type: 'GET',
                                        success: function(response) {
                                            scheduleSelect.empty();
                                            if (response.schedules.length > 0) {
                                                scheduleSelect.append(
                                                    '<option value="">Choose a game</option>');
                                                $.each(response.schedules, function(index, schedule) {
                                                    scheduleSelect.append(
                                                        `<option value="${schedule.id}" data-team1-name="${schedule.team1.name}" data-team2-name="${schedule.team2.name}">${schedule.team1.name} vs ${schedule.team2.name}</option>`
                                                    );
                                                });
                                            } else {
                                                scheduleSelect.append(
                                                    '<option value="">No schedules available</option>');
                                            }
                                        },
                                        error: function(error) {
                                            console.log("Error fetching schedules:", error);
                                        }
                                    });
                                } else {
                                    scheduleSelect.empty();
                                    scheduleSelect.append('<option value="">Choose a schedule</option>');
                                }

                                // Event listener to update team1 and team2 name displays
                                scheduleSelect.on('change', function() {
                                    var selectedOption = this.options[this.selectedIndex];
                                    var teamAName = selectedOption.getAttribute('data-team1-name');
                                    var teamBName = selectedOption.getAttribute('data-team2-name');

                                    // Update the divs with team names
                                    $('#team1NameDisplay').text(teamAName ? teamAName :
                                        ''); // Assuming the div has an ID of team1NameDisplay
                                    $('#team2NameDisplay').text(teamBName ? teamBName :
                                        ''); // Assuming the div has an ID of team2NameDisplay
                                });


                            });

                            categorySelect.on('change', function() {
                                tournamentSelect.trigger('change');
                            });

                            scheduleSelect.on('change', function() {
                                const scheduleId = $(this).val();

                                if (scheduleId) {
                                    // Fetch and update Team A Points chart
                                    fetch(`/chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const points = data.points;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // You can use percentage for width if the container is responsive
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Points",
                                                    data: points,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Points',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Add responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller devices
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("point-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching data for Team A:', error));


                                    // Fetch and update Team A Assists chart
                                    fetch(`/assists-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const assists = data.assists;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Assists",
                                                    data: assists,
                                                    color: "#1A56DB", // Custom color for assists
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Assists',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("assist-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching assists data for Team A:', error));


                                    // Fetch and update Team A Rebounds chart
                                    fetch(`/rebounds-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const rebounds = data.rebounds;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Rebounds",
                                                    data: rebounds,
                                                    color: "#1A56DB", // Custom color for rebounds
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Rebounds',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("rebound-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching rebounds data for Team A:', error));


                                    // Fetch and update Team A Steals chart
                                    fetch(`/steals-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const steals = data.steals;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Steals",
                                                    data: steals,
                                                    color: "#1A56DB", // Custom color for steals
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Steals',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("steal-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching steals data for Team A:', error));

                                    // Fetch and update Team A Blocks chart
                                    fetch(`/blocks-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const blocks = data.blocks;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Blocks",
                                                    data: blocks,
                                                    color: "#1A56DB", // Custom color for blocks
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'blocks',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("block-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching blocks data for Team A:', error));

                                    // Fetch and update Team A Personal Foul chart
                                    fetch(`/perfoul-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const personal_fouls = data.personal_fouls;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Personal Fouls",
                                                    data: personal_fouls,
                                                    color: "#1A56DB", // Custom color for personal fouls
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'personal_fouls',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("perfoul-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching personal fouls data for Team A:',
                                            error));

                                    // Fetch and update Team A Turnovers chart
                                    fetch(`/turnovers-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const turnovers = data.turnovers;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Turnovers",
                                                    data: turnovers,
                                                    color: "#1A56DB", // Custom color for turnovers
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'turnovers',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("turnover-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching turnovers data for Team A:', error));

                                    // Fetch and update Team A Offensive Rebounds chart
                                    fetch(`/offensive_rebounds-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const offensive_rebounds = data.offensive_rebounds;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Offensive Rebounds",
                                                    data: offensive_rebounds,
                                                    color: "#1A56DB", // Custom color for offensive rebounds
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Offensive Rebounds',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "offensive_rebounds-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching offensive rebounds data for Team A:',
                                            error));

                                    // Fetch and update Team A Defensive Rebounds chart
                                    fetch(`/defensive_rebounds-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const defensive_rebounds = data.defensive_rebounds;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Defensive Rebounds",
                                                    data: defensive_rebounds,
                                                    color: "#1A56DB", // Custom color for defensive rebounds
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Defensive Rebounds',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "defensive_rebounds-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching defensive rebounds data for Team A:',
                                            error));

                                    // Fetch and update Team A 2 Point FG Attempt chart
                                    fetch(`/two_pt_fg_attempt-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const two_pt_fg_attempt = data.two_pt_fg_attempt;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "2 Point FG Attempt",
                                                    data: two_pt_fg_attempt,
                                                    color: "#1A56DB", // Custom color for 2 Point FG Attempt
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: '2 Point FG Attempt',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "two_pt_fg_attempt-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching 2 Point FG Attempt data for Team A:',
                                            error));

                                    // Fetch and update Team A 2 Point FG Made chart
                                    fetch(`/two_pt_fg_made-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const two_pt_fg_made = data.two_pt_fg_made;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height in pixels
                                                    width: "100%", // Responsive width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "2 Point FG Made",
                                                    data: two_pt_fg_made,
                                                    color: "#1A56DB", // Custom color for 2 Point FG Made
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: '2 Point FG Made',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Responsive behavior for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250, // Adjust height for smaller screens
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "two_pt_fg_made-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching 2 Point FG Made data for Team A:',
                                            error));

                                    // Fetch and update Team A three Point FG Attempt chart
                                    fetch(`/three_pt_fg_attempt-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const three_pt_fg_attempt = data.three_pt_fg_attempt;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "three Point FG Attempt",
                                                    data: three_pt_fg_attempt,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'three Point FG Attempt',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "three_pt_fg_attempt-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching three Point FG Attempt for Team A:',
                                            error));

                                    // Fetch and update Team A three Point FG Made chart
                                    fetch(`/three_pt_fg_made-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const three_pt_fg_made = data.three_pt_fg_made;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "three Point FG Made",
                                                    data: three_pt_fg_made,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'three Point FG Made',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "three_pt_fg_made-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching three Point FG Made for Team A:',
                                            error));

                                    // Fetch and update Team A Two Point Percentage chart
                                    fetch(`/two_pt_percentage-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const two_pt_percentage = data.two_pt_percentage;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "bar",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Two Point Percentage",
                                                    data: two_pt_percentage,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Two Point Percentage',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "two_pt_percentage-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Two Point Percentage for Team A:',
                                            error));

                                    // Fetch and update Team A Three Point Percentage chart
                                    fetch(`/three_pt_percentage-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const three_pt_percentage = data.three_pt_percentage;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "bar",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Three Point Percentage",
                                                    data: three_pt_percentage,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Three Point Percentage',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "three_pt_percentage-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Three Point Percentage for Team A:',
                                            error));

                                    // Fetch and update Team A Free Throw Attempt chart
                                    fetch(`/free_throw_attempt-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const free_throw_attempt = data.free_throw_attempt;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Free Throw Attempt",
                                                    data: free_throw_attempt,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Free Throw Attempt',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "free_throw_attempt-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Free Throw Attempt for Team A:',
                                            error));

                                    // Fetch and update Team A Free Throw Made chart
                                    fetch(`/free_throw_made-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const free_throw_made = data.free_throw_made;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Free Throw Made",
                                                    data: free_throw_made,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Free Throw Made',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "free_throw_made-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Free Throw Made for Team A:',
                                            error));

                                    // Fetch and update Team A Free Throw Percentage chart
                                    fetch(`/free_throw_percentage-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const free_throw_percentage = data.free_throw_percentage;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "bar",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Free Throw Percentage",
                                                    data: free_throw_percentage,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Free Throw Percentage',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "free_throw_percentage-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Free Throw Percentage for Team A:',
                                            error));

                                    // Fetch and update Team A Free Throw Attempt Rate chart
                                    fetch(`/free_throw_attempt_rate-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const free_throw_attempt_rate = data.free_throw_attempt_rate;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Free Throw Attempt Rate",
                                                    data: free_throw_attempt_rate,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Free Throw Attempt Rate',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "free_throw_attempt_rate-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Free Throw Attempt Rate for Team A:',
                                            error));

                                    // Fetch and update Team A Plus Minus chart
                                    fetch(`/plus_minus-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const plus_minus = data.plus_minus;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Plus Minus",
                                                    data: plus_minus,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Plus Minus',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "plus_minus-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Plus Minus for Team A:',
                                            error));

                                    // Fetch and update Team A Effective Field Goal Percentage chart
                                    fetch(`/effective_field_goal_percentage-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const effective_field_goal_percentage = data
                                                .effective_field_goal_percentage;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "bar",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Effective Field Goal Percentage",
                                                    data: effective_field_goal_percentage,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Effective Field Goal Percentage',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "effective_field_goal_percentage-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error(
                                            'Error fetching Effective Field Goal Percentage for Team A:',
                                            error));

                                    // Fetch and update Team A Turnover Ratio chart
                                    fetch(`/turnover_ratio-chart-data-a/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const turnover_ratio = data.turnover_ratio;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Turnover Ratio",
                                                    data: turnover_ratio,
                                                    color: "#1A56DB",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Turnover Ratio',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "turnover_ratio-chart-a"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Turnover Ratio for Team A:',
                                            error));

                                    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                    // Fetch and update Team B Points chart
                                    fetch(`/chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const points = data.points;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300, // Set a fixed height
                                                    width: "100%", // Set to full width
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Points",
                                                    data: points,
                                                    color: "#FF5733", // Custom color for points
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Points',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000, // Adjust chart height for smaller screens
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("point-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching data for Team B:', error));

                                    // Fetch and update Team B Assists chart
                                    fetch(`/assists-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const assists = data.assists;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Assists",
                                                    data: assists,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Assists',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("assist-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching assists data for Team B:', error));

                                    // Fetch and update Team B Rebounds chart
                                    fetch(`/rebounds-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const rebounds = data.rebounds;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Rebounds",
                                                    data: rebounds,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Rebounds',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("rebound-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching rebounds data for Team B:', error));

                                    // Fetch and update Team B Steals chart
                                    fetch(`/steals-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const steals = data.steals;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Steals",
                                                    data: steals,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Steals',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("steal-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching steals data for Team B:', error));

                                    // Fetch and update Team B Blocks chart
                                    fetch(`/blocks-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const blocks = data.blocks;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Blocks",
                                                    data: blocks,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Blocks',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("block-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching blocks data for Team B:', error));

                                    // Fetch and update Team B Personal Fouls chart
                                    fetch(`/perfoul-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const personal_fouls = data.personal_fouls;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Personal Fouls",
                                                    data: personal_fouls,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'personal_fouls',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("perfoul-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Personal Fouls data for Team B:',
                                            error));

                                    // Fetch and update Team B Turnovers chart
                                    fetch(`/turnovers-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const turnovers = data.turnovers;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Turnovers",
                                                    data: turnovers,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Turnovers',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById("turnover-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching turnovers data for Team B:', error));

                                    // Fetch and update Team B Offensive Rebounds chart
                                    fetch(`/offensive_rebounds-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const offensive_rebounds = data.offensive_rebounds;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Offensive Rebounds",
                                                    data: offensive_rebounds,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Offensive Rebounds',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "offensive_rebounds-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching offensive rebounds data for Team B:',
                                            error));

                                    // Fetch and update Team B Defensive Rebounds chart
                                    fetch(`/defensive_rebounds-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const defensive_rebounds = data.defensive_rebounds;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Defensive Rebounds",
                                                    data: defensive_rebounds,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Defensive Rebounds',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "defensive_rebounds-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching defensive rebounds data for Team B:',
                                            error));

                                    // Fetch and update Team B two Point FG Attempt chart
                                    fetch(`/two_pt_fg_attempt-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const two_pt_fg_attempt = data.two_pt_fg_attempt;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "two Point FG Attempt",
                                                    data: two_pt_fg_attempt,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'two Point FG Attempt',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "two_pt_fg_attempt-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching 2 Point FG Attempt data for Team B:',
                                            error));

                                    // Fetch and update Team B two Point FG Made chart
                                    fetch(`/two_pt_fg_made-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const two_pt_fg_made = data.two_pt_fg_made;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "two Point FG Made",
                                                    data: two_pt_fg_made,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'two Point FG Made',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "two_pt_fg_made-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching two Point FG Made data for Team B:',
                                            error));

                                    // Fetch and update Team B three Point FG Attempt chart
                                    fetch(`/three_pt_fg_attempt-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const three_pt_fg_attempt = data.three_pt_fg_attempt;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "three Point FG Attempt",
                                                    data: three_pt_fg_attempt,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'three Point FG Attempt',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "three_pt_fg_attempt-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching three Point FG Attempt for Team B:',
                                            error));

                                    // Fetch and update Team B three Point FG Made chart
                                    fetch(`/three_pt_fg_made-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const three_pt_fg_made = data.three_pt_fg_made;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "three Point FG Made",
                                                    data: three_pt_fg_made,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'three Point FG Made',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "three_pt_fg_made-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching three Point FG Made for Team B:',
                                            error));

                                    // Fetch and update Team B Two Point Percentage chart
                                    fetch(`/two_pt_percentage-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const two_pt_percentage = data.two_pt_percentage;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "bar",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Two Point Percentage",
                                                    data: two_pt_percentage,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Two Point Percentage',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "two_pt_percentage-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Two Point Percentage for Team B:',
                                            error));

                                    // Fetch and update Team B Three Point Percentage chart
                                    fetch(`/three_pt_percentage-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const three_pt_percentage = data.three_pt_percentage;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "bar",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Three Point Percentage",
                                                    data: three_pt_percentage,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Three Point Percentage',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "three_pt_percentage-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Three Point Percentage for Team B:',
                                            error));

                                    // Fetch and update Team B Free Throw Attempt chart
                                    fetch(`/free_throw_attempt-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const free_throw_attempt = data.free_throw_attempt;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Free Throw Attempt",
                                                    data: free_throw_attempt,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Free Throw Attempt',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "free_throw_attempt-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Free Throw Attempt for Team B:',
                                            error));

                                    // Fetch and update Team B Free Throw Made chart
                                    fetch(`/free_throw_made-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const free_throw_made = data.free_throw_made;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Free Throw Made",
                                                    data: free_throw_made,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Free Throw Made',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "free_throw_made-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Free Throw Made for Team B:',
                                            error));

                                    // Fetch and update Team B Free Throw Percentage chart
                                    fetch(`/free_throw_percentage-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const free_throw_percentage = data.free_throw_percentage;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "bar",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Free Throw Percentage",
                                                    data: free_throw_percentage,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Free Throw Percentage',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "free_throw_percentage-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Free Throw Percentage for Team B:',
                                            error));

                                    // Fetch and update Team B Free Throw Attempt Rate chart
                                    fetch(`/free_throw_attempt_rate-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const free_throw_attempt_rate = data.free_throw_attempt_rate;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Free Throw Attempt Rate",
                                                    data: free_throw_attempt_rate,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Free Throw Attempt Rate',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "free_throw_attempt_rate-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Free Throw Attempt Rate for Team B:',
                                            error));

                                    // Fetch and update Team B Plus Minus chart
                                    fetch(`/plus_minus-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const plus_minus = data.plus_minus;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Plus Minus",
                                                    data: plus_minus,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Plus Minus',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "plus_minus-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Plus Minus for Team B:',
                                            error));

                                    // Fetch and update Team B Effective Field Goal Percentage chart
                                    fetch(`/effective_field_goal_percentage-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const effective_field_goal_percentage = data
                                                .effective_field_goal_percentage;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "bar",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Effective Field Goal Percentage",
                                                    data: effective_field_goal_percentage,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Effective Field Goal Percentage',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "effective_field_goal_percentage-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error(
                                            'Error fetching Effective Field Goal Percentage for Team B:',
                                            error));

                                    // Fetch and update Team B Turnover Ratio chart
                                    fetch(`/turnover_ratio-chart-data-b/${scheduleId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const turnover_ratio = data.turnover_ratio;
                                            const playerNames = data
                                                .playerNames; // Use playerNames instead of playerIds

                                            const options = {
                                                chart: {
                                                    height: 300,
                                                    width: "100%",
                                                    type: "line",
                                                    fontFamily: "Inter, sans-serif",
                                                    dropShadow: {
                                                        enabled: false,
                                                    },
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                series: [{
                                                    name: "Turnover Ratio",
                                                    data: turnover_ratio,
                                                    color: "#FF5733",
                                                }],
                                                xaxis: {
                                                    categories: playerNames, // Use playerNames as categories for X-axis
                                                    title: {
                                                        text: 'Players',
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Turnover Ratio',
                                                    },
                                                },
                                                responsive: [{
                                                    breakpoint: 1000,
                                                    options: {
                                                        chart: {
                                                            height: 250,
                                                        }
                                                    }
                                                }],
                                            };

                                            const chart = new ApexCharts(document.getElementById(
                                                    "turnover_ratio-chart-b"),
                                                options);
                                            chart.render();
                                        })
                                        .catch(error => console.error('Error fetching Turnover Ratio for Team B:',
                                            error));


                                }
                            });
                        });
                    </script>
                </div>
</x-app-layout>
