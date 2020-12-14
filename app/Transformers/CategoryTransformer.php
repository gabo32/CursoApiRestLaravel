<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identificador' => (int) $category->id,
            'titulo' => (string) $category->name,
            'detalles' => (string) $category->description,
            'fechaCreacion' => (string) $category->created_at,
            'fechaActualizacion' => (string) $category->updated_at,
            'fechaEliminacion' => isset($buyer->deleted_at)? (string) $buyer->deleted_at: null,
        ];
    }
}