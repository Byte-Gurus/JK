<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Test extends Component
{
    use WithFileUploads;
  
    public $image;
    public function render()
    {

        return view('livewire.test');
    }

    public function save()
    {
        dd($this->image);
    }
}
