<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItem extends Component
{
    public $product, $quantity;

    public $qty = 1;

    public function mount()
    {
        $this->quantity = $this->product->quantity;
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }

    public function increment()
    {
        $this->qty += 1;
    }

    public function decrement()
    {
        $this->qty -= 1;
    }
}
