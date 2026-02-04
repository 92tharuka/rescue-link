<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In | RescueLink Command</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Grid Background */
        .bg-grid {
            background-size: 50px 50px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }

        /* Floating Blobs Animation */
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(10deg); }
            66% { transform: translate(-20px, 20px) rotate(-5deg); }
        }
        .animate-blob { animation: float 10s infinite ease-in-out; }

        /* CRITICAL: Fix for messy text boxes (Autofill override) */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0f172a inset !important; /* Matches slate-900 */
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
            caret-color: white;
        }

        /* Entry Animation */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-enter { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="bg-slate-950 text-white antialiased overflow-hidden selection:bg-red-500 selection:text-white h-screen w-screen relative">

    <div class="absolute inset-0 z-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950"></div>
        <div class="absolute inset-0 bg-grid opacity-30"></div>
        
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-red-600/20 rounded-full blur-[100px] animate-blob"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] animate-blob" style="animation-delay: 2s"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-center animate-enter">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-red-600 to-red-800 shadow-[0_0_30px_rgba(220,38,38,0.5)] mb-4 text-white ring-1 ring-white/20">
                <i class='bx bxs-shield-plus text-4xl'></i>
            </div>
            <div>
                <span class="text-3xl font-black text-white tracking-tight">RESCUE<span class="text-red-500">LINK</span></span>
            </div>
            <p class="text-slate-400 text-[10px] font-bold tracking-[0.3em] uppercase mt-2 border-t border-slate-800 pt-2 inline-block">National Command Center</p>
        </div>

        <div class="w-full max-w-md bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-2xl shadow-black/50 animate-enter" style="animation-delay: 0.1s">
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white">Officer Login</h2>
                <p class="text-sm text-slate-400 mt-1">Enter your credentials to access the grid.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Official Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class='bx bxs-user text-slate-500 group-focus-within:text-red-500 transition-colors duration-300 text-xl'></i>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            class="block w-full pl-12 pr-4 py-4 bg-slate-950/50 border border-slate-700 rounded-xl text-white placeholder:text-slate-600 focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all duration-300 outline-none shadow-inner" 
                            placeholder="officer@rescue.gov">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Secure Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class='bx bxs-lock-alt text-slate-500 group-focus-within:text-red-500 transition-colors duration-300 text-xl'></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full pl-12 pr-4 py-4 bg-slate-950/50 border border-slate-700 rounded-xl text-white placeholder:text-slate-600 focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all duration-300 outline-none shadow-inner" 
                            placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center group cursor-pointer select-none">
                        <input id="remember_me" type="checkbox" name="remember" 
                            class="rounded border-slate-700 bg-slate-800 text-red-600 shadow-sm focus:ring-red-500/50 focus:ring-offset-slate-900 cursor-pointer">
                        <span class="ml-2 text-sm text-slate-400 group-hover:text-white transition-colors">Remember device</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-slate-500 hover:text-red-400 transition-colors" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button type="submit" 
                    class="group w-full relative flex justify-center items-center gap-2 py-4 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-orange-500 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-[0_0_20px_rgba(220,38,38,0.3)] hover:shadow-[0_0_30px_rgba(220,38,38,0.6)]">
                    <span>AUTHENTICATE</span>
                    <i class='bx bx-right-arrow-alt text-xl group-hover:translate-x-1 transition-transform'></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <a href="/" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-white transition-colors">
                    <i class='bx bx-arrow-back'></i>
                    Return to Public Portal
                </a>
            </div>
        </div>

        <div class="mt-8 flex flex-col items-center gap-2 animate-enter" style="animation-delay: 0.2s">
            <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-[10px] uppercase tracking-widest font-bold">
                <i class='bx bxs-lock'></i> 256-bit SSL Secured
            </div>
            <p class="text-slate-600 text-xs text-center">
                &copy; {{ date('Y') }} RescueLink Command System. Authorized Personnel Only.
            </p>
        </div>
    </div>

</body>
</html>