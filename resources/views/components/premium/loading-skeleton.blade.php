@props(['type' => 'card', 'count' => 3])

@if($type === 'card')
    <div class="space-y-4">
        @for($i = 0; $i < $count; $i++)
            <div class="glass-effect rounded-2xl p-6 border border-navy-800/50 animate-pulse">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-navy-700/50 rounded-xl"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-4 bg-navy-700/50 rounded w-3/4"></div>
                        <div class="h-3 bg-navy-700/50 rounded w-1/2"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@endif

@if($type === 'table')
    <div class="glass-effect rounded-2xl overflow-hidden border border-navy-800/50 animate-pulse">
        <div class="px-6 py-4 border-b border-navy-800/50 bg-navy-900/30">
            <div class="h-6 bg-navy-700/50 rounded w-1/4"></div>
        </div>
        <div class="p-6 space-y-4">
            @for($i = 0; $i < $count; $i++)
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-navy-700/50 rounded-full"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-4 bg-navy-700/50 rounded w-full"></div>
                        <div class="h-3 bg-navy-700/50 rounded w-2/3"></div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endif

@if($type === 'stat')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @for($i = 0; $i < $count; $i++)
            <div class="glass-effect rounded-2xl p-6 border border-navy-800/50 animate-pulse">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-navy-700/50 rounded-xl"></div>
                    <div class="h-6 bg-navy-700/50 rounded w-16"></div>
                </div>
                <div class="space-y-2">
                    <div class="h-8 bg-navy-700/50 rounded w-24"></div>
                    <div class="h-4 bg-navy-700/50 rounded w-32"></div>
                </div>
            </div>
        @endfor
    </div>
@endif
