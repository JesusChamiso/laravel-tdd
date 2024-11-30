<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-200">
    <ul class="max-w-lg bg-white border-r border-gray-300 shadow-xl">
        @forelse ($repositories as $repository)
            <li class="flex items-center text-black p-2 hover:bg-gray-300">
                <img class="w-12 h-12 rounded-full mr-2" src="{{ $repository->user->profile_photo_url }}">
                <div class="felx justify-between w-full">
                    <div class="felx-1">
                        <h2 class="text-sm font-semibold text-black">{{ $repository->url }}</h2>
                        <p>{{ $repository->description }}</p>
                    </div>
                    <span
                        class="text-xs font-medium text-gray-600">{{ $repository->created_at->diffForHumans() }}</span>
                </div>
            </li>
        @empty
            <p>sin datos</p>
        @endforelse
    </ul>
</body>

</html>
