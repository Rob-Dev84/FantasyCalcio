{{-- @props(['value']) --}}

<span {{ $attributes->merge(['class' => 'py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md']) }}>
    {{ $value ?? $slot }}
</span>
