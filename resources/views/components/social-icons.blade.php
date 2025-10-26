@props(['wrapper' => 'ul', 'wrapperClass' => 'list-unstyled mb-0 social-icons'])
@php $items = config('site.social_icons', []); @endphp
@if ($wrapper)
    <{{ $wrapper }} class="{{ $wrapperClass }}">
        @foreach ($items as $item)
            <li>
                <a href="{{ $item['url'] }}" class="text-decoration-none" target="_blank" rel="noopener noreferrer">
                    <i class="{{ $item['icon_class'] }}"></i>
                </a>
            </li>
        @endforeach
    </{{ $wrapper }}>
@else
    @foreach ($items as $item)
        <li>
            <a href="{{ $item['url'] }}" class="text-decoration-none" target="_blank" rel="noopener noreferrer">
                <i class="{{ $item['icon_class'] }}"></i>
            </a>
        </li>
    @endforeach
@endif
