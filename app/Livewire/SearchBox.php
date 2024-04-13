<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBox extends Component
{   
    public $search = '';
    
    public function render()
    {
        return view('livewire.search-box');
    }

    public function updatedSearch(){
        $this->dispatch('search', search: $this->search);
    }
}
