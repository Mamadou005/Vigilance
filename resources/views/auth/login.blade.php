<x-guest-premium-layout>
    @section('title', 'Connexion')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left Side - Branding & Info -->
        <div class="hidden lg:block space-y-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 -translate-x-10"
                 x-transition:enter-end="opacity-100 translate-x-0">

                <!-- Logo & Brand -->
                <div class="mb-12">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-3xl flex items-center justify-center transform rotate-3 shadow-xl">
                            <i class="ph-bold ph-shield-check text-white text-5xl"></i>
                        </div>
                        <div>
                            <h1 class="text-5xl font-black text-gray-900 tracking-tight">
                                VIGILANCE<span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">-COS</span>
                            </h1>
                            <p class="text-sm text-gray-600 font-medium uppercase tracking-wider mt-2">Système de Gestion de Sécurité</p>
                        </div>
                    </div>

                    <p class="text-xl text-gray-700 leading-relaxed font-medium">
                        Plateforme professionnelle de supervision et de gestion des opérations de sécurité 24h/24.
                    </p>
                </div>

                <!-- Features -->
                <div class="space-y-4">
                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-white/80 border-2 border-emerald-200 hover:border-emerald-400 hover:shadow-lg transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <i class="ph-bold ph-shield-checkered text-white text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 font-bold text-lg mb-1">Sécurité Renforcée</h3>
                            <p class="text-gray-600">Authentification sécurisée et chiffrement des données</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-white/80 border-2 border-blue-200 hover:border-blue-400 hover:shadow-lg transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <i class="ph-bold ph-clock text-white text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 font-bold text-lg mb-1">Disponible 24/7</h3>
                            <p class="text-gray-600">Surveillance et gestion continues des opérations</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-white/80 border-2 border-purple-200 hover:border-purple-400 hover:shadow-lg transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <i class="ph-bold ph-users-three text-white text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 font-bold text-lg mb-1">Gestion Centralisée</h3>
                            <p class="text-gray-600">Agents, sites, alertes et planning en un seul endroit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700 delay-100"
                 x-transition:enter-start="opacity-0 translate-x-10"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="glass-auth rounded-3xl p-10 lg:p-12">

                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                        <i class="ph-bold ph-shield-check text-white text-4xl"></i>
                    </div>
                    <h1 class="text-3xl font-black text-gray-900">
                        VIGILANCE<span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">-COS</span>
                    </h1>
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-4xl font-black text-gray-900 mb-3">Bon retour !</h2>
                    <p class="text-gray-600 text-lg">Connectez-vous à votre espace superviseur</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 px-5 py-4 rounded-xl bg-emerald-50 border-2 border-emerald-200 flex items-start space-x-3">
                        <i class="ph-bold ph-check-circle text-emerald-600 text-2xl mt-0.5"></i>
                        <p class="text-sm text-emerald-700 font-medium flex-1">{{ session('status') }}</p>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 px-5 py-4 rounded-xl bg-emerald-50 border-2 border-emerald-200 flex items-start space-x-3">
                        <i class="ph-bold ph-check-circle text-emerald-600 text-2xl mt-0.5"></i>
                        <p class="text-sm text-emerald-700 font-medium flex-1">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-2">
                            Adresse email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-envelope text-gray-400 text-xl"></i>
                            </div>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username"
                                   class="w-full pl-12 pr-4 py-4 bg-white border-2 @error('email') border-red-400 @else border-gray-300 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium"
                                   placeholder="votre.email@example.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-bold text-gray-900 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-lock text-gray-400 text-xl"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   class="w-full pl-12 pr-14 py-4 bg-white border-2 @error('password') border-red-400 @else border-gray-300 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium"
                                   placeholder="••••••••">
                            <button type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-900 transition-colors">
                                <i :class="showPassword ? 'ph-bold ph-eye-slash' : 'ph-bold ph-eye'" class="text-xl"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox"
                                   name="remember"
                                   class="w-5 h-5 rounded-lg border-2 border-gray-300 bg-white text-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                            <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">Se souvenir de moi</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm text-blue-600 hover:text-blue-800 transition-colors font-bold">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-xl hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-blue-200">
                        <span class="flex items-center justify-center space-x-2">
                            <i class="ph-bold ph-sign-in text-xl"></i>
                            <span>Se connecter</span>
                        </span>
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-8 pt-6 border-t-2 border-gray-200 text-center">
                    <p class="text-gray-600 font-medium">
                        Vous n'avez pas de compte ?
                        <a href="{{ route('register') }}"
                           class="text-blue-600 hover:text-blue-800 font-bold transition-colors">
                            Créer un compte
                        </a>
                    </p>
                </div>

                <!-- Footer Info -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500 flex items-center justify-center font-medium">
                        <i class="ph ph-shield-checkered mr-2"></i>
                        Connexion sécurisée par chiffrement SSL
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-premium-layout>
