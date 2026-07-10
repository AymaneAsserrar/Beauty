@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-ninich-rose text-sm font-semibold leading-5 text-ninich-ink focus:outline-none focus:border-ninich-rose-dark transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-ninich-muted hover:text-ninich-ink hover:border-ninich-line focus:outline-none focus:text-ninich-ink focus:border-ninich-line transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
