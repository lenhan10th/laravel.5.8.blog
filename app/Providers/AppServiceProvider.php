<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;
use App\ProductType;
use App\Cart;

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
        view()->composer('header', function($view){
            // $old_cart = null;
            // if(Session('cart')){
            //     $old_cart = Session::get('cart');
                
            // }
            // $cart = new Cart($old_cart);
            $product_types = ProductType::all();
            $view->with('product_types', $product_types);
        });

        view()->composer(['header','pages.checkout'],function($view){
            if(Session('cart')){
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $view->with([
                    'cart' => Session::get('cart'),
                    'product_cart' => $cart->items,
                    'total_price' => $cart->totalPrice,
                    'total_qty' => $cart->totalQty,
                ]);
            }
        });
    }
}
