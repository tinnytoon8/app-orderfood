<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Menu;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AllMenuPage extends Component
{
    use CategoryFilterTrait;

    public $categories;
    public $selectedCategories = [];
    public $items;
    public $title = 'All Menus';

    public function mount(Menu $menus)
    {
        $this->categories = Category::all();
        $this->items = $menus->getAllMenus();
    }

    #[Layout('components.layouts.page')]

    public function render()
    {
        $filterdProducts = $this->getFilteredItems();

        return view('product.all-menu-page', [
            'filteredProducts' => $filterdProducts,
        ]);
    }
}
