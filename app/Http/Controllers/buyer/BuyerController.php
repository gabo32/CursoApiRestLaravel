<?php

namespace App\Http\Controllers\buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //los usuarios que tengan al menos una transaccion
        $compradores = Buyer::has('transactions')->get();

        return $this->showAll($compradores);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comprador = Buyer::has('transactions')->findOrFail($id);

        return $this->showOne($comprador,201);     
    }
}
