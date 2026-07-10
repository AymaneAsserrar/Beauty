@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg shadow-sm']) }}>
