@props([
    'label' => null,
    'error' => null,
    'type' => 'text',
    'icon' => null,
    'required' => false,
    'placeholder' => ''
])

<div>
    @if($label)
        <label {{ $attributes->only('for') }} class="block text-sm font-medium text-gray-400 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-400">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="ph {{ $icon }} text-gray-500"></i>
            </div>
        @endif

        <input
            type="{{ $type }}"
            {{ $attributes->merge([
                'class' => 'w-full ' . ($icon ? 'pl-10' : 'pl-4') . ' pr-4 py-2.5 bg-navy-900/50 border ' . ($error ? 'border-red-500/50' : 'border-navy-700/50') . ' rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all'
            ]) }}
            placeholder="{{ $placeholder }}"
        >
    </div>

    @if($error)
        <p class="mt-2 text-sm text-red-400 flex items-center">
            <i class="ph-bold ph-warning-circle mr-1"></i>
            {{ $error }}
        </p>
    @endif
</div>
