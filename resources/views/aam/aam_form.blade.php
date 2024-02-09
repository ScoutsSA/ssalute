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

<div class="p-8 " >

    <div class="text-center mb-4">
        <h1 class="text-2xl font-semibold mb-4">Scouts South Africa</h1>

        <p class="text-gray-600 mb-6">Application for Adult Membership (AAM)</p>
    </div>
    <livewire:aam.application-adult-member-form />
</div>

@livewire('notifications')
@filamentScripts
@vite('resources/js/app.js')
</body>

</html>
