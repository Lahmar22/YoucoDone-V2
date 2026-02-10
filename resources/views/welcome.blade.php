<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YoucoDone | Culinary Excellence</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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
              light: '#f8f5f2'
            }
          }
        }
      }
    }
  </script>

  <style>
    /* Custom Utilities */
    .text-shadow {
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
  </style>
</head>
<body class="font-sans bg-brand-light text-gray-800 antialiased">

  <nav class="fixed w-full z-50 top-0 transition-all duration-300 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <h1 class="font-serif text-2xl font-bold tracking-wide text-brand-dark">
        Youco<span class="text-orange-600">Done</span>
      </h1>
      <ul class="flex space-x-8 font-medium text-sm uppercase tracking-widest text-gray-600">
        <li><a href="{{ route('login') }}" class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal">
                Log in
            </a>
        </li>
        <li><a href="{{ route('register') }}" class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal">
                Register
            </a>
        </li>
        
    </div>
  </nav>

  <section id="home" class="relative h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
      <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Fine Dining" class="w-full h-full object-cover transform scale-105 hover:scale-100 transition duration-[20s]">
      <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-brand-dark/90"></div>
    </div>

    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto mt-16">
      <span class="block text-orange-400 font-serif italic text-xl mb-4 animate-pulse">Welcome to YoucoDone</span>
      <h2 class="font-serif text-5xl md:text-7xl font-bold text-white mb-6 leading-tight text-shadow">
        Where Flavor Meets <br /> Perfection
      </h2>
      <p class="text-lg md:text-xl text-gray-200 mb-10 font-light max-w-2xl mx-auto">
        Experience a symphony of tastes crafted with passion, precision, and the finest organic ingredients.
      </p>
      
    </div>
  </section>

  
  <section id="about" class="py-24 bg-white relative">
    <div class="container mx-auto px-6">
      <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="md:w-1/2 relative">
           <div class="absolute -top-4 -left-4 w-full h-full border-2 border-orange-200 rounded-3xl z-0"></div>
           <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Chef Cooking" class="relative z-10 rounded-3xl shadow-2xl w-full object-cover">
        </div>
        
        <div class="md:w-1/2">
          <h3 class="text-orange-600 font-bold uppercase tracking-widest mb-2 text-sm">Our Story</h3>
          <h2 class="font-serif text-4xl font-bold text-brand-dark mb-6">Crafting Memories at YoucoDone</h2>
          <p class="text-gray-600 text-lg leading-relaxed mb-6">
            At <strong>YoucoDone</strong>, we believe dining is more than just eating—it's an emotion. Founded in 2026, our mission is to bring the world's finest flavors to your plate.
          </p>
          <p class="text-gray-600 text-lg leading-relaxed mb-8">
            Our chefs meticulously select locally sourced ingredients to create dishes that are not only visually stunning but also nutritionally balanced. Come, join our family.
          </p>
          <div class="flex items-center space-x-4">
             <div class="text-center">
                <span class="block text-3xl font-serif font-bold text-brand-dark">15+</span>
                <span class="text-xs text-gray-500 uppercase">Years Exp.</span>
             </div>
             <div class="w-px h-10 bg-gray-300"></div>
             <div class="text-center">
                <span class="block text-3xl font-serif font-bold text-brand-dark">20k+</span>
                <span class="text-xs text-gray-500 uppercase">Happy Clients</span>
             </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-brand-dark text-white py-12 border-t border-gray-800">
    <div class="container mx-auto px-6">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-6 md:mb-0 text-center md:text-left">
          <h2 class="font-serif text-2xl font-bold">Youco<span class="text-orange-600">Done</span></h2>
          <p class="text-gray-400 text-sm mt-2">Premium dining experience.</p>
        </div>
        
        <div class="flex space-x-6 mb-6 md:mb-0">
          <a href="#" class="text-gray-400 hover:text-white transition">Instagram</a>
          <a href="#" class="text-gray-400 hover:text-white transition">Twitter</a>
          <a href="#" class="text-gray-400 hover:text-white transition">Facebook</a>
        </div>
      </div>
      
      <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500 text-sm">
        &copy; 2026 YoucoDone Restaurant. All rights reserved.
      </div>
    </div>
  </footer>

</body>
</html>