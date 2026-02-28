@props(['headers' => []])

<div class="glass-effect rounded-2xl overflow-hidden border border-navy-800/50">
    @isset($title)
        <div class="px-6 py-4 border-b border-navy-800/50 bg-navy-900/30">
            <div class="flex items-center justify-between">
                <div>{{ $title }}</div>
                @isset($actions)
                    <div>{{ $actions }}</div>
                @endisset
            </div>
        </div>
    @endisset

    <div class="overflow-x-auto">
        <table class="w-full">
            @if(count($headers) > 0)
                <thead class="bg-navy-900/50 border-b border-navy-800/50 sticky top-0">
                    <tr>
                        @foreach($headers as $header)
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="divide-y divide-navy-800/30">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @isset($footer)
        <div class="px-6 py-4 border-t border-navy-800/50 bg-navy-900/30">
            {{ $footer }}
        </div>
    @endisset
</div>
