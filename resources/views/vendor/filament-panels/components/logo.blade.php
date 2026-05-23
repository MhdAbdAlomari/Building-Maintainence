@php
    $logoPath = public_path('images/logo_app.png');
    $hasLogo  = file_exists($logoPath);
@endphp

<div class="flex items-center justify-center gap-3">
    @if ($hasLogo)
        <img
            src="{{ asset('images/logo_app.png') }}"
            alt="ShamFix"
            class="h-10 w-10 rounded-xl object-contain"
            style="background: rgba(48,153,73,0.10); padding: 4px;"
        />
    @else
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl"
              style="background: rgba(48,153,73,0.12); color: rgb(23,102,47);">
            <x-heroicon-o-wrench-screwdriver class="h-7 w-7" />
        </span>
    @endif

    <span class="text-2xl font-bold tracking-tight" style="color: rgb(23,102,47);">
        ShamFix
    </span>
</div>
