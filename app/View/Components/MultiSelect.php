<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MultiSelect extends Component
{
    public string $name;

    public bool $multiple = true;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        public array $options = [],
        public ?array $selected = null,
        public bool $required = false,
        public string $placeholder = '',
    ) {
        $this->name = Str::endsWith($name, '[]') ? $name : "{$name}[]";
    }

    public function render(): View
    {
        return view('components.multi-select');
    }
}
