<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Livewire\WithFileUploads;

class TestSecond extends Controller
{
    use WithFileUploads;

    public $image;

    public function index()
    {
        return view('second-test');
    }

    public function save(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // adjust the validation rules as needed
        ]);

        // Get the file from the request
        $image = $request->file('image');

        // Display the file information
        dd($image);
    }
}
