@props(['icon' => 'ph-folder-open', 'title' => 'Aucune donnée', 'description' => '', 'action' => null, 'actionText' => 'Ajouter'])

<div class="text-center py-12">
    <div class="w-20 h-20 bg-navy-800/50 rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3">
        <i class="ph-bold {{ $icon }} text-gray-500 text-4xl"></i>
    </div>

    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>

    @if($description)
        <p class="text-gray-400 mb-6 max-w-md mx-auto">{{ $description }}</p>
    @endif

    @if($action)
        <a href="{{ $action }}"
           class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
            <i class="ph-bold ph-plus-circle"></i>
            <span>{{ $actionText }}</span>
        </a>
    @endif

    {{ $slot }}
</div>
