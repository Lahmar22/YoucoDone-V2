<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Dashboard | YoucoDone</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['"Poppins"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            gold: '#d4af37',
                            dark: '#1c1c1c',
                            light: '#f8f5f2',
                            orange: '#ea580c'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans bg-brand-light text-gray-800 antialiased" x-data="{ openModal: false }">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                    Youco<span class="text-brand-orange">Done</span>
                </h1>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('restaurateur.dashboard') }}" class="text-brand-orange hover:text-brand-dark font-medium">Home</a>
                <a href="{{ route('restaurateur.myRestaurant') }}" class="text-brand-orange hover:text-brand-dark font-medium">My Restaurants</a>
                <a href="{{ route('restaurateur.myMenu') }}" class="text-brand-orange hover:text-brand-dark font-medium">My menu</a>
            </div>

            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" type="button" class="inline-flex items-center px-3 py-2 border border-gray-100 text-sm font-medium rounded-xl text-gray-600 bg-white hover:bg-gray-50 transition shadow-sm">
                        <div class="w-8 h-8 rounded-full bg-orange-100 text-brand-orange flex items-center justify-center mr-2 font-bold uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        {{ Auth::user()->name }}
                        <i data-lucide="chevron-down" class="ms-2 w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak class="absolute right-0 mt-2 w-48 rounded-2xl shadow-2xl py-2 bg-white border border-gray-100 z-50">
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-brand-orange">
                            <i data-lucide="user" class="w-4 h-4"></i> Profile
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-brand-dark">Welcome to Your Partner Dashboard</h1>
        <p class="text-gray-600 mt-2">Manage your restaurants and view performance analytics.</p>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>