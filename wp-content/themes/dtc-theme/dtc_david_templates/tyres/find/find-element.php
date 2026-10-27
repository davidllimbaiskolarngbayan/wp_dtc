<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/7/2015
 * Time: 11:48 PM
 */

if (is_array($data) && !empty($data)):
    if (isset($_GET['compare_true']) and !empty($_GET['compare_true'])) {
        echo hatt()->load_template('tyres/compare', FALSE);
        return;
    }

    if(isset($_GET['compare_item_return']) && !empty($_GET['compare_item_return'])){
        $compare_item_return = explode(',', $_GET['compare_item_return']);

        if (isset($_COOKIE['findtyre'])) {
            $_GET['type'] = $_COOKIE['findtyre'];
        }
    }
?>
    <div class="find-type">
        <div class="type-detail text-center container">
            <?php
            if (!empty($_GET['type']) && $_GET['type'] === 'vehicle') {
                $_COOKIE['findtyre'] = 'vehicle';
                echo hatt()->load_template('tyres/find/find', 'vehicle', array(
                    'data_header' => $data,
                    'content_header' => $content
                ));
            }
			elseif(!empty($_GET['type']) && $_GET['type'] === 'rfq'){
				echo hatt()->load_template('tyres/find/find', 'rfq', array(
                    'data_header' => $data,
                    'content_header' => $content
                ));
			}
            else {
                if (!empty($_GET['type']) && $_GET['type'] === 'size') {
                    $_COOKIE['findtyre'] = 'size';
                    echo hatt()->load_template('tyres/find/find', 'size', array(
                        'data_header' => $data,
                        'content_header' => $content
                    ));
                } else {
                    echo hatt()->load_template('tyres/header', false, array(
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