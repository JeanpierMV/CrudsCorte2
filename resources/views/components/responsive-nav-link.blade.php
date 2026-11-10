@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-amber-500 text-start text-base font-semibold text-amber-800 bg-amber-50 focus:outline-none focus:text-amber-900 focus:bg-amber-100 focus:border-amber-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-amber-800 hover:bg-amber-50 hover:border-amber-300 focus:outline-none focus:text-amber-800 focus:bg-amber-50 focus:border-amber-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
