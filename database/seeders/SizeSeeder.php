<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Builder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)->where('size', true);
        })->get();

        $sizes = ['S', 'M', 'L'];

        foreach ($products as $product) {

            foreach ($sizes as $size) {
                $product->sizes()->create([
                    'name' => $size
                ]);
            }
        }
    }
}
