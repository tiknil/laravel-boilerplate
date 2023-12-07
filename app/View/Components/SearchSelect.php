<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchSelect extends Component
{
    public bool $multiple = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public array $options = [],
        public string|int|null $selected = null,
        public bool $required = false,
        public string $placeholder = '',
    ) {
    }

    public function render(): View
    {
        return view('components.multi-select');
    }
}
