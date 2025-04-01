<?php

namespace App\Livewire\Components;

use Livewire\Component;

class MenuCard extends Component
{
    public $categories;
    public $matchedCategory;
    public $data;
    public bool $isGrid = true;

    public function mount()
    {   
        $this->matchedCategory = collect($this->categories)->firstWhere('id', $this->data->categories_id);
    }

    public function showDetails()
    {
        return $this->redirect('/menu/' . $this->data->id, navigate: true);
    }

    public function render()
    {
        return view('livewire.menu-card');
    }
}
