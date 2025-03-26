<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Menu;
use Livewire\Attributes\Layout;
use Livewire\Component;

class FavoritePage extends Component
{
    use CategoryFilterTrait;

    public $categories;
    public $selectedCategories = [];
    public $items;
    public $title = 'Favorite';

    public function mount(Menu $menus)
    {
        $this->categories = Category::all();
        $this->items = $menus->getFavoriteMenu();
    }

    #[Layout('components.layouts.page')]
    public function render()
    {
        $filteredProducts = $this->getFilteredItems();
        return view('product.favorite', [
            'filteredProducts' => $filteredProducts,
        ]);
    }
}
