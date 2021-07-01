<?php

namespace App\Http\Livewire;

use App\Models\Size;
use Livewire\Component;

class AddCartItemSize extends Component
{
    public $product, $sizes;

    public $size_id = '';
    public $color_id = '';
    public $colors = [];
    public $qty = 1;
    public $quantity = 0;

    public function mount()
    {
        $this->sizes = $this->product->sizes;
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }

    public function updatedSizeId($value)
    {
        $this->color_id = '';

        $this->quantity = 0;

        $size = Size::find($value);

        $this->colors = $size->colors;
    }

    public function updatedColorId($value)
    {
        $size = Size::find($this->size_id);

        $this->quantity = $size->colors->find($value)->pivot->quantity;
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
