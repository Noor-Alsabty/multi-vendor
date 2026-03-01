<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empty Basket - NOVA</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    
    <style>
        .font-cairo { font-family: 'Cairo', sans-serif; }
        .hover-grow { transition: transform 0.3s; }
        .hover-grow:hover { transform: scale(1.05); }
    </style>
</head>

<body class="bg-white font-cairo text-gray-800">

    <div class="min-h-screen flex flex-col items-center justify-center px-6">
        
        <div class="relative mb-8 text-gray-200">
            <svg class="w-40 h-40" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center pt-8">
                <span class="text-4xl">?</span>
            </div>
        </div>

        <h1 class="text-3xl font-black text-black mb-3 uppercase tracking-tighter">
            Your basket is empty
        </h1>
        <p class="text-gray-500 text-center max-w-sm mb-10 leading-relaxed">
            It looks like you haven't discovered our latest collections yet. 
            Don't worry, your perfect item is waiting for you!
        </p>

        <div class="flex flex-col sm:flex-row gap-4 w-full max-w-xs sm:max-w-md justify-center">
            <a href="{{ url('/') }}" 
            class="bg-black text-white text-center px-10 py-4 rounded-full font-bold uppercase text-xs tracking-widest hover-grow shadow-lg transition-all">
                Start Shopping
            </a>
            
            @guest
            <a href="{{ route('login') }}" 
            class="border-2 border-black text-black text-center px-10 py-4 rounded-full font-bold uppercase text-xs tracking-widest hover:bg-black hover:text-white transition-all">
                Sign In First
            </a>
            @endguest
        </div>

        <a href="{{ url('/') }}" class="mt-8 text-sm text-gray-400 hover:text-black transition-colors underline decoration-1 underline-offset-4">
            Back to Home
        </a>

    </div>

</body>
</html>