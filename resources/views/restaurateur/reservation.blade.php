<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations | YoucoDone</title>
    
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
                            gold: '#d4af37', dark: '#1c1c1c', light: '#f8f5f2', orange: '#ea580c'
                        }
                    }
                }
            }
        }
    </script>
    <style> [x-cloak] { display: none !important; } </style>
</head>
<body class="font-sans bg-brand-light text-gray-800 antialiased" 
      x-data="{ openModal: false, editModal: false, currentRestaurant: {} }">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
            <div class="flex items-center space-x-6">
                <a href="{{ route('restaurateur.dashboard') }}" class="text-brand-orange hover:text-brand-dark font-medium">Home</a>
                <a href="{{ route('restaurateur.myRestaurant') }}" class="text-brand-orange hover:text-brand-dark font-medium">My Restaurants</a>
                <a href="{{ route('restaurateur.myMenu') }}" class="text-brand-orange hover:text-brand-dark font-medium">My menu</a>
                <a href="{{ route('restaurateur.reservation') }}"
                    class="text-brand-orange hover:text-brand-dark font-medium">Reservations</a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-gray-100 text-sm font-medium rounded-xl text-gray-600 bg-white hover:bg-gray-50 transition shadow-sm">
                        <div class="w-8 h-8 rounded-full bg-orange-100 text-brand-orange flex items-center justify-center mr-2 font-bold uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        {{ Auth::user()->name }}
                        <i data-lucide="chevron-down" class="ms-2 w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="absolute right-0 mt-2 w-48 rounded-2xl shadow-2xl py-2 bg-white border border-gray-100 z-50 text-sm">
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-brand-orange">
                            <i data-lucide="user" class="w-4 h-4"></i> Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10 max-w-6xl">
        

       <div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Réservations</h2>
        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $reservations->count() }} Réservations</span>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <thead>
                <tr class="text-left bg-gray-100 text-gray-600 font-bold text-sm uppercase tracking-wide">
                    <th class="py-3 px-6">Restaurant</th>
                    <th class="py-3 px-6">Date & Heure</th>
                    <th class="py-3 px-6">Personnes</th>
                    <th class="py-3 px-6">Cuisine</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($reservations as $res)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ asset('storage/' . $res->image) }}" 
                                         alt="{{ $res->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $res->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $res->location }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($res->date)->format('d M, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $res->time }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $res->number_of_people }} Personnes
                            </span>
                        </td>
                        <td class="py-4 px-6 text-sm">
                            {{ $res->cuisine_type }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button class="text-red-600 hover:text-red-900 font-medium text-sm">Annuler</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500 italic">
                            Aucune réservation trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    </div>

    

    

    <script>
        lucide.createIcons();
    </script>
</body>
</html>