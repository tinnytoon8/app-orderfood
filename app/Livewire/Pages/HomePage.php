<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Menu;
use Livewire\Attributes\Layout;
use Livewire\Component;

class HomePage extends Component
{
    public $promos;
    public $favorites;
    public $categories;

    public $tableNumber;
    public $name;
    public $phone;

    public $term = '';

    public bool $isCustomerDataComplete = true;

    public function mount(Menu $menus)
    {
        $this->categories = Category::all();
        $this->promos = $menus->getPromo();
        $this->favorites = $menus->getfavoriteMenu();
        $this->tableNumber = session('table_number');

        $name = session('name');
        $phone = session('phone');

        if($name && $phone){
            $this->isCustomerDataComplete = false;
        }
    }

    public function saveUserInfo()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        session(['name' => $this->name, 'phone' => $this->phone]);
        $this->name = session('name');
    }

    #[Layout('components.layouts.page')]
    public function render(Menu $menus)
    {
        sleep(1);
        $searchResult = $menus->search(trim($this->term))->get();

        return view('home-page', [
            'searchResult' => $searchResult,
        ]);
    }
}
