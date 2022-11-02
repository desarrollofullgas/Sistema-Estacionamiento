<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PassReset extends Component
{
    public $open = false;
    
    public function render()
    {
        return view('livewire.pass-reset');
    }
}
