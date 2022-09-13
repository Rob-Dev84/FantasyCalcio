
<span {{ $attributes->merge(['class' => 'ml-4 w-9 h-8 flex justify-center items-center uppercase text-xs text-white font-semibold tracking-widest rounded-md']) }}>
    {{ $value ?? $slot }}
</span>
