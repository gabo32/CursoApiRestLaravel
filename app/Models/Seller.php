<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends User
{
    use HasFactory;

    //construir e inicializa el modelo
    //inyectamos un global scope
    protected static function boot(){
    	parent::boot();

    	static::addGlobalScope(new SellerScope);
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }
}
