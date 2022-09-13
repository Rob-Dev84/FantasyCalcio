<?php

namespace App\Support;

class TextAlignment 
{

    private string $align;

    public function __construct(string $align = 'left')
    {
        $this->align = $align;
    }

    public function className(): string
    {
        return [
            'text-left' => 'text-left',
            'text-center' => 'text-center',
            'text-right' => 'text-right',
            ][$this->align] ?? 'text-left';
    }

    
}