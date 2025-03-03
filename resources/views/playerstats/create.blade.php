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
                            <!-- Team 1 Section -->
                            <div class="flex-1 bg-white p-2 rounded-lg shadow text-center">
                                <h3 class="font-bold text-lg text-black">{{ $team1Name }}</h3>
                                <p class="font-semibold mt-2" id="team-1-fouls-display">Fouls (Quarter 1): 0</p>
                            </div>
                    
                            <!-- Team A Score -->
                            <div class="bg-white p-4 rounded-lg shadow text-center">
                                <p id="team-a-score" class="text-4xl font-semibold text-black">{{$teamAScore}}</p>
                            </div>
                    
                            <!-- Timer and Start/Pause Buttons -->
                            <div class="flex flex-col items-center space-y-2">
                                <div class="bg-white p-4 rounded-lg shadow text-center">
                                    <p id="gameTime" class="text-4xl font-semibold text-black">10:00</p>
                                    <div class="flex items-center space-x-4">
                                        <!-- Game Time Input -->
                                        <input 
                                            id="gameTimeInput" 
                                            class="text-2xl font-semibold text-black border border-gray-400 p-2 rounded-lg hidden focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                            type="text" 
                                            value="10:00"
                                            placeholder="MM:SS"
                                            aria-label="Edit game time"
                                        />
                                    
                                        <button 
                                            id="editTime" 
                                            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105 focus:ring-2 focus:ring-blue-300 focus:outline-none flex items-center space-x-2">
                                            <span>Edit</span>
                                        </button>
                                    
                                        <button 
                                            id="saveTime" 
                                            class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105 focus:ring-2 focus:ring-green-300 focus:outline-none hidden flex items-center space-x-2">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Save</span>
                                        </button>
                        
                                        <button 
                                            id="cancelEdit" 
                                            class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105 focus:ring-2 focus:ring-gray-300 focus:outline-none hidden flex items-center space-x-2">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Cancel</span>
                                        </button>
                                    </div>
                                    
                                </div>
                                
                                <div class="bg-white p-4 rounded-lg shadow text-center">
                                    <h3 class="font-bold text-lg text-black">Pause/Start Time</h3>
                                    <div class="flex justify-center space-x-4 mt-2">
                                        <button id="startButton" class="bg-blue-500 hover:bg-blue-700 text-white p-2 rounded transition-transform transform hover:scale-105 focus:outline-none">Start</button>
                                        <button id="pauseButton" class="bg-red-500 hover:bg-red-700 text-white p-2 rounded transition-transform transform hover:scale-105 focus:outline-none">Pause</button>
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Team B Score -->
                            <div class="bg-white p-4 rounded-lg shadow text-center">
                                <p id="team-b-score" class="text-4xl font-semibold text-black">{{$teamBScore}}</p>
                            </div>
                    
                            <!-- Team 2 Section -->
                            <div class="flex-1 bg-white p-2 rounded-lg shadow text-center">
                                <h3 class="font-bold text-lg text-black">{{ $team2Name }}</h3>
                                <p class="font-semibold mt-2" id="team-2-fouls-display">Fouls (Quarter 1): 0</p>
                            </div>
                        </div>
                    </div>
                    

                    <div class="flex flex-col items-center space-y-4 mb-4">
                        <div class="flex flex-row space-x-8 w-full">
                            <!-- Team A Section -->
                            <div class="flex flex-col items-center w-1/2">
                                <!-- Starting Players for Team A -->
                                <p class="font-semibold mb-2 mt-4 -ml-72">On Court:</p>
                                <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6 border border-gray-300 rounded-lg shadow-md p-2">
                                    <div class="flex flex-wrap justify-center gap-1" id="startingTeamA">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="player-box bg-gray-500 hover:bg-blue-700 transition-transform transform hover:scale-105 focus:outline-none text-center cursor-pointer text-white rounded p-1 w-16 h-16 flex items-center justify-center" 
                                                data-team="teamA" data-position="starting" data-index="{{ $i }}"
                                                data-player-number="{{ isset($startingPlayersTeamA[$i]) ? $startingPlayersTeamA[$i]->number : '' }}"
                                                onclick="selectPlayer(this)">
                                                <p>{{ isset($startingPlayersTeamA[$i]) ? $startingPlayersTeamA[$i]->number : '' }}</p>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                    
                                <!-- Bench Players for Team A -->
                                <p class="font-semibold mb-2 mt-4 -ml-64">Bench Players:</p>
                                <div class="grid grid-cols-5 sm:grid-cols-4 md:grid-cols-3 lg:grid-cols-5 gap-2 mt-2" id="benchPlayersTeamA">
                                    @foreach ($benchPlayersTeamA as $player)
                                        <div class="player-box bg-gray-500 hover:bg-blue-700 transition-transform transform hover:scale-105 focus:outline-none text-center cursor-pointer text-white rounded p-2 w-16 h-16 flex items-center justify-center"
                                            data-team="teamA" data-position="bench" data-player-number="{{ $player->number }}" data-player-id="{{ $player->id }}"
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
                                <p class="font-semibold mb-2 mt-4 -ml-72">On Court:</p>
                                <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6 border border-gray-300 rounded-lg shadow-md p-2">
                                    <div class="flex flex-wrap justify-center gap-1" id="startingTeamB">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="player-box bg-gray-500 hover:bg-blue-700 transition-transform transform hover:scale-105 focus:outline-none text-center cursor-pointer text-white rounded p-1 w-16 h-16 flex items-center justify-center" 
                                                data-team="teamB" data-position="starting" data-index="{{ $i }}"
                                                onclick="selectPlayer(this)">
                                                <p>{{ isset($startingPlayersTeamB[$i]) ? $startingPlayersTeamB[$i]->number : '' }}</p>
                                            </div>
                                        @endfor
                                    </div>
                                </div>                                
                    
                                <!-- Bench Players for Team B -->
                                <p class="font-semibold mb-2 mt-4 -ml-64">Bench Players:</p>
                                <div class="grid grid-cols-5 sm:grid-cols-4 md:grid-cols-3 lg:grid-cols-5 gap-2 mt-2" id="benchPlayersTeamB">
                                    @foreach ($benchPlayersTeamB as $player)
                                        <div class="player-box bg-gray-500  hover:bg-blue-700 transition-transform transform hover:scale-105 focus:outline-none text-center cursor-pointer text-white rounded p-2 w-16 h-16 flex items-center justify-center"
                                            data-team="teamB" data-position="bench" 
                                            data-player-number="{{ $player->number }}"
                                            data-player-id="{{ $player->id }}"
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
                            </div>

                            <!-- Made Points -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeTwoPoints()">Made 2 Points</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeThreePoints()">Made 3 Points</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeFreeThrow()">Made Free Throw</button>
                                <button type="button" class="bg-blue-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeBlock()">Block</button>
                            </div>

                            <!-- Missed Points -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-red-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="missedTwoPoints()">Missed 2 Points</button>
                                <button type="button" class="bg-red-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="missedThreePoints()">Missed 3 Points</button>
                                <button type="button" class="bg-red-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="missedFreeThrow()">Missed Free Throw</button>
                                <button type="button" class="bg-blue-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeSteal()">Steal</button>
                            </div>

                            <!-- Rebounds -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeOffensiveRebound()">Offensive Rebound</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeDefensiveRebound()">Defensive Rebound</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeAssist()">Assist</button>
                                <button type="button" class="bg-blue-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeTurnover()">Turnover</button>
                            </div>

                            <!-- Block, Steal, Turnover, Foul -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-gray-500 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeFoul()">Personal Foul</button>
                                <button type="button" class="bg-gray-500 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeTechnicalFoul()">Technical Foul</button>
                                <button type="button" class="bg-gray-500 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeUnsportsmanlikeFoul()">Unsportsmanlike Foul</button>
                                <button type="button" class="bg-gray-500 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeDisqualifyingFoul()">Disqualifying Foul</button>
                            </div>

                            <!-- Micro stats -->
                            <p class="font-semibold mb-2 mt-4">Micro Stats:</p>
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeTwoPointOffTurnover()">2-Point Off Turnover</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeThreePointOffTurnover()">3-Point Off Turnover</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeTwoPointFastbreak()">2-Point Fastbreak</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeThreePointFastbreak()">3-Point Fastbreak</button>
                                
                            </div>

                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeOnePointSecondChance()">1-Point 2nd Chance</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeTwoPointSecondChance()">2-Point 2nd Chance</button>
                                <button type="button" class="bg-green-700 transition-transform transform hover:scale-105 text-white font-bold py-2 px-4 rounded" onclick="madeThreePointSecondChance()">3-Point 2nd Chance</button>
                            </div>

                            <div class="mb-4 grid grid-cols-4 gap-4">
                                <div class="col-span-3"></div> 
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded col-span-1 mt-20" onclick="markGameAsCompleted()">
                                    Game Finished
                                </button>
                            </div>                            
                        </form>
                    </div>
                </div>

                <div class="parent-container" >
                    <div class="bg-gray-100 p-6 rounded-lg border border-gray-400 shadow-md flex flex-col h-full">
                        <div class="mb-6 text-center">
                            <h2 class="font-semibold text-xl text-black leading-tight">Live Play-By-Play Statistics</h2>
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

        .okButton {
            background-color: #314795; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            padding: 10px 20px; 
            font-size: 16px; 
            cursor: pointer; 
        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>

    let currentQuarter = 1;
    let timer;
    let timeLeft = 600; // 10 minutes in seconds
    const teamAId = {{ $teams[0]->id }};
    const teamBId = {{ $teams[1]->id }};
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
        console.log("Current timeLeft:", timeLeft); // Debug log
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
    }

    function resetTimer() {
        timeLeft = 600; // Reset to 10 minutes
        updateDisplay(); // Update the display
    }

    function nextQuarter() {
        const scheduleId = getCurrentScheduleId();
        if (currentQuarter < 4) {
            currentQuarter++;
            resetTimer(); 
            stopTimer();
            updateDisplay();
            sendElapsedTimeDataToBackend(); 
        } else {
            alert('Already in the final quarter');
        }
        updateTeamFouls(scheduleId, currentQuarter, true);
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
                console.log('Fetched game details:', data); 
                currentQuarter = data.current_quarter || 1; // Default to Q1 if not provided
                quarterElapsedTime = data.quarter_elapsed_time || 0; // Time elapsed in the current quarter

                const quarterLength = 600;
                timeLeft = Math.max(quarterLength - quarterElapsedTime, 0); 
                updateDisplay();
                updateTeamFouls(scheduleId, currentQuarter);
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
        // Retrieve necessary data from the playerBox element
        const teamPlaceholder = playerBox.dataset.team; 
        const position = playerBox.dataset.position;
        const index = position === 'starting' ? parseInt(playerBox.dataset.index, 10) : null;
        const playerNumber = playerBox.dataset.playerNumber || '';
        const playerId = playerBox.dataset.playerId || null; 
        const scheduleId = getCurrentScheduleId();

        // Initialize the selectedPlayer object
        const selectedPlayer = {
            playerNumber: playerNumber,
            playerId: playerId, 
            team: teamPlaceholder,
            index: index,
            box: playerBox,
            teamId: getTeamId(teamPlaceholder),
            scheduleId: scheduleId
        };

        // Update the global variables based on the player's position
        if (position === 'bench') {
            selectedBenchPlayer = selectedPlayer; 
            highlightSelected(playerBox, 'bench');
        } else if (position === 'starting') {
            selectedStartingPosition = selectedPlayer; 
            highlightSelected(playerBox, 'starting');
        }

        // Debugging output
        console.log('Selected Player Data:', {
            playerNumber: selectedPlayer.playerNumber,
            playerId: selectedPlayer.playerId,
            team: selectedPlayer.team,
            index: selectedPlayer.index,
            teamId: selectedPlayer.teamId,
            scheduleId: selectedPlayer.scheduleId
        });
    }

    function removeSelectedPlayer(position) {
        if (position === 'bench' && selectedBenchPlayer) {
            // Clear the selected bench player data
            selectedBenchPlayer = null;
            // Optionally, remove the highlight to indicate the unselection
            document.querySelectorAll(`.player-box[data-position="bench"]`).forEach(box => {
                box.classList.remove('border-4', 'border-green-500');
            });
        } else if (position === 'starting' && selectedStartingPosition) {
            // Clear the selected starting player data
            selectedStartingPosition = null;
            // Optionally, remove the highlight to indicate the unselection
            document.querySelectorAll(`.player-box[data-position="starting"]`).forEach(box => {
                box.classList.remove('border-4', 'border-green-500');
            });
        }

        console.log(`Removed selected player data from ${position}.`);
    }

    function updateBox(box, playerNumber) {
        // Update the data attribute and text inside the box
        box.dataset.playerNumber = playerNumber;
        box.querySelector('p').textContent = playerNumber;
    }

    function highlightSelected(playerBox, type) {
        // Clear previous highlights
        document.querySelectorAll(`.player-box[data-position="${type}"]`).forEach(box => {
            box.classList.remove('border-4', 'border-4', 'border-green-500');
        });

        // Highlight the current selection
        playerBox.classList.add('border-4', 'border-green-500');
    }

    function checkFouls(playerId, scheduleId) {
        return $.ajax({
            url: `/check-fouls/${playerId}/${scheduleId}`,
            type: 'GET',
            success: function(response) {
                console.log('Fouls check successful:', response.message);

                if (response.playerData) {
                    selectedBenchPlayer = response.playerData;
                }
            },
            error: function(xhr) {
                if (xhr.status === 400) {
                    // player exceeded the foul limit
                    alert(xhr.responseJSON.message || 'Player cannot be substituted due to foul limits.');
                } else if (xhr.status === 404) {
                    // player stats are not found
                    alert(xhr.responseJSON.message || 'Player statistics not found for this schedule.');
                } else {
                    // other errors
                    alert('An unexpected error occurred. Please try again.');
                }
            },
        });
    }

    function performSubstitution() {
        // Check if both players are selected
        if (!selectedBenchPlayer || selectedStartingPosition === null) {
            alert('Please select a player from the bench and a starting position to substitute.');
            return;
        }

        // Check if the bench player has an actual player number
        if (!selectedBenchPlayer.playerNumber || selectedBenchPlayer.playerNumber.trim() === '') {
            alert('The selected bench position does not have a player to substitute.');
            return;
        }

        // Check if both players are from the same team
        if (selectedBenchPlayer.team !== selectedStartingPosition.team) {
            alert('You can only substitute players within the same team.');
            return;
        }

        // Log the selector to debug
        const startingSelector = `#starting${selectedStartingPosition.team === 'teamA' ? 'TeamA' : 'TeamB'} .player-box:nth-child(${selectedStartingPosition.index + 1})`;
        const benchSelector = `#benchPlayers${selectedBenchPlayer.team === 'teamA' ? 'TeamA' : 'TeamB'} .player-box[data-player-number="${selectedBenchPlayer.playerNumber}"]`;

        // Check fouls for the selected bench player before substitution
        checkFouls(selectedBenchPlayer.playerId, getCurrentScheduleId())
            .then(() => {
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

                    // Change background color for substituted players
                    startingBox.classList.remove('bg-gray-500');
                    startingBox.classList.add('bg-blue-700');

                    benchBox.classList.remove('bg-green-500', 'bg-blue-700');
                    benchBox.classList.add('bg-gray-500');

                    // Reset selections
                    selectedBenchPlayer = null;
                    selectedStartingPosition = null;

                    // Remove highlights from all player boxes
                    document.querySelectorAll('.player-box').forEach(box => {
                        box.classList.remove('border-4', 'border-green-500');
                    });
                } else {
                    alert('Error: Could not find the necessary player boxes.');
                }
            })
    }

    function getStartingPlayers() {
        const startingPlayers = {
            teamA: [],
            teamB: []
        };

        // Select the starting player boxes for Team A
        const startingBoxesTeamA = document.querySelectorAll('#startingTeamA .player-box');
        startingBoxesTeamA.forEach(box => {
            const playerNumber = box.dataset.playerNumber;
            if (playerNumber) {
                startingPlayers.teamA.push(playerNumber);
            }
        });

        // Select the starting player boxes for Team B
        const startingBoxesTeamB = document.querySelectorAll('#startingTeamB .player-box');
        startingBoxesTeamB.forEach(box => {
            const playerNumber = box.dataset.playerNumber; 
            if (playerNumber) {
                startingPlayers.teamB.push(playerNumber);
            }
        });

        return startingPlayers;
    }

    function recordShot(result, type_of_stat) {
        const selectedPlayer = selectedStartingPosition; 
        let currentGameTime = document.getElementById('gameTime').textContent;

        if (!selectedPlayer) {
            alert('Please select a player that is on the court.');
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

        const startingPlayers = getStartingPlayers();

        // Check if the player is in the starting lineup of their team
        const isInStartingLineup = startingPlayers[teamPlaceholder]?.includes(playerNumber);

        if (!isInStartingLineup) {
            alert('Only players in the court can have their stat recorded.');
            return;
        }

        let points = 0;

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
            points: points,
            startingPlayers: startingPlayers 
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
                game_time: currentGameTime,
                starting_players: startingPlayers
            },
            success: function(response) {
                console.log('Shot recorded successfully:', response);
                document.getElementById('team-a-score').textContent = response.teamAScore;
                document.getElementById('team-b-score').textContent = response.teamBScore;
                loadPlayByPlay(); // Refresh the play-by-play display

                const position = selectedPlayer.box.dataset.position;
                removeSelectedPlayer(position);
                if (response.message) {
                    alert(response.message); 
                }
            },
            error: function(xhr, status, error) {
                console.error('Error recording event:', status, error);
            }
        });
        updateTeamFouls(scheduleId, quarter);
    }

    function recordTeamMetric(result, type_of_stat) {
        const selectedPlayer = selectedBenchPlayer || selectedStartingPosition;
        const currentGameTime = document.getElementById('gameTime').textContent;

        if (!selectedPlayer) {
            alert('Please select a player first.');
            return;
        }

        const teamPlaceholder = selectedPlayer.team;
        const teamId = getTeamId(teamPlaceholder);
        const scheduleId = getCurrentScheduleId();
        const quarter = getCurrentQuarter();

        if (!teamId) {
            alert('Invalid team selected.');
            return;
        }

        let points = 0;

        // Determine points based on the type of stat
        if (type_of_stat === 'one_point_second_chance' ) {
            points = 1;
        }
        else if (type_of_stat === 'two_point_off_turnover' || type_of_stat === 'two_point_fastbreak' || type_of_stat === 'two_point_second_chance') {
            points = 2;
        } else if (type_of_stat === 'three_point_off_turnover' || type_of_stat === 'three_point_fastbreak' || type_of_stat === 'three_point_second_chance') {
            points = 3;
        }

        console.log('Team Metric Data being sent:', {
            teamId: teamId,
            scheduleId: scheduleId,
            quarter: quarter,
            type_of_stat: type_of_stat,
            points: points,
            result: result,
            gameTime: currentGameTime
        });

        $.ajax({
            url: '{{ route('team-metrics.store') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                team_id: teamId,
                type_of_stat: type_of_stat,
                points: points,
                result: result,
                schedule_id: scheduleId,
                quarter: quarter,
                game_time: currentGameTime
            },
            success: function(response) {
                console.log('Team metric recorded successfully:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error recording team metric:', status, error);
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
        stopTimer();
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

    // Function for the "2-Point Off Turnover" button
    function madeTwoPointOffTurnover() {
        recordShot('made', 'two_point');
        recordTeamMetric('made', 'two_point_off_turnover');
    }

    // Function for the "3-Point Off Turnover" button
    function madeThreePointOffTurnover() {
        recordShot('made', 'three_point');
        recordTeamMetric('made', 'three_point_off_turnover');
    }

    // Function for the "2-Point Fastbreak" button
    function madeTwoPointFastbreak() {
        recordShot('made', 'two_point');
        recordTeamMetric('made', 'two_point_fastbreak');
    }

    // Function for the "3-Point Fastbreak" button
    function madeThreePointFastbreak() {
        recordShot('made', 'three_point');
        recordTeamMetric('made', 'three_point_fastbreak');
    }

    // Function for the "1-Point Second Chance" button
    function madeOnePointSecondChance() {
        recordShot('made', 'free_throw');
        recordTeamMetric('made', 'one_point_second_chance');
    }

    // Function for the "2-Point Second Chance" button
    function madeTwoPointSecondChance() {
        recordShot('made', 'two_point');
        recordTeamMetric('made', 'two_point_second_chance');
    }

    // Function for the "3-Point Second Chance" button
    function madeThreePointSecondChance() {
        recordShot('made', 'three_point');
        recordTeamMetric('made', 'three_point_second_chance');
    }

    // Function for the "Technical Foul" button
    function madeTechnicalFoul() {
        recordShot('made', 'technical_foul');
        stopTimer();
    }

    // Function for the "Unsportsmanlike Foul" button
    function madeUnsportsmanlikeFoul() {
        recordShot('made', 'unsportsmanlike_foul');
        stopTimer();
    }

    // Function for the "Disqualifying Foul" button
    function madeDisqualifyingFoul() {
        recordShot('made', 'disqualifying_foul');
        stopTimer();
    }

    let displayedEntries = [];

    function loadPlayByPlay() {
        const scheduleId = getCurrentScheduleId(); 

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
                console.log('Play-by-play data:', response); 

                // Check data in response
                if (response && response.play_by_play && Array.isArray(response.play_by_play)) {
                    // Clear the existing entries before adding new ones
                    $('#live-statistics').empty();
                    displayedEntries = []; // Reset displayed entries for the new load

                    response.play_by_play.forEach(entry => {
                        // Destructure entry data
                        const { id, player_name, player_number, game_time, action, points, team_A_score, team_B_score } = entry;

                        // Determine the points text
                        const pointsText = points && points !== 0 ? `(${points} points)` : '';

                        // Create the HTML for the statistic entry
                        const statisticEntry = `
                        <div class="live-statistic-entry flex flex-col lg:flex-row justify-between items-start p-4 border-b border-gray-300 bg-white rounded-lg shadow-sm" data-id="${id}">
                            <!-- Player Name -->
                            <div class="live-statistic-left flex-1 text-left truncate">
                                <span class="text-gray-500 text-sm block">#${player_number}</span>
                                <span class="font-semibold text-gray-800 text-base">${player_name}</span>
                            </div>
                            <!-- Game Time and Action -->
                            <div class="live-statistic-center flex-1 text-center">
                                <span class="block font-semibold text-xl text-gray-900">${game_time}</span>
                                <span class="block text-gray-700 text-sm mt-1">
                                    ${action} ${pointsText}
                                </span>
                                <!-- Delete Button -->
                                <div class="delete-statistic text-center mt-2">
                                    <button id="deleteButton" class="delete-btn bg-red-500 hover:bg-red-700 text-white p-2 rounded transition-transform transform hover:scale-105 focus:outline-none" data-id="${id}">
                                        Delete
                                    </button>
                                </div>
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

    $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            deletePlayerStat(id);
        });

    function deletePlayerStat(id) {
        console.log('PlayByPlay ID:', id);

        if (!id) {
            console.error('PlayByPlay ID is undefined');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const url = `/playbyplay/${id}/delete`;  
        console.log("Deleting play-by-play with URL:", url);

        $.ajax({
        url: url,  
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            console.log('Play-by-play deleted:', response);
            
            if (response.success) {
                document.getElementById('team-a-score').textContent = response.team_a_score || 0;
                document.getElementById('team-b-score').textContent = response.team_b_score || 0;
            } else {
                console.error('Unexpected response format:', response);
            }
            loadPlayByPlay();
        },
        error: function(error) {
            console.error('Error deleting play-by-play:', error);
        }
    });
    }

    $(document).ready(function () {
        loadPlayByPlay(); // Initial load

        // reload data every 5 seconds
        // setInterval(loadPlayByPlay, 5000); // Reload every 5 seconds
    });

    function markGameAsCompleted() {
        const scheduleId = getCurrentScheduleId(); 

        fetch(`/schedules/${scheduleId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ is_completed: true })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "Game marked as finished!",
                    icon: "success",
                    confirmButtonText: "OK", 
                    customClass: {
                        confirmButton: 'okButton'
                    }
                }).then(() => {
                    // Redirect after the alert is closed
                    window.location.href = '{{ route("schedules.index") }}';
                });
            } else {
                alert('Failed to mark game as finished.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function updateTeamFouls(scheduleId, currentQuarter, reset = false) {
        const team1Element = document.getElementById('team-1-fouls-display');
        const team2Element = document.getElementById('team-2-fouls-display');

        if (reset) {
            if (team1Element) {
                team1Element.innerText = `Fouls (Quarter ${currentQuarter}): 0`;
            }

            if (team2Element) {
                team2Element.innerText = `Fouls (Quarter ${currentQuarter}): 0`;
            }

            return;
        }

        // Fetch updated fouls 
        $.ajax({
            url: `/team-fouls/${scheduleId}/${currentQuarter}`,
            method: 'GET',
            success: function (response) {
                if (response) {
                    if (response.team_1_fouls !== undefined) {
                        if (team1Element) {
                            team1Element.innerText = `Fouls (Quarter ${currentQuarter}): ${response.team_1_fouls}`;
                        }
                    }

                    if (response.team_2_fouls !== undefined) {
                        if (team2Element) {
                            team2Element.innerText = `Fouls (Quarter ${currentQuarter}): ${response.team_2_fouls}`;
                        }
                    }
                } else {
                    console.error('Invalid response received:', response);
                }
            },
            error: function (xhr) {
                console.error('Error fetching team fouls:', xhr.responseJSON);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const gameTimeElement = document.getElementById('gameTime');
        const gameTimeInput = document.getElementById('gameTimeInput');
        const editButton = document.getElementById('editTime');
        const saveButton = document.getElementById('saveTime');
        const cancelButton = document.getElementById('cancelEdit');

        // Show the input field for editing
        editButton.addEventListener('click', () => {
            gameTimeInput.value = gameTimeElement.textContent.trim();
            gameTimeElement.classList.add('hidden');
            gameTimeInput.classList.remove('hidden');
            editButton.classList.add('hidden');
            saveButton.classList.remove('hidden');
            cancelButton.classList.remove('hidden');
        });

        // Save the updated time
        saveButton.addEventListener('click', () => {
            const newTime = gameTimeInput.value.trim();

            if (isValidTimeFormat(newTime)) {
                saveButton.disabled = true;

                saveTimeToBackend(newTime)
                    .then(() => {
                        gameTimeElement.textContent = newTime;
                        gameTimeElement.classList.remove('hidden');
                        gameTimeInput.classList.add('hidden');
                        editButton.classList.remove('hidden');
                        saveButton.classList.add('hidden');
                        cancelButton.classList.add('hidden');
                    })
                    .catch((error) => {
                        alert('Failed to save the new time. Please check your connection and try again.');
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        saveButton.disabled = false;
                    });
            } else {
                alert('Please enter a valid time format (e.g., 10:00).');
            }
        });

        // Cancel the edit
        cancelButton.addEventListener('click', () => {
            gameTimeInput.classList.add('hidden');
            gameTimeElement.classList.remove('hidden');
            editButton.classList.remove('hidden');
            saveButton.classList.add('hidden');
            cancelButton.classList.add('hidden');
        });

        // Validate time format mm:Ss
        function isValidTimeFormat(time) {
            return /^\d{1,2}:\d{2}$/.test(time);
        }

        function saveTimeToBackend(newTime) {
            const scheduleId = getCurrentScheduleId(); 

            if (!scheduleId) {
                return Promise.reject('No schedule ID found.');
            }

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '{{ route('schedules.updateGameTime') }}', 
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', 
                        schedule_id: scheduleId,
                        new_time: newTime,
                    },
                    success: function (response) {
                        console.log('Time updated successfully:', response);
                        resolve();
                        fetchGameDetails(scheduleId);
                        updateDisplay();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error updating time:', status, error);
                        reject(error);
                    },
                });
            });
        }
    });
    </script>
</x-app-layout>