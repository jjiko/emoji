<?php namespace Jiko\Emoji\Providers;

use Illuminate\Support\ServiceProvider;

class EmojiServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->loadViewsFrom(__DIR__ . '/../views', 'emoji');

    if (!$this->app->routesAreCached()) {
      require_once(__DIR__ . '/../Http/routes.php');
    }
  }

  public function register() {
//    $this->mergeConfigFrom(
//      __DIR__.'/../config/services.php', 'services'
//    );
  }
}