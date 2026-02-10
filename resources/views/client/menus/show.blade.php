<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $menu->name }} | YoucoDone</title>
    
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
        .item-row:hover { background-color: rgba(234, 88, 12, 0.02); }
    </style>
</head>
<body class="font-sans bg-brand-light text-gray-800 antialiased">

    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
            <div class="flex items-center space-x-6">
                <a href="{{ route('client.restaurant.show', $menu->restaurant_id) }}" class="text-sm font-semibold text-gray-500 hover:text-brand-orange flex items-center gap-2 transition-all group">
                    <i data-lucide="chevron-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> 
                    Back to Restaurant
                </a>
                <div class="h-6 w-px bg-gray-200"></div>
                <div class="w-8 h-8 rounded-full bg-brand-orange text-white flex items-center justify-center font-bold text-xs">
                     {{ substr(Auth::user()->name, 0, 2) }}
                </div>
            </div>
        </div>
    </nav>

    <section class="relative h-[45vh] flex items-center justify-center overflow-hidden">
        @if($menu->image)
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 bg-brand-dark"></div>
        @endif
        <div class="absolute inset-0 bg-brand-dark/50 backdrop-blur-[2px]"></div>
        
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-[0.3em] mb-3 block">Special Selection</span>
            <h1 class="font-serif text-5xl md:text-7xl font-bold text-white mb-4 italic">
                {{ $menu->name }}
            </h1>
            <div class="w-24 h-1 bg-brand-orange mx-auto rounded-full"></div>
        </div>
    </section>

    <main class="container mx-auto px-6 max-w-5xl -mt-20 relative z-20 pb-20">
        
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-white mb-16">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
                <div class="max-w-xl">
                    <h2 class="text-sm font-black uppercase text-gray-400 tracking-widest mb-2">Detailed Menu</h2>
                    <p class="text-gray-500 text-lg leading-relaxed italic">
                        Explore our curated selection of dishes, each prepared with artisanal precision and the freshest seasonal ingredients.
                    </p>
                </div>
                <div class="bg-brand-light px-8 py-6 rounded-3xl border border-gray-100 flex flex-col items-center">
                    <span class="text-3xl font-serif font-bold text-brand-orange leading-none">{{ $items->count() }}</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mt-1">Total Items</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-4 mb-10">
                <h2 class="font-serif text-3xl font-bold text-brand-dark">Culinary <span class="text-brand-orange italic">Lineup</span></h2>
                <div class="h-px flex-grow bg-gray-200"></div>
            </div>

            @if($items->count() > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach($items as $item)
                        <div class="item-row group bg-white rounded-3xl p-6 md:p-10 border border-gray-100 transition-all hover:shadow-lg hover:border-orange-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <h3 class="text-xl md:text-2xl font-bold text-brand-dark group-hover:text-brand-orange transition-colors">
                                        {{ $item->name }}
                                    </h3>
                                    <div class="h-px w-8 bg-gray-200 group-hover:w-12 group-hover:bg-brand-orange transition-all"></div>
                                </div>
                                @if($item->description)
                                    <p class="text-gray-500 text-sm md:text-base leading-relaxed max-w-2xl font-light">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center gap-8 self-end md:self-auto">
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest block mb-1">Investment</span>
                                    <p class="font-serif text-2xl md:text-3xl font-bold text-brand-dark">
                                        <span class="text-brand-orange text-sm font-sans mr-0.5">$</span>{{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-brand-light flex items-center justify-center text-brand-dark group-hover:bg-brand-orange group-hover:text-white transition-all">
                                    <i data-lucide="plus" class="w-5 h-5"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                    <i data-lucide="coffee" class="w-12 h-12 text-gray-200 mx-auto mb-4"></i>
                    <p class="text-gray-400 font-medium italic">Our kitchen is currently updating these selections.</p>
                </div>
            @endif
        </div>
    </main>

    <footer class="py-16 border-t border-gray-100 text-center">
        <p class="text-gray-400 text-xs tracking-widest uppercase mb-2">&copy; 2024 YoucoDone</p>
        <p class="font-serif italic text-gray-500">Exceptional taste, elegantly delivered.</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>