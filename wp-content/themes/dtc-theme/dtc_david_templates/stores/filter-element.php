<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/7/2015
 * Time: 11:48 PM
 */
 
 	$_GET["category"] = sanitize_text_field(isset($_GET["category"]));
 	$_GET["specialty"] = sanitize_text_field(isset($_GET["specialty"]));
 	$_GET["state"] = sanitize_text_field(isset($_GET["state"]));
 	$_GET["area"] = sanitize_text_field(isset($_GET["area"]));

    $zpo_on = 'off';
    $zpo_checked = '';
    if(isset($_GET['zpo']) && ($_GET['zpo']=='on')){
        $zpo_on = 'on';
        $zpo_checked = 'checked';
    }

    $uhp_rof_on = 'off';
    $uhp_rof_checked = '';
    if(isset($_GET['uhp_rof']) && ($_GET['uhp_rof']=='on')){
        $uhp_rof_on = 'on';
        $uhp_rof_checked = 'checked';
    }

    $storeFilters = array(
        'category' => ( isset($_GET['category']) ) ? strtolower( $_GET['category'] ) : null ,
        'specialty' => ( isset($_GET['specialty']) ) ? strtolower( $_GET['specialty'] ) : null ,
        'area' => ( isset($_GET['area']) ) ? $_GET['area']  : null ,
        'state' => ( isset($_GET['state']) ) ?  $_GET['state']  : null ,
        'locale' => SITE_LOCALE,
        'dtc_zero_percent' => $zpo_on,
        'uhp_rof_tyre_available' => $uhp_rof_on,
    );

    wp_enqueue_script( "baidu.api");

    if(SITE_LOCALE=='cn'){
        wp_enqueue_script( "baidu.api");
        wp_enqueue_script( "baidu-texticon");
        wp_enqueue_script( "baidu-cluster");
        wp_enqueue_script( "baidu.area.restrict");
    }else{
        wp_enqueue_script( "google-map");
        wp_enqueue_script( "google-map-clustering");
    }

    wp_enqueue_script('findStore');
    wp_localize_script( 'findStore', 'storeFilters', $storeFilters );

