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
      x-data="{ openModal: false, openModelItem: false, menus: {id: '', name: ''} }">

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
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h2 class="font-serif text-4xl font-bold text-brand-dark mb-2">My Menus</h2>
            <p class="text-gray-500">Manage your published menus.</p>
        </div>
        <button @click="openModal = true" class="inline-flex items-center gap-2 bg-brand-orange text-white font-bold px-6 py-3 rounded-full hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition transform hover:-translate-y-1">
            <i data-lucide="plus-circle" class="w-5 h-5"></i> Add New Menu
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @foreach($menus as $menu)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group">
            <!-- Card Header with Image -->
            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                <img src="{{ asset('storage/' . $menu->image) }}" alt="Menu Cover" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-brand-orange shadow-lg">
                    <i data-lucide="menu" class="inline w-3 h-3 mr-1"></i> Menu
                </div>
            </div>
            
            <!-- Card Content -->
            <div class="p-6">
                <!-- Header Info -->
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-brand-dark mb-1 group-hover:text-brand-orange transition">{{ $menu->name }}</h3>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <i data-lucide="building" class="w-4 h-4"></i>
                        {{ $menu->restaurant_name }}
                    </p>
                </div>
                
                <!-- Description -->
                <p class="text-gray-600 text-sm mb-6 line-clamp-2">Our seasonal selection of fresh breakfast favorites and artisan coffees.</p>
                
                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-100">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-brand-orange">{{ $menu->items_count ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Items</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-brand-dark">-</p>
                        <p class="text-xs text-gray-500">Status</p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col gap-2">
                    <a href="{{ route('menus.show', $menu->id) }}" 
                       class="w-full flex gap-2 items-center justify-center bg-brand-orange hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                        <i data-lucide="eye" class="w-5 h-5"></i> 
                        View Items
                    </a>
                    <div class="flex gap-2">
                        <button @click="menus = {id: '{{ $menu->id }}', name: '{{ $menu->name }}'}; openModelItem = true" 
                                class="flex-1 flex gap-2 items-center justify-center bg-gradient-to-r from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 text-brand-orange font-bold py-2 px-4 rounded-xl transition-all duration-200 border border-orange-200">
                            <i data-lucide="plus" class="w-5 h-5"></i> 
                            Add
                        </button>
                        <form action="{{ route('menus.destroy', $menu->id) }}" method="post" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex gap-2 items-center justify-center hover:bg-red-50 text-gray-400 hover:text-red-600 font-bold py-2 px-4 rounded-xl transition-all duration-200 border border-gray-200"
                                    onclick="return confirm('Are you sure you want to delete this menu?');">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
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
                
                <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-orange-100 p-2 rounded-lg text-brand-orange">
                                    <i data-lucide="store" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-2xl font-serif font-bold text-gray-800" id="modal-title">New Menu</h3>
                            </div>
                            <button @click="openModal = false" type="button" class="text-gray-400 hover:text-gray-600 transition">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Menu Name</label>
                                <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange focus:ring-2 focus:ring-orange-100 outline-none transition-all">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Restaurant</label>
                                <select name="id_restaurant" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-orange outline-none bg-white">
                                    @foreach($restaurants as $restaurant)
                                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                    @endforeach
                                </select>
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
                            Add menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="openModelItem" 
         x-cloak 
         class="fixed inset-0 z-[100] overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        
        <div class="fixed inset-0 bg-brand-dark/60 backdrop-blur-sm transition-opacity" @click="openModelItem = false"></div>
        
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative transform bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden border border-gray-100"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                 
                <form action="{{ route('menus.itemsStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-orange-100 p-2 rounded-lg text-brand-orange">
                                    <i data-lucide="list-plus"></i>
                                </div>
                                <h3 class="text-2xl font-serif font-bold text-gray-800">
                                    Add items to <span class="text-brand-orange" x-text="menus.name"></span>
                                </h3>
                            </div>
                            <button @click="openModelItem = false" type="button" class="text-gray-400 hover:text-gray-600 transition">
                                <i data-lucide="x"></i>
                            </button>
                        </div>
                        <input type="hidden" name="menu_id" :value="menus.id">

                        <div class="max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            <label class="block text-sm font-bold text-gray-700 mb-4">Select Items to Include:</label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($menuItems as $item)
                                <label class="relative flex items-center p-4 bg-white border-2 border-gray-100 rounded-2xl cursor-pointer hover:border-brand-orange/30 hover:bg-orange-50/30 transition-all group">
                                    <input type="checkbox" name="items[]" value="{{ $item->id }}" 
                                        class="w-5 h-5 rounded border-gray-300 text-brand-orange focus:ring-brand-orange mr-4">
                                    
                                    <div class="flex items-center gap-3">
                                        
                                        
                                        <div>
                                            <p class="font-bold text-gray-800 group-hover:text-brand-orange transition-colors">
                                                {{ $item->name }}
                                            </p>
                                            
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-8 py-6 flex justify-end gap-3">
                        <button @click="openModelItem = false" type="button" class="px-6 py-3 text-sm font-bold text-gray-500">Cancel</button>
                       <button type="submit" class="bg-brand-dark text-white font-bold px-8 py-3 rounded-full hover:bg-black transition transform hover:-translate-y-1 shadow-lg">
                            Confirm Selection
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