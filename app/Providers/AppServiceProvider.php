<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $parameters =  DB::table('tbl_parameters')
                        ->select('parameter', 'par_value', 'parid')
                        ->where('param_type', 'CS')
                        ->where('status', 1)
                        ->where('bit_Deleted_Flag', 0)
                        ->get();
        $footer =  DB::table('tbl_footer')
                    ->select('vch_Footer_Name', 'vch_Footer_URL', 'int_footer_id')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->get();

        View::share('parameters', $parameters);
        View::share('footer', $footer);
    }
}
