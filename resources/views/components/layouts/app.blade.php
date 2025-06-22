<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Minha Página' }}</title>

    <!-- Vite: CSS e JS -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <!-- Livewire -->
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">

    <!-- Cabeçalho opcional -->
    <header class="bg-white shadow p-4">
        <h1 class="text-xl font-bold">{{ $title ?? 'Título' }}</h1>
    </header>

    <!-- Conteúdo principal -->
    <main class="p-4">
        {{ $slot }}
    </main>

    <!-- Livewire -->
    @livewireScripts
</body>
</html>