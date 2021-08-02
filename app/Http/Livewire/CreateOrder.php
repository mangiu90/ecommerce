<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Province;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CreateOrder extends Component
{
    public $envio_type = 1;

    public $contact, $phone, $address, $references;

    public $shipping_cost = 0;

    public $countries, $provinces = [], $cities = [];

    public $country_id, $province_id, $city_id;

    public $rules = [
        'contact' => 'required',
        'phone' => 'required',
        'envio_type' => 'required',
    ];

    public function mount()
    {
        $this->countries = Country::all();   

        $this->country_id = ""; 
        $this->province_id = ""; 
        $this->city_id = "";
    }

    public function render()
    {
        return view('livewire.create-order');
    }

    public function create_order()
    {
        $rules = $this->rules;
        if ($this->envio_type == 2) {
            $rules['country_id'] = 'required';
            $rules['province_id'] = 'required';
            $rules['city_id'] = 'required';
            $rules['address'] = 'required';
            $rules['references'] = 'required';
        }

        $this->validate($rules);

        $order = new Order();

        $order->user_id = auth()->user()->id;
        $order->contact = $this->contact;
        $order->phone = $this->phone;
        $order->envio_type = $this->envio_type;
        $order->shipping_cost = 0;
        $order->total = $this->shipping_cost + str_replace(',', '', Cart::subtotal());
        $order->content = Cart::content();

        if ($this->envio_type == 2) {
            $order->shipping_cost = $this->shipping_cost;
            $order->city_id = $this->city_id;
            $order->address = $this->address;
            $order->references = $this->references;
        }

        $order->save();

        foreach (Cart::content() as $item) {
            discount($item);
        }

        Cart::destroy();

        return redirect()->route('orders.payment', $order);
    }

    public function updatedEnvioType($value)
    {
        if ($value == 1) {
            $this->resetValidation([
                'country_id', 
                'province_id', 
                'city_id', 
                'address',
                'references'
            ]);
        }
    }

    public function updatedCountryId($value)
    {
        $this->province_id = "";
        $this->city_id = "";
        $this->provinces = Province::where('country_id', $value)->get();
    }

    public function updatedProvinceId($value)
    {
        $this->city_id = "";
        $this->cities = City::where('province_id', $value)->get();
    }

    public function updatedCityId($value)
    {
        $city = City::find($value);

        $this->shipping_cost = $city->cost;
    }
}
