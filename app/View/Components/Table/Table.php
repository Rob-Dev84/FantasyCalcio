<?php

namespace App\View\Components\Table;

use App\Support\TextAlignment;
use Illuminate\View\Component;

class Table extends Component
{

    public array $headers;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $headers)
    {
        // dd($this->formatHeaders ($headers));
        $this->headers = $this->formatHeaders ($headers);
    }

    private function formatHeaders(array $headers): array
    {
        // dd($headers);
        return array_map(function ($header) {

            $name = is_array($header) ? $header['name'] : $header;

            return [
                'name' => $name,
                'classes' => $this->textAlignClasses($header['class'] ?? 'text-left'),
            ];

        }, $headers);
    }

    // private function textAlignClasses($class): string
    // {
        
    //     return [
    //         'text-left' => 'text-left',
    //         'text-center' => 'text-center',
    //         'text-right' => 'text-right',
    //         ][$class] ?? 'text-left';
    // }

    private function textAlignClasses($align): string
    {
        
        return (new TextAlignment($align))->className();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.table');
    }
}
