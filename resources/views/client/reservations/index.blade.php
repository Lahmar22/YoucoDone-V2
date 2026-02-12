<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations | YoucoDone</title>
    
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
    <style> 
        [x-cloak] { display: none !important; }
        .reservation-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="font-sans bg-brand-light text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('client.restaurants') }}" class="text-gray-600 hover:text-brand-orange font-medium transition-colors">Restaurants</a>
                <a href="{{ route('reservations.index') }}" class="text-brand-orange font-semibold">My Reservations</a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="inline-flex items-center p-1 pr-3 border border-gray-100 rounded-full bg-white hover:bg-gray-50 transition shadow-sm">
                        <div class="w-8 h-8 rounded-full bg-brand-orange text-white flex items-center justify-center font-bold uppercase text-xs">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <i data-lucide="chevron-down" class="ms-2 w-4 h-4 text-gray-400"></i>
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

    <header class="relative bg-gradient-to-br from-white via-orange-50/30 to-purple-50/20 pt-20 pb-16 border-b border-gray-100 overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-10 left-10 w-72 h-72 bg-brand-orange rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-6 max-w-6xl relative z-10">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-brand-orange to-red-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="calendar-heart" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <h2 class="font-serif text-4xl md:text-5xl font-bold text-brand-dark leading-tight">
                        My <span class="text-brand-orange italic">Reservations</span>
                    </h2>
                    <p class="text-gray-600 text-lg mt-1">Manage your upcoming dining experiences</p>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-16 max-w-6xl">
        
        @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                <p class="font-semibold flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-green-600 hover:text-green-800 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        @endif

        @if($reservations->count() > 0)
            <div class="grid grid-cols-1 gap-6">
                @foreach($reservations as $reservation)
                    <div class="reservation-card bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden transition-all duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 p-8">
                            
                            <!-- Restaurant Image -->
                            <div class="md:col-span-3">
                                <div class="relative h-40 md:h-full rounded-2xl overflow-hidden bg-gray-200">
                                    @if($reservation->restaurant->image)
                                        <img src="{{ asset('storage/' . $reservation->restaurant->image) }}" alt="{{ $reservation->restaurant->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i data-lucide="utensils" class="w-12 h-12"></i>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-brand-orange/90 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold">
                                            {{ $reservation->restaurant->cuisine_type }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Reservation Details -->
                            <div class="md:col-span-6 flex flex-col justify-center">
                                <h3 class="font-serif text-2xl font-bold text-brand-dark mb-2">
                                    {{ $reservation->restaurant->name }}
                                </h3>
                                <div class="flex items-center text-gray-500 text-sm mb-4">
                                    <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-brand-orange"></i>
                                    {{ $reservation->restaurant->location }}
                                </div>
                                
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-xl">
                                        <i data-lucide="calendar" class="w-5 h-5 text-brand-orange"></i>
                                        <div>
                                            <p class="text-xs text-gray-500 font-semibold">Date</p>
                                            <p class="text-sm font-bold text-brand-dark">{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-xl">
                                        <i data-lucide="clock" class="w-5 h-5 text-brand-orange"></i>
                                        <div>
                                            <p class="text-xs text-gray-500 font-semibold">Time</p>
                                            <p class="text-sm font-bold text-brand-dark">{{ \Carbon\Carbon::parse($reservation->time)->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-xl">
                                        <i data-lucide="users" class="w-5 h-5 text-brand-orange"></i>
                                        <div>
                                            <p class="text-xs text-gray-500 font-semibold">Guests</p>
                                            <p class="text-sm font-bold text-brand-dark">{{ $reservation->number_of_people }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="md:col-span-3 flex flex-col justify-center items-end gap-3">
                                @php
                                    $reservationDate = \Carbon\Carbon::parse($reservation->date);
                                    $isPast = $reservationDate->isPast();
                                    $isToday = $reservationDate->isToday();
                                    $isUpcoming = $reservationDate->isFuture();
                                @endphp

                                @if($isPast)
                                    <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-sm font-bold">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        Completed
                                    </span>
                                @elseif($isToday)
                                    <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Today!
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 bg-orange-100 text-brand-orange px-4 py-2 rounded-full text-sm font-bold">
                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                        Upcoming
                                    </span>
                                @endif

                                <a href="{{ route('client.restaurant.show', $reservation->restaurant->id) }}" class="inline-flex items-center gap-2 border-2 border-brand-dark text-brand-dark font-bold px-6 py-2 rounded-xl hover:bg-brand-dark hover:text-white transition-all">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    View Restaurant
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-[3rem] shadow-sm border border-dashed border-gray-200">
                <div class="bg-orange-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="calendar-x" class="w-12 h-12 text-brand-orange"></i>
                </div>
                <h3 class="font-serif text-3xl font-bold text-brand-dark mb-3">No Reservations Yet</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Start exploring our premium restaurants and make your first reservation!</p>
                <a href="{{ route('client.restaurants') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-orange to-red-600 text-white font-bold px-8 py-4 rounded-2xl hover:from-red-600 hover:to-brand-orange transition-all shadow-lg">
                    <i data-lucide="utensils" class="w-5 h-5"></i>
                    Explore Restaurants
                </a>
            </div>
        @endif
        
    </main>

    <footer class="py-12 text-center text-gray-400 text-sm border-t border-gray-100">
        &copy; 2024 YoucoDone. All culinary rights reserved.
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
