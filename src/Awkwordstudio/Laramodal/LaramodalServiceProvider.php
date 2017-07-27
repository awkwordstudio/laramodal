<?php namespace Awkwordstudio\Laramodal;

use Illuminate\Support\ServiceProvider;

class LaramodalServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('awkwordstudio/laramodal');
	}
	
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->singleton(Laramodal::class, function () {
            return new Laramodal();
        });

		$this->app->alias(Laramodal::class, 'awkwordstudio.laramodal');

	}

	
}
