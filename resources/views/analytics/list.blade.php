<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics') }}
        </h2>
    </x-slot>



    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
            <label for="tournament" class="block text-sm font-medium text-gray-700 mb-2">Select Tournament</label>
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
        
            <div class="mb-4 mt-2" id="category-selection" style="display:none;">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Select Category</label>
                <select id="category" name="category"
                    class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">All Categories</option>
                    <option value="juniors">Juniors</option>
                    <option value="seniors">Seniors</option>
                </select>
            </div>
        </div>
        
        <div class="mb-4 mt-2">
            <label for="scheduleSelect" class="block text-sm font-medium text-gray-700 mb-2">Select Game:</label>
            <select id="scheduleSelect"
                class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Choose a Game</option>
            </select>
        </div>
        
        <div class="space-y-4">
        <div class="text-lg font-bold ml-2 flex space-x-4">
            <button
                class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300 active-btn"
                data-type="basicstatsA,basicstatsB">
                Basic Statistics
            </button>
            <button
                class="nav-btn px-4 py-2 bg-gray-400 text-white rounded hover:bg-[#314795] focus:outline-none focus:ring-2 focus:ring-gray-300"
                data-type="advstatsA,advstatsB">
                Advanced Statistics
            </button>
        </div>

        <div class="space-y-4">
            <div id="basicstatsA" class="content-section space-y-4 bg-white-400 border-2 border-gray-300 rounded-lg shadow-xl p-4">
                <div id="team1NameDisplayA" class="text-gray-900 text-2xl leading-none font-bold">No team selected</div>
                <!-- Add horizontal scrolling -->
                <div class="overflow-x-auto mt-4">
                    <div class="flex space-x-4 w-max">
                        <!-- Points Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Points</h3>
                            </div>
                            <div id="point-chart-a"></div>
                        </div>

                        <!-- Assists Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Assists</h3>
                            </div>
                            <div id="assist-chart-a"></div>
                        </div>

                        <!-- Rebounds Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Rebounds</h3>
                            </div>
                            <div id="rebound-chart-a"></div>
                        </div>

                        <!-- Steals Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Steals</h3>
                            </div>
                            <div id="steal-chart-a"></div>
                        </div>

                        <!-- Blocks Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Blocks</h3>
                            </div>
                            <div id="block-chart-a"></div>
                        </div>

                        <!-- Turnovers Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Turnovers</h3>
                            </div>
                            <div id="turnover-chart-a"></div>
                        </div>  

                        <!-- Personal Fouls Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Personal Fouls</h3>
                            </div>
                            <div id="perfoul-chart-a"></div>
                        </div>

                        <!-- Offensive Rebounds Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Offensive Rebounds</h3>
                            </div>
                            <div id="offensive_rebounds-chart-a"></div>
                        </div>

                        <!-- Defensive Rebounds Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Defensive Rebounds</h3>
                            </div>
                            <div id="defensive_rebounds-chart-a"></div>
                        </div>

                        <!-- Two Point FG Attempt Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Two-Point FG Attempt</h3>
                            </div>
                            <div id="two_pt_fg_attempt-chart-a"></div>
                        </div>

                        <!-- Two Point FG Made Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Two-Point FG Made</h3>
                            </div>
                            <div id="two_pt_fg_made-chart-a"></div>
                        </div>

                        <!-- Two Point Percentage Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Two-Point Percentage</h3>
                            </div>
                            <div id="two_pt_percentage-chart-a"></div>
                        </div>

                        <!-- Three Point FG Attempt Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Three-Point FG Attempt</h3>
                            </div>
                            <div id="three_pt_fg_attempt-chart-a"></div>
                        </div>

                        <!-- Three Point FG Made Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Three-Point FG Made</h3>
                            </div>
                            <div id="three_pt_fg_made-chart-a"></div>
                        </div>

                        <!-- Three Point Percentage Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Three-Point Percentage</h3>
                            </div>
                            <div id="three_pt_percentage-chart-a"></div>
                        </div>

                        <!-- Free Throw Attempt Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Free Throw Attempt</h3>
                            </div>
                            <div id="free_throw_attempt-chart-a"></div>
                        </div>

                        <!-- Free Throw Made Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Free Throw Made</h3>
                            </div>
                            <div id="free_throw_made-chart-a"></div>
                        </div>

                        <!-- Free Throw Percentage Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Free Throw Percentage</h3>
                            </div>
                            <div id="free_throw_percentage-chart-a"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="advstatsA"
                class="content-section space-y-4 bg-white-400 border-2 border-gray-300 rounded-lg shadow-xl p-4">

                <div id="team1NameDisplayB" class="text-gray-900 text-2xl leading-none font-bold">No
                    team
                    selected</div>

                <!-- Add overflow-x-auto here for horizontal scrolling -->
                <div class="overflow-x-auto mt-4">
                    <div class="flex space-x-4 w-max mb-4">

                        <!-- Free Throw Attempt Rate Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Free Throw Attempt Rate</h3>
                            </div>
                            <div id="free_throw_attempt_rate-chart-a"></div>
                        </div>

                        <!-- Plus-Minus Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Plus-Minus</h3>
                            </div>
                            <div id="plus_minus-chart-a"></div>
                        </div>

                        <!-- Effective FG Percentage Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Effective FG Percentage</h3>
                            </div>
                            <div id="effective_field_goal_percentage-chart-a"></div>
                        </div>

                        <!-- Turnover Ratio Box -->
                        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                            <div class="flex justify-center mb-5">
                                <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Turnover Ratio</h3>
                            </div>
                            <div id="turnover_ratio-chart-a"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="basicstatsB"
                class="content-section space-y-4 bg-white-400 border-2 border-gray-300 rounded-lg shadow-xl p-4">
                <div id="team2NameDisplayA" class="text-gray-900 text-2xl leading-none font-bold">No
                    team
                    selected</div>

                <!-- Add overflow-x-auto here for horizontal scrolling -->
                <div class="overflow-x-auto mt-4">
                    <div class="flex space-x-4 w-max mb-4">

                        <!-- Add overflow-x-auto here for horizontal scrolling -->
                        <div class="overflow-x-auto">
                            <div class="flex space-x-4 w-max">
                                <!-- Points Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Points</h3>
                                    </div>
                                    <div id="point-chart-b"></div>
                                </div>

                                <!-- Assists Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Assists</h3>
                                    </div>
                                    <div id="assist-chart-b"></div>
                                </div>

                                <!-- Rebounds Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Rebounds</h3>
                                    </div>
                                    <div id="rebound-chart-b"></div>
                                </div>

                                <!-- Steals Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Steals</h3>
                                    </div>
                                    <div id="steal-chart-b"></div>
                                </div>

                                <!-- Blocks Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Blocks</h3>
                                    </div>
                                    <div id="block-chart-b"></div>
                                </div>

                                <!-- Turnovers Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Turnovers</h3>
                                    </div>
                                    <div id="turnover-chart-b"></div>
                                </div>

                                <!-- Personal Fouls Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Personal Fouls</h3>
                                    </div>
                                    <div id="perfoul-chart-b"></div>
                                </div>

                                <!-- Offensive Rebounds Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Offensive Rebounds</h3>
                                    </div>
                                    <div id="offensive_rebounds-chart-b"></div>
                                </div>

                                <!-- Defensive Rebounds Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Defensive Rebounds</h3>
                                    </div>
                                    <div id="defensive_rebounds-chart-b"></div>
                                </div>

                                <!-- Two Point FG Attempt Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Two-Point FG Attempt</h3>
                                    </div>
                                    <div id="two_pt_fg_attempt-chart-b"></div>
                                </div>

                                <!-- Two Point FG Made Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Two-Point FG Made</h3>
                                    </div>
                                    <div id="two_pt_fg_made-chart-b"></div>
                                </div>

                                <!-- Two Point Percentage Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Two-Point FG Percentage</h3>
                                    </div>
                                    <div id="two_pt_percentage-chart-b"></div>
                                </div>

                                <!-- Three Point FG Attempt Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Three-Point FG Attempt</h3>
                                    </div>
                                    <div id="three_pt_fg_attempt-chart-b"></div>
                                </div>

                                <!-- Three Point FG Made Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Three-Point FG Made</h3>
                                    </div>
                                    <div id="three_pt_fg_made-chart-b"></div>
                                </div>

                                <!-- Three Point Percentage Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Three-Point FG Percentage</h3>
                                    </div>
                                    <div id="three_pt_percentage-chart-b"></div>
                                </div>

                                <!-- Free Throw Attempt Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Free-Throw Attempt</h3>
                                    </div>
                                    <div id="free_throw_attempt-chart-b"></div>
                                </div>

                                <!-- Free Throw Made Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Free-Throw Made</h3>
                                    </div>
                                    <div id="free_throw_made-chart-b"></div>
                                </div>

                                <!-- Free Throw Percentage Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Free-Throw Percentage</h3>
                                    </div>
                                    <div id="free_throw_percentage-chart-b"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="advstatsB"
                class="content-section space-y-4 bg-white-400 border-2 border-gray-300 rounded-lg shadow-xl p-4">
                <div id="team2NameDisplayB" class="text-gray-900 text-2xl leading-none font-bold">No
                    team
                    selected</div>

                <!-- Add overflow-x-auto here for horizontal scrolling -->
                <div class="overflow-x-auto mt-4">
                    <div class="flex space-x-4 w-max mb-4">

                        <!-- Add overflow-x-auto here for horizontal scrolling -->
                        <div class="overflow-x-auto">
                            <div class="flex space-x-4 w-max">

                                <!-- Free Throw Attempt Rate Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Free Throw Attempt Rate</h3>
                                    </div>
                                    <div id="free_throw_attempt_rate-chart-b"></div>
                                </div>

                                <!-- Plus-Minus Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Plus-Minus</h3>
                                    </div>
                                    <div id="plus_minus-chart-b"></div>
                                </div>

                                <!-- Effective FG Percentage Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Effective FG Percentage</h3>
                                    </div>
                                    <div id="effective_field_goal_percentage-chart-b"></div>
                                </div>

                                <!-- Turnover Ratio Box -->
                                <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
                                    <div class="flex justify-center mb-5">
                                        <h3 class="text-center text-xl font-bold text-gray-700 mb-2">Turnover Ratio</h3>
                                    </div>
                                    <div id="turnover_ratio-chart-b"></div>
                                </div>

                            </div>
                        </div>
                    </div>
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

                        
                        $('#team1NameDisplayA').text(teamAName ? teamAName :
                            ''); 
                        $('#team1NameDisplayB').text(teamAName ? teamAName :
                            ''); 
                        $('#team2NameDisplayA').text(teamBName ? teamBName :
                            ''); 
                        $('#team2NameDisplayB').text(teamBName ? teamBName :
                            ''); 
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
                                const playerNames = data.playerNames;

                                // Filter out players with zero points
                                const filteredNames = [];
                                const filteredPoints = [];

                                points.forEach((point, index) => {
                                    if (point > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredPoints.push(point);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredPoints,
                                    }],
                                    colors: ["#1A56DB"], // Use a single color for all bars
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Points',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Vertical bars
                                            columnWidth: '50%', // Adjust the width of bars
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            }
                                        }
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("point-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching points data for Team A:', error));

                        // Fetch and update Team A Assists chart
                        fetch(`/assists-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const assists = data.assists;
                                const playerNames = data.playerNames;

                                // Filter out players with zero assists
                                const filteredNames = [];
                                const filteredAssists = [];

                                assists.forEach((assist, index) => {
                                    if (assist > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredAssists.push(assist);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredAssists,
                                    }],
                                    colors: ["#1A56DB"], // Use a single color for all bars
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Assists',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Vertical bars
                                            columnWidth: '50%', // Adjust the width of bars
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("assist-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching assists data for Team A:', error));

                        
                        // Fetch and update Team A Rebounds chart
                        fetch(`/rebounds-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const rebounds = data.rebounds;
                                const playerNames = data.playerNames;

                                // Filter out players with zero rebounds
                                const filteredNames = [];
                                const filteredRebounds = [];

                                rebounds.forEach((rebound, index) => {
                                    if (rebound > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredRebounds.push(rebound);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredRebounds,
                                    }],
                                    colors: ["#1A56DB"], // Use a single color for all bars
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Rebounds',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Vertical bars
                                            columnWidth: '50%', // Adjust the width of bars
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("rebound-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching rebounds data for Team A:', error));


                        // Fetch and update Team A Steals chart
                        fetch(`/steals-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const steals = data.steals;
                                const playerNames = data.playerNames;

                                // Filter out players with zero steals
                                const filteredNames = [];
                                const filteredSteals = [];

                                steals.forEach((steal, index) => {
                                    if (steal > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredSteals.push(steal);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredSteals,
                                    }],
                                    colors: ["#1A56DB"], // Use a single color for all bars
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Steals',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Vertical bars
                                            columnWidth: '50%', // Adjust the width of bars
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("steal-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching steals data for Team A:', error));

                        // Fetch and update Team A Blocks chart
                        fetch(`/blocks-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const blocks = data.blocks;
                                const playerNames = data.playerNames;

                                // Filter out players with zero blocks
                                const filteredNames = [];
                                const filteredBlocks = [];

                                blocks.forEach((block, index) => {
                                    if (block > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredBlocks.push(block);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredBlocks,
                                    }],
                                    colors: ["#1A56DB"], // Use a single color for all bars
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Blocks',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Vertical bars
                                            columnWidth: '50%', // Adjust the width of bars
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("block-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching blocks data for Team A:', error));

                        // Fetch and update Team A Personal Foul chart
                        fetch(`/perfoul-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const personalFouls = data.personal_fouls;
                                const playerNames = data.playerNames; // Use playerNames instead of playerIds

                                // Filter out players with zero personal fouls
                                const filteredNames = [];
                                const filteredFouls = [];
                                const colors = []; // Array to store custom colors for each slice

                                  // Predefined color palette
                                const predefinedColors = [
                                    "#FF5733", "#33FF57", "#3357FF", "#FF33A8", "#A833FF", "#33FFF6"
                                ];

                                personalFouls.forEach((foul, index) => {
                                    if (foul > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredFouls.push(foul);

                                        if (predefinedColors.length > 0) {
                                            colors.push(predefinedColors.shift());
                                        } else {
                                            colors.push("#CCCCCC"); 
                                        }
                                    }
                                });

                                // Donut chart options
                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "donut", // Donut chart type
                                        fontFamily: "Inter, sans-serif",
                                        dropShadow: {
                                            enabled: false,
                                        },
                                        toolbar: {
                                            show: false,
                                        },
                                    },
                                    series: filteredFouls, // Data for the donut chart (personal fouls)
                                    labels: filteredNames, // Player names who have personal fouls
                                    colors: colors, // Custom colors for each slice (random colors)
                                    legend: {
                                        position: "bottom",
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("perfoul-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching personal fouls data for Team A:', error));

                        // Fetch and update Team A Turnovers chart
                        fetch(`/turnovers-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const turnovers = data.turnovers;
                                const playerNames = data.playerNames;

                                // Filter out players with zero turnovers
                                const filteredNames = [];
                                const filteredTurnovers = [];

                                turnovers.forEach((turnover, index) => {
                                    if (turnover > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredTurnovers.push(turnover);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredTurnovers,
                                    }],
                                    colors: ["#1A56DB"], // Use only the specified color for all bars
                                    xaxis: {
                                        categories: filteredNames, // Use playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Turnovers',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Vertical bars
                                            columnWidth: '50%', // Adjust the width of bars
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller screens
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("turnover-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching turnovers data for Team A:', error));

                       // Fetch and update Team A Offensive Rebounds chart
                        fetch(`/offensive_rebounds-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const offensiveRebounds = data.offensive_rebounds;
                                const playerNames = data.playerNames;

                                // Filter out players with zero offensive rebounds
                                const filteredNames = [];
                                const filteredRebounds = [];
                                const colors = [];

                                 // Predefined color palette
                                const predefinedColors = [
                                    "#FF5733", "#33FF57", "#3357FF", "#FF33A8", "#A833FF", "#33FFF6"
                                ];

                                offensiveRebounds.forEach((rebound, index) => {
                                    if (rebound > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredRebounds.push(rebound);
                                        if (predefinedColors.length > 0) {
                                            colors.push(predefinedColors.shift());
                                        } else {
                                            colors.push("#CCCCCC"); 
                                        }
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "donut",
                                        fontFamily: "Inter, sans-serif",
                                        dropShadow: {
                                            enabled: false,
                                        },
                                        toolbar: {
                                            show: false,
                                        },
                                    },
                                    series: filteredRebounds, // Data for the donut chart
                                    labels: filteredNames, // Player names who have rebounds
                                    colors: colors, // Random colors for each slice
                                    legend: {
                                        position: "bottom",
                                    },
                                    responsive: [{
                                        breakpoint: 1000,
                                        options: {
                                            chart: {
                                                height: 250,
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("offensive_rebounds-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching offensive rebounds data for Team A:', error));

                        // Fetch and update Team A Defensive Rebounds chart
                        fetch(`/defensive_rebounds-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const defensiveRebounds = data.defensive_rebounds;
                                const playerNames = data.playerNames;

                                // Filter out players with zero defensive rebounds
                                const filteredNames = [];
                                const filteredRebounds = [];
                                const colors = [];

                                // Predefined color palette
                                const predefinedColors = [
                                    "#FF5733", "#33FF57", "#3357FF", "#FF33A8", "#A833FF", "#33FFF6"
                                ];

                                defensiveRebounds.forEach((rebound, index) => {
                                    if (rebound > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredRebounds.push(rebound);

                                        if (predefinedColors.length > 0) {
                                            colors.push(predefinedColors.shift());
                                        } else {
                                            colors.push("#CCCCCC"); 
                                        }
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "donut",
                                        fontFamily: "Inter, sans-serif",
                                        dropShadow: {
                                            enabled: false,
                                        },
                                        toolbar: {
                                            show: false,
                                        },
                                    },
                                    series: filteredRebounds, // Data for the donut chart
                                    labels: filteredNames, // Player names who have rebounds
                                    colors: colors, // Random colors for each slice
                                    legend: {
                                        position: "bottom",
                                    },
                                    responsive: [{
                                        breakpoint: 1000,
                                        options: {
                                            chart: {
                                                height: 250,
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("defensive_rebounds-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching defensive rebounds data for Team A:', error));

                        // Fetch and update Team A 2 Point FG Attempt chart
                        fetch(`/two_pt_fg_attempt-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const two_pt_fg_attempt = data.two_pt_fg_attempt;
                                const playerNames = data.playerNames; // Use playerNames instead of playerIds

                                // Filter out players with zero 2 Point FG Attempts
                                const filteredNames = [];
                                const filteredAttempts = [];

                                two_pt_fg_attempt.forEach((attempt, index) => {
                                    if (attempt > 0) { // Only include players with attempts
                                        filteredNames.push(playerNames[index]);
                                        filteredAttempts.push(attempt);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "line", // Bar chart for 2 Point FG Attempt
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
                                        data: filteredAttempts,
                                        color: "#1A56DB", // Custom color for 2 Point FG Attempt
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Filtered player names for X-axis
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

                                const chart = new ApexCharts(document.getElementById("two_pt_fg_attempt-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching 2 Point FG Attempt data for Team A:', error));

                        // Fetch and update Team A 2 Point FG Made chart
                        fetch(`/two_pt_fg_made-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const two_pt_fg_made = data.two_pt_fg_made;
                                const playerNames = data.playerNames; // Use playerNames instead of playerIds

                                // Filter out players with zero 2 Point FG Made
                                const filteredNames = [];
                                const filteredMades = [];

                                two_pt_fg_made.forEach((made, index) => {
                                    if (made > 0) { // Only include players with made shots
                                        filteredNames.push(playerNames[index]);
                                        filteredMades.push(made);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart for 2 Point FG Made
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
                                        data: filteredMades,
                                        color: "#1A56DB", 
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Filtered player names for X-axis
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

                                const chart = new ApexCharts(document.getElementById("two_pt_fg_made-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching 2 Point FG Made data for Team A:', error));

                        /// Fetch and update Team A Three Point FG Attempt chart
                        fetch(`/three_pt_fg_attempt-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const three_pt_fg_attempt = data.three_pt_fg_attempt;
                                const playerNames = data.playerNames;

                                // Filter out players with zero attempts
                                const filteredNames = [];
                                const filteredThreePtFgAttempt = [];

                                three_pt_fg_attempt.forEach((attempt, index) => {
                                    if (attempt > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredThreePtFgAttempt.push(attempt);
                                    }
                                });

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
                                        name: "Three Point FG Attempt",
                                        data: filteredThreePtFgAttempt,
                                        color: "#1A56DB",
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Three Point FG Attempt',
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

                                const chart = new ApexCharts(document.getElementById("three_pt_fg_attempt-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Three Point FG Attempt data for Team A:', error));

                        // Fetch and update Team A Three Point FG Made chart
                        fetch(`/three_pt_fg_made-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const three_pt_fg_made = data.three_pt_fg_made;
                                const playerNames = data.playerNames;

                                // Filter out players with zero made FG
                                const filteredNames = [];
                                const filteredThreePtFgMade = [];

                                three_pt_fg_made.forEach((made, index) => {
                                    if (made > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredThreePtFgMade.push(made);
                                    }
                                });

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
                                        name: "Three Point FG Made",
                                        data: filteredThreePtFgMade,
                                        color: "#1A56DB",
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Three Point FG Made',
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

                                const chart = new ApexCharts(document.getElementById("three_pt_fg_made-chart-a"), options);
                                chart.render();
                            })

                        // Fetch and update Team A Two Point Percentage chart
                        fetch(`/two_pt_percentage-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const twoPtPercentages = data.two_pt_percentage; // Two point percentages for players
                                const playerNames = data.playerNames; // Player names
                                
                                // Filter out players with zero two-point percentage
                                const filteredNames = [];
                                const filteredPercentages = [];
                                const colors = []; // Array to store custom colors for each slice

                                twoPtPercentages.forEach((percentage, index) => {
                                    if (percentage > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredPercentages.push(percentage);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300, // Fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredPercentages, // Filtered data for two point percentages
                                        color: "#1A56DB", // Static color for the bar chart
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Two Point Percentage (%)',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("two_pt_percentage-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Two Point Percentage data for Team A:', error));

                        // Fetch and update Team A Three Point Percentage chart
                        fetch(`/three_pt_percentage-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const threePtPercentages = data.three_pt_percentage; // Three-point percentages
                                const playerNames = data.playerNames; // Player names
                                
                                // Filter out players with zero three-point percentage
                                const filteredNames = [];
                                const filteredPercentages = [];
                                const colors = []; // Array to store custom colors for each slice

                                threePtPercentages.forEach((percentage, index) => {
                                    if (percentage > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredPercentages.push(percentage);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300, // Fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredPercentages, // Filtered data for three-point percentages
                                        color: "#1A56DB", // Static color for the bars
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Three Point Percentage (%)',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("three_pt_percentage-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Three Point Percentage data for Team A:', error));

                        // Fetch and update Team A Free Throw Attempt chart
                        fetch(`/free_throw_attempt-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const freeThrowAttempts = data.free_throw_attempt; // Free throw attempts
                                const playerNames = data.playerNames; // Player names
                                
                                // Filter out players with zero free throw attempts
                                const filteredNames = [];
                                const filteredAttempts = [];
                                const colors = []; // Array to store custom colors for each slice

                                freeThrowAttempts.forEach((attempt, index) => {
                                    if (attempt > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredAttempts.push(attempt);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Line chart options
                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "line", // Line chart type
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
                                        data: filteredAttempts, // Filtered data for free throw attempts
                                        color: "#1A56DB", // Static color for the line
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Free Throw Attempts',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("free_throw_attempt-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Free Throw Attempt data for Team A:', error));

                        // Fetch and update Team A Free Throw Made chart
                        fetch(`/free_throw_made-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const freeThrowMade = data.free_throw_made; // Free throw made data
                                const playerNames = data.playerNames; // Player names

                                // Filter out players with zero free throw made
                                const filteredNames = [];
                                const filteredMade = [];
                                const colors = []; // Array to store custom colors for each slice

                                freeThrowMade.forEach((made, index) => {
                                    if (made > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredMade.push(made);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Line chart options
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
                                        name: "Free Throw Made",
                                        data: filteredMade, // Filtered data for free throw made
                                        color: "#1A56DB", // Static color for the line
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
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
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("free_throw_made-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Free Throw Made data for Team A:', error));


                        // Fetch and update Team A Free Throw Percentage chart
                        fetch(`/free_throw_percentage-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const freeThrowPercentage = data.free_throw_percentage; // Free throw percentage data
                                const playerNames = data.playerNames; // Player names

                                // Filter out players with zero free throw percentage
                                const filteredNames = [];
                                const filteredPercentages = [];
                                const colors = []; // Array to store custom colors for each slice

                                freeThrowPercentage.forEach((percentage, index) => {
                                    if (percentage > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredPercentages.push(percentage);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "bar", // Bar chart type
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
                                        data: filteredPercentages, // Filtered data for free throw percentages
                                        color: "#1A56DB", // Static color for the bars
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Free Throw Percentage (%)',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("free_throw_percentage-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Free Throw Percentage data for Team A:', error));

                        // Fetch and update Team A Free throw attempt rate
                        fetch(`/free_throw_attempt_rate-chart-data-a/${scheduleId}`)
                                .then(response => response.json())
                                .then(data => {
                                    const freeThrowAttemptRate = data.free_throw_attempt_rate; // Free throw attempt rate data
                                    const playerNames = data.playerNames; // Player names

                                    // Filter out players with zero free throw attempt rate
                                    const filteredNames = [];
                                    const filteredAttemptRate = [];
                                    const colors = []; // Array to store custom colors for each slice

                                    freeThrowAttemptRate.forEach((attemptRate, index) => {
                                        if (attemptRate > 0) {
                                            filteredNames.push(playerNames[index]);
                                            filteredAttemptRate.push(attemptRate);

                                            // Generate random color for each player
                                            const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                            colors.push(randomColor);
                                        }
                                    });

                                    // Line chart options
                                    const options = {
                                        chart: {
                                            height: 300,
                                            width: "100%",
                                            type: "line", // Line chart type
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
                                            data: filteredAttemptRate, // Filtered data for free throw attempt rate
                                            color: "#1A56DB", // Static color for the line
                                        }],
                                        xaxis: {
                                            categories: filteredNames, // Player names on the X-axis
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
                                            breakpoint: 1000, // Responsive behavior for smaller devices
                                            options: {
                                                chart: {
                                                    height: 250, // Adjust height for smaller devices
                                                },
                                            },
                                        }],
                                    };

                                    const chart = new ApexCharts(document.getElementById("free_throw_attempt_rate-chart-a"), options);
                                    chart.render();
                                })
                                .catch(error => console.error('Error fetching Free Throw Attempt Rate data for Team A:', error));


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
                                const effectiveFieldGoalPercentage = data.effective_field_goal_percentage; // Effective field goal percentage data
                                const playerNames = data.playerNames; // Player names

                                // Filter out players with zero effective field goal percentage
                                const filteredNames = [];
                                const filteredEffectiveFieldGoalPercentage = [];
                                const colors = []; // Array to store custom colors for each slice

                                effectiveFieldGoalPercentage.forEach((percentage, index) => {
                                    if (percentage > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredEffectiveFieldGoalPercentage.push(percentage);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "bar", // Bar chart type
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
                                        data: filteredEffectiveFieldGoalPercentage, // Filtered data for effective field goal percentage
                                        color: "#1A56DB", // Static color for the bars
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
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
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("effective_field_goal_percentage-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Effective Field Goal Percentage data for Team A:', error));

                        // Fetch and update Team A Turnover Ratio chart
                        fetch(`/turnover_ratio-chart-data-a/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const turnoverRatio = data.turnover_ratio; // Turnover ratio data
                                const playerNames = data.playerNames; // Player names

                                // Filter out players with zero turnover ratio
                                const filteredNames = [];
                                const filteredTurnoverRatio = [];
                                const colors = []; // Array to store custom colors for each slice

                                turnoverRatio.forEach((ratio, index) => {
                                    if (ratio > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredTurnoverRatio.push(ratio);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "bar", // Change chart type to bar
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
                                        data: filteredTurnoverRatio, // Filtered data for turnover ratio
                                        color: "#1A56DB", // Static color for the bars
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
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
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("turnover_ratio-chart-a"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Turnover Ratio data for Team A:', error));


                    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                        // Fetch and update Team B Points chart
                        fetch(`/chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const points = data.points;
                                const playerNames = data.playerNames;

                                // Filter out players with zero points
                                const filteredNames = [];
                                const filteredPoints = [];

                                points.forEach((point, index) => {
                                    if (point > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredPoints.push(point);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredPoints,
                                    }],
                                    colors: ["#FF5733"], 
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Points',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Vertical bars
                                            columnWidth: '50%', // Adjust the width of bars
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            }
                                        }
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("point-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching points data for Team B:', error));

                        // Fetch and update Team B Assists chart
                        fetch(`/assists-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const assists = data.assists;
                                const playerNames = data.playerNames;

                                // Filter out players with zero assists
                                const filteredNames = [];
                                const filteredAssists = [];

                                assists.forEach((assist, index) => {
                                    if (assist > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredAssists.push(assist);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredAssists,
                                    }],
                                    colors: ["#FF5733"], // Use a single color for all bars
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Assists',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Vertical bars
                                            columnWidth: '50%', // Adjust the width of bars
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("assist-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching assists data for Team B:', error));

                        // Fetch and update Team B Rebounds chart
                        fetch(`/rebounds-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const rebounds = data.rebounds;
                                const playerNames = data.playerNames;

                                // Filter out players with zero rebounds
                                const filteredNames = [];
                                const filteredRebounds = [];

                                rebounds.forEach((rebound, index) => {
                                    if (rebound > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredRebounds.push(rebound);
                                    }
                                });

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
                                        name: "Rebounds",
                                        data: filteredRebounds,
                                    }],
                                    colors: ["#FF5733"], 
                                    xaxis: {
                                        categories: filteredNames, 
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Rebounds',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, 
                                            columnWidth: '50%',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, 
                                        options: {
                                            chart: {
                                                height: 250, 
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("rebound-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching rebounds data for Team B:', error));

                        // Fetch and update Team B Steals chart
                        fetch(`/steals-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const steals = data.steals;
                                const playerNames = data.playerNames;

                                // Filter out players with zero steals
                                const filteredNames = [];
                                const filteredSteals = [];

                                steals.forEach((steal, index) => {
                                    if (steal > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredSteals.push(steal);
                                    }
                                });

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
                                        name: "Steals",
                                        data: filteredSteals,
                                    }],
                                    colors: ["#FF5733"], 
                                    xaxis: {
                                        categories: filteredNames, 
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Steals',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, 
                                            columnWidth: '50%', 
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000,
                                        options: {
                                            chart: {
                                                height: 250,
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("steal-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching steals data for Team B:', error));

                        // Fetch and update Team B Blocks chart
                        fetch(`/blocks-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const blocks = data.blocks;
                                const playerNames = data.playerNames;

                                // Filter out players with zero blocks
                                const filteredNames = [];
                                const filteredBlocks = [];

                                blocks.forEach((block, index) => {
                                    if (block > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredBlocks.push(block);
                                    }
                                });

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
                                        name: "Blocks",
                                        data: filteredBlocks,
                                    }],
                                    colors: ["#FF5733"],
                                    xaxis: {
                                        categories: filteredNames,
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Blocks',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, 
                                            columnWidth: '50%', 
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, 
                                        options: {
                                            chart: {
                                                height: 250,
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("block-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching blocks data for Team B:', error));

                        // Fetch and update Team B Personal Fouls chart
                        fetch(`/perfoul-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const personalFouls = data.personal_fouls;
                                const playerNames = data.playerNames;

                                // Filter out players with zero personal fouls
                                const filteredNames = [];
                                const filteredFouls = [];
                                const colors = [];

                                // Predefined color palette
                                const predefinedColors = [
                                    "#FF5733", "#33FF57", "#3357FF", "#FF33A8", "#A833FF", "#33FFF6"
                                ];

                                personalFouls.forEach((foul, index) => {
                                    if (foul > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredFouls.push(foul);

                                        if (predefinedColors.length > 0) {
                                            colors.push(predefinedColors.shift());
                                        } else {
                                            colors.push("#CCCCCC"); 
                                        }
                                    }
                                });

                                // Donut chart options
                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "donut", 
                                        fontFamily: "Inter, sans-serif",
                                        dropShadow: {
                                            enabled: false,
                                        },
                                        toolbar: {
                                            show: false,
                                        },
                                    },
                                    series: filteredFouls, // Data for the donut chart (personal fouls)
                                    labels: filteredNames, // Player names who have personal fouls
                                    colors: colors, // Custom colors for each slice (random colors)
                                    legend: {
                                        position: "bottom",
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller screens
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("perfoul-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching personal fouls data for Team B:', error));


                        // Fetch and update Team B Turnovers chart
                        fetch(`/turnovers-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const turnovers = data.turnovers;
                                const playerNames = data.playerNames;

                                // Filter out players with zero turnovers
                                const filteredNames = [];
                                const filteredTurnovers = [];

                                turnovers.forEach((turnover, index) => {
                                    if (turnover > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredTurnovers.push(turnover);
                                    }
                                });

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
                                        name: "Turnovers",
                                        data: filteredTurnovers,
                                    }],
                                    colors: ["#FF5733"], 
                                    xaxis: {
                                        categories: filteredNames,
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Turnovers',
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, 
                                            columnWidth: '50%', 
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, 
                                        options: {
                                            chart: {
                                                height: 250,
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("turnover-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching turnovers data for Team B:', error));

                        // Fetch and update Team B Offensive Rebounds chart
                        fetch(`/offensive_rebounds-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const offensiveRebounds = data.offensive_rebounds;
                                const playerNames = data.playerNames;

                                // Filter out players with zero offensive rebounds
                                const filteredNames = [];
                                const filteredRebounds = [];
                                const colors = [];

                                // Predefined color palette
                                const predefinedColors = [
                                    "#FF5733", "#33FF57", "#3357FF", "#FF33A8", "#A833FF", "#33FFF6"
                                ];

                                offensiveRebounds.forEach((rebound, index) => {
                                    if (rebound > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredRebounds.push(rebound);

                                        if (predefinedColors.length > 0) {
                                            colors.push(predefinedColors.shift());
                                        } else {
                                            colors.push("#CCCCCC"); 
                                        }
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "donut",
                                        fontFamily: "Inter, sans-serif",
                                        dropShadow: {
                                            enabled: false,
                                        },
                                        toolbar: {
                                            show: false,
                                        },
                                    },
                                    series: filteredRebounds,
                                    labels: filteredNames, 
                                    colors: colors, 
                                    legend: {
                                        position: "bottom",
                                    },
                                    responsive: [{
                                        breakpoint: 1000,
                                        options: {
                                            chart: {
                                                height: 250,
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("offensive_rebounds-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching offensive rebounds data for Team B:', error));


                        // Fetch and update Team B Defensive Rebounds chart
                        fetch(`/defensive_rebounds-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const defensiveRebounds = data.defensive_rebounds;
                                const playerNames = data.playerNames;

                                // Filter out players with zero defensive rebounds
                                const filteredNames = [];
                                const filteredRebounds = [];
                                const colors = [];

                                 // Predefined color palette
                                const predefinedColors = [
                                    "#FF5733", "#33FF57", "#3357FF", "#FF33A8", "#A833FF", "#33FFF6"
                                ];

                                defensiveRebounds.forEach((rebound, index) => {
                                    if (rebound > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredRebounds.push(rebound);

                                        if (predefinedColors.length > 0) {
                                            colors.push(predefinedColors.shift());
                                        } else {
                                            colors.push("#CCCCCC"); 
                                        }
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "donut",
                                        fontFamily: "Inter, sans-serif",
                                        dropShadow: {
                                            enabled: false,
                                        },
                                        toolbar: {
                                            show: false,
                                        },
                                    },
                                    series: filteredRebounds, 
                                    labels: filteredNames,
                                    colors: colors, 
                                    legend: {
                                        position: "bottom",
                                    },
                                    responsive: [{
                                        breakpoint: 1000,
                                        options: {
                                            chart: {
                                                height: 250,
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("defensive_rebounds-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching defensive rebounds data for Team B:', error));


                        // Fetch and update Team B two Point FG Attempt chart
                        fetch(`/two_pt_fg_attempt-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const two_pt_fg_attempt = data.two_pt_fg_attempt;
                                const playerNames = data.playerNames; // Use playerNames instead of playerIds

                                // Filter out players with zero 2 Point FG Attempts
                                const filteredNames = [];
                                const filteredAttempts = [];

                                two_pt_fg_attempt.forEach((attempt, index) => {
                                    if (attempt > 0) { // Only include players with attempts
                                        filteredNames.push(playerNames[index]);
                                        filteredAttempts.push(attempt);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "line", // Bar chart for 2 Point FG Attempt
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
                                        data: filteredAttempts,
                                        color: "#FF5733", // Custom color for 2 Point FG Attempt
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Filtered player names for X-axis
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

                                const chart = new ApexCharts(document.getElementById("two_pt_fg_attempt-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching 2 Point FG Attempt data for Team B:', error));

                        // Fetch and update Team B two Point FG Made chart
                        fetch(`/two_pt_fg_made-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const two_pt_fg_made = data.two_pt_fg_made;
                                const playerNames = data.playerNames; // Use playerNames instead of playerIds

                                // Filter out players with zero 2 Point FG Made
                                const filteredNames = [];
                                const filteredMades = [];

                                two_pt_fg_made.forEach((made, index) => {
                                    if (made > 0) { // Only include players with made shots
                                        filteredNames.push(playerNames[index]);
                                        filteredMades.push(made);
                                    }
                                });

                                const options = {
                                    chart: {
                                        height: 300, // Set a fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart for 2 Point FG Made
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
                                        data: filteredMades,
                                        color: "#FF5733", 
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Filtered player names for X-axis
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

                                const chart = new ApexCharts(document.getElementById("two_pt_fg_made-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching 2 Point FG Made data for Team B:', error));


                        // Fetch and update Team B three Point FG Attempt chart
                        fetch(`/three_pt_fg_attempt-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const three_pt_fg_attempt = data.three_pt_fg_attempt;
                                const playerNames = data.playerNames;

                                // Filter out players with zero attempts
                                const filteredNames = [];
                                const filteredThreePtFgAttempt = [];

                                three_pt_fg_attempt.forEach((attempt, index) => {
                                    if (attempt > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredThreePtFgAttempt.push(attempt);
                                    }
                                });

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
                                        name: "Three Point FG Attempt",
                                        data: filteredThreePtFgAttempt,
                                        color: "#FF5733",
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Three Point FG Attempt',
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

                                const chart = new ApexCharts(document.getElementById("three_pt_fg_attempt-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Three Point FG Attempt data for Team B:', error));

                        // Fetch and update Team B three Point FG Made chart
                        fetch(`/three_pt_fg_made-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const three_pt_fg_made = data.three_pt_fg_made;
                                const playerNames = data.playerNames;

                                // Filter out players with zero made FG
                                const filteredNames = [];
                                const filteredThreePtFgMade = [];

                                three_pt_fg_made.forEach((made, index) => {
                                    if (made > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredThreePtFgMade.push(made);
                                    }
                                });

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
                                        name: "Three Point FG Made",
                                        data: filteredThreePtFgMade,
                                        color: "#FF5733",
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Use filtered playerNames as categories for X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Three Point FG Made',
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

                                const chart = new ApexCharts(document.getElementById("three_pt_fg_made-chart-b"), options);
                                chart.render();
                            })

                        // Fetch and update Team B Two Point Percentage chart
                        fetch(`/two_pt_percentage-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const twoPtPercentages = data.two_pt_percentage; // Two point percentages for players
                                const playerNames = data.playerNames; // Player names
                                
                                // Filter out players with zero two-point percentage
                                const filteredNames = [];
                                const filteredPercentages = [];
                                const colors = []; // Array to store custom colors for each slice

                                twoPtPercentages.forEach((percentage, index) => {
                                    if (percentage > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredPercentages.push(percentage);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300, // Fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredPercentages, // Filtered data for two point percentages
                                        color: "#FF5733", // Static color for the bar chart
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Two Point Percentage (%)',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("two_pt_percentage-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Two Point Percentage data for Team B:', error));

                        // Fetch and update Team B Three Point Percentage chart
                        fetch(`/three_pt_percentage-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const threePtPercentages = data.three_pt_percentage; // Three-point percentages
                                const playerNames = data.playerNames; // Player names
                                
                                // Filter out players with zero three-point percentage
                                const filteredNames = [];
                                const filteredPercentages = [];
                                const colors = []; // Array to store custom colors for each slice

                                threePtPercentages.forEach((percentage, index) => {
                                    if (percentage > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredPercentages.push(percentage);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300, // Fixed height in pixels
                                        width: "100%", // Responsive width
                                        type: "bar", // Bar chart type
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
                                        data: filteredPercentages, // Filtered data for three-point percentages
                                        color: "#FF5733", // Static color for the bars
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Three Point Percentage (%)',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("three_pt_percentage-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Three Point Percentage data for Team B:', error));


                        // Fetch and update Team B Free Throw Attempt chart
                        fetch(`/free_throw_attempt-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const freeThrowAttempts = data.free_throw_attempt; // Free throw attempts
                                const playerNames = data.playerNames; // Player names
                                
                                // Filter out players with zero free throw attempts
                                const filteredNames = [];
                                const filteredAttempts = [];
                                const colors = []; // Array to store custom colors for each slice

                                freeThrowAttempts.forEach((attempt, index) => {
                                    if (attempt > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredAttempts.push(attempt);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Line chart options
                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "line", // Line chart type
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
                                        data: filteredAttempts, // Filtered data for free throw attempts
                                        color: "#FF5733", // Static color for the line
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Free Throw Attempts',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("free_throw_attempt-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Free Throw Attempt data for Team B:', error));


                        // Fetch and update Team B Free Throw Made chart
                        fetch(`/free_throw_made-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const freeThrowMade = data.free_throw_made; // Free throw made data
                                const playerNames = data.playerNames; // Player names

                                // Filter out players with zero free throw made
                                const filteredNames = [];
                                const filteredMade = [];
                                const colors = []; // Array to store custom colors for each slice

                                freeThrowMade.forEach((made, index) => {
                                    if (made > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredMade.push(made);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Line chart options
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
                                        name: "Free Throw Made",
                                        data: filteredMade, // Filtered data for free throw made
                                        color: "#FF5733", // Static color for the line
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
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
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("free_throw_made-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Free Throw Made data for Team B:', error));


                        // Fetch and update Team B Free Throw Percentage chart
                        fetch(`/free_throw_percentage-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const freeThrowPercentage = data.free_throw_percentage; // Free throw percentage data
                                const playerNames = data.playerNames; // Player names

                                // Filter out players with zero free throw percentage
                                const filteredNames = [];
                                const filteredPercentages = [];
                                const colors = []; // Array to store custom colors for each slice

                                freeThrowPercentage.forEach((percentage, index) => {
                                    if (percentage > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredPercentages.push(percentage);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "bar", // Bar chart type
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
                                        data: filteredPercentages, // Filtered data for free throw percentages
                                        color: "#FF5733", // Static color for the bars
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
                                        title: {
                                            text: 'Players',
                                        },
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Free Throw Percentage (%)',
                                        },
                                    },
                                    responsive: [{
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("free_throw_percentage-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Free Throw Percentage data for Team B:', error));

                        // Fetch and update Team B Free Throw Attempt Rate chart
                        fetch(`/free_throw_attempt_rate-chart-data-b/${scheduleId}`)
                                .then(response => response.json())
                                .then(data => {
                                    const freeThrowAttemptRate = data.free_throw_attempt_rate; // Free throw attempt rate data
                                    const playerNames = data.playerNames; // Player names

                                    // Filter out players with zero free throw attempt rate
                                    const filteredNames = [];
                                    const filteredAttemptRate = [];
                                    const colors = []; // Array to store custom colors for each slice

                                    freeThrowAttemptRate.forEach((attemptRate, index) => {
                                        if (attemptRate > 0) {
                                            filteredNames.push(playerNames[index]);
                                            filteredAttemptRate.push(attemptRate);

                                            // Generate random color for each player
                                            const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                            colors.push(randomColor);
                                        }
                                    });

                                    // Line chart options
                                    const options = {
                                        chart: {
                                            height: 300,
                                            width: "100%",
                                            type: "line", // Line chart type
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
                                            data: filteredAttemptRate, // Filtered data for free throw attempt rate
                                            color: "#FF5733", // Static color for the line
                                        }],
                                        xaxis: {
                                            categories: filteredNames, // Player names on the X-axis
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
                                            breakpoint: 1000, // Responsive behavior for smaller devices
                                            options: {
                                                chart: {
                                                    height: 250, // Adjust height for smaller devices
                                                },
                                            },
                                        }],
                                    };

                                    const chart = new ApexCharts(document.getElementById("free_throw_attempt_rate-chart-b"), options);
                                    chart.render();
                                })
                                .catch(error => console.error('Error fetching Free Throw Attempt Rate data for Team B:', error));


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
                                const effectiveFieldGoalPercentage = data.effective_field_goal_percentage; // Effective field goal percentage data
                                const playerNames = data.playerNames; // Player names

                                // Filter out players with zero effective field goal percentage
                                const filteredNames = [];
                                const filteredEffectiveFieldGoalPercentage = [];
                                const colors = []; // Array to store custom colors for each slice

                                effectiveFieldGoalPercentage.forEach((percentage, index) => {
                                    if (percentage > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredEffectiveFieldGoalPercentage.push(percentage);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "bar", // Bar chart type
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
                                        data: filteredEffectiveFieldGoalPercentage, // Filtered data for effective field goal percentage
                                        color: "#FF5733", // Static color for the bars
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
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
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("effective_field_goal_percentage-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Effective Field Goal Percentage data for Team B:', error));


                        // Fetch and update Team B Turnover Ratio chart
                        fetch(`/turnover_ratio-chart-data-b/${scheduleId}`)
                            .then(response => response.json())
                            .then(data => {
                                const turnoverRatio = data.turnover_ratio; // Turnover ratio data
                                const playerNames = data.playerNames; // Player names

                                // Filter out players with zero turnover ratio
                                const filteredNames = [];
                                const filteredTurnoverRatio = [];
                                const colors = []; // Array to store custom colors for each slice

                                turnoverRatio.forEach((ratio, index) => {
                                    if (ratio > 0) {
                                        filteredNames.push(playerNames[index]);
                                        filteredTurnoverRatio.push(ratio);

                                        // Generate random color for each player
                                        const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`; // Random color
                                        colors.push(randomColor);
                                    }
                                });

                                // Bar chart options
                                const options = {
                                    chart: {
                                        height: 300,
                                        width: "100%",
                                        type: "bar", // Change chart type to bar
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
                                        data: filteredTurnoverRatio, // Filtered data for turnover ratio
                                        color: "#FF5733", // Static color for the bars
                                    }],
                                    xaxis: {
                                        categories: filteredNames, // Player names on the X-axis
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
                                        breakpoint: 1000, // Responsive behavior for smaller devices
                                        options: {
                                            chart: {
                                                height: 250, // Adjust height for smaller devices
                                            },
                                        },
                                    }],
                                };

                                const chart = new ApexCharts(document.getElementById("turnover_ratio-chart-b"), options);
                                chart.render();
                            })
                            .catch(error => console.error('Error fetching Turnover Ratio data for Team B:', error));


                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Click the basic stats button by default
                const basicStatsButton = document.querySelector('.nav-btn[data-type="basicstatsA,basicstatsB"]');
                basicStatsButton.click();
            });

            document.querySelectorAll('.nav-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons (resets them to default state)
                    document.querySelectorAll('.nav-btn').forEach(btn => {
                        btn.classList.remove('bg-[#314795]');
                        btn.classList.add('bg-gray-400');
                    });

                    // Add the active class to the clicked button
                    this.classList.remove('bg-gray-400');
                    this.classList.add('bg-[#314795]');

                    // Get the selected data types from the clicked button's 'data-type' attribute
                    const selectedTypes = this.getAttribute('data-type').split(',');

                    // Hide all content sections before showing the relevant ones
                    document.querySelectorAll('.content-section').forEach(section => {
                        section.classList.add('hidden'); // Hides each section
                    });

                    // Show the sections that match the 'data-type' of the clicked button
                    selectedTypes.forEach(type => {
                        const selectedSection = document.getElementById(type);
                        if (selectedSection) {
                            selectedSection.classList.remove('hidden'); // Show the matching sections
                        }
                    });
                });
            });
        </script>
    </div>
</x-app-layout>