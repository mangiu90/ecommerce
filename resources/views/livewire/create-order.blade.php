<div class="container py-8 grid grid-cols-5 gap-6">
    <div class="col-span-3">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-4">
                <x-jet-label value="Nombre de contacto"></x-jet-label>

                <x-jet-input wire:model.defer="contact" type="text" class="w-full" placeholder="Ingrese el nombre de la persona que recibira el producto"></x-jet-input>

                <x-jet-input-error for="contact"></x-jet-input-error>
            </div>

            <div>
                <x-jet-label value="Teléfono de contacto"></x-jet-label>

                <x-jet-input wire:model.defer="phone" type="text" class="w-full" placeholder="Ingrese un número de teléfono de contacto"></x-jet-input>

                <x-jet-input-error for="phone"></x-jet-input-error>
            </div>
        </div>

        <div x-data="{ envio_type : @entangle('envio_type') }">
            <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Envíos</p>

            <label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4">
                <input x-model="envio_type" type="radio" value="1" name="envio_type" class="text-gray-600">

                <span class="ml-2 text-gray-700">
                    Recojo en tienda (Calle Falsa 123)
                </span>

                <span class="font-semibold text-gray-700 ml-auto">
                    Gratis
                </span>
            </label>

            <div class="bg-white rounded-lg shadow">
                <label class="px-6 py-4 flex items-center mb-4">
                    <input x-model="envio_type" type="radio"  value="2" name="envio_type" class="text-gray-600">

                    <span class="ml-2 text-gray-700">
                        Envío a domicilio
                    </span>
                </label>

                <div class="px-6 pb-6 grid grid-cols-2 gap-6 hidden" :class="{ 'hidden': envio_type != 2 }">
                    <div>
                        <x-jet-label value="Pais"></x-jet-label>

                        <select wire:model="country_id" class="form-control w-full">
                            <option value="" disabled selected>Seleccionar pais</option>

                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>

                        <x-jet-input-error for="country_id"></x-jet-input-error>
                    </div>

                    <div>
                        <x-jet-label value="Provincia"></x-jet-label>

                        <select wire:model="province_id" class="form-control w-full">
                            <option value="" disabled selected>Seleccionar provincia</option>

                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>

                        <x-jet-input-error for="province_id"></x-jet-input-error>
                    </div>

                    <div>
                        <x-jet-label value="Ciudad"></x-jet-label>

                        <select wire:model="city_id" class="form-control w-full">
                            <option value="" disabled selected>Seleccionar ciudad</option>

                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>

                        <x-jet-input-error for="city_id"></x-jet-input-error>
                    </div>

                    <div>
                        <x-jet-label value="Dirección"></x-jet-label>

                        <x-jet-input wire:model="address" type="text" class="w-full"></x-jet-input>

                        <x-jet-input-error for="address"></x-jet-input-error>
                    </div>

                    <div class="col-span-2">
                        <x-jet-label value="Referencias"></x-jet-label>

                        <x-jet-input wire:model="references" type="text" class="w-full"></x-jet-input>

                        <x-jet-input-error for="references"></x-jet-input-error>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <x-jet-button wire:loading.attr="disabled" wire:target="create_order" wire:click="create_order" class="mt-6 mb-4">
                Continuar con la compra
            </x-jet-button>

            <hr>

            <p class="text-sm text-gray-700 mt-2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloribus dolorem officia aperiam. Architecto, voluptate quidem non hic corrupti ipsam soluta, vitae atque asperiores, quod ea alias. Animi voluptatum corrupti id. <a href="" class="font-semibold text-orange-700">Políticas y Privacidad</a></p>
        </div>
    </div>

    <div class="col-span-2">
        <div  class="bg-white rounded-lg shadow p-6">
            <ul>
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-gray-200 border-b">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
    
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
    
                            <div class="flex">
                                <p class="mr-1">Cant: {{ $item->qty }} </p>
    
                                @isset($item->options['color'])
                                    <p class="mr-1">Color: {{ __($item->options['color']) }}</p>
                                @endisset
    
                                @isset($item->options['size'])
                                    <p>Talle: {{ $item->options['size'] }}</p>
                                @endisset
                            </div>
    
                            <p>USD: {{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-center text-gray-700">
                            No tiene agregado ningun producto en el carrito
                        </p>
                    </li>
                @endforelse
            </ul>

            <hr class="mt-4 mb-3">

            <div class="text-gray-700">
                <p class="flex justify-between items-center">
                    Subtotal
                    <span class="font-semibold">{{ Cart::subtotal() }} USD</span>
                </p>

                <p class="flex justify-between items-center">
                    Envío
                    <span class="font-semibold">
                        @if ($envio_type == 1 || $shipping_cost == 0)
                            Gratis
                        @else
                            {{ $shipping_cost }} USD
                        @endif
                    </span>
                </p>

                <hr class="mt-4 mb-3">

                <p class="flex justify-between items-center">
                    <span class="text-lg">Total</span>
                        @if ($envio_type == 1)
                            {{ Cart::subtotal() }} USD
                        @else
                            {{ Cart::subtotal() + $shipping_cost }} USD
                        @endif
                </p>
            </div>
        </div>
    </div>
</div>