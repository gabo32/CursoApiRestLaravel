<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identificador' => (int) $user->id,
            'nombre' => (string) $user->name,
            'correo' => (string) $user->email,
            'esVerificado' => (int) $user->verified,
            'esAdministrador' => ($user->admin === 'true'),
            'fechaCreacion' => (string) $user->created_at,
            'fechaActualizacion' => (string) $user->updated_at,
            'fechaEliminacion' => isset($buyer->deleted_at)? (string) $buyer->deleted_at: null,
        ];
    }
}