<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="flex items-center justify-center h-16 bg-gray-800">
            <span class="text-xl font-semibold">Dashboard</span>
        </div>
        <nav class="flex-1 p-4">
            <ul>
                <li>
                    <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                        <span class="material-icons">home</span>
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                        <span class="material-icons">group</span>
                        <span class="ml-2">Team</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                        <span class="material-icons">folder</span>
                        <span class="ml-2">Projects</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                        <span class="material-icons">calendar_today</span>
                        <span class="ml-2">Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                        <span class="material-icons">description</span>
                        <span class="ml-2">Documents</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                        <span class="material-icons">bar_chart</span>
                        <span class="ml-2">Reports</span>
                    </a>
                </li>
            </ul>
            <div class="mt-4">
                <h3 class="text-xs uppercase tracking-wider text-gray-400">Your teams</h3>
                <ul>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <span class="bg-gray-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">H</span>
                            <span class="ml-2">Heroicons</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <span class="bg-gray-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">T</span>
                            <span class="ml-2">Tailwind Labs</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <span class="bg-gray-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">W</span>
                            <span class="ml-2">Workcation</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="p-4">
            <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                <span class="material-icons">settings</span>
                <span class="ml-2">Settings</span>
            </a>
        </div>
    </div>

    <!-- Main content -->
    <div class="flex-1 p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
            <div class="flex items-center">
                <button class="material-icons p-2 rounded-full hover:bg-gray-200">notifications</button>
                <div class="ml-4 flex items-center">
                    <span class="material-icons">account_circle</span>
                    <span class="ml-2">Tom Cook</span>
                </div>
            </div>
        </div>
        <div class="border-2 border-dashed border-gray-300 rounded-lg h-96"></div>
    </div>
</div>
</body>
</html>

