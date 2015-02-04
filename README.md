A simple way to add an admin nag, that can be dismissed via AJAX.

### Example
Show a warning if current version of PHP is less than 5.3.
```php
    if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
        if ( is_admin() ) {
            $message = __( sprintf( 'Caldera Easy Pods requires PHP version %1s or later. We strongly recommend PHP 5.4 or later for security and performance reasons. Current version is %2s.', '5.3.0', PHP_VERSION ), 'caldera-easy-pods' );
            $path    = dirname( __FILE__ ) . '/vendor/calderawp/messages/src/admin_notice.php';
            if ( file_exists( $path ) ) {
                include_once( $path );
                echo Caldera_Warnings_Dismissible_Notice::notice( $message );
            }
        }
    
    } else {
        include_once( CEP_PATH . '/bootstrap.php' );
    }
```

### Backwards Compat and such
This library was written with PHP 5.2 backwards-compat in mind. Hence the prefixed instead of namespaced class name. It will still be autoload if using the Composer Autoloader. The above example doe snot use the autoloader since it's goal is to nag and bail if user is using PHP 5.2.


### License & Copyright
Copyright 2015  [Josh Pollock](http://JoshPress.net)

Licensed under the terms of the [GNU General Public License version 2](http://www.gnu.org/licenses/gpl-2.0.html) or later. Please share with your neighbor.
