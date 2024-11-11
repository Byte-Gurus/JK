<?php

namespace App\Livewire;

use App\Events\testEvent;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestPage extends Component
{
    use WithFileUploads;

    public $name;
    public $photo;

    public $selected = false;

    public function render()
    {


        event(new testEvent($this->name));
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
}
