<x-guest-premium-layout>
    @section('title', 'Inscription')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Left Side - Registration Form -->
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" class="order-2 lg:order-1">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 -translate-x-10"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="glass-auth rounded-3xl p-8 lg:p-10 shadow-premium-lg max-w-xl mx-auto">

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
                    <h2 class="text-3xl font-bold text-white mb-2">Créer un compte</h2>
                    <p class="text-gray-400">Rejoignez la plateforme de gestion de sécurité</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                            Nom complet
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-user text-gray-500"></i>
                            </div>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus
                                   autocomplete="name"
                                   class="w-full pl-11 pr-4 py-3 bg-navy-900/50 border @error('name') border-red-500/50 @else border-navy-700/50 @enderror rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                   placeholder="Ex: Mohamed DIOP">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

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
                                   autocomplete="new-password"
                                   class="w-full pl-11 pr-12 py-3 bg-navy-900/50 border @error('password') border-red-500/50 @else border-navy-700/50 @enderror rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                   placeholder="Minimum 8 caractères">
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

                    <!-- Password Confirmation -->
                    <div x-data="{ showPasswordConfirm: false }">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-lock text-gray-500"></i>
                            </div>
                            <input :type="showPasswordConfirm ? 'text' : 'password'"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   class="w-full pl-11 pr-12 py-3 bg-navy-900/50 border border-navy-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                   placeholder="Confirmez votre mot de passe">
                            <button type="button"
                                    @click="showPasswordConfirm = !showPasswordConfirm"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-white transition-colors">
                                <i :class="showPasswordConfirm ? 'ph-bold ph-eye-slash' : 'ph-bold ph-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms"
                                   name="terms"
                                   type="checkbox"
                                   required
                                   class="w-4 h-4 rounded border-navy-700/50 bg-navy-900/50 text-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-offset-0 transition-all">
                        </div>
                        <label for="terms" class="ml-3 text-sm text-gray-400">
                            J'accepte les
                            <a href="#" class="text-primary-400 hover:text-primary-300 transition-colors">Conditions d'utilisation</a>
                            et la
                            <a href="#" class="text-primary-400 hover:text-primary-300 transition-colors">Politique de confidentialité</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-glow focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-navy-900">
                        <span class="flex items-center justify-center space-x-2">
                            <i class="ph-bold ph-user-plus"></i>
                            <span>Créer mon compte</span>
                        </span>
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-8 pt-6 border-t border-navy-700/50 text-center">
                    <p class="text-sm text-gray-400">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}"
                           class="text-primary-400 hover:text-primary-300 font-medium transition-colors">
                            Se connecter
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Benefits -->
        <div class="hidden lg:block space-y-8 order-1 lg:order-2" x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700 delay-100"
                 x-transition:enter-start="opacity-0 translate-x-10"
                 x-transition:enter-end="opacity-100 translate-x-0">

                <!-- Logo & Brand -->
                <div class="mb-12">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center transform -rotate-3 shadow-glow">
                            <i class="ph-bold ph-shield-check text-white text-4xl"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-white tracking-tight">
                                VIGILANCE<span class="text-primary-400">-COS</span>
                            </h1>
                            <p class="text-sm text-gray-400 uppercase tracking-wider mt-1">Rejoignez-nous</p>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-4">
                        Pourquoi choisir VIGILANCE-COS ?
                    </h3>
                    <p class="text-gray-300 leading-relaxed">
                        La solution complète pour gérer vos opérations de sécurité avec efficacité et professionnalisme.
                    </p>
                </div>

                <!-- Benefits List -->
                <div class="space-y-4">
                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gradient-to-br from-navy-800/40 to-navy-900/40 border border-primary-500/20 hover:border-primary-500/40 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-users-three text-primary-400 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Gestion des Agents</h4>
                            <p class="text-sm text-gray-400">Suivez et gérez votre personnel de sécurité en temps réel</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gradient-to-br from-navy-800/40 to-navy-900/40 border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-buildings text-emerald-400 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Multi-Sites</h4>
                            <p class="text-sm text-gray-400">Gérez plusieurs sites depuis une interface unique</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gradient-to-br from-navy-800/40 to-navy-900/40 border border-amber-500/20 hover:border-amber-500/40 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500/20 to-amber-600/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-calendar-check text-amber-400 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Planning Intelligent</h4>
                            <p class="text-sm text-gray-400">Planifiez et optimisez les rotations automatiquement</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gradient-to-br from-navy-800/40 to-navy-900/40 border border-red-500/20 hover:border-red-500/40 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500/20 to-red-600/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-warning-octagon text-red-400 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Alertes en Temps Réel</h4>
                            <p class="text-sm text-gray-400">Recevez et traitez les incidents instantanément</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gradient-to-br from-navy-800/40 to-navy-900/40 border border-purple-500/20 hover:border-purple-500/40 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-chart-line text-purple-400 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Rapports & Analytics</h4>
                            <p class="text-sm text-gray-400">Statistiques détaillées et tableaux de bord personnalisés</p>
                        </div>
                    </div>
                </div>

                <!-- Trust Indicators -->
                <div class="mt-12 pt-8 border-t border-navy-700/50">
                    <div class="grid grid-cols-3 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold text-primary-400 mb-1">99.9%</div>
                            <div class="text-xs text-gray-400">Uptime</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-emerald-400 mb-1">24/7</div>
                            <div class="text-xs text-gray-400">Support</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-amber-400 mb-1">SSL</div>
                            <div class="text-xs text-gray-400">Sécurisé</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-premium-layout>
