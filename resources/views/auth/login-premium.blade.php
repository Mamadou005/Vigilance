<x-guest-premium-layout>
    @section('title', 'Connexion')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Left Side - Branding & Info -->
        <div class="hidden lg:block space-y-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 -translate-x-10"
                 x-transition:enter-end="opacity-100 translate-x-0">

                <!-- Logo & Brand -->
                <div class="mb-12">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center transform rotate-3 shadow-glow">
                            <i class="ph-bold ph-shield-check text-white text-4xl"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-white tracking-tight">
                                VIGILANCE<span class="text-primary-400">-COS</span>
                            </h1>
                            <p class="text-sm text-gray-400 uppercase tracking-wider mt-1">Système de Gestion de Sécurité</p>
                        </div>
                    </div>

                    <p class="text-lg text-gray-300 leading-relaxed">
                        Plateforme professionnelle de supervision et de gestion des opérations de sécurité 24h/24.
                    </p>
                </div>

                <!-- Features -->
                <div class="space-y-4">
                    <div class="flex items-start space-x-4 p-4 rounded-2xl bg-navy-800/30 border border-navy-700/50 hover:border-primary-500/30 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-shield-checkered text-emerald-400 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold mb-1">Sécurité Renforcée</h3>
                            <p class="text-sm text-gray-400">Authentification sécurisée et chiffrement des données</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-4 rounded-2xl bg-navy-800/30 border border-navy-700/50 hover:border-primary-500/30 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-clock text-blue-400 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold mb-1">Disponible 24/7</h3>
                            <p class="text-sm text-gray-400">Surveillance et gestion continues des opérations</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-4 rounded-2xl bg-navy-800/30 border border-navy-700/50 hover:border-primary-500/30 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-users-three text-purple-400 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold mb-1">Gestion Centralisée</h3>
                            <p class="text-sm text-gray-400">Agents, sites, alertes et planning en un seul endroit</p>
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
                 class="glass-auth rounded-3xl p-8 lg:p-10 shadow-premium-lg">

                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-glow">
                        <i class="ph-bold ph-shield-check text-white text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white">
                        VIGILANCE<span class="text-primary-400">-COS</span>
                    </h1>
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Bon retour !</h2>
                    <p class="text-gray-400">Connectez-vous à votre espace superviseur</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-start space-x-3 animate-fade-in">
                        <i class="ph-bold ph-check-circle text-emerald-400 text-xl mt-0.5"></i>
                        <p class="text-sm text-emerald-400 flex-1">{{ session('status') }}</p>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-start space-x-3 animate-fade-in">
                        <i class="ph-bold ph-check-circle text-emerald-400 text-xl mt-0.5"></i>
                        <p class="text-sm text-emerald-400 flex-1">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Adresse email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-envelope text-gray-500"></i>
                            </div>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username"
                                   class="w-full pl-11 pr-4 py-3 bg-navy-900/50 border @error('email') border-red-500/50 @else border-navy-700/50 @enderror rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                   placeholder="votre.email@example.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-lock text-gray-500"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   class="w-full pl-11 pr-12 py-3 bg-navy-900/50 border @error('password') border-red-500/50 @else border-navy-700/50 @enderror rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                   placeholder="••••••••">
                            <button type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-white transition-colors">
                                <i :class="showPassword ? 'ph-bold ph-eye-slash' : 'ph-bold ph-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
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
                                   class="w-4 h-4 rounded border-navy-700/50 bg-navy-900/50 text-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-offset-0 transition-all">
                            <span class="ml-2 text-sm text-gray-400 group-hover:text-gray-300 transition-colors">Se souvenir de moi</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm text-primary-400 hover:text-primary-300 transition-colors font-medium">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-glow focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-navy-900">
                        <span class="flex items-center justify-center space-x-2">
                            <i class="ph-bold ph-sign-in"></i>
                            <span>Se connecter</span>
                        </span>
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-8 pt-6 border-t border-navy-700/50 text-center">
                    <p class="text-sm text-gray-400">
                        Vous n'avez pas de compte ?
                        <a href="{{ route('register') }}"
                           class="text-primary-400 hover:text-primary-300 font-medium transition-colors">
                            Créer un compte
                        </a>
                    </p>
                </div>

                <!-- Footer Info -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        <i class="ph ph-shield-checkered mr-1"></i>
                        Connexion sécurisée par chiffrement SSL
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-premium-layout>
