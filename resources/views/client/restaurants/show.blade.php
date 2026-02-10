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
    </style>
</head>
<body class="font-sans bg-brand-light text-gray-800 antialiased">

    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
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
        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/40 to-transparent"></div>
        
        <div class="container mx-auto px-6 relative z-10 pb-16">
            <div class="max-w-4xl">
                <span class="bg-brand-orange text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest mb-4 inline-block">
                    {{ $restaurant->cuisine_type }}
                </span>
                <h1 class="font-serif text-5xl md:text-7xl font-bold text-white mb-4">
                    {{ $restaurant->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-6 text-white/80 font-medium">
                    <span class="flex items-center gap-2"><i data-lucide="map-pin" class="w-5 h-5 text-brand-orange"></i> {{ $restaurant->location }}</span>
                    <span class="flex items-center gap-2"><i data-lucide="users" class="w-5 h-5 text-brand-orange"></i> {{ $restaurant->capacity }} Guests</span>
                    @if($restaurant->horaires)
                        <span class="flex items-center gap-2"><i data-lucide="clock" class="w-5 h-5 text-brand-orange"></i> {{ $restaurant->horaires }}</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <main class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            

            <div class="lg:col-span-8">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="font-serif text-4xl font-bold text-brand-dark italic">Signature <span class="not-italic text-brand-orange">Menus</span></h2>
                    <div class="h-px flex-grow mx-8 bg-gray-200 hidden md:block"></div>
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

    <footer class="py-12 border-t border-gray-100 text-center text-gray-400 text-sm">
        <p>&copy; 2024 YoucoDone. Crafted for Culinary Excellence.</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>