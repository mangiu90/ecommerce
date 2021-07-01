<x-app-layout>
    <div class="container py-8">
        <ul>
            @forelse ($products as $product)
                <x-product-list :product="$product"></x-product-list>
            @empty
                <div class="p-4">
                    <p class="text-lg text-gray-700 font-semibold shadow-2xl">Ningún producto coincide con la búsqueda</p>
                </div>
            @endforelse
        </ul>

        <div class="mt-4">
            {{ $products->appends([ 'name' => $name ])->links() }}
        </div>
    </div>
</x-app-layout>