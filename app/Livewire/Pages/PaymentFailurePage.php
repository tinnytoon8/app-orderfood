<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PaymentFailurePage extends Component
{
    #[Layout('components.layouts.page')]
    public function render()
    {
        return view('payment.payment-failure-page');
    }
}
