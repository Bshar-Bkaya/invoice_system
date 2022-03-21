<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

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
    $locale = config('app.locale') == 'ar' ? 'ar' : config('app.locale');
    App::setlocale($locale);
    Lang::setlocale($locale);
    Session::put('locale', $locale);
    Carbon::setlocale($locale);
  }
}
