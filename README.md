A simple way to add an admin nag, that can be dismissed via AJAX.

### Example
Show a warning if current version of PHP is less than 5.3.
```php
    add_action( 'plugins_loaded', 'caeq_bootstrap' );
    function caeq_bootstrap(){

    	if (  ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
    		if ( is_admin() || defined( 'DOING_AJAX' ) && DOING_AJAX ) {
    			include_once CAEQ_PATH . 'vendor/calderawp/dismissible-notice/src/callback_hook.php';
    		}
    
    		if ( is_admin() ) {
    			//BIG nope nope nope!
    
    			$message = sprintf( __( 'Caldera Easy Queries requires PHP version %1s or later. We strongly recommend PHP 5.4 or later for security and performance reasons. Current version is %2s.', '5.3.0', 'caldera-text-domain' ), PHP_VERSION );
    			echo caldera_warnings_dismissible_notice( $message, true, 'activate_plugins' );
    		}
    
    	}else{
    		//bootstrap plugin
    		require_once( CAEQ_PATH . 'bootstrap.php' );
    
    	}

}
```

### Backwards Compat and such
This library was written with PHP 5.2 backwards-compat in mind. Hence the prefixed, instead of namespaced class name. You will also need to manually include the class.


### License & Copyright
Copyright 2015  [Josh Pollock](http://JoshPress.net)

Licensed under the terms of the [GNU General Public License version 2](http://www.gnu.org/licenses/gpl-2.0.html) or later. Please share with your neighbor.
