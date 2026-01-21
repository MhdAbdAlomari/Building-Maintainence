<x-filament::section>
    <div class="rounded-2xl border bg-white shadow-sm h-full flex flex-col">
        {{-- Header --}}
        <div class="flex items-start justify-between p-5">
            <div>
                <div class="text-sm text-gray-500">Overview</div>


                <div class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ $requestsCount + $techniciansCount + $servicesCount + $regionsCount }}
                </div>

               <div class="mt-1 text-xs text-gray-500">Quick access to core modules.</div>

            </div>

            <div class="h-10 w-10 rounded-xl" style="background: rgba(48,153,73,0.10);">
                <div class="h-full w-full flex items-center justify-center" style="color: rgb(48,153,73);">
                    <x-heroicon-o-squares-2x2 class="h-5 w-5" />
                </div>
            </div>
        </div>

        {{-- Tiles wrapper --}}
        <div class="px-5">
            <div class="rounded-2xl border border-gray-100 p-3">
                <div class="grid gap-3 grid-cols-1 sm:grid-cols-2">
                    {{-- Requests --}}
                    <a href="{{ \App\Filament\Resources\RequestResource::getUrl('index') }}"
                       class="group rounded-2xl border border-gray-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                       style="background: rgba(59,130,246,0.10);">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl"
                                      style="background: rgba(59,130,246,0.14); color: rgb(59,130,246);">
                                    <x-heroicon-o-clipboard-document-list class="h-4 w-4" />
                                </span>

                                <div>
                                    <div class="text-sm font-medium text-gray-900">Requests</div>
                                    <div class="text-xs text-gray-500">Open list</div>
                                </div>
                            </div>

                            <div class="text-2xl font-semibold text-gray-900">{{ $requestsCount }}</div>
                        </div>
                    </a>

                    {{-- Technicians --}}
                    <a href="{{ \App\Filament\Resources\TechnicianDetailResource::getUrl('index') }}"
                       class="group rounded-2xl border border-gray-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                       style="background: rgba(168,85,247,0.10);">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl"
                                      style="background: rgba(168,85,247,0.14); color: rgb(168,85,247);">
                                    <x-heroicon-o-wrench-screwdriver class="h-4 w-4" />
                                </span>

                                <div>
                                    <div class="text-sm font-medium text-gray-900">Technicians</div>
                                    <div class="text-xs text-gray-500">Open list</div>
                                </div>
                            </div>

                            <div class="text-2xl font-semibold text-gray-900">{{ $techniciansCount }}</div>
                        </div>
                    </a>

                    {{-- Services --}}
                    <a href="{{ \App\Filament\Resources\ServiceResource::getUrl('index') }}"
                       class="group rounded-2xl border border-gray-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                       style="background: rgba(48,153,73,0.10);">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl"
                                      style="background: rgba(48,153,73,0.14); color: rgb(48,153,73);">
                                    <x-heroicon-o-wrench class="h-4 w-4" />
                                </span>

                                <div>
                                    <div class="text-sm font-medium text-gray-900">Services</div>
                                    <div class="text-xs text-gray-500">Open list</div>
                                </div>
                            </div>

                            <div class="text-2xl font-semibold text-gray-900">{{ $servicesCount }}</div>
                        </div>
                    </a>

                    {{-- Regions --}}
                    <a href="{{ \App\Filament\Resources\RegionResource::getUrl('index') }}"
                       class="group rounded-2xl border border-gray-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                       style="background: rgba(245,158,11,0.12);">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl"
                                      style="background: rgba(245,158,11,0.16); color: rgb(245,158,11);">
                                    <x-heroicon-o-map-pin />
                                </span>

                                <div>
                                    <div class="text-sm font-medium text-gray-900">Regions</div>
                                    <div class="text-xs text-gray-500">Open list</div>
                                </div>
                            </div>

                            <div class="text-2xl font-semibold text-gray-900">{{ $regionsCount }}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

      {{-- Insights (no duplication with Requests Overview) --}}
<div class="px-5 pb-5 mt-4">
    <div class="rounded-2xl border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="text-sm font-medium text-gray-900">Insights</div>
            <a href="{{ \App\Filament\Resources\RequestResource::getUrl('index') }}"
               class="text-xs font-medium"
               style="color: rgb(48,153,73);">
                See requests
            </a>
        </div>

      <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
    {{-- Most Requested Service (Blue) --}}
    <div class="rounded-xl border p-4"
         style="background: rgba(59,130,246,0.06); border-color: rgba(59,130,246,0.18);">
        <div class="text-xs text-gray-500">Most Requested Service</div>
        <div class="mt-1 text-sm font-semibold" style="color: rgb(59,130,246);">
            {{ $topServiceName ?? '—' }}
        </div>
        <div class="mt-1 text-xs text-gray-500">
            {{ $topServiceCount ?? 0 }} requests
        </div>
    </div>

    {{-- Most Active Region (Amber) --}}
    <div class="rounded-xl border p-4"
         style="background: rgba(245,158,11,0.07); border-color: rgba(245,158,11,0.22);">
        <div class="text-xs text-gray-500">Most Active Region</div>
        <div class="mt-1 text-sm font-semibold" style="color: rgb(245,158,11);">
            {{ $topRegionName ?? '—' }}
        </div>
        <div class="mt-1 text-xs text-gray-500">
            {{ $topRegionCount ?? 0 }} requests
        </div>
    </div>
</div>

    </div>
</div>

        
{{-- Payment Insights --}}
<div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
    {{-- Paid Requests (Green) --}}
    <div class="rounded-xl border p-4"
         style="background: rgba(48,153,73,0.06); border-color: rgba(48,153,73,0.18);">
        <div class="text-xs text-gray-500">Paid Requests</div>
        <div class="mt-1 text-2xl font-semibold" style="color: rgb(48,153,73);">
            {{ $paidCount ?? 0 }}
        </div>
        <div class="mt-1 text-xs text-gray-500">
            Completed & paid
        </div>
    </div>

    {{-- Unpaid Completed (Red) --}}
    <div class="rounded-xl border p-4"
         style="background: rgba(239,68,68,0.06); border-color: rgba(239,68,68,0.18);">
        <div class="text-xs text-gray-500">Unpaid Completed</div>
        <div class="mt-1 text-2xl font-semibold" style="color: rgb(239,68,68);">
            {{ $unpaidCompletedCount ?? 0 }}
        </div>
        <div class="mt-1 text-xs text-gray-500">
            Completed, waiting payment
        </div>
    </div>

    {{-- Total Revenue (Purple) --}}
    <div class="rounded-xl border p-4"
         style="background: rgba(168,85,247,0.06); border-color: rgba(168,85,247,0.18);">
        <div class="text-xs text-gray-500">Total Revenue (USD)</div>
        <div class="mt-1 text-2xl font-semibold" style="color: rgb(168,85,247);">
            ${{ number_format((float)($revenueUsd ?? 0), 2) }}
        </div>
        <div class="mt-1 text-xs text-gray-500">
            Sum of paid payments
        </div>
    </div>
</div>

    </div>
</x-filament::section>

