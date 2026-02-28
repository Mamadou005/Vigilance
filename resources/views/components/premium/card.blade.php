@props(['title' => null, 'icon' => null, 'gradient' => false])

<div {{ $attributes->merge(['class' => 'glass-effect rounded-2xl p-6 border border-navy-800/50 hover:border-navy-700/50 transition-all duration-200']) }}>
    @if($title || $icon)
        <div class="flex items-center justify-between mb-4 pb-4 border-b border-navy-800/50">
            <div class="flex items-center space-x-3">
                @if($icon)
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-xl flex items-center justify-center">
                        <i class="ph-bold {{ $icon }} text-primary-400 text-xl"></i>
                    </div>
                @endif
                @if($title)
                    <h3 class="text-lg font-bold text-white">{{ $title }}</h3>
                @endif
            </div>
            @isset($actions)
                <div>{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div>
        {{ $slot }}
    </div>
</div>
