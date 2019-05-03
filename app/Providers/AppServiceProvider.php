<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use ExportLocalization;
use Validator;

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

        // List of all langages on site
        View::share('languages', ['en', 'sr']);

        View::share('messages', ExportLocalization::export()->toFlat());

        Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
            if($value != ''){
                $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
                if (in_array($type, $parameters)) {
                    return true;
                }
                return false;
            }

            return true;
        });

        Validator::replacer('image64', function($message, $attribute, $rule, $parameters) {
            if($message != ''){
                return str_replace(':values',join(",",$parameters),$message);
            }
        });
    }
}
