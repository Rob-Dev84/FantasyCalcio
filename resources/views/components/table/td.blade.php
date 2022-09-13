@props([
    'class' => 'text-left',
    ])

@php

    $textAlignClass = (new App\Support\TextAlignment())->className();

    // $textAlignClass = [
    //     'text-left' => 'text-left',
    //     'text-center' => 'text-center',
    //     'text-right' => 'text-right',
    //     ][$class] ?? 'text-left';


    $flexAlignClass = [
        'flex' => 'flex',
        'flex justify-center' => 'flex justify-center',
        ][$class] ?? '';    
@endphp

<td class="px-6 py-3 {{ $textAlignClass }} {{ $flexAlignClass }}">
    {{ $slot }} 
</td>