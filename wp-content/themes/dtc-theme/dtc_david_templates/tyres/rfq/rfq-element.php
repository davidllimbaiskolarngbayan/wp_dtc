<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/7/2015
 * Time: 11:48 PM
 */

if (is_array($data) && !empty($data)):
    if (isset($_REQUEST['compare_true']) and !empty($_REQUEST['compare_true'])) {
        echo hatt()->load_template('tyres/compare', FALSE);
        return;
    }

    if(  isset($_GET['start']) && $_GET['start'] == 1){
        unset($_SESSION['rfq-vehicle-list']);
        unset($_SESSION['items']);
    }


    if(isset($_GET['compare_item_return']) && !empty($_GET['compare_item_return'])){

        $compare_item_return = explode(',', $_GET['compare_item_return']);

        if ($_GET['type'] == 'size') {

            $tyre_type = get_post( $_REQUEST['compare_item_return'] );

            add_tyre_on_list($tyre_type->post_title , $tyre_type->ID);

        }

    }

    //set cookie
    $cookie_expiry = strtotime('+10 days'); //time()+3600;
    $cookie_path = "/";
    $cookie_domain = $_SERVER['HTTP_HOST'];





    //print_r($_COOKIE);
?>
    <div class="find-type">
        <div class="type-detail text-center container">
            <?php

            if (!empty($_GET['type']) && $_GET['type'] == 'vehicle') {

                if($_COOKIE['findtyre'] != 'vehicle'){
                    unset($_SESSION['rfq-vehicle-list']);
                    unset($_SESSION['items']);
                }

                @setcookie("findtyre", 'vehicle', ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);

                echo hatt()->load_template('tyres/rfq/rfq', 'vehicle', array(
                    'data_header' => $data,
                    'content_header' => $content
                ));
            }
            else {

                if($_COOKIE['findtyre'] != 'size'){
                    unset($_SESSION['rfq-vehicle-list']);
                    unset($_SESSION['items']);
                }

                @setcookie("findtyre", 'size', ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);

                if (!empty($_GET['type']) && $_GET['type'] == 'size') {
                   
                    echo hatt()->load_template('tyres/rfq/rfq', 'size', array(
                    'data_header' => $data,
                    'content_header' => $content
                ));

                } else {
                    echo hatt()->load_template('tyres/rfq/rfq', 'header', array(
                        'data_header' => $data,
                        'content' => $content
                    ));
                };
            }
            ?>
        </div>
    </div>
<?php
endif;