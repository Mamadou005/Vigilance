@props(['type' => 'primary', 'size' => 'md', 'icon' => null, 'iconPosition' => 'left'])

@php
    $typeClasses = match($type) {
        'primary' => 'bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white shadow-lg hover:shadow-glow',
        'danger' => 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white shadow-lg',
        'success' => 'bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white shadow-lg',
        'secondary' => 'bg-navy-800/50 hover:bg-navy-700/50 border border-navy-700/50 text-gray-300 hover:text-white',
        'outline' => 'bg-transparent hover:bg-navy-800/30 border border-navy-700 text-gray-300 hover:text-white',
        'ghost' => 'bg-transparent hover:bg-navy-800/30 text-gray-300 hover:text-white',
        default => 'bg-navy-800 hover:bg-navy-700 text-white',
    };

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg',
        default => 'px-4 py-2.5 text-sm',
    };
@endphp

<button {{ $attributes->merge(['class' => "inline-flex items-center justify-center space-x-2 font-medium rounded-xl transition-all duration-200 transform hover:scale-105 $typeClasses $sizeClasses"]) }}>
    @if($icon && $iconPosition === 'left')
        <i class="ph-bold {{ $icon }}"></i>
    @endif

    <span>{{ $slot }}</span>

    @if($icon && $iconPosition === 'right')
        <i class="ph-bold {{ $icon }}"></i>
    @endif
</button>
