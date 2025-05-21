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
        $destinatoinURL = DB::table('tbl_destination as a')
                        ->selectRaw('a.destination_id, a.destination_name, a.destination_url')
                        ->where('bit_Deleted_Flag', '=', 0)
                        ->where('status', 1)
                        ->first();
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

        $bestTourPackages = DB::table('tbl_tourpackages as a')
                    ->select(
                        'a.tourpackageid',
                        'a.tpackage_name',
                        'a.tpackage_url',
                        )
                    ->where('a.bit_Deleted_Flag', 0)
                    ->where('a.pack_type', 15)
                    ->where('a.status', 1);
        $bestTourPackages = $bestTourPackages->inRandomOrder()->get();

        View::share('parameters', $parameters);
        View::share('footer', $footer);
        View::share('destinatoinURL', $destinatoinURL);
        View::share('bestTourPackages', $bestTourPackages);
    }
}
