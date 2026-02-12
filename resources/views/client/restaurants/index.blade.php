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
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap"
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

        .restaurant-card:hover .btn-explore {
            background-color: #ea580c;
            color: white;
            border-color: #ea580c;
        }

        .restaurant-card:hover .btn-reserve {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(234, 88, 12, 0.3);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #ea580c 0%, #d4af37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="font-sans bg-brand-light text-gray-800 antialiased"
    x-data="{ reservationModal: false, selectedRestaurant: null }">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                Youco<span class="text-brand-orange">Done</span>
            </h1>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('client.restaurants') }}"
                    class="text-brand-dark hover:text-brand-orange font-medium transition-colors">Restaurants</a>
                <a href="{{ route('reservations.index') }}"
                    class="text-gray-600 hover:text-brand-orange font-medium transition-colors">My Reservations</a>

            </div>
            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center p-1 pr-3 border border-gray-100 rounded-full bg-white hover:bg-gray-50 transition shadow-sm">
                        <div
                            class="w-8 h-8 rounded-full bg-brand-orange text-white flex items-center justify-center font-bold uppercase text-xs">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <i data-lucide="chevron-down" class="ms-2 w-4 h-4 text-gray-400"></i>
                    </button>
                    <div x-show="open" x-cloak
                        class="absolute right-0 mt-2 w-48 rounded-2xl shadow-2xl py-2 bg-white border border-gray-100 z-50 text-sm">
                        <a href="{{ route('profile.show') }}"
                            class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-brand-orange">
                            <i data-lucide="user" class="w-4 h-4"></i> Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <header
        class="relative bg-gradient-to-br from-white via-orange-50/30 to-purple-50/20 pt-20 pb-16 border-b border-gray-100 overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-10 left-10 w-72 h-72 bg-brand-orange rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-6 max-w-6xl relative z-10">
            <h2 class="font-serif text-5xl md:text-6xl font-bold text-brand-dark mb-6 leading-tight">
                Premium <span class="gradient-text italic">Dining</span> <br>Experiences
            </h2>
            <p class="text-gray-600 text-lg md:text-xl max-w-2xl mb-8 leading-relaxed">Explore our curated selection of
                top-tier restaurants and artisanal menus tailored for your taste.</p>
            <div class="flex flex-wrap gap-4">
                <div
                    class="flex items-center gap-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm border border-gray-100">
                    <i data-lucide="award" class="w-4 h-4 text-brand-orange"></i>
                    <span class="text-sm font-semibold text-gray-700">Premium Selection</span>
                </div>
                <div
                    class="flex items-center gap-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm border border-gray-100">
                    <i data-lucide="star" class="w-4 h-4 text-brand-orange"></i>
                    <span class="text-sm font-semibold text-gray-700">Top Rated</span>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-16 max-w-6xl">

        @if($restaurants->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($restaurants as $restaurant)
                    <div
                        class="restaurant-card group bg-white rounded-[2rem] shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100">

                        <div class="relative h-64 overflow-hidden bg-gray-200">
                            @if($restaurant->image)
                                <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i data-lucide="utensils" class="w-12 h-12"></i>
                                </div>
                            @endif

                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-white/80 backdrop-blur-md text-brand-orange px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest shadow-sm border border-white/20">
                                    {{ $restaurant->cuisine_type }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                @if(Auth::check())
                                    @php $isFav = Auth::user()->favoris->contains($restaurant->id); @endphp
                                    <form method="POST" action="{{ route('favorites.toggle', $restaurant->id) }}"
                                        class="favorite-form">
                                        @csrf
                                        <button type="submit" title="Toggle favorite"
                                            class="fav-btn p-2 rounded-full shadow transition-colors focus:outline-none {{ $isFav ? 'bg-red-500 text-white' : 'bg-white/90' }}">
                                            <i data-lucide="heart"
                                                class="w-5 h-5 {{ $isFav ? 'text-white' : 'text-gray-400' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" title="Log in to favorite"
                                        class="p-2 rounded-full bg-white/90 shadow">
                                        <i data-lucide="heart" class="w-5 h-5 text-gray-400"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="p-8">
                            <h3
                                class="font-serif text-2xl font-bold text-brand-dark mb-2 group-hover:text-brand-orange transition-colors">
                                {{ $restaurant->name }}
                            </h3>

                            <div class="flex items-center text-gray-400 text-sm mb-6 font-medium">
                                <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-brand-orange"></i>
                                {{ $restaurant->location }}
                            </div>

                            <div class="grid grid-cols-2 gap-4 py-4 border-t border-gray-50 mb-6">
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Capacity</span>
                                    <span class="text-sm font-semibold text-brand-dark">{{ $restaurant->capacity }}
                                        Guests</span>
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Availability</span>
                                    <span class="text-sm font-semibold text-green-600">Open Now</span>
                                </div>
                            </div>

                            @if($restaurant->horaires)
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-6 bg-gray-50 p-3 rounded-xl">
                                    <i data-lucide="clock" class="w-4 h-4 text-brand-orange"></i>
                                    <span>{{ $restaurant->horaires }}</span>
                                </div>
                            @endif

                            <div class="space-y-3">
                                <button @click="selectedRestaurant = {{ $restaurant->id }}; reservationModal = true"
                                    class="btn-reserve w-full flex items-center justify-center gap-2 bg-gradient-to-r from-brand-orange to-red-600 hover:from-red-600 hover:to-brand-orange text-white font-bold py-4 rounded-2xl transition-all duration-300 shadow-lg">
                                    <i data-lucide="calendar-check" class="w-5 h-5"></i>
                                    Reserve Table
                                </button>
                                <a href="{{ route('client.restaurant.show', $restaurant->id) }}"
                                    class="btn-explore w-full flex items-center justify-center gap-2 border-2 border-brand-dark text-brand-dark font-bold py-4 rounded-2xl transition-all duration-300">
                                    View Menus
                                    <i data-lucide="arrow-right"
                                        class="w-5 h-5 transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>
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

    <!-- Reservation Modal -->
    <div x-show="reservationModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @click.self="reservationModal = false">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" x-show="reservationModal"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full overflow-hidden"
            x-show="reservationModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">

            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-brand-orange to-red-600 p-8 text-white relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <button @click="reservationModal = false"
                    class="absolute top-6 right-6 text-white/80 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
                <div class="relative">
                    <i data-lucide="calendar-heart" class="w-12 h-12 mb-4"></i>
                    <h3 class="font-serif text-3xl font-bold mb-2">Reserve Your Table</h3>
                    <p class="text-white/90 text-sm">Secure your spot for an unforgettable dining experience</p>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('reservations.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="restaurant_id" :value="selectedRestaurant">

                <!-- Error Messages -->
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

                <!-- Date Field -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-brand-orange"></i>
                        Date
                    </label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
                </div>

                <!-- Time Field -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-brand-orange"></i>
                        Time
                    </label>
                    <input type="time" name="time" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
                </div>

                <!-- Number of People -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-brand-orange"></i>
                        Number of Guests
                    </label>
                    <input type="number" name="number_of_people" min="1" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-brand-orange focus:ring-4 focus:ring-orange-100 transition-all outline-none">
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3 pt-4">
                    <button type="button" @click="reservationModal = false"
                        class="flex-1 px-6 py-4 border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-4 bg-gradient-to-r from-brand-orange to-red-600 text-white font-bold rounded-xl hover:from-red-600 hover:to-brand-orange transition-all shadow-lg flex items-center justify-center gap-2">
                        <i data-lucide="check" class="w-5 h-5"></i>
                        Confirm Reservation
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="py-12 text-center text-gray-400 text-sm">
        &copy; 2024 YoucoDone. All culinary rights reserved.
    </footer>

    <script>
        lucide.createIcons();
    </script>
    <script>
        // Toggle visual favorite state immediately on click
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.fav-btn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    // optimistic UI: toggle classes immediately
                    var isFav = btn.classList.contains('bg-red-500');
                    if (isFav) {
                        btn.classList.remove('bg-red-500', 'text-white');
                        btn.classList.add('bg-white/90');
                        var ico = btn.querySelector('i'); if (ico) { ico.classList.remove('text-white'); ico.classList.add('text-gray-400'); }
                    } else {
                        btn.classList.remove('bg-white/90');
                        btn.classList.add('bg-red-500', 'text-white');
                        var ico = btn.querySelector('i'); if (ico) { ico.classList.remove('text-gray-400'); ico.classList.add('text-white'); }
                    }
                    // allow form to submit normally (page may reload)
                });
            });
        });
    </script>
</body>

</html>