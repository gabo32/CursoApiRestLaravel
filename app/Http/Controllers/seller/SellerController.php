<?php

namespace App\Http\Controllers\seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //los usuarios que tengan al menos una transaccion
        //$vendedores = Seller::has('products')->get();
        $vendedores = Seller::all();

        return $this->showAll($vendedores);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        return $this->showOne($seller);      
    }


}
