<?php

namespace App\Models;

use App\Models\Seller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    public $transformer = ProductTransformer::class;
    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    protected $hidden = [
        'pivot'
    ];


    /**
    * Valida si el producto esta disponible o no
    */
    public function estaDisponible(){
    	return $this->status == Product::PRODUCTO_DISPONIBLE;
    }

    /**
    * productos a categoria
    */
    public function categories(){
        //pertenece a 
        return $this->belongsToMany(Category::class);
    }

    /**
    * relacion con sellet
    */
    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    /**
    * relacion con transacciones
    */
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
