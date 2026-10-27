<?php
    /**
     * Created by PhpStorm.
     * User: x
     * Date: 4/8/2015
     * Time: 12:03 AM
     */
    $term = array();
    $html = '';
    $checkin = array();
    $checkall = false;
    $array = explode(',', $category);
    $filter_category = '';

    if (!empty($array) && is_array($array)) {
        foreach ($array as $value) {
            if (!$value) {
                $checkall = true;
                break;
            }
        }
    }

    // Get all terms
    $all_terms = get_terms('tyres_cat', array('orderby' => 'id', 'order' => 'ASC', 'hide_empty' => false));

    // Define the desired order
    $desired_order = array(
        'All',
        'Passenger',
        'Performance',
        'SUV /4x4/ Light Truck Radial',
        'Earth Mover',
        'Farm and Grader',
        'Light Truck Bias',
        'Medium Commercial Truck Bias',
        'Medium Radial Truck'
    );

    // Reorder the terms according to our desired order
    $ordered_terms = array();
    foreach ($desired_order as $name) {
        foreach ($all_terms as $term) {
            if ($term->name === $name) {
                $ordered_terms[] = $term;
                break;
            }
        }
    }

    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $checkin = explode(',', strtolower(urlencode(trim($_GET['category']))));
    } else {
        // default to first item
        $checkin = array(strtolower($ordered_terms[0]->slug));
    }

    $filter_category = _x('Filter by category', 'browser-category', HATT_TEXTDOMAIN);
    
    $html = '<h4 class="hidden-xs">' . $filter_category . '</h4><ul class="type-cate hidden-xs">';

    foreach ($ordered_terms as $key => $value) {
        if (in_array($value->slug, $checkin)) {
            $checked = 'checked=checked';
            $class = "type_checked";
        } else {
            $checked = '';
            $class = '';
        }

        $img = get_tax_meta($value->term_id, 'tyre_cat_image');

        if ($img) {
            $html .= '
            <li>
                <label class="' . $class . '" for="category_' . $value->slug . '">
                <span>' . $value->name . '</span>
                </label>
            </li>';
        } else {
            if (SITE_LOCALE == 'in') {
                $html .= '
                <li class="' . $class . '">
                    <label>
                    <a href="' . get_page_link() . '/' . $value->slug . '">' . $value->name . '</a></label>
                </li>';
            } else {
                $html .= '
                <li class="' . $class . '">
                    <a href="' . get_page_link() . '/?category=' . $value->slug . '"><label>' . $value->name . '</label></a>
                </li>';
            }
        }
    }
    $html .= '</ul>';

    // Mobile select
    $html .= '<select class="visible-xs" id="category-filter-mobile">';
    foreach ($ordered_terms as $key => $value) {
        $selected = (in_array($value->slug, $checkin)) ? 'selected' : '';
        $html .= '<option value="' . $value->slug . '" ' . $selected . '>' . $value->name . '</option>';    
    }
    $html .= '</select> <br/>';

    echo $html;
?>