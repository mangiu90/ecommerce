<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class UpdateCartItem extends Component
{
    public $rowId, $qty, $quantity;
    
    public function mount()
    {
        $item = Cart::get($this->rowId);

        $this->qty = $item->qty;

        $this->quantity = qty_available($item->id);
    }

    public function render()
    {
        return view('livewire.update-cart-item');
    }

    public function increment()
    {
        $this->qty += 1;

        Cart::update($this->rowId, $this->qty);

        $this->emitTo('dropdown-cart', 'render');
        $this->emitTo('shopping-cart', 'render');
    }

    public function decrement()
    {
        $this->qty -= 1;

        Cart::update($this->rowId, $this->qty);

        $this->emitTo('dropdown-cart', 'render');
        $this->emitTo('shopping-cart', 'render');
    }
}
