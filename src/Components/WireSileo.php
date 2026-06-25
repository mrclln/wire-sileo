<?php

declare(strict_types=1);

namespace Sileo\Components;

use Livewire\Component;

class WireSileo extends Component
{
    public string $position = 'top-right';

    public function mount(string $position = null): void
    {
        $this->position = $position ?? config('wire-sileo.position', 'top-right');
    }

    public function render()
    {
        return view('wire-sileo::wire-sileo');
    }
}
