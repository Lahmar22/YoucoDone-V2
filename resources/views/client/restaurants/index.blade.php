<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Restaurants | YoucoDone</title>
    
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
        .restaurant-card:hover .btn-explore { background-color: #ea580c; color: white; border-color: #ea580c; }
    </style>
</head>
<body class="font-sans bg-brand-light text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('client.restaurants') }}" class="text-brand-dark hover:text-brand-orange font-medium transition-colors">Restaurants</a>
                
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

    <header class="bg-white pt-16 pb-12 border-b border-gray-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <h2 class="font-serif text-5xl font-bold text-brand-dark mb-4 leading-tight">
                Premium <span class="text-brand-orange italic">Dining</span> <br>Experiences
            </h2>
            <p class="text-gray-500 text-lg max-w-xl">Explore our curated selection of top-tier restaurants and artisanal menus tailored for your taste.</p>
        </div>
    </header>

    <main class="container mx-auto px-6 py-16 max-w-6xl">
        
        @if($restaurants->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($restaurants as $restaurant)
                    <div class="restaurant-card group bg-white rounded-[2rem] shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100">
                        
                        <div class="relative h-64 overflow-hidden bg-gray-200">
                            @if($restaurant->image)
                                <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i data-lucide="utensils" class="w-12 h-12"></i>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/80 backdrop-blur-md text-brand-orange px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest shadow-sm border border-white/20">
                                    {{ $restaurant->cuisine_type }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                @if(Auth::check())
                                    @php $isFav = Auth::user()->favoris->contains($restaurant->id); @endphp
                                    <form method="POST" action="{{ route('favorites.toggle', $restaurant->id) }}" class="favorite-form">
                                        @csrf
                                        <button type="submit" title="Toggle favorite" class="fav-btn p-2 rounded-full shadow transition-colors focus:outline-none {{ $isFav ? 'bg-red-500 text-white' : 'bg-white/90' }}">
                                            <i data-lucide="heart" class="w-5 h-5 {{ $isFav ? 'text-white' : 'text-gray-400' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" title="Log in to favorite" class="p-2 rounded-full bg-white/90 shadow">
                                        <i data-lucide="heart" class="w-5 h-5 text-gray-400"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="p-8">
                            <h3 class="font-serif text-2xl font-bold text-brand-dark mb-2 group-hover:text-brand-orange transition-colors">
                                {{ $restaurant->name }}
                            </h3>
                            
                            <div class="flex items-center text-gray-400 text-sm mb-6 font-medium">
                                <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-brand-orange"></i>
                                {{ $restaurant->location }}
                            </div>

                            <div class="grid grid-cols-2 gap-4 py-4 border-t border-gray-50 mb-6">
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Capacity</span>
                                    <span class="text-sm font-semibold text-brand-dark">{{ $restaurant->capacity }} Guests</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Availability</span>
                                    <span class="text-sm font-semibold text-green-600">Open Now</span>
                                </div>
                            </div>

                            @if($restaurant->horaires)
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-8 bg-gray-50 p-3 rounded-xl">
                                <i data-lucide="clock" class="w-4 h-4 text-brand-orange"></i>
                                <span>{{ $restaurant->horaires }}</span>
                            </div>
                            @endif

                            <a href="{{ route('client.restaurant.show', $restaurant->id) }}" class="btn-explore w-full flex items-center justify-center gap-2 border-2 border-brand-dark text-brand-dark font-bold py-4 rounded-2xl transition-all duration-300">
                                View Menus
                                <i data-lucide="arrow-right" class="w-5 h-5 transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-[3rem] shadow-sm border border-dashed border-gray-200">
                <div class="bg-orange-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="search-x" class="w-10 h-10 text-brand-orange"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold text-brand-dark mb-2">No Restaurants Available</h3>
                <p class="text-gray-500">Check back soon for our new restaurant partners.</p>
            </div>
        @endif
        
    </main>

    <footer class="py-12 text-center text-gray-400 text-sm">
        &copy; 2024 YoucoDone. All culinary rights reserved.
    </footer>

    <script>
        lucide.createIcons();
    </script>
    <script>
        // Toggle visual favorite state immediately on click
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.fav-btn').forEach(function(btn) {
                btn.addEventListener('click', function (e) {
                    // optimistic UI: toggle classes immediately
                    var isFav = btn.classList.contains('bg-red-500');
                    if (isFav) {
                        btn.classList.remove('bg-red-500','text-white');
                        btn.classList.add('bg-white/90');
                        var ico = btn.querySelector('i'); if (ico) { ico.classList.remove('text-white'); ico.classList.add('text-gray-400'); }
                    } else {
                        btn.classList.remove('bg-white/90');
                        btn.classList.add('bg-red-500','text-white');
                        var ico = btn.querySelector('i'); if (ico) { ico.classList.remove('text-gray-400'); ico.classList.add('text-white'); }
                    }
                    // allow form to submit normally (page may reload)
                });
            });
        });
    </script>
</body>
</html>