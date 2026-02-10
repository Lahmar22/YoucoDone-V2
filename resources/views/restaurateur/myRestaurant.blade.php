<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Dashboard | YoucoDone</title>
    
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
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h2 class="font-serif text-4xl font-bold text-brand-dark mb-2">My Restaurants</h2>
                <p class="text-gray-500">Manage your published establishments.</p>
            </div>
            <button @click="openModal = true" class="inline-flex items-center gap-2 bg-brand-orange text-white font-bold px-6 py-3 rounded-full hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition transform hover:-translate-y-1">
                <i data-lucide="plus-circle" class="w-5 h-5"></i> Add New Restaurant
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Restaurant</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Cuisine</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Capacity</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Location</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach($restaurants as $restaurant)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $restaurant->image) }}" class="w-12 h-12 rounded-xl object-cover bg-gray-100">
                                    <span class="font-bold text-brand-dark">{{ $restaurant->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-orange-100 text-brand-orange text-xs font-bold px-2.5 py-1 rounded-lg">{{ $restaurant->cuisine_type }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-600">{{$restaurant->capacity}} Seats</td>
                            <td class="px-6 py-4 text-gray-500">{{$restaurant->location}}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button @click="
                                        currentRestaurant = {
                                            id: '{{ $restaurant->id }}',
                                            name: '{{ addslashes($restaurant->name) }}',
                                            cuisine_type: '{{ $restaurant->cuisine_type }}',
                                            location: '{{ addslashes($restaurant->location) }}',
                                            capacity: '{{ $restaurant->capacity }}',
                                            horaires: '{{ addslashes($restaurant->horaires) }}',
                                            image_url: '{{ asset('storage/' . $restaurant->image) }}'
                                        };
                                        editModal = true;
                                    " class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </button>
                                    <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST" onsubmit="return confirm('Delete this restaurant?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-brand-dark/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div x-show="openModal" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-white/20">
                
                <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-orange-100 p-2 rounded-lg text-brand-orange">
                                    <i data-lucide="store" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-2xl font-serif font-bold text-gray-800" id="modal-title">New Restaurant</h3>
                            </div>
                            <button @click="openModal = false" type="button" class="text-gray-400 hover:text-gray-600 transition">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Restaurant Name</label>
                                <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange focus:ring-2 focus:ring-orange-100 outline-none transition-all">
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Cuisine Type</label>
                                <select name="cuisine_type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none bg-white">
                                    <option>Italian</option>
                                    <option>French</option>
                                    <option>Japanese</option>
                                    <option>Moroccan</option>
                                </select>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Location</label>
                                <div class="relative">
                                    <i data-lucide="map-pin" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                                    <input type="text" name="location" placeholder="Marrakech, MA" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none">
                                </div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Capacity (Seats)</label>
                                <div class="relative">
                                    <i data-lucide="users" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                                    <input type="number" name="capacity" placeholder="50" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none">
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Opening Hours</label>
                                <input type="text" name="horaires" placeholder="Mon-Sun: 12:00 - 23:00" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Cover Image</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl hover:bg-gray-50 transition cursor-pointer relative group">
                                    <div class="space-y-1 text-center">
                                        <i data-lucide="image" class="mx-auto h-10 w-10 text-gray-400 group-hover:text-brand-orange transition"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <span class="relative cursor-pointer rounded-md font-bold text-brand-orange">Upload a file</span>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG up to 10MB</p>
                                    </div>
                                    <input name="image" type="file" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-8 py-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                        <button @click="openModal = false" type="button" class="px-6 py-3 text-sm font-bold text-gray-600 hover:text-gray-800 transition">Cancel</button>
                        <button type="submit" class="bg-brand-orange text-white font-bold px-8 py-3 rounded-full hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition transform hover:-translate-y-1">
                            Publish Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="editModal" x-cloak class="fixed inset-0 z-[100] overflow-y-auto">
        <div class="fixed inset-0 bg-brand-dark/60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative transform bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden border border-gray-100">
                <form :action="'/restaurants/' + currentRestaurant.id" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-100 p-2 rounded-lg text-blue-600"><i data-lucide="edit-3"></i></div>
                                <h3 class="text-2xl font-serif font-bold text-gray-800">Edit Restaurant</h3>
                            </div>
                            <button @click="editModal = false" type="button" class="text-gray-400 hover:text-gray-600"><i data-lucide="x"></i></button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Restaurant Name</label>
                                <input type="text" name="name" x-model="currentRestaurant.name" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none transition-all">
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Cuisine Type</label>
                                <select name="cuisine_type" x-model="currentRestaurant.cuisine_type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none bg-white">
                                    <option value="Italian">Italian</option>
                                    <option value="French">French</option>
                                    <option value="Japanese">Japanese</option>
                                    <option value="Moroccan">Moroccan</option>
                                </select>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Location</label>
                                <input type="text" name="location" x-model="currentRestaurant.location" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none">
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Capacity</label>
                                <input type="number" name="capacity" x-model="currentRestaurant.capacity" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Hours</label>
                                <input type="text" name="horaires" x-model="currentRestaurant.horaires" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Current Image</label>
                                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 mb-2">
                                    <template x-if="currentRestaurant.image_url">
                                        <img :src="currentRestaurant.image_url" class="w-20 h-20 rounded-xl object-cover border-2 border-white shadow-sm">
                                    </template>
                                    <p class="text-xs text-gray-400">Upload a new file below to replace this image.</p>
                                </div>
                                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-brand-orange hover:file:bg-orange-100">
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-8 py-6 flex justify-end gap-3">
                        <button @click="editModal = false" type="button" class="px-6 py-3 text-sm font-bold text-gray-500">Cancel</button>
                        <button type="submit" class="bg-brand-dark text-white font-bold px-8 py-3 rounded-full hover:bg-black transition transform hover:-translate-y-1">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>