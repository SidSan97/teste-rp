<?php

namespace Database\Seeders;

use App\Utils\GenerateSkuUtility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('products')->whereIn('email', ['admin@email.com', 'operador@email.com', 'comum@email.com'])->delete();

        DB::table('products')->insert([
            [
                'name'       => 'Produto 1',
                'description' => 'Descrição do produto 1',
                'quantity'    => '10',
                'price'   => 10.00,
                'category' => 'Categoria 1',
                'sku' => GenerateSkuUtility::generateSKU(),
                'created_at' => now(),
            ],
            [
                'name'       => 'Produto 2',
                'description' => 'Descrição do produto 2',
                'quantity'    => '30',
                'price'   => 24.99,
                'category' => 'Categoria 2',
                'sku' => GenerateSkuUtility::generateSKU(),
                'created_at' => now(),
            ],
        ]);
    }
}
