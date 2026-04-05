<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ChamaHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient {
            background: radial-gradient(circle at top right, #fff1f2, #ffffff);
        }
    </style>
</head>
<body class="hero-gradient min-h-screen">

    <nav class="max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="bg-rose-500 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
            <span class="font-bold text-2xl tracking-tighter text-slate-800 uppercase">ChamaHub</span>
        </div>
        <div class="flex items-center gap-6">
            <a href="login.php" class="font-bold text-slate-600 hover:text-rose-500 transition">Login</a>
            <a href="register.php" class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold shadow-xl hover:bg-rose-600 transition">Join Us</a>
        </div>
    </nav>

    <header class="max-w-7xl mx-auto px-6 pt-16 pb-24 grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8">
            <div class="inline-block bg-rose-100 text-rose-600 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest">
                Empowering Women Together
            </div>
            <h1 class="text-6xl lg:text-7xl font-black text-slate-900 leading-[1.1]">
                Grow Your <span class="text-rose-500">Savings</span> as a Community.
            </h1>
            <p class="text-xl text-slate-500 leading-relaxed max-w-lg">
                A secure, transparent, and easy way for our Chama to track contributions, achieve financial goals, and support each other.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="register.php" class="bg-rose-500 text-white px-10 py-5 rounded-[2rem] font-bold text-lg shadow-2xl shadow-rose-200 hover:bg-rose-600 transition text-center">
                    Get Started Now
                </a>
                <div class="flex items-center gap-4 px-6">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-white"></div>
                        <div class="w-10 h-10 rounded-full bg-slate-300 border-2 border-white"></div>
                        <div class="w-10 h-10 rounded-full bg-rose-200 border-2 border-white"></div>
                    </div>
                    <p class="text-sm font-bold text-slate-400">+50 Members Joined</p>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-0 bg-rose-200 blur-[120px] opacity-30 rounded-full"></div>
            <div class="relative bg-white p-4 rounded-[3rem] shadow-2xl rotate-3 border border-rose-50">
                <img src="https://img.freepik.com/free-vector/diverse-women-holding-hands-concept-illustration_114360-15965.jpg" 
                     alt="Women Empowerment" 
                     class="rounded-[2.5rem] w-full h-auto grayscale-[20%] hover:grayscale-0 transition duration-700">
            </div>
            
            <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-3xl shadow-xl border border-slate-100 animate-bounce transition duration-1000">
                <div class="flex items-center gap-4">
                    <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Latest Saving</p>
                        <p class="font-black text-slate-800">Ksh 2,500.00</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-slate-100">
        <div class="grid md:grid-cols-3 gap-12 text-center">
            <div>
                <h4 class="font-bold text-slate-800 text-lg mb-2">Secure Tracking</h4>
                <p class="text-sm text-slate-500">Every shilling is recorded with a receipt for total transparency.</p>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-lg mb-2">Unique Member IDs</h4>
                <p class="text-sm text-slate-500">Each woman gets a unique number for private dashboard access.</p>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-lg mb-2">Community Impact</h4>
                <p class="text-sm text-slate-500">Watch the total pot grow as everyone contributes their part.</p>
            </div>
        </div>
    </section>

</body>
</html>