<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

    	//borrar la base de datos
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    	DB::table('users')->delete();
    	DB::table('categories')->delete();
    	DB::table('products')->delete();
    	DB::table('transactions')->delete();
    	DB::table('category_product')->delete();;
    	DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        //desactivar eventos para evitar mandar miles de correos
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();


        \App\Models\User::factory(1000)->create();
        \App\Models\Category::factory(30)->create();
        \App\Models\Product::factory(1000)->create()->each(
        	function($product){
        		$categorias = Category::all()->random(mt_rand(1,5))->pluck('id');

        		$product->categories()->attach($categorias);
        	}
        );
        \App\Models\Transaction::factory(1000)->create();
    }
}
