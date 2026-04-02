<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@php
    $viteReady = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'));
@endphp
@if ($viteReady)
@vite(['resources/css/app.css', 'resources/js/app.js'])
@elseif (app()->environment('local'))
<style>
    .vite-build-banner{background:#fef3c7;border-bottom:1px solid #f59e0b;color:#78350f;padding:.65rem 1rem;font-size:.8125rem;text-align:center;font-family:system-ui,sans-serif}
    .vite-build-banner code{background:#fff;padding:.1rem .35rem;border-radius:4px}
</style>
<div class="vite-build-banner" role="status">
    <strong>Assets front-end não compilados.</strong>
    No diretório do projeto (de preferência dentro do Sail): <code>./sail npm install</code> e <code>./sail npm run build</code>
    — ou, em desenvolvimento, <code>./sail npm run dev</code>.
</div>
@else
@php
    abort(503, 'Frontend assets not built. Run: npm install && npm run build');
@endphp
@endif
@fluxAppearance
