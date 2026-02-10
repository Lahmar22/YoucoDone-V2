<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans bg-gray-100 text-gray-800 min-h-screen">
    <div class="flex">
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen px-6 py-8">
            <h2 class="font-serif text-2xl font-bold text-brand-dark mb-6">YoucoDone Admin</h2>
            <nav class="space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50">Dashboard</a>
                <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-50">Restaurants</a>
                <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-50">Menus</a>
                <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-50">Users</a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button id="sidebarToggle" class="p-2 rounded-md hover:bg-gray-50">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <div x-data="{ open: false }" class="relative">
                        <button @click.prevent="open = !open" class="inline-flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-50">
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center font-semibold">{{ strtoupper(substr(auth('admin')->user()->name ?? 'A',0,1)) }}</div>
                            <div class="text-sm text-gray-600">{{ auth('admin')->user()->name ?? 'Admin' }}</div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                        </button>

                        <div x-show="open" x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-48 rounded-2xl shadow-2xl py-2 bg-white border border-gray-100 z-50 text-sm">
                            <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-brand-orange">
                                <i data-lucide="user" class="w-4 h-4"></i> Profile
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
