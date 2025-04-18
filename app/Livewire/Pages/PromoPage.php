<?php

namespace App\Livewire\Pages;

use App\Livewire\Traits\CategoryFilterTrait;
use App\Models\Category;
use App\Models\Menu;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PromoPage extends Component
{
    use CategoryFilterTrait;

    public $categories;
    public $selectedCategories = [];
    public $items;
    public $title = 'Promo';

    public function mount(Menu $menus)
    {
        $this->categories = Category::all();
        $this->items = $menus->getPromo();
    }

    #[Layout('components.layouts.page')]
    public function render()
    {
        $filterProducts = $this->getFilteredItems();
        return view('products.promo', [
            'filteredProducts' => $filterProducts,
        ]);
    }
}
