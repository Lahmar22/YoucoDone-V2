<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Dashboard | YoucoDone</title> 

    <script src="https://cdn.tailwindcss.com"></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                            gold: '#d4af37',
                            dark: '#1c1c1c',
                            light: '#f8f5f2',
                            orange: '#ea580c'
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
    </style>
</head>

<body class="font-sans bg-brand-light text-gray-800 antialiased" x-data="{ openModal: false }">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
                    Youco<span class="text-brand-orange">Done</span>
                </h1>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('restaurateur.dashboard') }}"
                    class="text-brand-orange hover:text-brand-dark font-medium">Home</a>
                <a href="{{ route('restaurateur.myRestaurant') }}"
                    class="text-brand-orange hover:text-brand-dark font-medium">My Restaurants</a>
                <a href="{{ route('restaurateur.myMenu') }}"
                    class="text-brand-orange hover:text-brand-dark font-medium">My menu</a>
                <a href="{{ route('restaurateur.reservation') }}"
                    class="text-brand-orange hover:text-brand-dark font-medium">Reservations</a>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Notification Bell -->
                <div class="relative" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
                    <button @click="notifOpen = !notifOpen" type="button"
                        class="relative p-2 text-gray-600 hover:text-brand-orange hover:bg-orange-50 rounded-xl transition">
                        <i data-lucide="bell" class="w-6 h-6"></i>
                        @if($notifications->count() > 0)
                            <span
                                class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                                {{ $notifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="notifOpen" x-cloak
                        class="absolute right-0 mt-2 w-96 max-h-96 overflow-y-auto rounded-2xl shadow-2xl py-2 bg-white border border-gray-100 z-50"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                        <div class="px-4 py-3 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                        </div>

                        @if($notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <div class="px-4 py-3 hover:bg-orange-50 border-b border-gray-50 cursor-pointer transition"
                                    onclick="markAsRead({{ $notification->id }})">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 text-brand-orange flex items-center justify-center">
                                            <i data-lucide="calendar" class="w-5 h-5"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">
                                                New Reservation
                                            </p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <strong>{{ $notification->data['customer_name'] }}</strong> reserved a table at
                                                <strong>{{ $notification->data['restaurant_name'] }}</strong>
                                            </p>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <span>📅
                                                    {{ \Carbon\Carbon::parse($notification->data['date'])->format('M d, Y') }}</span>
                                                <span class="mx-1">•</span>
                                                <span>🕒
                                                    {{ \Carbon\Carbon::parse($notification->data['time'])->format('g:i A') }}</span>
                                                <span class="mx-1">•</span>
                                                <span>👥 {{ $notification->data['number_of_people'] }} guests</span>
                                            </div>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="px-4 py-2 text-center">
                                <button onclick="markAllAsRead()"
                                    class="text-sm text-brand-orange hover:text-brand-dark font-medium">
                                    Mark all as read
                                </button>
                            </div>
                        @else
                            <div class="px-4 py-8 text-center text-gray-500">
                                <i data-lucide="bell-off" class="w-12 h-12 mx-auto mb-2 text-gray-300"></i>
                                <p class="text-sm">No new notifications</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center px-3 py-2 border border-gray-100 text-sm font-medium rounded-xl text-gray-600 bg-white hover:bg-gray-50 transition shadow-sm">
                        <div
                            class="w-8 h-8 rounded-full bg-orange-100 text-brand-orange flex items-center justify-center mr-2 font-bold uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        {{ Auth::user()->name }}
                        <i data-lucide="chevron-down" class="ms-2 w-4 h-4 transition-transform"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak
                        class="absolute right-0 mt-2 w-48 rounded-2xl shadow-2xl py-2 bg-white border border-gray-100 z-50">
                        <a href="{{ route('profile.show') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-brand-orange">
                            <i data-lucide="user" class="w-4 h-4"></i> Profile
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

   <main class="p-6 overflow-y-auto">
     <br>   
    


            <!-- Statistic Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-gray-500">Total Restaurants</h2>
                    <p class="text-3xl font-bold mt-2">{{$totalRestaurant}}</p>
                    
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-gray-500">Total Reservations</h2>
                    <p class="text-3xl font-bold mt-2">{{ $totalreservation  }}</p>
                    
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-gray-500">Orders</h2>
                    <p class="text-3xl font-bold mt-2">893</p>
                    <p class="text-red-500 text-sm mt-1">-3% this month</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-gray-500">Visitors</h2>
                    <p class="text-3xl font-bold mt-2">12,890</p>
                    <p class="text-green-500 text-sm mt-1">+21% this month</p>
                </div>

            </div>

            <!-- Chart Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Bar Chart -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Monthly Revenue</h2>
                    <canvas id="barChart"></canvas>
                </div>

                <!-- Line Chart -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4">User Growth</h2>
                    <canvas id="lineChart"></canvas>
                </div>

            </div>



        </main>

    <script>
        lucide.createIcons();

        // Mark a single notification as read
        function markAsRead(notificationId) {
            fetch(`/restaurateur/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to update notification count
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Mark all notifications as read
        function markAllAsRead() {
            fetch('/restaurateur/notifications/read-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to update notification count
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        const barCtx = document.getElementById('barChart');

    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue ($)',
                data: [12000, 19000, 15000, 22000, 18000, 25000],
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Line Chart
    const lineCtx = document.getElementById('lineChart');

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Users',
                data: [200, 400, 650, 800, 950, 1200],
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
        }
    });
    </script>

</body>

</html>