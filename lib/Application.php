<?php

class Application{

    private function __construct() {}
    
    public static function boot(){
 
        $items = glob( __DIR__ . '/*');
        require_once __DIR__ . '/Database.php';
        require_once __DIR__ . "/../shopify_services/vendor/autoload.php";
        require_once __DIR__ . '/Theme.php'; 
        require_once __DIR__ . '/Store.php';
        require_once __DIR__ . '/Loyalty.php';
        require_once __DIR__ . '/ShopifyApi.php';
        require_once __DIR__ . '/Webhooks.php';
        foreach( $items as $item ) {
            $isPhp = pathinfo( $item )["extension"] === "php";
    
            if ( is_file( $item ) && $isPhp ) {
                require_once $item;
            } elseif ( is_dir( $item ) ) {
                Application::boot( $item );
            }
        }
    }

    public function run(){
        echo "Hello in bootstrap";
    }
}