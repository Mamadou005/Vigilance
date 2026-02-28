@props(['type' => 'default', 'icon' => null])

@php
    $classes = match($type) {
        'success' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
        'danger' => 'bg-red-500/10 text-red-400 border-red-500/20',
        'warning' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
        'info' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
        'primary' => 'bg-primary-500/10 text-primary-400 border-primary-500/20',
        'inactive' => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
        default => 'bg-navy-800/50 text-gray-300 border-navy-700/50',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center space-x-1 px-3 py-1 rounded-lg text-xs font-semibold border $classes"]) }}>
    @if($icon)
        <i class="ph-bold {{ $icon }}"></i>
    @endif
    <span>{{ $slot }}</span>
</span>
