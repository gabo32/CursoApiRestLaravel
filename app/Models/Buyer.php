<?php

namespace App\Models;

use App\Models\User;
use App\Scopes\BuyerScope;
use App\Models\Transaction;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
    use HasFactory;
    public $transformer = BuyerTransformer::class;

    //construir e inicializa el modelo
    //inyectamos un global scope
    protected static function boot(){
    	parent::boot();

    	static::addGlobalScope(new BuyerScope);
    }

    /**
    * relacion transacciones
    */
    public function transactions(){
    	return $this->hasMany(Transaction::class);
    }
}
