<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $menu->name }} Items | YoucoDone</title>
    
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
<body class="font-sans bg-brand-light text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
            <div class="flex items-center space-x-6">
                <a href="{{ route('restaurateur.dashboard') }}" class="text-brand-orange hover:text-brand-dark font-medium">Home</a>
                <a href="{{ route('restaurateur.myRestaurant') }}" class="text-brand-orange hover:text-brand-dark font-medium">My Restaurants</a>
                <a href="{{ route('restaurateur.myMenu') }}" class="text-brand-orange hover:text-brand-dark font-medium">My menu</a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-gray-100 text-sm font-medium rounded-xl text-gray-600 bg-white hover:bg-gray-50 transition shadow-sm">
                        <div class="w-8 h-8 rounded-full bg-orange-100 text-brand-orange flex items-center justify-center mr-2 font-bold uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        
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
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('restaurateur.myMenu') }}" class="text-brand-orange hover:text-brand-dark transition">
                    <i data-lucide="arrow-left" class="w-6 h-6"></i>
                </a>
                <h1 class="font-serif text-4xl font-bold text-brand-dark">Menu Items</h1>
            </div>
            <p class="text-gray-500 flex items-center gap-2">
                <i data-lucide="list" class="w-5 h-5"></i>
                <span class="text-brand-orange font-bold">{{ $menu->name }}</span>
            </p>
        </div>

        <!-- Items Grid -->
        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <!-- Item Header -->
                        <div class="relative h-32 overflow-hidden bg-gradient-to-br from-orange-100 to-orange-200">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-brand-orange group-hover:scale-110 transition-transform duration-300">
                                    <i data-lucide="utensils" class="w-8 h-8"></i>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-brand-orange shadow-lg">
                                <i data-lucide="check-circle" class="inline w-3 h-3 mr-1"></i> Item
                            </div>
                        </div>

                        <!-- Item Content -->
                        <div class="p-6">
                            <!-- Item Name -->
                            <h3 class="text-xl font-bold text-brand-dark mb-2 group-hover:text-brand-orange transition">
                                {{ $item->name }}
                            </h3>

                            <!-- Item Description (if available) -->
                            @if($item->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $item->description }}
                                </p>
                            @endif

                            <!-- Price Section -->
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 font-medium">Price</span>
                                    <span class="text-3xl font-bold text-brand-orange">
                                        ${{ number_format($item->price, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 mt-6">
                                
                                <form action="{{ route('menus.deleteItem', [$menu->id, $item->id]) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 border border-red-300 text-red-600 font-bold py-2 px-4 rounded-xl hover:bg-red-50 transition-all duration-200"
                                            onclick="return confirm('Are you sure you want to remove this item from the menu?');">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        
            

        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="bg-gray-100 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                    <i data-lucide="inbox" class="w-12 h-12 text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No Items Yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    This menu doesn't have any items yet. Add items from the menu management page to get started.
                </p>
                <a href="{{ route('myMenu') }}" class="inline-flex items-center gap-2 bg-brand-orange text-white font-bold px-8 py-3 rounded-full hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    Back to Menus
                </a>
            </div>
        @endif
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
