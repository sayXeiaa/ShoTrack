<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-16 flex items-center justify-center bg-gray-100">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-start space-y-12 md:space-y-0 md:space-x-8">
            <div class="w-full md:w-1/2 p-8 text-left bg-white rounded-lg shadow-lg mt-10">
                <h1 class="text-5xl font-extrabold text-gray-800 mb-6 leading-tight">
                    Welcome to<br> Shot Track!
                </h1>
                <p class="mb-8 text-gray-600 text-lg leading-relaxed">
                    Shot Track is a web-application for basketball enthusiasts. This web-application will allow users to 
                    view ongoing and upcoming basketball tournaments. 
                </p>
                <div class="flex space-x-6">
                    <a href="tournaments"
                        class="inline-block bg-blue-500 text-white font-semibold py-3 px-6 rounded-full shadow-lg hover:bg-blue-600 transition duration-300 ease-in-out">
                        View Tournaments
                    </a>
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <img src="{{ asset('images/shottracklogo.png') }}">
            </div>
        </div>
    </div>
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-8">
                Why Use Shot Track?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="bg-gray-50 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                    <div class="flex justify-center mb-4">
                        <svg class="h-12 w-12 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path d="M12 8v4l3 2" />
                            <circle cx="12" cy="12" r="10" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Real-Time Tracking</h3>
                    <p class="text-gray-600">
                        Alllow users and statistician to track real-time updates for the current games.
                    </p>
                </div>
                <div class="bg-gray-50 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                    <div class="flex justify-center mb-4">
                        <svg class="h-12 w-12 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 17l6-6 4 4 8-8" />
                            <line x1="2" y1="20" x2="22" y2="20" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Graphical Analytics</h3>
                    <p class="text-gray-600">
                        Shot Track displays graph and advanced statistical basketball data.
                    </p>
                </div>
                <div class="bg-gray-50 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                    <div class="flex justify-center mb-4">
                        <svg class="h-12 w-12 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c4.418 0 8 3.582 8 8M12 14c-4.418 0-8 3.582-8 8M12 14a5 5 0 100-10 5 5 0 000 10z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">User Friendly</h3>
                    <p class="text-gray-600">
                        Shot Track offers user friendly interface which allows different types of user 
                        to easily navigate through the application.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-blue-500 py-10 text-center text-white">
        <h2 class="text-4xl font-bold mb-4">©2024</h2>
        <p class="mb-8 text-lg">Developed by: Ray Anthony S. Gases and Robin Joshua R. Hermocilla</p>
    </div>
</x-app-layout>
