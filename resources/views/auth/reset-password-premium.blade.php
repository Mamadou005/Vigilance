<x-guest-premium-layout>
    @section('title', 'Réinitialiser le mot de passe')

    <div class="max-w-md mx-auto" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="glass-auth rounded-3xl p-8 lg:p-10 shadow-premium-lg">

            <!-- Icon -->
            <div class="mb-8 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-emerald-500/20 to-emerald-700/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-emerald-500/30">
                    <i class="ph-bold ph-lock-key-open text-emerald-400 text-4xl"></i>
                </div>

                <h2 class="text-3xl font-bold text-white mb-2">Nouveau mot de passe</h2>
                <p class="text-gray-400 text-sm">
                    Choisissez un nouveau mot de passe sécurisé pour votre compte
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                               value="{{ old('email', $request->email) }}"
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
                        Nouveau mot de passe
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

                <!-- Password Strength Indicator -->
                <div class="bg-navy-800/30 rounded-xl p-4 border border-navy-700/50">
                    <p class="text-xs text-gray-400 mb-2 font-medium">Le mot de passe doit contenir :</p>
                    <ul class="space-y-1 text-xs text-gray-500">
                        <li class="flex items-center">
                            <i class="ph-bold ph-check text-emerald-400 mr-2"></i>
                            Au moins 8 caractères
                        </li>
                        <li class="flex items-center">
                            <i class="ph-bold ph-check text-emerald-400 mr-2"></i>
                            Une lettre majuscule et une minuscule
                        </li>
                        <li class="flex items-center">
                            <i class="ph-bold ph-check text-emerald-400 mr-2"></i>
                            Un chiffre
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-navy-900">
                    <span class="flex items-center justify-center space-x-2">
                        <i class="ph-bold ph-check-circle"></i>
                        <span>Réinitialiser le mot de passe</span>
                    </span>
                </button>
            </form>

            <!-- Security Info -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500 flex items-center justify-center">
                    <i class="ph ph-shield-check mr-1"></i>
                    Connexion sécurisée SSL - Vos données sont protégées
                </p>
            </div>
        </div>
    </div>
</x-guest-premium-layout>
