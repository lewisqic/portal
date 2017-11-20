<?php namespace Conner\Kint;

use Illuminate\Support\ServiceProvider;
use Blade;
use Kint;

/**
 * Copyright (C) 2015 Robert Conner
 */
class KintServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 */
	protected $defer = false;
	
	/**
	 * Bootstrap the application events.
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../config/kint.php' => config_path('kint.php'),
		]);
		
		$this->bootBladeDirectives();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Illuminate\Support\ServiceProvider::register()
	 */
	public function register()
	{
		$this->registerConfigs();
	}
	
	protected function registerConfigs()
	{
		$configs = config('kint');

		if(empty($configs)) {
			return;
		}
		
		foreach($configs as $key => $val) {
			if($key == 'enabled') {
				Kint::enabled($val);
			} elseif(property_exists('Kint', $key)) {
				Kint::$$key = $val;
			}
		}
	}
	
	protected function bootBladeDirectives()
	{
		if(config('kint.blade_directives')) {
			Blade::directive('d', function($variable) {
				return "<?php echo d($variable); ?>";
			});
 			Blade::directive('dd', function($variable) {
 				return "<?php echo dd($variable); ?>";
 			});
 			Blade::directive('ddd', function($variable) {
 				return "<?php echo ddd($variable); ?>";
 			});
 			Blade::directive('s', function($variable) {
 				return "<?php echo s($variable); ?>";
 			});
 			Blade::directive('sd', function($variable) {
 				return "<?php echo sd($variable); ?>";
 			});
		}
	}
	
}
