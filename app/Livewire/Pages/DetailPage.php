<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DetailPage extends Component
{
    public $categories;
    public $mathedCategory;
    public $menu;
    public $title = 'Favorite';

    public function mount(Menu $menus, $id)
    {
        $this->categories = Category::all();

        $this->menu = $menus->getMenuDetails($id)->first();

        if(empty($this->menu)){
            abort(404);
        }

        $this->mathedCategory = collect($this->categories)->firstWhere('id', $this->menu->categories_id);

    }

    public function addToCart()
    {
        $cartItems = session('cart_items', []);

        $existingItemIndex = collect($cartItems)->search(fn($item) => $item['id'] === $this->menu->id);

        if($existingItemIndex !== false){
            $cartItems[$existingItemIndex]['quantity'] += 1;
        }else{
            $cartItems[] = array_merge(
                (array)$this->menu,
                [
                    'quantity' => 1,
                    'selected' => true,
                ]
            );
        }

        session(['cart_items' => $cartItems]);
        session(['has_unpaid_transaction' => false]);

        $this->dispatch('toast',
            data: [
                'message1' => 'Item added to cart',
                'message2' => $this->menu->name,
                'type' => 'success',
            ]
        );
    }

    public function orderNow()
    {
        $this->addToCart();
        return Redirect()->route('payment.checkout');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('product.detail-page');
    }
}
