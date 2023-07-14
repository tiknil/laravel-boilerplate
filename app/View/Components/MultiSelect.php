<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name = '',
        public array $options = [],
        public array $selected = [],
        public bool $required = false,
        public string $placeholder = '',
    ) {
    }

    public function render(): View
    {
        //dd($this->selected, $this->initialSelected());

        return view('components.multi-select');
    }

    public function initialSelected(): array|object
    {
        if (empty($this->selected)) {
            return new \stdClass();
        }

        return array_filter(
            $this->options,
            fn ($k) => in_array($k, $this->selected),
            ARRAY_FILTER_USE_KEY
        );
    }
}
