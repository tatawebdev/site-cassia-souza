@props([
    'phone' => '5511915201084',
    'text' => null,
    'label' => null,
    'target' => '_blank',
])

@php
    $defaultText = "Olá, Cassia Souza Advogacia!\n\nTenho interesse em seus serviços advocatícios ⚖️";
    $textToUse = $text ?? $defaultText;
    $href = 'https://web.whatsapp.com/send/?phone=' . $phone . '&text=' . urlencode($textToUse);
@endphp

<a {{ $attributes->merge(['href' => $href, 'target' => $target]) }}>
    {{-- se houver slot, usa ele; senão label; senão exibe o telefone --}}
    {!! $slot->isEmpty() ? e($label ?? $phone) : $slot !!}
</a>
