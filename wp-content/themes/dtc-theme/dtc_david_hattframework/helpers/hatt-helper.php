<?php
    /**
     * Created by PhpStorm.
     * User: me664
     * Date: 11/27/14
     * Time: 10:12 PM
     */

    if (!function_exists('hatt_hex2rgb')) {
        function hatt_hex2rgb($hex = FALSE)
        {

            if ($hex) {
                $hex = str_replace("#", "", $hex);

                if (strlen($hex) == 3) {
                    $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                    $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                    $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
                } else {
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                }
                $rgb = array($r, $g, $b);

                //return implode(",", $rgb); // returns the rgb values separated by commas
                return $rgb; // returns an array with the rgb values
            }
        }

    }
    if (!function_exists('hatt_handle_icon')) {
        function hatt_handle_icon($icon)
        {

            $icon = ltrim($icon);
            if (substr($icon, 0, 3) == 'fa-') {
                return "fa " . $icon;
            }

            return $icon;
        }
    }

    if (!function_exists('hatt_get_icon')) {
        function hatt_get_icon($icon, $holder = 'i')
        {

            $icon = hatt_handle_icon($icon);

            return "<$holder class='{$icon}'></$holder>";
        }
    }

    if (!function_exists('btp_list_order_by')) {
        function btp_list_order_by()
        {

            return array(
                __('None', HATT_TEXTDOMAIN)          => 'none',
                __('ID', HATT_TEXTDOMAIN)            => 'ID',
                __('Author', HATT_TEXTDOMAIN)        => 'author',
                __('Title', HATT_TEXTDOMAIN)         => 'title',
                __('Name', HATT_TEXTDOMAIN)          => 'name',
                __('Type', HATT_TEXTDOMAIN)          => 'type',
                __('Date', HATT_TEXTDOMAIN)          => 'date',
                __('Modified', HATT_TEXTDOMAIN)      => 'modified',
                __('Parent', HATT_TEXTDOMAIN)        => 'parent',
                __('Rand', HATT_TEXTDOMAIN)          => 'rand',
                __('Comment Count', HATT_TEXTDOMAIN) => 'comment_count',
            );
        }
    }

    if (!function_exists('btp_get_list_taxonomy')) {

        function btp_get_list_taxonomy($tax = 'category', $array = array())
        {

            $taxonomies = get_terms($tax, $array);

            $r = array();

            $r[__('All', HATT_TEXTDOMAIN)] = 0;

            if (!is_wp_error($taxonomies)) {

                foreach ($taxonomies as $key => $value) {
                    # code...
                    $r[$value->name] = $value->term_id;

                }
            }

            return $r;
        }

    }

    if (!function_exists('btp_is_all_cat')) {
        function btp_is_all_cat($cat_string)
        {

            $all = FALSE;

            $cat_obj = explode(',', $cat_string);

            if (!$cat_string) {
                return TRUE;
            }

            if (is_array($cat_obj)) {
                foreach ($cat_obj as $value) {
                    if (!$value) {
                        $all = TRUE;
                    }
                }

            }

            return $all;
        }
    }

    if (!function_exists('hatt_archive_title')) {
        function hatt_archive_title()
        {

            if (is_category()) {
                $title = sprintf(__('%s', HATT_TEXTDOMAIN), single_cat_title('', FALSE));
            } elseif (is_tag()) {
                $title = sprintf(__('Tag: %s', HATT_TEXTDOMAIN), single_tag_title('', FALSE));
            } elseif (is_author()) {
                $title = sprintf(__('Author: %s', HATT_TEXTDOMAIN), '<span class="vcard">' . get_the_author() . '</span>');
            } elseif (is_year()) {
                $title = sprintf(__('Year: %s', HATT_TEXTDOMAIN), get_the_date(_x('Y', 'yearly archives date format', HATT_TEXTDOMAIN)));
            } elseif (is_month()) {
                $title = sprintf(__('Month: %s', HATT_TEXTDOMAIN), get_the_date(_x('F Y', 'monthly archives date format', HATT_TEXTDOMAIN)));
            } elseif (is_day()) {
                $title = sprintf(__('Day: %s', HATT_TEXTDOMAIN), get_the_date(_x('F j, Y', 'daily archives date format', HATT_TEXTDOMAIN)));
            } elseif (is_tax('post_format')) {
                if (is_tax('post_format', 'post-format-aside')) {
                    $title = _x('Asides', 'post format archive title', HATT_TEXTDOMAIN);
                } elseif (is_tax('post_format', 'post-format-gallery')) {
                    $title = _x('Galleries', 'post format archive title', HATT_TEXTDOMAIN);
                } elseif (is_tax('post_format', 'post-format-image')) {
                    $title = _x('Images', 'post format archive title', HATT_TEXTDOMAIN);
                } elseif (is_tax('post_format', 'post-format-video')) {
                    $title = _x('Videos', 'post format archive title', HATT_TEXTDOMAIN);
                } elseif (is_tax('post_format', 'post-format-quote')) {
                    $title = _x('Quotes', 'post format archive title', HATT_TEXTDOMAIN);
                } elseif (is_tax('post_format', 'post-format-link')) {
                    $title = _x('Links', 'post format archive title', HATT_TEXTDOMAIN);
                } elseif (is_tax('post_format', 'post-format-status')) {
                    $title = _x('Statuses', 'post format archive title', HATT_TEXTDOMAIN);
                } elseif (is_tax('post_format', 'post-format-audio')) {
                    $title = _x('Audio', 'post format archive title', HATT_TEXTDOMAIN);
                } elseif (is_tax('post_format', 'post-format-chat')) {
                    $title = _x('Chats', 'post format archive title', HATT_TEXTDOMAIN);
                }
            } elseif (is_post_type_archive()) {
                $title = sprintf(__('%s', HATT_TEXTDOMAIN), post_type_archive_title('', FALSE));
            } elseif (is_tax()) {
                $tax = get_taxonomy(get_queried_object()->taxonomy);
                /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
                $title = sprintf(__('%1$s: %2$s', HATT_TEXTDOMAIN), $tax->labels->singular_name, single_term_title('', FALSE));
            } else {
                $title = __('Archives', HATT_TEXTDOMAIN);
            }

            /**
             * Filter the archive title.
             *
             * @since 4.1.0
             *
             * @param string $title Archive title to be displayed.
             */

            return apply_filters('get_the_archive_title', $title);
        }
    }

    if (!function_exists('ht_is_ajax')) {
        function ht_is_ajax()
        {

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                return TRUE;
            }
            {
                return FALSE;
            }
        }
    }

    if (!function_exists('ht_style_to_string')) {
        function ht_style_to_string($style = array())
        {

            if (is_array($style) and !empty($style)) {
                $html = '';
                foreach ($style as $key => $value) {

                    if ($value) {
                        if ($key == 'font-color') {
                            $key = 'color';
                        }

                        $html .= $key . ': ' . $value . ';' . "\r\n";
                    }

                }

                return $html;
            }
        }
    }
    if (!function_exists('ht_paging')) {
        function ht_paging($query = false)
        {
            // Don't print empty markup if there's only one page.
            if (!$query)
                $query = $GLOBALS['wp_query'];
            if ($query->max_num_pages < 2) {
                return;
            }

            $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
            $pagenum_link = html_entity_decode(get_pagenum_link());
            $query_args = array();
            $url_parts = explode('?', $pagenum_link);

            if (isset($url_parts[1])) {
                wp_parse_str($url_parts[1], $query_args);
            }

            $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
            $pagenum_link = trailingslashit($pagenum_link) . '%_%';

            $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
            $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

            // Set up paginated links.
            $links = paginate_links(array(
                'base'      => $pagenum_link,
                'format'    => $format,
                'total'     => $query->max_num_pages,
                'current'   => $paged,
                'mid_size'  => 1,
                // 'add_args' => array_map( 'urlencode', $query_args ),
                'add_args'  => $query_args,
                'prev_text' => __('<i class="fa fa-chevron-left"></i>', HATT_TEXTDOMAIN),
                'next_text' => __('<i class="fa fa-chevron-right"></i>', HATT_TEXTDOMAIN),
                'type'      => 'list'
            ));

            if ($links) :
                $links = str_replace('page-numbers', 'pagination', balanceTags($links));
                $links = str_replace('<span', '<a', $links);
                $links = str_replace('</span>', '</a>', $links);
                $links = str_replace("'", '"', $links);
                $links = str_replace('/"', '"', $links);
                ?>
                <?php echo str_replace('page-numbers', 'pagination', balanceTags($links));//do not use esc_html() with  paginate_links() result
                ?>
            <?php
            endif;
        }

        ;
    }

    if (!function_exists('ht_get_image_terms')) {
        function ht_get_image_terms($tax = 'category', $id_image = FALSE, $title = FALSE)
        {

            if ($id_image) {
                $term_post = wp_get_post_terms(get_the_ID(), $tax);
                if (!empty($term_post)) {
                    $html = '';
                    foreach ($term_post as $var) {
                        $img = get_tax_meta($var->term_id, $id_image);
                        if ($img) {
                            if ($title) {
                                $html .= '<span><img src="' . $img['url'] . '"">' . $var->name . '</span>';
                            } else {
                                $html .= '<span><img src="' . $img['url'] . '" data-toggle="tooltip" data-placement="bottom" title="' . $var->name . '"></span>';
                            }
                        } else {
                            $html .= '<span>' . $var->name . '</span>';
                        }

                    }

                    return $html;

                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }

        }
    }
    if (!function_exists('ht_check_compare')) {
        function ht_check_compare($id)
        {
            $compare_item_return = '';
            if (isset($_GET['compare_item_return']) and !empty($_GET['compare_item_return'])) {
                $compare_item_return = explode(',', $_GET['compare_item_return']);
                if (in_array($id, $compare_item_return)) {
                    return 'checked';
                } else {
                    return 'uncheck';
                }
            } else {
                return 'uncheck';
            }
        }
    };


    if (!function_exists('get_vc_pagecontent')) {
        function get_vc_pagecontent($page_id = FALSE)
        {

            if ($page_id) {
                $page = get_post($page_id);

                if ($page) {
                    $content = apply_filters('the_content', $page->post_content);

                    $content = str_replace(']]>', ']]&gt;', $content);

//					$shortcodes_custom_css = get_post_meta( $page_id, '_wpb_shortcodes_custom_css', TRUE );


                    wp_reset_postdata();

                    return $content;
                }
            }
        }
    }
    if (!function_exists('ht_get_url_find_store')) {
        function ht_get_url_find_store($menu = false,$id =false)
        {
            $url = '#';
            $find_store_url_on_off = hatt()->get_option('header_find_store_url_on_off', true);
            $find_store_url_custom = hatt()->get_option('header_find_store_url_custom', true);
            $find_store_url = hatt()->get_option('header_find_store_url', true);
            if ($find_store_url_on_off == 'on') {
                if ($find_store_url_custom) {
                    $url = $find_store_url_custom;
                    if ($menu) {
                        return $url;
                    }else{
                        if ($find_store_url) {
                            if($id){
                                $url = add_query_arg(array('tyre_id' =>$id), $url);

                            }else{
                                $url = add_query_arg(array('tyre_id' => get_the_ID()), $url);

                            }
                        } else {
                            $url = '#';
                        }
                    }
                }
            } else {
                if ($find_store_url) {
                    $url = get_permalink($find_store_url);
                    if ($menu) {
                        return $url;
                    }else{
                        if ($find_store_url) {
                            $url = add_query_arg(array('tyre_id' => get_the_ID()), $find_store_url);
                        } else {
                            $url = '#';
                        }
                    }

                } else {
                    $url = '#';
                }
            }
            return $url;
        }
    }
    if (!function_exists('ht_get_url_find_tyre')) {
        function ht_get_url_find_tyre($menu = false)
        {
            $url = '#';
            $find_tyre_url_on_off = hatt()->get_option('header_find_tyre_url_on_off', true);
            $find_tyre_url_custom = hatt()->get_option('header_find_tyre_url_custom', true);
            $find_tyre_url = hatt()->get_option('header_find_tyre_url', true);
            if ($find_tyre_url_on_off == 'on') {
                if ($find_tyre_url_custom) {
                    $url = $find_tyre_url_custom;
                }
            } else {
                if ($find_tyre_url) {
                    $url = get_permalink($find_tyre_url);
                    if ($menu) {
                        return $url;
                    }
                    if ($find_tyre_url) {
                        $url = add_query_arg(array('tyre_id' => get_the_ID()), $find_tyre_url);
                    } else {
                        $url = '#';
                    }
                } else {
                    $url = '#';
                }
            }
            return $url;
        }
    }
    if (!function_exists('ht_get_order_list')) {
        function ht_get_order_list($current = false, $extra = array(), $return = 'array')
        {
            $default = array(
                'none'     => __('None', HATT_TEXTDOMAIN),
                'ID'       => __('Post ID', HATT_TEXTDOMAIN),
                'author'   => __('Author', HATT_TEXTDOMAIN),
                'title'    => __('Post Title', HATT_TEXTDOMAIN),
                'name'     => __('Post Name', HATT_TEXTDOMAIN),
                'date'     => __('Post Date', HATT_TEXTDOMAIN),
                'modified' => __('Last Modified Date', HATT_TEXTDOMAIN),
                'parent'   => __('Post Parent', HATT_TEXTDOMAIN),
                'rand'     => __('Random', HATT_TEXTDOMAIN),
            );

            if (!empty($extra) and is_array($extra)) {
                $default = array_merge($default, $extra);
            }

            if ($return == "array") {
                return $default;
            } elseif ($return == 'option') {
                $html = '';
                if (!empty($default)) {
                    foreach ($default as $key => $value) {
                        $selected = selected($key, $current, false);
                        $html .= "<option {$selected} value='{$key}'>{$value}</option>";
                    }
                }

                return $html;
            }


        }
    }
    if (!function_exists('ht_vc_get_order_list')) {
        function ht_vc_get_order_list($current = false, $extra = array())
        {
            $list = ht_get_order_list($current, $extra);
            $r = array();

            if (!empty($list) and is_array($list)) {
                foreach ($list as $key => $value) {
                    $r[$value] = $key;
                }
            }

            return $r;

        }
    }

    /**
     * Get distance from two locations (with latitude & longtitude)
     * $unit maybe is M - Miles, K - Kilometters, N - Nautical Miles
     * Examples: distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
     * Examples: distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
     */

    if (!function_exists('ht_get_distance')) {
        function ht_get_distance($lat1, $lon1, $lat2, $lon2, $unit)
        {

            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }

        }
    }
    if (!function_exists('ht_search_excerpt_highlight')) {
        function ht_search_excerpt_highlight()
        {
            $excerpt = get_the_excerpt();
            $keys = implode('|', explode(' ', get_search_query()));
            $excerpt = preg_replace('/(' . $keys . ')/iu', '<strong class="search-highlight">\0</strong>', $excerpt);

            echo '<p>' . ($excerpt) . '</p>';
        }
    }

    if (!function_exists('ht_search_title_highlight')) {
        function ht_search_title_highlight()
        {
            $title = get_the_title();
            $keys = implode('|', explode(' ', get_search_query()));
            $title = preg_replace('/(' . $keys . ')/iu', '<strong class="search-highlight">\0</strong>', $title);

            echo($title);
        }
    }
    if (!function_exists('ht_get_price_tyre')) {
        function ht_get_price_tyre($id = false)
        {
            $html = '';
            $check_show = get_post_meta(get_the_ID(), 'ht_tyre_price_show', true);
            
            $text_premium = __('Premium',HATT_TEXTDOMAIN);
            $text_middle = __('Middle',HATT_TEXTDOMAIN);
            $text_value = __('Value',HATT_TEXTDOMAIN);
            
            if ($check_show == 'on') {
                $price = get_post_meta(get_the_ID(), 'ht_tyre_price', true);
                $html = '<p class="title">standard <br /> retail price</p>
                            <div class="group-price">
                                <p class="sgd">SGD</p>

                                <p class="price">' . $price . '</p>
                            </div>';
            } else {
                $type = get_post_meta(get_the_ID(), 'ht_tyre_price_type', true);

                 $html = '
                        <div class="group-price cn-group-price">
                        <span>'.__('Classification:',HATT_TEXTDOMAIN).'</span>
                        <div>'.$type.' </div>
                        </div>';


            }

            return $html;
        }
    }
