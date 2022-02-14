<?php
//     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    require_once __DIR__ . "/shopify_services/vendor/autoload.php";
    function autoloadLib($class) {
        include __DIR__.'/lib/' . $class . '.php';
    }
    spl_autoload_register('autoloadLib');
    define("root_path","https://brustad1.placewise-services.com");
    $store = new Store();
    $data_store = $store->getStoreByShop_url($_GET['shop']);
    $config = array(
        'ShopUrl' => $_GET['shop'],
        'AccessToken' => $data_store['token'],
    );
    $shopify = new PHPShopify\ShopifySDK($config);
    $webhook = $shopify->Webhook()->get();    
    $webhook_create_customer = 0;
    $webhook_create_order = 0;
    // echo "<pre>";
    // print_r($webhook);
    // exit;
    foreach ($webhook as $key_hook => $value_hook) {
        if($value_hook['topic'] == "customers/create" && $value_hook['address'] == root_path."/webhooks/create_customer.php"){
            $webhook_create_customer = 1;
        }
        if($value_hook['topic'] == "orders/create" && $value_hook['address'] == root_path."/webhooks/create_order.php"){
            $webhook_create_order = 1;
        }
    }
    if($webhook_create_customer != 1){
        $params_webhook_customer  = array(
            "topic" => "customers/create",
            "address" => root_path."/webhooks/create_customer.php",
            "format" => "json"
        );
        $shopify->Webhook()->post($params_webhook_customer);
    }
    if($webhook_create_order != 1){
        $params_webhook_order  = array(
            "topic" => "orders/create",
            "address" => root_path."/webhooks/create_order.php",
            "format" => "json"
        );
        $shopify->Webhook()->post($params_webhook_order);
    }
    $webhook_test = $shopify->Webhook()->get();   
    // echo "<pre>";
    // print_r($webhook_test);
    // exit;
    $script_tag = $shopify->ScriptTag()->get();
    $found = 0;
    foreach ($script_tag as $key => $value) {
        $src = $value['src'];
        $url_link = root_path."/assets/js/shopify_story.js";
        if($src == $url_link){
            $found = 1;
            break;
        }
    }
    if(!$found){
        // add script tag js  
        $params = array(
            "event" => "onload",
            "src" => root_path."/assets/js/shopify_story.js"
        );
        $script_tag = $shopify->ScriptTag()->post($params);
    }



// $script_tag = $shopify->ScriptTag()->get();
// echo "<pre>";
// print_r($script_tag);



    
    // $script_tag = $shopify->ScriptTag()->get();
    // echo "<pre>";
    // print_r($script_tag);
    $theme = $shopify->Theme()->get();    
    $theme_id = "";
    foreach ($theme as $key => $value) {
        if($value['role'] == "main"){
            $theme_id = $value['id'];
            $create_section_header = array(
                "key"   => "sections/techs_factory_header.liquid",
                "value" => "<link rel='stylesheet' href='".root_path."/assets/css/shopify_story.scss' />
                            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
                            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>"
            );
            $asset = $shopify->Theme($theme_id)->Asset()->put($create_section_header);
            $new_file_popup = "<div id='modal_iframe_buttom' class='ifram_modal_button' style='display:none;'>
                                    <div class='member-notification-container-popup'>
                                    <div class='member-notification-popup'>
                                        <div class='member-notification__content-popup'>  
                                        <p style='font-size: 15px;font-weight: 700;text-align: center;'>Rewards</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>  
                                <div id='loyaltymember'>  
                                    <div class='member-notification-container member-notification-container--top-right'>
                                        <div class='member-notification member-notification--guest-introduction'>
                                        <div class='member-notification__content'>
                                            <div class='member-notification__message'>Want to be loyalty member ?</div>
                                            <div class='member-notification__action'>
                                            <div id='popup_fill_data' style='display:none;'>
                                                  <p style='font-size: 12px;margin-bottom: 12px;'>Please Fill All Data</p>
                                            </div> 
                                            <a class='member-notification__action-button member-action-button' tabindex='0' id='link_open_iframe'>
                                                Learn more
                                            </a>
                                            </div>
                                        </div>
                                        <a class='member-notification__close-button' tabindex='0'>×</a>
                                        </div>
                                    </div>
                                </div>
                                <div id='data-shop-name' data-shop='{{shop.domain}}'></div>
                                <div class='modal fade' data-backdrop='static'  id='iframe_loyalty'  style='background-color: unset;' tabindex='-1' role='dialog' aria-labelledby='iframe_loyaltyLabel' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'  style='border-bottom: 0;padding: 0;'>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close' style='margin-right: 16px;margin-top: 10px;'>
                                                <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div  class='modal-body' style='padding:0px 15px 15px 15px;'>
                                                <div class='container_iframe'>
                                                    <div class='container-loading'>
                                                        <div class='circle circle-1'></div>
                                                        <div class='circle circle-2'></div>
                                                        <div class='circle circle-3'></div>
                                                        <div class='circle circle-4'></div>
                                                        <div class='circle circle-5'></div>
                                                    </div>	
                                              		<iframe style='border:none;' class='responsive-iframe' id='iframe_link' width='100%' height='100%' src='".root_path."/view/iframe' title='Loyalty Member'></iframe>
                                              	</div>	  
                                          	</div>
                                        </div>
                                    </div>
                                </div>";
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
            //add button log in/create account. in cart page
            // $create_section_button_login_cart = array(
            //     "key"   => "sections/techs_factory_login_cart.liquid",
            //     "value" => " <div style='margin-top: 16px;'><div class='cart__buttons-container'>
            //                     <div class='cart__submit-controls'><input type='submit'  class='cart__submit btn btn--small-wide' value='log in/create account.'>
            //                     </div>
            //                     <div class='cart__error-message-wrapper hide' role='alert' data-cart-error-message-wrapper=''>
            //                     </div>
            //                 </div>"
            // );
            // $options_cart = array(
            //     "asset[key]" => "sections/cart-template.liquid"
            // );

            // $theme_cart_liquid = $shopify->Theme($theme_id)->Asset()->get($options_cart);
            // $theme_cart_liquid_value = $theme_cart_liquid['asset']['value'];
            // // echo "<pre>";
            // // print_r($theme_cart_liquid_value);
            // // exit;
            // if (!(strpos($theme_cart_liquid_value, '{% section "techs_factory_login_cart" %}') !== false)) {
            //     $theme_cart_liquid_value = str_replace("</form>",'{% section "techs_factory_login_cart" %}</form>',$theme_cart_liquid_value);
            // }
            // $option_cart_css = array(
            //     "key"   => "sections/cart-template.liquid",
            //     "value" => $theme_cart_liquid
            // );
            // $shopify->Theme($theme_id)->Asset()->put($option_cart_css);
        }
    }

    // header("Location: https://".$_GET['shop']."/admin");
    // exit();
?>





