@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'nav-item active'
                : 'nav-item';
@endphp

<li class="{{ $classes }}">
    <a class="nav-link" {{ $attributes }}>
        {{ $slot }}
    </a>
</li>

