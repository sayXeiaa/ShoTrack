<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                    {{-- <p id="teamAScore" class="text-4xl font-semibold text-black">{{$teamAScore}}</p> --}}
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
                                    {{-- <p id="teamBScore" class="text-4xl font-semibold text-black">{{$teamBScore}}</p> --}}
                                    <p id="team-b-score" class="text-4xl font-semibold text-black">{{$teamBScore}}</p>
                            </div>
                            <div class="flex-1 bg-white p-2 rounded-lg shadow text-center">
                                <h3 class="font-bold text-lg text-black">{{ $team2Name }}</h3>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="mb-6 flex justify-between items-center">
                        <!-- Team A Players -->
                        <div class="flex space-x-2">
                            @foreach ($playersTeamA as $player)
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber({{ $player->number }}, '{{ $player->team }}')">
                                    <p>{{ $player->number }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Middle Controls -->
                        <div class="flex flex-col items-center space-y-4">
                            <div class="middle-box bg-gray-100 p-4 rounded-lg shadow text-center">
                                <button id="quarterButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Q1</button>
                            </div>
                            <div class="middle-box bg-gray-100 p-4 rounded-lg shadow text-center">
                                <button id="nextQuarterButtonSub" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="nextQuarter()">Next Quarter</button>
                            </div>
                        </div>
                        

                        <!-- Team B Players -->
                        <div class="flex space-x-2">
                            @foreach ($playersTeamB as $player)
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber({{ $player->number }}, '{{ $player->team }}')">
                                    <p>{{ $player->number }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div> --}}

                    <div class="flex flex-col items-center space-y-4 mb-4">
                        <div class="flex items-center space-x-8">
                            <!-- Team A Starting 5 (Blank by default) -->
                            <div class="flex flex-col items-center space-y-2">
                                <div class="flex space-x-2" id="startingTeamA">
                                    @for ($i = 0; $i < 5; $i++)
                                        <div class="player-box bg-gray-500 text-center cursor-pointer text-white rounded p-2 w-12 h-12" 
                                            data-team="teamA" data-position="starting" data-index="{{ $i }}"
                                            data-player-number="{{ isset($startingPlayersTeamA[$i]) ? $startingPlayersTeamA[$i]->number : '' }}"
                                            onclick="selectPlayer(this)">
                                            <p></p> <!-- Blank by default -->
                                        </div>
                                    @endfor
                                </div>
    
                    
                                <!-- Bench Players for Team A aligned under the starting five -->
                                <div class="flex flex-wrap gap-2 mt-2" id="benchPlayersTeamA">
                                    @foreach ($benchPlayersTeamA as $player)
                                        <div class="player-box bg-gray-500 text-center cursor-pointer text-white rounded p-2 w-12 h-12"
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
                            </div>
                    
                            <!-- Team B Starting 5 (Blank by default) -->
                            <div class="flex flex-col items-center space-y-2">
                                <div class="flex space-x-2" id="startingTeamB">
                                    @for ($i = 0; $i < 5; $i++)
                                        <div class="player-box bg-gray-500 text-center cursor-pointer text-white rounded p-2 w-12 h-12"
                                            data-team="teamB" data-position="starting" data-index="{{ $i }}"
                                            onclick="selectPlayer(this)">
                                            <p></p> <!-- Blank by default -->
                                        </div>
                                    @endfor
                                </div>
                    
                                <!-- Bench Players for Team B aligned under the starting five -->
                                <div class="flex flex-wrap gap-2 mt-2" id="benchPlayersTeamB">
                                    @foreach ($benchPlayersTeamB as $player)
                                        <div class="player-box bg-gray-500 text-center cursor-pointer text-white rounded p-2 w-12 h-12"
                                            data-team="teamB" data-position="bench" data-player-number="{{ $player->number }}"
                                            onclick="selectPlayer(this)">
                                            <p>{{ $player->number }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    
                        <!-- Substitution Button -->
                        <div class="flex flex-col items-center space-y-4 mt-4">
                            <button id="subButton"
                                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50"
                                    onclick="performSubstitution()">
                                Sub
                            </button>
                        </div>
                    </div>
                    

                    <div class="mb-6">
                        <x-message></x-message>
                        <form method="POST" action="{{ route('playerstats.store') }}" id="playerStatsForm">
                            @csrf
                            <input type="hidden" name="player_number" id="selectedPlayerNumber">
                            <input type="hidden" name="team_name" id="selectedTeamName">

                            <!-- Assist -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="setAssist('yes')">Assist</button>
                                <button type="button" class="bg-gray-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="setAssist('no')">No Assist</button>
                            </div>

                            <!-- Made Points -->
                            <div class="mb-4 space-y-2">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeTwoPoints()">Made 2 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeThreePoints()">Made 3 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeFreeThrow()">Made Free Throw</button>
                            </div>

                            <!-- Missed Points -->
                            <div class="mb-4 space-y-2">
                                <button type="button" class="bg-gray-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="missedTwoPoints()">Missed 2 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="missedThreePoints()">Missed 3 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="missedFreeThrow()">Missed Free Throw</button>
                            </div>

                            <!-- Rebounds -->
                            <div class="mb-4 space-y-2">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeOffensiveRebound()">Offensive Rebound</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeDefensiveRebound()">Defensive Rebound</button>
                            </div>

                            <!-- Block, Steal, Turnover, Foul -->
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeBlock()">Block</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeSteal()">Steal</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeTurnover()">Turnover</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="madeFoul()">Foul</button>
                            </div>

                            <button type="submit" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save Stats</button>
                        </form>
                    </div>
                </div>

                <!-- Live Player Statistics Section -->
                <div class="bg-gray-100 p-6 rounded-lg border border-gray-400 shadow-md flex-1">
                    <div class="mb-6 text-center">
                        <h2 class="font-semibold text-xl text-black leading-tight">Live Player Statistics</h2>
                        <hr class="border-gray-300 border-t-2 mt-2">
                    </div>
                    <div id="live-statistics" class="mt-4">
                        <!-- Play-by-play updates will be appended here -->
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
    </style>

    <script>


    let currentQuarter = 1;
    let timer;
    let isPaused = false;
    let timeLeft = 600; // 10 minutes in seconds
    const teamAId = {{ $teams[0]->id }}; 
    const teamBId = {{ $teams[1]->id }}; 

    function getTeamId(teamPlaceholder) {
        if (teamPlaceholder === 'teamA') {
            return teamAId; // Use the actual team ID for teamA
        } else if (teamPlaceholder === 'teamB') {
            return teamBId; // Use the actual team ID for teamB
        }
        return null; // In case of an unexpected team value
    }

    function getCurrentScheduleId() {
        return document.getElementById('currentScheduleId').value;
    }

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secondsLeft = seconds % 60;
        return `${String(minutes).padStart(2, '0')}:${String(secondsLeft).padStart(2, '0')}`;
    }

    function updateTimer() {
        if (timeLeft <= 0) {
            clearInterval(timer);
            document.getElementById('gameTime').textContent = '00:00';
            return;
        }
        document.getElementById('gameTime').textContent = formatTime(timeLeft);
        timeLeft--;
    }

    function startTimer() {
        if (!timer) {
            timer = setInterval(updateTimer, 1000);
        }
    }

    function stopTimer() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    function pauseTimer() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    function resetTimer() {
        timeLeft = 600; // Reset to 10 minutes
        document.getElementById('gameTime').textContent = formatTime(timeLeft);
    }

    function nextQuarter() {
        if (currentQuarter < 4) {
            currentQuarter++;
            resetTimer(); // Reset the timer when moving to the next quarter

            const quarterButton = document.getElementById('quarterButton');
            switch (currentQuarter) {
                case 2:
                    quarterButton.innerText = 'Q2';
                    break;
                case 3:
                    quarterButton.innerText = 'Q3';
                    break;
                case 4:
                    quarterButton.innerText = 'Q4';
                    break;
            }

            document.getElementById('nextQuarterButtonSub').innerText = 'Next Quarter';
            stopTimer();
        } else {
            alert('Already in final quarter');
        }
    }



    document.getElementById('quarterButton').innerText = 'Q1';
    document.getElementById('nextQuarterButtonSub').innerText = 'Next Quarter';

    document.getElementById('startButton').addEventListener('click', startTimer);
    document.getElementById('pauseButton').addEventListener('click', pauseTimer);
    document.getElementById('quarterButton').addEventListener('click', nextQuarter);


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


    // function recordShot(result, type_of_stat) {
    //     const selectedPlayer = selectedBenchPlayer || selectedStartingPosition;

    //     if (!selectedPlayer) {
    //         alert('Please select a player first.');
    //         return;
    //     }

    //     const playerNumber = selectedPlayer.playerNumber || selectedPlayer.index;
    //     const teamPlaceholder = selectedPlayer.team;

    //     // Get the actual team ID using the function
    //     const teamId = getTeamId(teamPlaceholder); 
    //     const scheduleId = getCurrentScheduleId();

    //     console.log('Player Number:', playerNumber);
    //     console.log('Team Placeholder:', teamPlaceholder);
    //     console.log('Team ID:', teamId);
    //     console.log('Result:', result); 
    //     console.log('type_of_stat:', type_of_stat);
    //     console.log('Current Schedule ID:', scheduleId);

    //     if (!teamId) {
    //         alert('Invalid team selected.');
    //         return;
    //     }

    //     // Send AJAX request to record the shot
    //     $.ajax({
    //         url: '{{ route('playerstats.store') }}',
    //         method: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}', // Ensure this token is correct
    //             player_number: playerNumber,
    //             team: teamId, // Send the actual team ID
    //             type_of_stat: type_of_stat,
    //             result: result, // Either 'made' or 'missed'
    //             schedule_id: scheduleId // Include the schedule ID
    //         },
    //         success: function(response) {
    //             alert('Shot recorded successfully!');
    //             console.log(response);

    //             $('#team-a-score').text(response.teamAScore);
    //             $('#team-b-score').text(response.teamBScore);

    //         },
    //         error: function(error) {
    //             console.error('Error recording shot:', error);
    //             alert('Error recording shot.');
    //         }
    //     });
    // }

    function recordShot(result, type_of_stat) {
        const selectedPlayer = selectedBenchPlayer || selectedStartingPosition;

        if (!selectedPlayer) {
            alert('Please select a player first.');
            return;
        }

        const playerNumber = selectedPlayer.playerNumber || selectedPlayer.index;
        const teamPlaceholder = selectedPlayer.team;

        // Get the actual team ID using the function
        const teamId = getTeamId(teamPlaceholder); 
        const scheduleId = getCurrentScheduleId();

        console.log('Player Number:', playerNumber);
        console.log('Team Placeholder:', teamPlaceholder);
        console.log('Team ID:', teamId);
        console.log('Result:', result); 
        console.log('type_of_stat:', type_of_stat);
        console.log('Current Schedule ID:', scheduleId);

        if (!teamId) {
            alert('Invalid team selected.');
            return;
        }

        // Send AJAX request to record the shot
        $.ajax({
    url: '{{ route('playerstats.store') }}',
    method: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        player_number: playerNumber,
        team: teamId,
        type_of_stat: type_of_stat,
        result: result,
        schedule_id: scheduleId
    },
    success: function(response) {
        // Get current timestamp
        const timestamp = new Date().toLocaleTimeString();

         // Check if scores are present in the response
        if (response.teamAScore !== undefined && response.teamBScore !== undefined) {
            $('#team-a-score').text(response.teamAScore);
            $('#team-b-score').text(response.teamBScore);
        } else {
            console.warn('Scores not found in response:', response);
        }

        // Create a new statistic entry
        const statisticEntry = `
            <div class="live-statistic-entry flex justify-between items-center p-2 border-b border-gray-300">
                <div class="live-statistic-left w-1/3 text-left">
                    ${response.team === 'teamA' ? response.playerName : ''}
                </div>
                <div class="live-statistic-center w-1/3 text-center">
                    <span class="font-semibold">${timestamp}</span><br>
                    <span class="text-gray-700">
                        ${response.playerName} ${response.action} (${response.points} points)
                    </span><br>
                    <span class="text-gray-500">Score: ${response.teamAScore} - ${response.teamBScore}</span>
                </div>
                <div class="live-statistic-right w-1/3 text-right">
                    ${response.team === 'teamB' ? response.playerName : ''}
                </div>
            </div>
        `;

        // Append the new statistic entry to the live statistics container
        $('#live-statistics').prepend(statisticEntry);
    },
    error: function(error) {
        console.error('Error recording shot:', error);
    }
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

    // Function for the "dEfensive Rebound" button
    function madeBlock() {
        recordShot('made', 'block');
    }

    // Function for the "dEfensive Rebound" button
    function madeSteal() {
        recordShot('made', 'steal');
    }

     // Function for the "dEfensive Rebound" button
    function madeTurnover() {
        recordShot('made', 'turnover');
    }

    // Function for the "dEfensive Rebound" button
    function madeFoul() {
        recordShot('made', 'foul');
        pauseTimer();
    }

    </script>
</x-app-layout>