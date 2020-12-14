<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;
    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';

    protected $table = 'users';
    protected $dates = ['deleted_at'];

    public $transformer = UserTransformer::class;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    //mutador
    public function setNameAttribute($valor){
        $this->attributes['name'] = strtolower($valor);
    }

    //mutador
    public function setEmailAttribute($valor){
        $this->attributes['email'] = strtolower($valor);
    }    

    //acceesor
    public function getNameAttribute($valor){
        return ucwords($valor);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function esVerificado(){
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    public function esAdministrador(){
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }

    public static function generarVerificacionToken(){
        return  Str::random(40);
    }
}
