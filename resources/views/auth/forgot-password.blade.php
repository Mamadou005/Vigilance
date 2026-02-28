<x-guest-premium-layout>
    @section('title', 'Mot de passe oublié')

    <div class="max-w-md mx-auto" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="glass-auth rounded-3xl p-10 lg:p-12">

            <!-- Icon -->
            <div class="mb-8 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                    <i class="ph-bold ph-lock-key text-white text-4xl"></i>
                </div>

                <h2 class="text-4xl font-black text-gray-900 mb-3">Mot de passe oublié ?</h2>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Pas de problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 px-5 py-4 rounded-xl bg-emerald-50 border-2 border-emerald-200 flex items-start space-x-3">
                    <i class="ph-bold ph-check-circle text-emerald-600 text-2xl mt-0.5 flex-shrink-0"></i>
                    <p class="text-sm text-emerald-700 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-xl hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-blue-200">
                    <span class="flex items-center justify-center space-x-2">
                        <i class="ph-bold ph-paper-plane-tilt text-xl"></i>
                        <span>Envoyer le lien de réinitialisation</span>
                    </span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-8 pt-6 border-t-2 border-gray-200 text-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors group font-medium">
                    <i class="ph ph-arrow-left group-hover:-translate-x-1 transition-transform text-lg"></i>
                    <span>Retour à la connexion</span>
                </a>
            </div>

            <!-- Security Info -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500 flex items-center justify-center font-medium">
                    <i class="ph ph-shield-check mr-2"></i>
                    Lien de réinitialisation sécurisé valable 60 minutes
                </p>
            </div>
        </div>
    </div>
</x-guest-premium-layout>