?>



     <div class="row hidden-xs">
         <div class="location-filter-bar">
             <div class="col-md-2 col-sm-2  col-xs-5">
                 <select class="states">
                    <option value=""><?php echo _x('State','store-page', HATT_TEXTDOMAIN);?></option>
                </select>
            </div>
            <div class="col-md-2 col-sm-2  col-xs-5">
                <select class="areas">
                    <option value=""><?php echo _x('Area','store-page', HATT_TEXTDOMAIN);?></option>
                </select>  
            </div>
             <div class="col-md-3 col-sm-2 col-xs-2">
               <a href="#useCurrentLocation" class="currentLocation locate-me-btn disable"><?php echo _x('Locate Me','store-page', HATT_TEXTDOMAIN);?></a>
            </div>   

            <div class="col-md-5 col-sm-6 text-right  hidden-xs">
                <div class="dropdown-label"><?php echo _x('Show Results','store-page', HATT_TEXTDOMAIN);?></div>
                <select id="range" class="resultwithin">
                    <option value=""><?php echo _x(' Select distance','store-page', HATT_TEXTDOMAIN);?></option>
                    <option value="1"><?php echo _x('Within 1km','store-page', HATT_TEXTDOMAIN);?></option>
                    <option value="2"><?php echo _x('Within 2km','store-page', HATT_TEXTDOMAIN);?></option>
                    <option value="3"><?php echo _x('Within 3km','store-page', HATT_TEXTDOMAIN);?></option>
                    <option value="5"><?php echo _x('Within 5km','store-page', HATT_TEXTDOMAIN);?></option>
                    <option value="10"><?php echo _x('Within 10km','store-page', HATT_TEXTDOMAIN);?></option>
                </select>  
            </div>
        </div>
     </div>

    <div class="row visible-xs">
        <div class="col-sm-12 mobile-location-filter"> 
            <select class="states">
                <option value=""><?php echo _x('State','store-page', HATT_TEXTDOMAIN);?></option>
            </select>
            <select class="areas">
                <option value=""><?php echo _x('Area','store-page', HATT_TEXTDOMAIN);?></option>
            </select> 
            <a href="#useCurrentLocation" class="currentLocation locate-me-btn disable"><?php echo _x('Locate Me','store-page', HATT_TEXTDOMAIN);?></a>
        </div>
    </div>

    <div class="row visible-xs"> 
         <div class="filter-by-header" style="display:none">
            <div class="col-sm-3"><?php echo _x('Filter by','store-page', HATT_TEXTDOMAIN);?></div>
        </div>
    </div>

    <div class="visible-xs " >
        <div class="row" id="special-cat-filter">
            <div style="display:none">
                <div class="col-sm-3">
                    <select class="store_category">
                        <option value="-"><?php echo _x('Store category','store-page', HATT_TEXTDOMAIN);?></option>
                        <?php 
                            $store_cats = get_terms( 'store_cat' );
                            foreach( $store_cats as $store_category):
                        ?>
                            <option value="<?php echo $store_category->slug;?>"><?php echo $store_category->name;?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if( SITE_LOCALE == 'cn') :?>
                    <select class="specialty">
                        <option value=""><?php echo _x('Specialty','store-page', HATT_TEXTDOMAIN);?></option>
                    </select>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="store-map-container"> 
        <div class="col-md-12">
            <div id="store-map"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-3 hidden-xs" style="display:none"> 
            <strong class="dropdown-label"><?php echo _x('Filter by','store-page', HATT_TEXTDOMAIN);?></strong>
        </div>
        <div class="col-md-4 col-sm-4  col-xs-12" >
            <strong class="dropdown-label"><?php echo _x('<span id="total_result"></span> results found','store-page', HATT_TEXTDOMAIN);?>  </strong>
            <div class="dtc_zero_percent_box rof_box">
                <label><input name="filterstore_dtc_zero_percent" id="filterstore_dtc_zero_percent" type="checkbox" value="on" <?php echo $zpo_checked; ?> > <?php echo _x('Show only stores with 0% interest payment plans','store-page', HATT_TEXTDOMAIN);?> </label>
            </div>

            <div class="uhp_rof_tyre_available_box rof_box">
                <label><input name="filterstore_uhp_rof_tyre_available" id="filterstore_uhp_rof_tyre_available" type="checkbox" value="on" <?php echo $uhp_rof_checked; ?> > <?php echo _x('Show only stores with UHP and ROF Tyres','store-page', HATT_TEXTDOMAIN);?> </label>
            </div>
            
        </div>

        <div class="col-md-5 col-sm-5  col-xs-5 text-right  hidden-xs">
            <label class="dropdown-label"><?php echo _x('Number of results','store-page', HATT_TEXTDOMAIN);?></label>
            <select id="post-per-page" class="year">
                <option value="207">All</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3  col-sm-3  hidden-xs store-filter-desktop">

            <div id="india-store-location-filter">
            <select class="states">
                <option value=""><?php echo _x('State','store-page', HATT_TEXTDOMAIN);?></option>
            </select>
            <select class="areas">
                <option value=""><?php echo _x('Area','store-page', HATT_TEXTDOMAIN);?></option>
            </select> 
            </div>


            <select class="store_category" style="display:none">
                <option value="-"><?php echo _x('Store category','store-page', HATT_TEXTDOMAIN);?></option>
                <?php 
                    $store_cats = get_terms( 'store_cat' );
                    foreach( $store_cats as $store_category):
                ?>
                    <option value="<?php echo $store_category->slug;?>"><?php echo $store_category->name;?></option>
                <?php endforeach; ?>
            </select>
            <?php if( SITE_LOCALE == 'cn') :?>
            <select class="specialty">
                <option value=""><?php echo _x('Specialty','store-page', HATT_TEXTDOMAIN);?></option>
            </select>
            <?php endif;?>
        </div>


         <div class="col-md-12 col-sm-12 col-xs-12">

                <div id="store_template" style="display: none;">
                    <div class="store-box">
                        <h3><a href="#" class="store-title"></a></h3>                         
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="get-direction"><a href="#" target="_blank" class="store-map-link"><?php echo _x('Get Directions','store-page', HATT_TEXTDOMAIN);?></a></p>
                            </div>
                            <div class="col-sm-4">
                                <p class="address">
                                    <span class="store-address"></span><br>

                                </p>
                            </div>
                            <div class="col-sm-4">
                                <p class="phone hidden-xs">
									<a href="#" class="store-contact"></a>
								</p>
                            </div>
                            <div class="col-sm-4">
                                <p class="whatsapplink hidden-xs store-contact"></p>
                            </div>							
                            <div class="col-sm-4 hidden-xs">
                                 <p class="store-category"></p>
                            </div>
                        </div>  

                        <div class="row">
                            <div class="col-sm-12 store-zpo-uhp"></div>
                            <div class="col-sm-12 col-lg-4 store-zpo visible-xs"></div>
                            <div class="col-sm-12 col-lg-4 store-uhp visible-xs"></div>                           
                        </div>


                        <div class="row col-sm-12">
                            <p class="phone visible-xs"> 
                                <a href="#" class="store-contact"></a>
                            </p>                            
                        </div> 
						
                        <div class="row col-sm-12">
                            <p class="whatsapplink visible-xs">
                                <a href="#" class="store-contact"></a>
                            </p>                            
                        </div> 



                    </div>    
                </div>

                <div style="display: none;">
                    <div id="no-result-found"><?php echo _x('No results found','store-page', HATT_TEXTDOMAIN);?></div>
                </div>

                <section id="store-list"></section>  

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="pagination_div font- text-center" id="store-pagination"></div>
                    </div>
                </div>
         </div>
    </div>

 
	