<x-filament::section>
    <div class="rounded-2xl border bg-white p-5 shadow-sm h-full flex flex-col">
        {{-- Header --}}
     <div class="flex items-center justify-between">
     <div class="flex items-center gap-3">
        <div class="h-10 w-10 rounded-xl" style="background: rgba(48,153,73,0.10);">
            <div class="h-full w-full flex items-center justify-center" style="color: rgb(48,153,73);">
                <x-heroicon-o-bolt class="h-5 w-5" />
            </div>
        </div>

         <div>
            <div class="text-base font-semibold text-gray-900">Quick Actions</div>
            <div class="text-xs text-gray-500">Create & manage items faster.</div>
         </div>
    </div>

    <a href="{{ \App\Filament\Resources\RequestResource::getUrl('index') }}"
       class="text-xs font-medium"
       style="color: rgb(48,153,73);">
        View all
    </a>
</div>



        {{-- Actions --}}
        <div class="mt-4 grid gap-3 flex-1 content-start">
            {{-- Create Request --}}
            <a class="rounded-xl border border-gray-200 px-4 py-3 transition hover:shadow-sm hover:border-gray-300"
               href="{{ \App\Filament\Resources\RequestResource::getUrl('create') }}">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl"
                          style="background: rgba(59,130,246,0.12); color: rgb(59,130,246);">
                        <x-heroicon-o-plus class="h-4 w-4" />
                    </span>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Create Request</div>
                        <div class="text-xs text-gray-500">Add a new maintenance request</div>
                    </div>
                </div>
            </a>

            {{-- Add Technician --}}
            <a class="rounded-xl border border-gray-200 px-4 py-3 transition hover:shadow-sm hover:border-gray-300"
               href="{{ \App\Filament\Resources\TechnicianDetailResource::getUrl('create') }}">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl"
                          style="background: rgba(168,85,247,0.12); color: rgb(168,85,247);">
                        <x-heroicon-o-user-plus class="h-4 w-4" />
                    </span>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Add Technician</div>
                        <div class="text-xs text-gray-500">Create technician profile</div>
                    </div>
                </div>
            </a>

            {{-- Add Service --}}
            <a class="rounded-xl border border-gray-200 px-4 py-3 transition hover:shadow-sm hover:border-gray-300"
               href="{{ \App\Filament\Resources\ServiceResource::getUrl('create') }}">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl"
                          style="background: rgba(48,153,73,0.12); color: rgb(48,153,73);">
                        <x-heroicon-o-wrench class="h-4 w-4" />
                    </span>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Add Service</div>
                        <div class="text-xs text-gray-500">Create a new service</div>
                    </div>
                </div>
            </a>

            {{-- Add Region --}}
            <a class="rounded-xl border border-gray-200 px-4 py-3 transition hover:shadow-sm hover:border-gray-300"
               href="{{ \App\Filament\Resources\RegionResource::getUrl('create') }}">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl"
                          style="background: rgba(245,158,11,0.14); color: rgb(245,158,11);">
                        <x-heroicon-o-map-pin class="h-4 w-4" />
                    </span>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Add Region</div>
                        <div class="text-xs text-gray-500">Create a new region</div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Tip --}}
        <div class="mt-4 rounded-xl p-4"
             style="background: linear-gradient(135deg, rgba(70,165,94,0.16), rgba(48,153,73,0.10), rgba(23,102,47,0.12));">
            <div class="text-sm font-semibold text-gray-900">Tip</div>
            <div class="mt-1 text-xs text-gray-600">
                Try assigning pending requests to available technicians in the same region.
            </div>
        </div>
    </div>
</x-filament::section>
