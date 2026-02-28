<x-guest-premium-layout>
    @section('title', 'Mot de passe oublié')

    <div class="max-w-md mx-auto" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="glass-auth rounded-3xl p-8 lg:p-10 shadow-premium-lg">

            <!-- Icon -->
            <div class="mb-8 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-primary-500/20 to-primary-700/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-primary-500/30">
                    <i class="ph-bold ph-lock-key text-primary-400 text-4xl"></i>
                </div>

                <h2 class="text-3xl font-bold text-white mb-2">Mot de passe oublié ?</h2>
                <p class="text-gray-400 text-sm">
                    Pas de problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-start space-x-3 animate-fade-in">
                    <i class="ph-bold ph-check-circle text-emerald-400 text-xl mt-0.5 flex-shrink-0"></i>
                    <p class="text-sm text-emerald-400">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-glow focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-navy-900">
                    <span class="flex items-center justify-center space-x-2">
                        <i class="ph-bold ph-paper-plane-tilt"></i>
                        <span>Envoyer le lien de réinitialisation</span>
                    </span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-8 pt-6 border-t border-navy-700/50 text-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center space-x-2 text-sm text-gray-400 hover:text-white transition-colors group">
                    <i class="ph ph-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    <span>Retour à la connexion</span>
                </a>
            </div>

            <!-- Security Info -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500 flex items-center justify-center">
                    <i class="ph ph-shield-check mr-1"></i>
                    Lien de réinitialisation sécurisé valable 60 minutes
                </p>
            </div>
        </div>
    </div>
</x-guest-premium-layout>
