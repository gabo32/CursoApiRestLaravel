<?php

namespace App\Http\Controllers\buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     * es una relacion muchos a muchos
     * no hay manera directa
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        //transactio no es una colleccion
        //$products = $buyer ->transactions->products;

        //llamamos al querybuilder de transactions
        //eager loadding
        //lista de transacciones con cada uno de sus productos
        $products = $buyer->transactions()->with('product')
            ->get()
            ->pluck('product');//indcamos que solo nos interesa products


        //return lista de productos que ha comprado un comprador
        //pasando por transactions
        return $this->showAll($products);
    }
}
