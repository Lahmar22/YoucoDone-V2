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
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
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
        [x-cloak] {
            display: none !important;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .item-row:hover {
            background-color: rgba(234, 88, 12, 0.02);
        }

        .item-row:hover .plus-icon {
            transform: rotate(90deg);
        }

        .gradient-hero {
            background: linear-gradient(135deg, rgba(234, 88, 12, 0.95) 0%, rgba(212, 175, 55, 0.95) 100%);
        }
    </style>
</head>

<body class="font-sans bg-brand-light text-gray-800 antialiased" x-data="{ reservationModal: false }">

    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
            <div class="hidden md:flex items-center space-x-6 mr-6">
                <a href="{{ route('client.restaurants') }}"
                    class="text-gray-600 hover:text-brand-orange font-medium transition-colors">Restaurants</a>
                <a href="{{ route('reservations.index') }}"
                    class="text-gray-600 hover:text-brand-orange font-medium transition-colors">My Reservations</a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('client.restaurant.show', $menu->restaurant_id) }}"
                    class="text-sm font-semibold text-gray-500 hover:text-brand-orange flex items-center gap-2 transition-all group">
                    <i data-lucide="chevron-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                    Back to Restaurant
                </a>
                <div class="h-6 w-px bg-gray-200"></div>
                <div
                    class="w-8 h-8 rounded-full bg-brand-orange text-white flex items-center justify-center font-bold text-xs">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
            </div>
        </div>
    </nav>

    <section class="relative h-[50vh] flex items-center justify-center overflow-hidden">
        @if($menu->image)
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 bg-brand-dark"></div>
        @endif
        <div class="absolute inset-0 gradient-hero backdrop-blur-[2px]"></div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <span
                class="text-white/90 font-bold text-xs uppercase tracking-[0.3em] mb-4 block bg-white/20 backdrop-blur-sm inline-block px-6 py-2 rounded-full border border-white/30">Special
                Selection</span>
            <h1 class="font-serif text-5xl md:text-7xl font-bold text-white mb-6 italic drop-shadow-2xl">
                {{ $menu->name }}
            </h1>
            <div class="w-24 h-1 bg-white/80 mx-auto rounded-full mb-8"></div>
            <a href="#"
                class="inline-flex items-center gap-3 bg-white text-brand-orange font-bold px-8 py-4 rounded-2xl transition-all duration-300 hover:bg-brand-orange hover:text-white shadow-2xl hover:scale-105">
                <i data-lucide="calendar-check" class="w-6 h-6"></i>
                Reserve Table for This Menu
            </a>
        </div>
    </section>

    <main class="container mx-auto px-6 max-w-5xl -mt-20 relative z-20 pb-20">

        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-white mb-16">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
                <div class="max-w-xl">
                    <h2 class="text-sm font-black uppercase text-gray-400 tracking-widest mb-2">Detailed Menu</h2>
                    <p class="text-gray-500 text-lg leading-relaxed italic">
                        Explore our curated selection of dishes, each prepared with artisanal precision and the freshest
                        seasonal ingredients.
                    </p>
                </div>
                <div class="bg-brand-light px-8 py-6 rounded-3xl border border-gray-100 flex flex-col items-center">
                    <span
                        class="text-3xl font-serif font-bold text-brand-orange leading-none">{{ $items->count() }}</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mt-1">Total Items</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-4 mb-10">
                <h2 class="font-serif text-3xl font-bold text-brand-dark">Culinary <span
                        class="text-brand-orange italic">Lineup</span></h2>
                <div class="h-px flex-grow bg-gray-200"></div>
            </div>

            @if($items->count() > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach($items as $item)
                        <div
                            class="item-row group bg-white rounded-3xl p-6 md:p-10 border border-gray-100 transition-all hover:shadow-lg hover:border-orange-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <h3
                                        class="text-xl md:text-2xl font-bold text-brand-dark group-hover:text-brand-orange transition-colors">
                                        {{ $item->name }}
                                    </h3>
                                    <div
                                        class="h-px w-8 bg-gray-200 group-hover:w-12 group-hover:bg-brand-orange transition-all">
                                    </div>
                                </div>
                                @if($item->description)
                                    <p class="text-gray-500 text-sm md:text-base leading-relaxed max-w-2xl font-light">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center gap-8 self-end md:self-auto">
                                <div class="text-right">
                                    <span
                                        class="text-[10px] font-bold text-gray-300 uppercase tracking-widest block mb-1">Investment</span>
                                    <p class="font-serif text-2xl md:text-3xl font-bold text-brand-dark">
                                        <span
                                            class="text-brand-orange text-sm font-sans mr-0.5">$</span>{{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-2xl bg-brand-light flex items-center justify-center text-brand-dark group-hover:bg-brand-orange group-hover:text-white transition-all">
                                    <i data-lucide="plus" class="w-5 h-5 plus-icon transition-transform duration-300"></i>
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

    <!-- Reservation Modal -->
    <div x-show="reservationModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @click.self="reservationModal = false">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" x-show="reservationModal"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full overflow-hidden"
            x-show="reservationModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">

            <div class="bg-gradient-to-r from-brand-orange to-red-600 p-8 text-white relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <button @click="reservationModal = false"
                    class="absolute top-6 right-6 text-white/80 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
                <div class="relative">
                    <i data-lucide="calendar-heart" class="w-12 h-12 mb-4"></i>
                    <h3 class="font-serif text-3xl font-bold mb-2">Reserve Your Table</h3>
                    <p class="text-white/90 text-sm">For {{ $menu->name }}</p>
                </div>
            </div>

            <form action="{{ route('reservations.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{ $menu->restaurant_id }}">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-brand-orange"></i>
                        Date
                    </label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-brand-orange"></i>
                        Time
                    </label>
                    <input type="time" name="time" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-brand-orange"></i>
                        Number of Guests
                    </label>
                    <select name="number_of_people" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
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
                    <textarea name="special_request" rows="3" placeholder="Dietary restrictions, celebrations, etc."
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="reservationModal = false"
                        class="flex-1 px-6 py-4 border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-4 bg-gradient-to-r from-brand-orange to-red-600 text-white font-bold rounded-xl hover:from-red-600 hover:to-brand-orange transition-all shadow-lg flex items-center justify-center gap-2">
                        <i data-lucide="check" class="w-5 h-5"></i>
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="py-16 border-t border-gray-100 text-center">
        <p class="text-gray-400 text-xs tracking-widest uppercase mb-2">&copy; 2024 YoucoDone</p>
        <p class="font-serif italic text-gray-500">Exceptional taste, elegantly delivered.</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>