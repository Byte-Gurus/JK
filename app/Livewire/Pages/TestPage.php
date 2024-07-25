<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestPage extends Component
{
    use WithFileUploads;
    #[Validate('image|max:1024')]
    public $photo;

    public function render()
    {
        return view('livewire.pages.test-page');
    }



    public function save()
    {


        $this->validate([
            'photo' => 'image|mimes:jpg,png', // 1MB Max
        ]);

        $this->photo->store('photos');
        dd($this->photo);
    }
}
