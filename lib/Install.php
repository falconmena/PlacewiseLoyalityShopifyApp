<?php
    class Install{
        
        public function index(){
            $theme = new Theme();
            $theme->render('install',['name'=>'mohammad']);
        }
        
        public function do_install(){
            $store_url = $_POST['store_url'];
            $api_key = $_POST['api_key'];
            $shared_secret = $_POST['shared_secret'];
            
            $pw_production = $_POST['pw_production'];
            $pw_product_name = $_POST['pw_product_name'];
            $pw_slug = $_POST['pw_slug'];
            $pw_client_authorization = $_POST['pw_client_authorization'];
            
            
            
            $config_key = array(
                'ShopUrl' => $store_url,
                'ApiKey' => $api_key,
                'SharedSecret' => $shared_secret,
            );
            $_SESSION["api_key_temp"] = $api_key;
            $_SESSION["sharedSecret_temp"] = $shared_secret;
            
            $_SESSION["pw_production"] = $pw_production;
            $_SESSION["pw_product_name"] = $pw_product_name;
            $_SESSION["pw_slug"] = $pw_slug;
            $_SESSION["pw_client_authorization"] = $pw_client_authorization;
            // echo "<pre>";
            // print_r($_SESSION);
            // exit;
            PHPShopify\ShopifySDK::config($config_key);
            $scopes = 'read_products,write_products,read_script_tags,write_script_tags,read_price_rules,write_price_rules,read_themes,write_themes,read_customers,write_customers,unauthenticated_write_customers,write_orders,read_orders';
            $redirectUrl = root_path."/?r=install/redirect_url";
            \PHPShopify\AuthHelper::createAuthRequest($scopes, $redirectUrl);
        }
        
        public function redirect_url(){
            $shop_url = $_GET['shop'];
            $api_key = $_SESSION['api_key_temp'];
            $sharedSecret = $_SESSION['sharedSecret_temp'];
            
            $pw_production = $_SESSION['pw_production'];
            $pw_product_name = $_SESSION['pw_product_name'];
            $pw_slug = $_SESSION['pw_slug'];
            $pw_client_authorization = $_SESSION['pw_client_authorization'];
            
            
            
            
            unset($_SESSION["api_key_temp"]);
            unset($_SESSION["sharedSecret_temp"]);
            
            unset($_SESSION["pw_production"]);
            unset($_SESSION["pw_product_name"]);
            unset($_SESSION["pw_slug"]);
            unset($_SESSION["pw_client_authorization"]);
            $config_key = array(
                'ShopUrl' => $shop_url,
                'ApiKey' => $api_key,
                'SharedSecret' => $sharedSecret,
            );
            PHPShopify\ShopifySDK::config($config_key);
            $accessToken = \PHPShopify\AuthHelper::getAccessToken();
            
            $this->save_store($shop_url,$accessToken,$api_key,$sharedSecret,$pw_production,$pw_product_name,$pw_slug,$pw_client_authorization);
        }
        
        public function save_store($shop_url,$accessToken,$api_key,$sharedSecret,$pw_production,$pw_product_name,$pw_slug,$pw_client_authorization){
            
            $store = new Store();
            $checkStoreExist = $store->getStoreByShop_url($shop_url);
            if(!empty($checkStoreExist)){
                $store->update($shop_url,$accessToken,$api_key,$sharedSecret,$pw_production,$pw_product_name,$pw_slug,$pw_client_authorization);
            }else{
                $store->create($shop_url,$accessToken,$api_key,$sharedSecret,$pw_production,$pw_product_name,$pw_slug,$pw_client_authorization);
            }
            header("Location: ".root_path."/?".$_SERVER['QUERY_STRING'] . "&r=install/install_theme");
            exit();
        }
        
        public function install_theme(){
            $store = new Store();
            $data_store = $store->getStoreByShop_url($_GET['shop']);
            $config = array(
                'ShopUrl' => $_GET['shop'],
                'AccessToken' => $data_store['token'],
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            
            $this->create_webhooks($shopify);
            
            $this->create_script_tag($shopify);
            
            $this->create_theme_data($shopify);
            
            
            header("Location: https://".$_GET['shop']."/admin");
            exit();
            
        }
        public function create_webhooks($shopify){
            
            $webhook = $shopify->Webhook()->get();    
            $webhook_create_customer = 0;
            $webhook_create_order = 0;
            
            foreach ($webhook as $key_hook => $value_hook) {
                if($value_hook['topic'] == "customers/create" && $value_hook['address'] == root_path."/?r=webhooks/create_customer"){
                    $webhook_create_customer = 1;
                }
                if($value_hook['topic'] == "orders/create" && $value_hook['address'] == root_path."/?r=webhooks/create_order"){
                    $webhook_create_order = 1;
                }
            }
            if($webhook_create_customer != 1){
                $params_webhook_customer  = array(
                    "topic" => "customers/create",
                    "address" => root_path."/?r=webhooks/create_customer",
                    "format" => "json"
                );
                $shopify->Webhook()->post($params_webhook_customer);
            }
            if($webhook_create_order != 1){
                $params_webhook_order  = array(
                    "topic" => "orders/create",
                    "address" => root_path."/?r=webhooks/create_order",
                    "format" => "json"
                );
                $shopify->Webhook()->post($params_webhook_order);
            }
        }
        
        public function create_script_tag($shopify){
            $script_tag = $shopify->ScriptTag()->get();
            $found = 0;
            foreach ($script_tag as $key => $value) {
                $src = $value['src'];
                $url_link = root_path."/views/assets/js/shopify_story.js";
                if($src == $url_link){
                    $found = 1;
                    break;
                }
            }
            if(!$found){
                // add script tag js  
                $params = array(
                    "event" => "onload",
                    "src" => root_path."/views/assets/js/shopify_story.js"
                );
                $script_tag = $shopify->ScriptTag()->post($params);
            }
            $script_tag = $shopify->ScriptTag()->get();
        }
        public function create_theme_data($shopify){
            
            $theme = $shopify->Theme()->get();    
            $theme_id = "";
            foreach ($theme as $key => $value) {
                if($value['role'] == "main"){
                    $theme_id = $value['id'];
                    $create_section_header = array(
                        "key"   => "sections/techs_factory_header.liquid",
                        "value" => ""
                    );
                    $asset = $shopify->Theme($theme_id)->Asset()->put($create_section_header);
                    
                    
                    $new_file_popup = "<div id='data-shop-name' data-shop='{{shop.domain}}'></div>";
                    $create_section_footer = array(
                        "key"   => "sections/techs_factory_footer.liquid",
                        "value" => $new_file_popup
                    );
                    $asset = $shopify->Theme($theme_id)->Asset()->put($create_section_footer);
            
                    $options_css = array(
                        "asset[key]" => "layout/theme.liquid"
                    );
                    $theme_liquid = $shopify->Theme($theme_id)->Asset()->get($options_css);
                    $theme_value = $theme_liquid['asset']['value'];
                    if (!(strpos($theme_value, '{% section "techs_factory_header" %}') !== false)) {
                        $theme_value = str_replace("<head>",'<head>{% section "techs_factory_header" %}',$theme_value);
                    }
                    if (!(strpos($theme_value, '{% section "techs_factory_footer" %}') !== false)) {
                        $theme_value = str_replace("</body>",'{% section "techs_factory_footer" %}</body>',$theme_value);
                    }
                    $asset_option_css = array(
                        "key"   => "layout/theme.liquid",
                        "value" => $theme_value
                    );
                    $asset = $shopify->Theme($theme_id)->Asset()->put($asset_option_css);
                }
            }
            
        }
        
    }
?>