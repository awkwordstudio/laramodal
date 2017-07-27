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
		//publish directory
		 $this->publishes([
				__DIR__.'/assets' => public_path('vendor/laramodal'),
			], 'public');
	    //load views
		$this->loadViewsFrom(__DIR__.'/path/to/views', 'laramodal');
	}
	
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->singleton(Modal::class, function () {
            return new Modal();
        });

		$this->app->alias(Modal::class, 'awkwordstudio.laramodal');

	}

	
}
