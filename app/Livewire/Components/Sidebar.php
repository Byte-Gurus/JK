<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Sidebar extends Component
{

    public $selected;
    public function render()
    {
        return view('livewire.components.sidebar');
    }

    public function ss()
    {
        $this->selected = !$this->selected;
    }
}
