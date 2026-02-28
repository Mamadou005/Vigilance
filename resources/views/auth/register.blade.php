<x-guest-premium-layout>
    @section('title', 'Inscription')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left Side - Registration Form -->
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" class="order-2 lg:order-1">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 -translate-x-10"
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
                    <h2 class="text-4xl font-black text-gray-900 mb-3">Créer un compte</h2>
                    <p class="text-gray-600 text-lg">Rejoignez la plateforme de gestion de sécurité</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-900 mb-2">
                            Nom complet
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-user text-gray-400 text-xl"></i>
                            </div>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus
                                   autocomplete="name"
                                   class="w-full pl-12 pr-4 py-4 bg-white border-2 @error('name') border-red-400 @else border-gray-300 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium"
                                   placeholder="Ex: Mohamed DIOP">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

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
                                   autocomplete="new-password"
                                   class="w-full pl-12 pr-14 py-4 bg-white border-2 @error('password') border-red-400 @else border-gray-300 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium"
                                   placeholder="Minimum 8 caractères">
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

                    <!-- Password Confirmation -->
                    <div x-data="{ showPasswordConfirm: false }">
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-900 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-lock text-gray-400 text-xl"></i>
                            </div>
                            <input :type="showPasswordConfirm ? 'text' : 'password'"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   class="w-full pl-12 pr-14 py-4 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium"
                                   placeholder="Confirmez votre mot de passe">
                            <button type="button"
                                    @click="showPasswordConfirm = !showPasswordConfirm"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-900 transition-colors">
                                <i :class="showPasswordConfirm ? 'ph-bold ph-eye-slash' : 'ph-bold ph-eye'" class="text-xl"></i>
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
                                   class="w-5 h-5 rounded-lg border-2 border-gray-300 bg-white text-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                        </div>
                        <label for="terms" class="ml-3 text-sm text-gray-700 font-medium">
                            J'accepte les
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">Conditions d'utilisation</a>
                            et la
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">Politique de confidentialité</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-xl hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-blue-200">
                        <span class="flex items-center justify-center space-x-2">
                            <i class="ph-bold ph-user-plus text-xl"></i>
                            <span>Créer mon compte</span>
                        </span>
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-8 pt-6 border-t-2 border-gray-200 text-center">
                    <p class="text-gray-600 font-medium">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}"
                           class="text-blue-600 hover:text-blue-800 font-bold transition-colors">
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
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-3xl flex items-center justify-center transform rotate-3 shadow-xl">
                            <i class="ph-bold ph-shield-check text-white text-5xl"></i>
                        </div>
                        <div>
                            <h1 class="text-5xl font-black text-gray-900 tracking-tight">
                                VIGILANCE<span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">-COS</span>
                            </h1>
                            <p class="text-sm text-gray-600 font-medium uppercase tracking-wider mt-2">Rejoignez-nous</p>
                        </div>
                    </div>

                    <h3 class="text-3xl font-black text-gray-900 mb-4">
                        Pourquoi choisir VIGILANCE-COS ?
                    </h3>
                    <p class="text-xl text-gray-700 leading-relaxed font-medium">
                        La solution complète pour gérer vos opérations de sécurité avec efficacité et professionnalisme.
                    </p>
                </div>

                <!-- Benefits List -->
                <div class="space-y-4">
                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-white/80 border-2 border-blue-200 hover:border-blue-400 hover:shadow-lg transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <i class="ph-bold ph-users-three text-white text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-gray-900 font-bold text-lg mb-1">Gestion des Agents</h4>
                            <p class="text-gray-600">Suivez et gérez votre personnel de sécurité en temps réel</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-white/80 border-2 border-emerald-200 hover:border-emerald-400 hover:shadow-lg transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <i class="ph-bold ph-buildings text-white text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-gray-900 font-bold text-lg mb-1">Multi-Sites</h4>
                            <p class="text-gray-600">Gérez plusieurs sites depuis une interface unique</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-white/80 border-2 border-amber-200 hover:border-amber-400 hover:shadow-lg transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <i class="ph-bold ph-calendar-check text-white text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-gray-900 font-bold text-lg mb-1">Planning Intelligent</h4>
                            <p class="text-gray-600">Planifiez et optimisez les rotations automatiquement</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-white/80 border-2 border-red-200 hover:border-red-400 hover:shadow-lg transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <i class="ph-bold ph-warning-octagon text-white text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-gray-900 font-bold text-lg mb-1">Alertes en Temps Réel</h4>
                            <p class="text-gray-600">Recevez et traitez les incidents instantanément</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-white/80 border-2 border-purple-200 hover:border-purple-400 hover:shadow-lg transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <i class="ph-bold ph-chart-line text-white text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-gray-900 font-bold text-lg mb-1">Rapports & Analytics</h4>
                            <p class="text-gray-600">Statistiques détaillées et tableaux de bord personnalisés</p>
                        </div>
                    </div>
                </div>

                <!-- Trust Indicators -->
                <div class="mt-12 pt-8 border-t-2 border-gray-200">
                    <div class="grid grid-cols-3 gap-6 text-center">
                        <div>
                            <div class="text-4xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">99.9%</div>
                            <div class="text-sm text-gray-600 font-bold">Uptime</div>
                        </div>
                        <div>
                            <div class="text-4xl font-black bg-gradient-to-r from-emerald-500 to-emerald-600 bg-clip-text text-transparent mb-2">24/7</div>
                            <div class="text-sm text-gray-600 font-bold">Support</div>
                        </div>
                        <div>
                            <div class="text-4xl font-black bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent mb-2">SSL</div>
                            <div class="text-sm text-gray-600 font-bold">Sécurisé</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-premium-layout>
