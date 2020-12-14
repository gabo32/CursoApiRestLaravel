<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //evento para mandar correo 
        User::created(function($user){
            //nos ayudamos con un helper 
            //5 intentos, ejectar, 100 milisegundos de diferencia
            retry(5, function() use($user){
                Mail::to($user->email)->send(new UserCreated($user));    
            }, 100);
            
        });

        //evento para cambio de correo
        User::updated(function($user){
            if( $user->isDirty('email')){
                 //nos ayudamos con un helper 
                //5 intentos, ejectar, 100 milisegundos de diferencia
                retry(5, function() use($user){
                    Mail::to($user->email)->send(new UserMailChanged($user));    
                }, 100);
                
            }
            
        });

        //cuando un producto sea actualizado hacer lo siguiente
        //evento
        Product::updated(function($product){
            if( $product->quantity == 0 && $product->estaDisponible()){
                $product->status = Product::PRODUCTO_NO_DISPONIBLE;

                $product->save();
            }
        });
    }
}
