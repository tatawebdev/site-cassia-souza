@props([
    'title' => 'Cássia Souza Advocacia Tributária',
    'description' => 'Advocacia tributária para empresas: planejamento tributário, recuperação de PIS/COFINS, regularização de débitos na PGFN e assessoria para a Reforma Tributária.',
    // Imagem ao compartilhar o link (WhatsApp, LinkedIn etc.)
    'image' => '/assets/img/sobrenos.png',
])

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="Cássia Souza Advocacia">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ url($image) }}">
    <meta name="twitter:card" content="summary_large_image">
    {{-- Monograma "SC" do logo (gerado a partir de assets/favicon original) --}}
    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" type="image/png" href="/assets/favicon.png" sizes="192x192">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#590854">
    <link rel="preload" href="/assets/images/monograma-sc.png" as="image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,500;6..72,600&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/novo.css')
</head>

<body>
    @include('partials.preloader')

    {{ $slot }}

    @include('novo.partials.footer')

    @include('novo.partials.modal-saida')

    <x-link-whatsapp rel="nofollow" title="Conversar no WhatsApp" aria-label="Conversar no WhatsApp"
        class="fixed bottom-6 right-6 z-50 grid h-14 w-14 place-items-center rounded-full bg-[#25d366] text-[28px] text-white shadow-[0_12px_28px_-8px_rgba(0,0,0,0.45)] transition hover:scale-105">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
    </x-link-whatsapp>

    <script src="/assets/js/preloader.js?v={{ filemtime(public_path('assets/js/preloader.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Livewire 3: dispatch('swal', payload) dos formulários de contato e newsletter
        window.addEventListener('swal', event => {
            let detail = event.detail;
            if (Array.isArray(detail) && detail.length) detail = detail[0];
            detail = detail || {};

            Swal.fire({
                icon: detail.type || 'success',
                title: detail.title || '',
                text: detail.text || '',
                showConfirmButton: detail.showConfirmButton !== false,
                timer: detail.timer || undefined,
                confirmButtonColor: '#590854',
            });
        });
    </script>
</body>

</html>
