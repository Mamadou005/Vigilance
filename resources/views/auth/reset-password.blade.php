<x-guest-premium-layout>
    @section('title', 'Réinitialiser le mot de passe')

    <div class="max-w-md mx-auto" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="glass-auth rounded-3xl p-10 lg:p-12">

            <!-- Icon -->
            <div class="mb-8 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                    <i class="ph-bold ph-lock-key-open text-white text-4xl"></i>
                </div>

                <h2 class="text-4xl font-black text-gray-900 mb-3">Nouveau mot de passe</h2>
                <p class="text-gray-600 text-lg">
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
                               value="{{ old('email', $request->email) }}"
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
                        Nouveau mot de passe
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

                <!-- Password Strength Indicator -->
                <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-100">
                    <p class="text-xs text-gray-700 mb-2 font-bold">Le mot de passe doit contenir :</p>
                    <ul class="space-y-1 text-xs text-gray-600">
                        <li class="flex items-center font-medium">
                            <i class="ph-bold ph-check text-emerald-500 mr-2 text-base"></i>
                            Au moins 8 caractères
                        </li>
                        <li class="flex items-center font-medium">
                            <i class="ph-bold ph-check text-emerald-500 mr-2 text-base"></i>
                            Une lettre majuscule et une minuscule
                        </li>
                        <li class="flex items-center font-medium">
                            <i class="ph-bold ph-check text-emerald-500 mr-2 text-base"></i>
                            Un chiffre
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full px-6 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold text-lg rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-xl hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-emerald-200">
                    <span class="flex items-center justify-center space-x-2">
                        <i class="ph-bold ph-check-circle text-xl"></i>
                        <span>Réinitialiser le mot de passe</span>
                    </span>
                </button>
            </form>

            <!-- Security Info -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500 flex items-center justify-center font-medium">
                    <i class="ph ph-shield-check mr-2"></i>
                    Connexion sécurisée SSL - Vos données sont protégées
                </p>
            </div>
        </div>
    </div>
</x-guest-premium-layout>
