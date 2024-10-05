<x-app-layout>
    <div class="py-12">
        <div class="mx-auto p-4">
            <div class="flex space-x-8">
                <!-- Live Scoring Section -->
                <div class="bg-gray-100 p-6 rounded-lg border border-gray-400 shadow-md flex-1">
                    <div class="mb-6 text-center">
                        <h2 class="font-semibold text-xl text-black leading-tight">Live Scoring</h2>
                        <hr class="border-gray-300 border-t-2 mt-2">
                    </div>
                    <input type="hidden" id="currentScheduleId" value="{{ $schedule_id }}">
                    <div class="mb-6">
                        <div class="flex bg-gray-100 py-4 px-6 rounded-lg shadow-md border border-gray-400 space-x-4 items-center">
                            <div class="flex-1 bg-white p-2 rounded-lg shadow text-center">
                                <h3 class="font-bold text-lg text-black">{{ $team1Name }}</h3>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow text-center">
                                    <p id="team-a-score" class="text-4xl font-semibold text-black">{{$teamAScore}}</p>
                            </div>
                            <div class="flex flex-col items-center space-y-2">
                                <div class="bg-white p-4 rounded-lg shadow text-center">
                                    <p id="gameTime" class="text-4xl font-semibold text-black">10:00</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow text-center">
                                    <h3 class="font-bold text-lg text-black">Pause/Start Time</h3>
                                    <div class="flex justify-center space-x-4 mt-2">
                                        <button id="startButton" class="bg-blue-500 text-white p-2 rounded">Start</button>
                                        <button id="pauseButton" class="bg-red-500 text-white p-2 rounded">Pause</button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow text-center">
                                    <p id="team-b-score" class="text-4xl font-semibold text-black">{{$teamBScore}}</p>
                            </div>
                            <div class="flex-1 bg-white p-2 rounded-lg shadow text-center">
                                <h3 class="font-bold text-lg text-black">{{ $team2Name }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center space-y-4 mb-4">
                        <div class="flex flex-row space-x-8 w-full">
                            <!-- Team A Section -->
                            <div class="flex flex-col items-center w-1/2">
                                <!-- Starting Players for Team A -->
                                <div class="flex flex-wrap justify-center gap-2" id="startingTeamA">
                                    @for ($i = 0; $i < 5; $i++)
                                        <div class="player-box bg-gray-500 text-center cursor-pointer text-white rounded p-2 w-16 h-16 flex items-center justify-center" 
                                            data-team="teamA" data-position="starting" data-index="{{ $i }}"
                                            data-player-number="{{ isset($startingPlayersTeamA[$i]) ? $startingPlayersTeamA[$i]->number : '' }}"
                                            onclick="selectPlayer(this)">
                                            <p>{{ isset($startingPlayersTeamA[$i]) ? $startingPlayersTeamA[$i]->number : '' }}</p>
                                        </div>
                                    @endfor
                                </div>
                    
                                <!-- Bench Players for Team A -->
                                <div class="grid grid-cols-5 sm:grid-cols-4 md:grid-cols-3 lg:grid-cols-5 gap-2 mt-2" id="benchPlayersTeamA">
                                    @foreach ($benchPlayersTeamA as $player)
                                        <div class="player-box bg-gray-500 text-center cursor-pointer text-white rounded p-2 w-16 h-16 flex items-center justify-center"
                                            data-team="teamA" data-position="bench" data-player-number="{{ $player->number }}"
                                            onclick="selectPlayer(this)">
                                            <p>{{ $player->number }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                    
                            <!-- Control Buttons -->
                            <div class="flex flex-col items-center space-y-4">
                                <button id="quarterButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                    Q1
                                </button>
                                <button id="nextQuarterButtonSub" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50" onclick="nextQuarter()">
                                    Next Quarter
                                </button>
                                <button id="subButton"
                                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50"
                                    onclick="performSubstitution()">
                                Sub
                            </button>
                            </div>
                    
                            <!-- Team B Section -->
                            <div class="flex flex-col items-center w-1/2">
                                <!-- Starting Players for Team B -->
                                <div class="flex flex-wrap justify-center gap-2" id="startingTeamB">
                                    @for ($i = 0; $i < 5; $i++)
                                        <div class="player-box bg-gray-500 text-center cursor-pointer text-white rounded p-2 w-16 h-16 flex items-center justify-center"
                                            data-team="teamB" data-position="starting" data-index="{{ $i }}"
                                            onclick="selectPlayer(this)">
                                            <p>{{ isset($startingPlayersTeamB[$i]) ? $startingPlayersTeamB[$i]->number : '' }}</p>
                                        </div>
                                    @endfor
                                </div>
                    
                                <!-- Bench Players for Team B -->
                                <div class="grid grid-cols-5 sm:grid-cols-4 md:grid-cols-3 lg:grid-cols-5 gap-2 mt-2" id="benchPlayersTeamB">
                                    @foreach ($benchPlayersTeamB as $player)
                                        <div class="player-box bg-gray-500 text-center cursor-pointer text-white rounded p-2 w-16 h-16 flex items-center justify-center"
                                            data-team="teamB" data-position="bench" data-player-number="{{ $player->number }}"
                                            onclick="selectPlayer(this)">
                                            <p>{{ $player->number }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 mt-12">
                        <x-message></x-message>
                        <form method="POST" action="{{ route('playerstats.store') }}" id="playerStatsForm">
                            @csrf
                            <input type="hidden" name="player_number" id="selectedPlayerNumber">
                            <input type="hidden" name="team_name" id="selectedTeamName">

                            <!-- Assist -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="madeAssist()">Assist</button>
                                {{-- <button type="button" class="bg-gray-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="()">No Assist</button> --}}
                            </div>

                            <!-- Made Points -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="madeTwoPoints()">Made 2 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="madeThreePoints()">Made 3 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="madeFreeThrow()">Made Free Throw</button>
                            </div>

                            <!-- Missed Points -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-gray-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="missedTwoPoints()">Missed 2 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="missedThreePoints()">Missed 3 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="missedFreeThrow()">Missed Free Throw</button>
                            </div>

                            <!-- Rebounds -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="madeOffensiveRebound()">Offensive Rebound</button>
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="madeDefensiveRebound()">Defensive Rebound</button>
                            </div>

                            <!-- Block, Steal, Turnover, Foul -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeBlock()">Block</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeSteal()">Steal</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeTurnover()">Turnover</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeFoul()">Foul</button>
                            </div>

                            <button type="submit" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save Stats</button>
                        </form>
                    </div>
                </div>

                <div class="parent-container" >
                    <div class="bg-gray-100 p-6 rounded-lg border border-gray-400 shadow-md flex flex-col h-full">
                        <div class="mb-6 text-center">
                            <h2 class="font-semibold text-xl text-black leading-tight">Live Player Statistics</h2>
                            <hr class="border-gray-300 border-t-2 mt-2">
                        </div>
                        <div id="live-statistics" class="flex-1 mt-4 overflow-y-auto">
                                    {{-- Play by play display --}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .player-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 24px;
            margin: 4px;
        }

        .middle-box {
            width: 90px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 18px;
            margin: 4px;
        }

        .parent-container {
            height: 150vh;
            width: 60vh;
        }  

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>

    let currentQuarter = 1;
    let timer;
    let timeLeft = 600; // 10 minutes in seconds
    const teamAId = {{ $teams[0]->id }};
    const teamBId = {{ $teams[1]->id }};
    let totalElapsedTime = 0; 
    let quarterElapsedTime = 0;
    let teamAScore = 0;
    let teamBScore = 0;
    let playerTimes= {
    teamA: {},
    teamB: {}
    }; 
    let gameTime = 0;

    function getCurrentScheduleId() {
        return document.getElementById('currentScheduleId').value;
    }

    function getTeamId(teamPlaceholder) {
        if (teamPlaceholder === 'teamA') {
            return teamAId; 
        } else if (teamPlaceholder === 'teamB') {
            return teamBId; 
        }
        return null; 
    }

    function convertTimeToSeconds(time) {
        const parts = time.split(':');
        return parseInt(parts[0]) * 60 + parseInt(parts[1]);
    }

    function getCurrentQuarter() {
        return currentQuarter;
    }

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }

    function updateDisplay() {
        document.getElementById('gameTime').textContent = formatTime(timeLeft);
        document.getElementById('quarterButton').innerText = `Q${currentQuarter}`;
    }

    function updateTimer() {
        if (timeLeft <= 0) {
            clearInterval(timer);
            alert("Game over!");
            return;
        }
        
        timeLeft--;
        totalElapsedTime++; // Update total elapsed time
        updateDisplay();
        sendElapsedTimeDataToBackend(); // Send elapsed time data to backend
    }

    function startTimer() {
        if (!timer) {
            timer = setInterval(updateTimer, 1000); // Update every second
        }
        startGameTimeTracking();
    }

    function stopTimer() {
        if (timer) {
            clearInterval(timer); // Clear the timer interval
            timer = null; // Reset the timer variable
        }
        stopGameTimeTracking() 
    }

    function resetTimer() {
        timeLeft = 600; // Reset to 10 minutes
        updateDisplay(); // Update the display
    }

    function nextQuarter() {
        if (currentQuarter < 4) {
            totalElapsedTime += (600 - timeLeft); // Update total elapsed time
            currentQuarter++;
            resetTimer(); // Reset the timer to 10 minutes for the next quarter
            stopTimer(); // Stop the timer
            updateDisplay(); // Update the display
            sendElapsedTimeDataToBackend(); // Send data for the previous quarter
        } else {
            alert('Already in the final quarter');
        }
    }

    function startGameTimeTracking() {
        gameTimeInterval = setInterval(() => {
            // Iterate over each starting position player and increase their minutes
            const playerBoxes = document.querySelectorAll('#startingTeamA .player-box, #startingTeamB .player-box');

            // Log the number of player boxes found
            console.log(`Found ${playerBoxes.length} player boxes.`);

            playerBoxes.forEach(box => {
                const playerNumber = box.dataset.playerNumber;
                const team = box.dataset.team;

                if (playerNumber) {
                    if (!playerTimes[team][playerNumber]) {
                        playerTimes[team][playerNumber] = 0; // Initialize if not present
                    }
                    playerTimes[team][playerNumber] += 1; 
                    console.log(`Updated ${team} player ${playerNumber}: ${playerTimes[team][playerNumber]} seconds`); // Log updated time
                }
            });

            // Log current player times after updating
            console.log('Current player times:', playerTimes); 
        }, 1000); 
    }

    function stopGameTimeTracking() {
        clearInterval(gameTimeInterval); // Stop the game time tracking when needed
    }

    function sendElapsedTimeDataToBackend() {
        const scheduleId = getCurrentScheduleId();

        if (!scheduleId) {
            console.error('No schedule ID found.');
            return;
        }

        const gameTimeElement = document.getElementById('gameTime');
        const gameTime = gameTimeElement.textContent || gameTimeElement.innerText;
        const gameTimeInSeconds = convertTimeToSeconds(gameTime);

        const quarter = currentQuarter;
        const quarterElapsedTime = 600 - timeLeft; // Calculate based on remaining time

        const transformedPlayerTimes = {
            teamA: {},
            teamB: {}
        };

        for (const team in playerTimes) {
            for (const player in playerTimes[team]) {
                transformedPlayerTimes[team][player] = playerTimes[team][player];
            }
        }

        // Add the recorded player times to the data
        const dataToSend = {
            _token: '{{ csrf_token() }}',
            schedule_id: scheduleId,
            current_quarter: quarter,
            game_time: gameTimeInSeconds,
            total_elapsed_time: totalElapsedTime,
            quarter_elapsed_time: quarterElapsedTime,
            player_minutes: transformedPlayerTimes 
        };

        console.log('Sending elapsed time and player minutes data to backend:', dataToSend);

        $.ajax({
            url: '{{ route('schedules.storeGameTime') }}',
            method: 'POST',
            data: dataToSend,
            success: function(response) {
                console.log('Elapsed time recorded successfully:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error recording elapsed time:', status, error);
            }
        });
    }

    function fetchGameDetails(scheduleId) {
        $.ajax({
            url: `/getGameDetails/${scheduleId}`,
            method: 'GET',
            success: function(data) {
                console.log('Fetched game details:', data); // Debug log
                currentQuarter = data.current_quarter || 1; // Default to Q1 if not provided
                totalElapsedTime = data.total_elapsed_time || 0; // Set total elapsed time from fetched data
                timeLeft = Math.max(600 - totalElapsedTime, 0); // Ensure timeLeft doesn't go negative
                
                // Update the display immediately
                updateDisplay();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching game details:', error);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const scheduleId = getCurrentScheduleId();
        fetchGameDetails(scheduleId);

        // Event listeners
        document.getElementById('startButton').addEventListener('click', startTimer);
        document.getElementById('pauseButton').addEventListener('click', stopTimer);
        document.getElementById('quarterButton').addEventListener('click', nextQuarter);
    });

    let selectedBenchPlayer = null;
    let selectedStartingPosition = null;

    function selectPlayer(playerBox) {
        const teamPlaceholder = playerBox.dataset.team; // team should be 'teamA' or 'teamB'
        const position = playerBox.dataset.position;
        const index = position === 'starting' ? parseInt(playerBox.dataset.index, 10) : null;
        const playerNumber = playerBox.dataset.playerNumber || '';
        const scheduleId = getCurrentScheduleId();

        const selectedPlayer = {
            playerNumber: playerNumber,
            team: teamPlaceholder,
            index: index,
            box: playerBox,
            teamId: getTeamId(teamPlaceholder),
            scheduleId: scheduleId 
        };

        if (position === 'bench') {
            selectedBenchPlayer = selectedPlayer;
            highlightSelected(playerBox);
        } else if (position === 'starting') {
            selectedStartingPosition = selectedPlayer;
            highlightSelected(playerBox);
        }

        console.log('Selected Player Data:', {
            playerNumber: selectedPlayer.playerNumber,
            team: selectedPlayer.team,
            index: selectedPlayer.index,
            teamId: selectedPlayer.teamId,
            scheduleId: selectedPlayer.scheduleId
        });
        console.log(getCurrentQuarter()); 
    }

    function updateBox(box, playerNumber) {
        // Update the data attribute and text inside the box
        box.dataset.playerNumber = playerNumber;
        box.querySelector('p').textContent = playerNumber;
    }

    // Highlight selected player
    function highlightSelected(playerBox) {
        // Clear previous highlights
        document.querySelectorAll('.player-box').forEach(box => {
            box.classList.remove('border-4', 'border-green-500');
        });

        // Highlight current selection
        playerBox.classList.add('border-4', 'border-green-500');
    }

    function performSubstitution() {
        // Check if both players are selected
        if (!selectedBenchPlayer || selectedStartingPosition === null) {
            alert('Please select a player from the bench and a starting position to substitute.');
            return;
        }

        // Check if both players are from the same team
        if (selectedBenchPlayer.team !== selectedStartingPosition.team) {
            alert('You can only substitute players within the same team.');
            return;
        }

        // Get the team and position-related selectors
        const startingSelector = `#starting${selectedStartingPosition.team === 'teamA' ? 'TeamA' : 'TeamB'} .player-box:nth-child(${selectedStartingPosition.index + 1})`;
        const benchSelector = `#benchPlayers${selectedBenchPlayer.team === 'teamA' ? 'TeamA' : 'TeamB'} .player-box[data-player-number="${selectedBenchPlayer.playerNumber}"]`;

        // Find the starting and bench boxes
        const startingBox = document.querySelector(startingSelector);
        const benchBox = document.querySelector(benchSelector);

        // Check if the boxes are found
        if (startingBox && benchBox) {
            // Get the player number currently in the starting position
            const startingPlayerNumber = startingBox.querySelector('p').innerText.trim();

            // Swap player numbers
            startingBox.innerHTML = `<p>${selectedBenchPlayer.playerNumber}</p>`;
            benchBox.innerHTML = `<p>${startingPlayerNumber}</p>`;

            // Update data attributes
            startingBox.dataset.playerNumber = selectedBenchPlayer.playerNumber;
            benchBox.dataset.playerNumber = startingPlayerNumber;

            // Reset selections
            selectedBenchPlayer = null;
            selectedStartingPosition = null;

            // Remove highlights from all player boxes
            document.querySelectorAll('.player-box').forEach(box => {
                box.classList.remove('border-4', 'border-green-500'); // Adjust these classes to match your highlight styles
            });
        } else {
            alert('Error: Could not find the necessary player boxes.');
        }
    }

    function recordShot(result, type_of_stat) {
        const selectedPlayer = selectedBenchPlayer || selectedStartingPosition;
        let currentGameTime = document.getElementById('gameTime').textContent;

        if (!selectedPlayer) {
            alert('Please select a player first.');
            return;
        }

        const playerNumber = selectedPlayer.playerNumber || selectedPlayer.index;
        const teamPlaceholder = selectedPlayer.team;
        const teamId = getTeamId(teamPlaceholder);
        const scheduleId = getCurrentScheduleId();
        const quarter = getCurrentQuarter();

        if (!teamId) {
            alert('Invalid team selected.');
            return;
        }

        let points = 0;

        // Check points,result, and type of shot
        if (result === 'made') {
            if (type_of_stat === 'two_point') points = 2;
            else if (type_of_stat === 'three_point') points = 3;
            else if (type_of_stat === 'free_throw') points = 1;
        }

        if (points > 0) {
            // Update the score based on points
            recordScore(teamPlaceholder, points, scheduleId, quarter, currentGameTime);
        }

        console.log('Data being sent:', {
            playerNumber: playerNumber,
            teamId: teamId,
            scheduleId: scheduleId,
            quarter: quarter,
            type_of_stat: type_of_stat,
            result: result,
            points: points
        });

        // Send player stats via AJAX
        $.ajax({
            url: '{{ route('playerstats.store') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                player_number: playerNumber,
                team: teamId,
                type_of_stat: type_of_stat,
                result: result,
                schedule_id: scheduleId,
                quarter: quarter,
                game_time: currentGameTime
            },
            success: function(response) {
                console.log('Shot recorded successfully:', response);
                document.getElementById('team-a-score').textContent = response.teamAScore;
                document.getElementById('team-b-score').textContent = response.teamBScore;
                loadPlayByPlay(); // Refresh the play-by-play display
            },
            error: function(xhr, status, error) {
                console.error('Error recording event:', status, error);
            }
        });
    }

    function recordScore(teamPlaceholder, points, scheduleId, quarter, gameTime) {
        const teamId = getTeamId(teamPlaceholder);

        $.ajax({
            url: '{{ route('scores.store') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                schedule_id: scheduleId,
                team_id: teamId,
                quarter: quarter,
                score: points,
            },
            success: function(response) {
                console.log('Score recorded successfully:', response);
            },
            // error: function(xhr, status, error) {
            //     console.error('Error recording score:', status, error);
            // }
        });
    }

    // Function for the "Made 2 Points" button
    function madeTwoPoints() {
        recordShot('made', 'two_point');
    }

    // Function for the "Missed 2 Points" button
    function missedTwoPoints() {
        recordShot('missed', 'two_point');
    }

    // Function for the "Made 3 Points" button
    function madeThreePoints() {
        recordShot('made', 'three_point');
    }

    // Function for the "Missed 3 Points" button
    function missedThreePoints() {
        recordShot('missed', 'three_point');
    }

    // Function for the "Made Free Throw" button
    function madeFreeThrow() {
        recordShot('made', 'free_throw');
    }

    // Function for the "Missed Free Throw" button
    function missedFreeThrow() {
        recordShot('missed', 'free_throw');
    }

     // Function for the "Offensive Rebound button
    function madeOffensiveRebound() {
        recordShot('made', 'offensive_rebound');
    }

     // Function for the "Defensive Rebound button
    function madeDefensiveRebound() {
        recordShot('made', 'defensive_rebound');
    }

    // Function for the "Block" button
    function madeBlock() {
        recordShot('made', 'block');
    }

    // Function for the "Steal" button
    function madeSteal() {
        recordShot('made', 'steal');
    }
    
     // Function for the "Turnover" button
    function madeTurnover() {
        recordShot('made', 'turnover');
    }

    // Function for the "Foul" button
    function madeFoul() {
        recordShot('made', 'foul');
        stopTimer();
    }

     // Function for the "Foul" button
    function madeAssist() {
        recordShot('made', 'assist');
    }

    let displayedEntries = [];

    function loadPlayByPlay() {
        const scheduleId = getCurrentScheduleId(); // Retrieve the schedule ID dynamically

        if (!scheduleId) {
            console.error('No schedule ID found.');
            return;
        }

        // Construct the URL for fetching play-by-play data
        const url = `{{ route('playbyplay.get', ['scheduleId' => '__SCHEDULE_ID__']) }}`.replace('__SCHEDULE_ID__', scheduleId);
        console.log('Fetching URL:', url); // Debug the URL

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                console.log('Play-by-play data:', response); // Debug

                // Check data in response
                if (response && response.play_by_play && Array.isArray(response.play_by_play)) {
                    // Clear the existing entries before adding new ones
                    $('#live-statistics').empty();
                    displayedEntries = []; // Reset displayed entries for the new load

                    response.play_by_play.forEach(entry => {
                        // Destructure entry data
                        const { player_name, game_time, action, points, team_A_score, team_B_score } = entry;

                        // Create the HTML for the statistic entry
                        const statisticEntry = `
                        <div class="live-statistic-entry flex flex-col lg:flex-row justify-between items-start p-4 border-b border-gray-300 bg-white rounded-lg shadow-sm">
                            <!-- Player Name -->
                            <div class="live-statistic-left flex-1 text-left truncate">
                                <span class="font-semibold text-gray-800 text-base">${player_name}</span>
                            </div>
                            <!-- Game Time and Action -->
                            <div class="live-statistic-center flex-1 text-center">
                                <span class="block font-semibold text-xl text-gray-900">${game_time}</span>
                                <span class="block text-gray-700 text-sm mt-1">
                                    ${action} (${points !== null ? `${points} points` : 'No points'})
                                </span>
                            </div>
                            <!-- Individual Scores -->
                            <div class="live-statistic-right flex-1 text-right">
                                <span class="text-lg font-bold text-gray-900">${team_A_score || '0'}</span> - 
                                <span class="text-lg font-bold text-gray-900">${team_B_score || '0'}</span>
                            </div>
                        </div>
                        `;

                        // Prepend the new statistic entry to the list
                        $('#live-statistics').prepend(statisticEntry);
                    });
                } else {
                    console.error('Response is not in the expected format:', response);
                }
            },
            error: function(error) {
                console.error('Error loading play-by-play data:', error);
            }
        });
    }

    $(document).ready(function () {
        loadPlayByPlay(); // Initial load

        // reload data every 5 seconds
        // setInterval(loadPlayByPlay, 5000); // Reload every 5 seconds
    });

    </script>
</x-app-layout>