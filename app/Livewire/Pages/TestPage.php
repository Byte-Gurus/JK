<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;

class TestPage extends Component
{
    use WithFileUploads;


    public $photo;

    public function render()
    {
        return view('livewire.pages.test-page');
    }



    public function save()
    {
        dd($this->photo);

        $this->validate([
            'photo' => 'image|mimes:jpg,png', // 1MB Max
        ]);

        $this->photo->store('photos');

    }
    public function hi($SS)
    {
        dd($SS);
    }
}
