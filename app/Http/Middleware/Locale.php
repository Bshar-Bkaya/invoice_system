<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Locale
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (config('locale.status')) {
      if (
        Session::has('locale') &&
        array_key_exists(Session::get('locale'), config('locale.languages'))
      ) {
        App::SetLocale(Session::get('locale'));
      } else {
        $userLang = preg_split('/[,;]/', $request->server('HTTP_ACCEPT_LANGUAGE'));
        foreach ($userLang as $lang) {
          if (array_key_exists($lang, config('locale.languages'))) {
            App::setLocale($lang);
            setLocale(LC_TIME, config('locale.languages')[$lang][1]);
            Carbon::setLocale(config('locale.languages')[$lang][0]);

            if (config('locale.languages')[$lang][2]) {
              Session(['lang-rtl' => true]);
            } else {
              Session()->forget('lang-rtl');
            }
            break;
          }
        }
      }
    }

    return $next($request);
  }
}
