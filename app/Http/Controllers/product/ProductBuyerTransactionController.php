<?php

namespace App\Http\Controllers\product;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class ProductBuyerTransactionController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {

        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        if( $buyer->id == $product->seller_id){
            return $this->errorResponse("El comprador debe ser diferente al vendedor", 409);
        }

        if( !$buyer->esVerificado()){
            return $this->errorResponse("El comprador debe ser un usuario verificado", 409);
        }
        
        if( !$product->seller->esVerificado()){
            return $this->errorResponse("El vendedor debe ser un usuario verificado", 409);
        }

        if(!$product->estaDisponible()){
            return $this->errorResponse("El producto para esta transaccion no esta disponible", 409);
        }

        if($product->quantity < $request->quantity){
            return $this->errorResponse("El producto no tiene stock", 409);
        }

        return DB::transaction(function() use ($request, $product, $buyer){
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);
        });
    }

    
}
