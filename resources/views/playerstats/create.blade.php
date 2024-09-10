<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex space-x-8">
                <div class="bg-gray p-6 rounded-lg border border-gray-400 shadow-md flex-1">
                    <div class="mb-6 text-center">
                        <h2 class="flex justify-left font-semibold text-xl text-black leading-tight">Live Scoring</h2>
                        <hr class="border-gray-300 border-t-2 mt-2">
                    </div>
                    <div class="mb-6">
                        <div class="flex bg-gray-100 py-4 px-6 rounded-lg shadow-md border border-gray-400 space-x-8">
                            <div class="flex-1 bg-white p-2 rounded-lg shadow flex flex-col items-center justify-center">
                                <h3 class="font-bold text-lg text-black">Team A</h3>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center justify-center">
                                <p id="teamAScore" class="text-4xl font-semibold text-black">0</p>
                            </div>
                            <div class="flex-col items-center space-y-2">
                                <div class="bg-white p-4 rounded-lg shadow">
                                    <p id="gameTime" class="text-4xl font-semibold text-black text-center">00:00</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow">
                                    <h3 class="font-bold text-lg text-black text-center">Pause Time</h3>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center justify-center">
                                <p id="teamBScore" class="text-4xl font-semibold text-black">0</p>
                            </div>
                            <div class="flex-1 bg-white p-4 rounded-lg shadow flex flex-col items-center justify-center">
                                <p id="teamname" class="text-4xl font-semibold text-black">Team B</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-4">
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(10, 'Team A')">
                                    <p>10</p>
                                </div>
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(12, 'Team A')">
                                    <p>12</p>
                                </div>
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(23, 'Team A')">
                                    <p>23</p>
                                </div>
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(7, 'Team A')">
                                    <p>7</p>
                                </div>
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(5, 'Team A')">
                                    <p>5</p>
                                </div>
                            </div>
                            <div class="middle-box bg-gray-100 p-4 rounded-lg shadow text-center">
                                <button id="quarterButton" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="nextQuarter()">
                                    Q1
                                </button>
                            </div>
                            <div class="flex space-x-4">
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(8, 'Team B')">
                                    <p>8</p>
                                </div>
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(22, 'Team B')">
                                    <p>22</p>
                                </div>
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(33, 'Team B')">
                                    <p>33</p>
                                </div>
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(11, 'Team B')">
                                    <p>11</p>
                                </div>
                                <div class="player-box bg-gray-500 text-center cursor-pointer text-black" onclick="selectPlayerNumber(21, 'Team B')">
                                    <p>21</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="flex justify-between items-center">
                                <div class="flex space-x-4">
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(30, 'Team A')">
                                        <p>30</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(32, 'Team A')">
                                        <p>32</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(45, 'Team A')">
                                        <p>45</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(6, 'Team A')">
                                        <p>6</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(15, 'Team A')">
                                        <p>15</p>
                                    </div>
                                </div>
                                <div class="middle-box bg-gray-100 p-4 rounded-lg shadow text-center">
                                    <button id="nextQuarterButtonSub" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="nextQuarter()">
                                        Next Quarter
                                    </button>
                                </div>
                                <div class="flex space-x-4">
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(9, 'Team B')">
                                        <p>9</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(24, 'Team B')">
                                        <p>24</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(34, 'Team B')">
                                        <p>34</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(14, 'Team B')">
                                        <p>14</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(19, 'Team B')">
                                        <p>19</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="flex justify-between items-center">
                                <div class="flex space-x-4">
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(30, 'Team A')">
                                        <p>30</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(32, 'Team A')">
                                        <p>32</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(45, 'Team A')">
                                        <p>45</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(6, 'Team A')">
                                        <p>6</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(15, 'Team A')">
                                        <p>15</p>
                                    </div>
                                </div>
                                <div class="middle-box bg-gray-100 p-4 rounded-lg shadow text-center">                  
                                    <button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick>
                                        Sub
                                    </button>
                                </div>
                                <div class="flex space-x-4">
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(9, 'Team B')">
                                        <p>9</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(24, 'Team B')">
                                        <p>24</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(34, 'Team B')">
                                        <p>34</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(14, 'Team B')">
                                        <p>14</p>
                                    </div>
                                    <div class="player-box bg-gray-200 text-center cursor-pointer text-black" onclick="selectPlayerNumber(19, 'Team B')">
                                        <p>19</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <x-message></x-message>
                        <form method="POST" action="{{ route('playerstats.index') }}" id="playerStatsForm">
                            @csrf
                            <input type="hidden" name="player_number" id="selectedPlayerNumber" value="">
                            <input type="hidden" name="team_name" id="selectedTeamName" value="">
                            <!-- Shot Made or Missed -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded" onclick="setShotResult('made')">Made</button>
                                <button type="button" class="bg-gray-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="setShotResult('missed')">Missed</button>
                            </div>
                            <!-- Assist -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="setAssist('yes')">Assist</button>
                                <button type="button" class="bg-gray-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="setAssist('no')">No Assist</button>
                            </div>
                            <!-- Points -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="setShotType('2pt')">2 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="setShotType('3pt')">3 Points</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="setShotType('free')">Free Throw</button>
                            </div>
                            <!-- Rebounds -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="addStatAndSubmit('offensive_rebounds', 1)">Offensive Rebound</button>
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="addStatAndSubmit('defensive_rebounds', 1)">Defensive Rebound</button>
                            </div>
                            <!-- Block -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="addStatAndSubmit('blocks', 1)">Block</button>
                            </div>
                            <!-- Steal -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="addStatAndSubmit('steals', 1)">Steal</button>
                            </div>
                            <!-- Turnover -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="addStatAndSubmit('turnovers', 1)">Turnover</button>
                            </div>
                            <!-- Foul -->
                            <div class="mb-4">
                                <button type="button" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="addStatAndSubmit('fouls', 1)">Foul</button>
                            </div>
                            <button type="submit" class="bg-gray-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save Stats</button>
                        </form>
                    </div>
                </div>
                <div class="bg-gray p-6 rounded-lg border border-gray-400 shadow-md flex-1">
                    <div class="mb-6 text-center">
                        <h2 class="flex justify-left font-semibold text-xl text-black leading-tight">Live Player Statistics</h2>
                        <hr class="border-gray-300 border-t-2 mt-2">
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
    </style>

    <style>
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
        function selectPlayerNumber(number, team) {
            document.getElementById('player_number').innerText = number;
            document.getElementById('team_name').innerText = team;
            document.getElementById('selectedPlayerNumber').value = number;
            document.getElementById('selectedTeamName').value = team;
        }

        function setShotResult(result) {
            document.getElementById('shot_result').value = result;
        }

        function setAssist(assist) {
            document.getElementById('assist').value = assist;
        }

        function setShotType(type) {
            document.getElementById('shot_type').value = type;
        }

        function addStatAndSubmit(stat, value) {
            let input = document.getElementById(stat);
            input.value = parseInt(input.value) + value;
            document.getElementById('playerStatsForm').submit();
        }

        function nextQuarter() {
            if (currentQuarter < 4) {
                currentQuarter++;
                if (currentQuarter === 2) {
                    document.getElementById('quarterButton').innerText = 'Q2';
                } else if (currentQuarter === 3) {
                    document.getElementById('quarterButton').innerText = 'Q3';
                } else if (currentQuarter === 4) {
                    document.getElementById('quarterButton').innerText = 'Q4';
                }
                document.getElementById('nextQuarterButtonSub').innerText = 'Next Quarter';
            } else {
                alert('Already in final quarter');
            }
        }

        document.getElementById('quarterButton').innerText = 'Q1';
        document.getElementById('nextQuarterButtonSub').innerText = 'Next Quarter';
    </script>
</x-app-layout>
