<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = [
        'pivot'
    ];

    /**
    * relaciones
    * pertenece a muchos
    */
    public function products(){
        return $this->belongsToMany(Product::class);
    }

}
