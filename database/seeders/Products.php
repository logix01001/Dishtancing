<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Product::create([
            'name' => 'Spaghetti',
            'qty' => 6,
        ]);

        Product::create([
            'name' => 'Lasagna supreme',
            'qty' => 8,
        ]);

    }
}
