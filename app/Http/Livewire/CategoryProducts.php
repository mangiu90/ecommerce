<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CategoryProducts extends Component
{
    public $category;
    public $products = [];

    public function loadProducts()
    {
        $this->products = $this->category->products()->publicado()->take(15)->get();

        $this->emit('glider', $this->category->id);
    }

    public function render()
    {
        return view('livewire.category-products');
    }
}
