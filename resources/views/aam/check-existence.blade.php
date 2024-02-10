<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scout Management System</title>
    @filamentStyles
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="max-w-md w-full p-8 bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-semibold mb-4">Scouts South Africa</h1>
        <h1 class="text-xl font-semibold mb-4">Application for Adult Member</h1>

        <p class="text-gray-600 mb-6">
            Have you already got an account on scouts digital?
        </p>

        <livewire:aam.check-user-existence />


    </div>
    @livewire('notifications')
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
