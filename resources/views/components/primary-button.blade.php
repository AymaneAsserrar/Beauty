<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-ninich-rose border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-ninich-rose-dark focus:bg-ninich-rose-dark active:bg-ninich-rose-dark focus:outline-none focus:ring-2 focus:ring-ninich-rose focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
