<?php

namespace App\Livewire\Pages;

use App\Livewire\Traits\CartManagement;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;
use Illuminate\Support\Str;

class CheckoutPage extends Component
{
    use CartManagement;

    public $name;
    public $phone;
    #[Session(key: 'table_number')]
    public $tableNumber;
    #[Session(key: 'tax')]
    public $tax;
    #[Session(key: 'has_unpaid_transaction')]
    public $hasUnpaidTransaction;
    #[Session(key: 'cart_items')]
    public $cartItems = [];

    public $title = 'All Menus';

    public $grandtotal;
    public $subtotal;

    public $paymentToken;

    #[On('saved-user-info')]
    public function mount()
    {
        $this->name = session('name');
        $this->phone = session('phone');
        if(empty($this->cartItems)){
            return redirect()->route('product.cart');
        }

        $this->paymentToken = Str::random(32);
        session(['payment_token' => $this->paymentToken]);

        $this->updateTotals();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('payment.checkout-page');
    }
}
