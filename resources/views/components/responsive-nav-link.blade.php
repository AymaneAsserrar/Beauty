@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-ninich-rose text-start text-base font-medium text-ninich-rose-dark bg-ninich-blush-2 focus:outline-none focus:text-ninich-rose-dark focus:bg-ninich-blush-2 focus:border-ninich-rose-dark transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-ninich-muted hover:text-ninich-ink hover:bg-ninich-blush-2 hover:border-ninich-line focus:outline-none focus:text-ninich-ink focus:bg-ninich-blush-2 focus:border-ninich-line transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
