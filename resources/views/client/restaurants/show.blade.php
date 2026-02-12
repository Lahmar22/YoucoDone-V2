<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | YoucoDone</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
        .glass-effect { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .menu-card:hover img { transform: scale(1.05); }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(234, 88, 12, 0.4); } 50% { box-shadow: 0 0 40px rgba(234, 88, 12, 0.6); } }
        .btn-reserve-hero { animation: pulse-glow 2s ease-in-out infinite; }
        .gradient-overlay { background: linear-gradient(135deg, rgba(234, 88, 12, 0.9) 0%, rgba(116, 75, 162, 0.9) 100%); }
    </style>
</head>
<body class="font-sans bg-brand-light text-gray-800 antialiased" x-data="{ reservationModal: false }">

    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('client.restaurants') }}" class="text-gray-600 hover:text-brand-orange font-medium transition-colors">Restaurants</a>
                <a href="{{ route('reservations.index') }}" class="text-gray-600 hover:text-brand-orange font-medium transition-colors">My Reservations</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('client.restaurants') }}" class="text-sm font-semibold text-gray-500 hover:text-brand-orange flex items-center gap-2 transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
                </a>
                <div class="h-6 w-px bg-gray-200"></div>
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-brand-orange text-white flex items-center justify-center font-bold text-xs">
                             {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    </button>
                    <div x-show="open" x-cloak class="absolute right-0 mt-3 w-48 glass-effect rounded-2xl shadow-xl border border-gray-100 py-2">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-orange-50 text-sm">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 text-sm">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative h-[60vh] flex items-end">
        @if($restaurant->image)
            <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}" class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 bg-brand-dark flex items-center justify-center">
                <i data-lucide="utensils-crosses" class="text-white/20 w-32 h-32"></i>
            </div>
        @endif
        <div class="absolute inset-0 gradient-overlay"></div>
        
        <div class="container mx-auto px-6 relative z-10 pb-16">
            <div class="max-w-4xl">
                <span class="bg-white/20 backdrop-blur-md text-white px-5 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-6 inline-block border border-white/30">
                    {{ $restaurant->cuisine_type }}
                </span>
                <h1 class="font-serif text-5xl md:text-7xl font-bold text-white mb-6 drop-shadow-2xl">
                    {{ $restaurant->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-6 text-white/90 font-medium mb-8">
                    <span class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                        <i data-lucide="map-pin" class="w-5 h-5 text-white"></i> {{ $restaurant->location }}
                    </span>
                    <span class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                        <i data-lucide="users" class="w-5 h-5 text-white"></i> {{ $restaurant->capacity }} Guests
                    </span>
                    @if($restaurant->horaires)
                        <span class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                            <i data-lucide="clock" class="w-5 h-5 text-white"></i> {{ $restaurant->horaires }}
                        </span>
                    @endif
                </div>
                <div class="flex flex-wrap gap-4">
                    <button @click="reservationModal = true" class="btn-reserve-hero inline-flex items-center gap-3 bg-white text-brand-orange font-bold px-8 py-4 rounded-2xl transition-all duration-300 hover:bg-brand-orange hover:text-white shadow-2xl hover:scale-105">
                        <i data-lucide="calendar-check" class="w-6 h-6"></i>
                        Reserve Your Table
                    </button>
                    <a href="#menus" class="inline-flex items-center gap-3 bg-white/20 backdrop-blur-md text-white border-2 border-white/30 font-bold px-8 py-4 rounded-2xl transition-all duration-300 hover:bg-white hover:text-brand-orange">
                        <i data-lucide="scroll-text" class="w-5 h-5"></i>
                        Explore Menus
                    </a>
                </div>
            </div>
        </div>
    </section>

    <main id="menus" class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            

            <div class="lg:col-span-12">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="font-serif text-4xl font-bold text-brand-dark italic">Signature <span class="not-italic text-brand-orange">Menus</span></h2>
                    <div class="h-px flex-grow mx-8 bg-gradient-to-r from-transparent via-gray-300 to-transparent hidden md:block"></div>
                </div>

                @if($menus->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($menus as $menu)
                            <div class="menu-card group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100">
                                <div class="relative h-56 overflow-hidden">
                                    @if($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <i data-lucide="image" class="w-10 h-10 text-gray-300"></i>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-brand-dark">
                                        {{ $menu->items()->count() }} Dishes
                                    </div>
                                </div>
                                
                                <div class="p-8">
                                    <h3 class="font-serif text-2xl font-bold text-brand-dark mb-2 group-hover:text-brand-orange transition-colors">
                                        {{ $menu->name }}
                                    </h3>
                                    <p class="text-gray-500 text-sm mb-6 line-clamp-2 italic">
                                        Discover a curated selection of artisanal dishes crafted with seasonal ingredients.
                                    </p>
                                    
                                    <a href="{{ route('client.menu.show', $menu->id) }}" class="flex items-center justify-center gap-2 w-full py-4 border-2 border-brand-dark rounded-xl font-bold text-brand-dark group-hover:bg-brand-dark group-hover:text-white transition-all">
                                        Discover Menu <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                        <i data-lucide="search-x" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                        <p class="text-gray-500 font-medium italic">No menus available at this moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Reservation Modal -->
    <div x-show="reservationModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="reservationModal = false">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" x-show="reservationModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full overflow-hidden" x-show="reservationModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
            
            <div class="bg-gradient-to-r from-brand-orange to-red-600 p-8 text-white relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <button @click="reservationModal = false" class="absolute top-6 right-6 text-white/80 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
                <div class="relative">
                    <i data-lucide="calendar-heart" class="w-12 h-12 mb-4"></i>
                    <h3 class="font-serif text-3xl font-bold mb-2">Reserve Your Table</h3>
                    <p class="text-white/90 text-sm">At {{ $restaurant->name }}</p>
                </div>
            </div>

            <form action="{{ route('reservations.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                
                @if($errors->any())
                    <div class="bg-red-50 border-2 border-red-200 text-red-800 px-4 py-3 rounded-xl">
                        <ul class="text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="flex items-start gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 flex-shrink-0"></i>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-brand-orange"></i>
                        Date
                    </label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-brand-orange"></i>
                        Time
                    </label>
                    <input type="time" name="time" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-brand-orange"></i>
                        Number of Guests
                    </label>
                    <select name="number_of_people" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
                        <option value="">Select number of guests</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-4 h-4 text-brand-orange"></i>
                        Special Requests <span class="text-gray-400 font-normal">(Optional)</span>
                    </label>
                    <textarea name="special_request" rows="3" placeholder="Dietary restrictions, celebrations, etc." class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="reservationModal = false" class="flex-1 px-6 py-4 border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-gradient-to-r from-brand-orange to-red-600 text-white font-bold rounded-xl hover:from-red-600 hover:to-brand-orange transition-all shadow-lg flex items-center justify-center gap-2">
                        <i data-lucide="check" class="w-5 h-5"></i>
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="py-12 border-t border-gray-100 text-center text-gray-400 text-sm">
        <p>&copy; 2024 YoucoDone. Crafted for Culinary Excellence.</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>