@php
    $name = auth()->user()->name ?? 'Admin';
    $hour = now()->hour;

    $greeting =
        $hour < 12 ? 'Good Morning' :
        ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
@endphp

<x-filament::section>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
           <div class="h-12 w-12 rounded-2xl flex items-center justify-center shadow-sm"
                 style="background: linear-gradient(135deg, rgba(70,165,94,0.22), rgba(48,153,73,0.16), rgba(23,102,47,0.20));">
           <div class="h-10 w-10 rounded-2xl flex items-center justify-center"
                 style="background: rgba(255,255,255,0.65); color: rgb(23,102,47);">
                    <x-heroicon-o-building-office-2 class="h-5 w-5" />
          </div>
</div>


            <div>
                <div class="text-xl font-semibold text-gray-900">
                    Hello {{ $name }}, {{ $greeting }} 👋
                </div>
                <div class="mt-1 text-sm text-gray-500">
                    Here’s what’s happening with Building Maintenance today.
                </div>
            </div>
        </div>

        <div class="text-sm text-gray-500">
            {{ now()->format('l, d M Y') }}
        </div>
    </div>
</x-filament::section>
