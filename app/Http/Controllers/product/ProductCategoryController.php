<?php

namespace App\Http\Controllers\product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product ->categories;
        return $this->showAll($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        //sync, attach, syncWithoutdetaching

        //sync reemplaza lo que ya habia
        //$product->categories()->sync([$category->id]);

        //attach no hace diferencia y repite las categorias
        //$product->categories()->attach([$category->id]);

        //agregar la categoria sin borra las que ya existen
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        if( !$product->categories()->find($category->id)){
            return $this->errorResponse("La categoria especificada no es una categoria de este producto", 404);
        }

        //eliminar relacion
        $product->categories()->detach([$category->id]);

        return $this->showAll($product->categories);
    }
}
