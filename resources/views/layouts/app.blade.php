<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zabbix Template Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .step-active { color: #3b82f6; border-bottom: 2px solid #3b82f6; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-lg mb-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-microchip text-blue-600 text-2xl mr-3"></i>
                    <span class="font-bold text-xl text-gray-800">Zabbix Template Studio</span>
                </div>
                <div class="hidden md:flex space-x-4">
                    <span class="text-sm text-gray-500">Advanced Template & LLD Generator</span>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 pb-12">
        <div class="bg-white rounded-lg shadow-md p-6">
            @yield('content')
        </div>
    </main>

    <footer class="text-center text-gray-500 text-sm py-8">
        &copy; {{ date('Y') }} Zabbix Template Studio - Senior Software Architect Specialist
    </footer>
</body>
</html>
