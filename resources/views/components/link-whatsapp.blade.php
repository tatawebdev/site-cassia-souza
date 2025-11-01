@props([
    // optional values; defaults read from config/site.php when available
    'phone' => null,
    'text' => null,
    'label' => null,
    'target' => '_blank',
])

@php
    // label fallback from config
    $labelDefault = config('site.whatsapp') ?: ($label ?? null);
    // If a full link exists in config, use it. Otherwise build a web.whatsapp.com URL from phone or config
    $configLink = config('site.whatsapp_link');
    if ($configLink) {
        $href = $configLink;
    } else {
        $phoneToUse = $phone ?? preg_replace('/[^0-9]/', '', config('site.whatsapp') ?? '');
        $defaultText = "Olá, Cassia Souza Advogacia!\n\nTenho interesse em seus serviços advocatícios ⚖️";
        $textToUse = $text ?? $defaultText;
        $href = 'https://web.whatsapp.com/send/?phone=' . $phoneToUse . '&text=' . urlencode($textToUse);
    }
@endphp

<a {{ $attributes->merge(['href' => $href, 'target' => $target]) }}>
    {{-- se houver slot, usa ele; senão label; senão exibe o telefone vindo do config --}}
    @if (! $slot->isEmpty())
        {!! $slot !!}
    @else
        {{ $label ?? $labelDefault ?? '' }}
    @endif
</a>
