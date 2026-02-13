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
            <div class="space-y-8">
                @foreach($reservations as $reservation)
                    <div class="group relative bg-white rounded-[2.5rem] shadow-sm hover:shadow-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-1">
                        <div class="flex flex-col lg:flex-row overflow-hidden">
                            
                            <div class="relative w-full lg:w-80 h-64 lg:h-auto overflow-hidden">
                                @if($reservation->restaurant->image)
                                    <img src="{{ asset('storage/' . $reservation->restaurant->image) }}" 
                                        alt="{{ $reservation->restaurant->name }}" 
                                        class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <i data-lucide="utensils-crossed" class="w-12 h-12 text-slate-300"></i>
                                    </div>
                                @endif
                                
                                <div class="absolute top-6 left-6">
                                    <span class="bg-white/95 backdrop-blur-md text-brand-dark px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-xl">
                                        {{ $reservation->restaurant->cuisine_type }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex-1 p-8 lg:p-12 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-6">
                                        <div>
                                            <h3 class="font-serif text-3xl font-bold text-brand-dark group-hover:text-brand-orange transition-colors duration-300">
                                                {{ $reservation->restaurant->name }}
                                            </h3>
                                            <p class="flex items-center text-gray-400 text-sm mt-2">
                                                <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-brand-orange/70"></i>
                                                {{ $reservation->restaurant->location }}
                                            </p>
                                        </div>

                                        @php
                                            $resDate = \Carbon\Carbon::parse($reservation->date);
                                            $statusClasses = $resDate->isPast() ? 'bg-gray-100 text-gray-500' : ($resDate->isToday() ? 'bg-green-50 text-green-600 border-green-100' : 'bg-orange-50 text-brand-orange border-orange-100');
                                            $statusText = $resDate->isPast() ? 'Completed' : ($resDate->isToday() ? 'Happening Today' : 'Upcoming');
                                        @endphp
                                        <span class="hidden md:block {{ $statusClasses }} px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest border">
                                            {{ $statusText }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 py-8 border-t border-gray-50">
                                        <div class="space-y-2">
                                            <p class="text-[10px] uppercase tracking-[0.15em] text-gray-400 font-bold">Reservation Date</p>
                                            <p class="text-base font-bold text-brand-dark">{{ \Carbon\Carbon::parse($reservation->date)->format('F d, Y') }}</p>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-[10px] uppercase tracking-[0.15em] text-gray-400 font-bold">Arrival Time</p>
                                            <p class="text-base font-bold text-brand-dark">{{ \Carbon\Carbon::parse($reservation->time)->format('g:i A') }}</p>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-[10px] uppercase tracking-[0.15em] text-gray-400 font-bold">Party Size</p>
                                            <p class="text-base font-bold text-brand-dark">{{ $reservation->number_of_people }} Guests</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-6 border-t border-gray-50">
                                    <div class="flex items-center gap-4">
                                        @if($reservation->payment && $reservation->payment->status === 'completed')
                                            <div class="flex items-center gap-2 text-green-600 font-bold text-xs">
                                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                                Payment Confirmed
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2 text-amber-500 font-bold text-xs uppercase tracking-tighter">
                                                <i data-lucide="info" class="w-4 h-4"></i>
                                                Pending Settlement
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-4 w-full md:w-auto">
                                        @if(!$resDate->isPast() && (!$reservation->payment || $reservation->payment->status !== 'completed'))
                                            <a href="{{ route('payment.create', $reservation->id) }}"
                                            class="w-full md:w-auto text-center bg-brand-dark text-white px-10 py-4 rounded-2xl font-bold text-sm hover:bg-brand-orange transition-all shadow-xl shadow-gray-200">
                                                Secure Checkout
                                            </a>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-32 bg-white rounded-[3.5rem] border border-gray-100 shadow-sm">
                <div class="w-24 h-24 bg-brand-light rounded-full flex items-center justify-center mx-auto mb-8">
                    <i data-lucide="calendar-days" class="w-10 h-10 text-gray-300"></i>
                </div>
                <h3 class="text-3xl font-serif font-bold text-brand-dark mb-3">No Reservations Found</h3>
                <p class="text-gray-400 mb-10 max-w-sm mx-auto italic">Your upcoming culinary adventures will appear here once you've booked a table.</p>
                <a href="{{ route('client.restaurants') }}" 
                class="bg-brand-orange text-white px-10 py-4 rounded-2xl font-bold text-sm shadow-2xl shadow-orange-100 hover:scale-105 transition-transform">
                    Browse Fine Dining
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
