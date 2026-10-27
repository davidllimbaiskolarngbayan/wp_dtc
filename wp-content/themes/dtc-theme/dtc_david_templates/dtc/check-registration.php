<div id="message"></div>
<form id="dtc-check-registry-form" class="dtc-form" data-parsely-validate="" method="POST">
    <div class="panel">

        <!-- CHECK WARRANTY REGISTRATION -->
        <div class="panel-heading"> <h3 class="panel-header"> Verify your Registration </h3></div> <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="col-md-12">				
                <div class="row">
                    <div class="col-md-4 dtc-section">
                        <p class="dtc-title-header"> Enter the DTC Code or Vehicle Plate Number <br/> </p>
                        <div class="form-group">
                            <input type="text" name="dtc_code" id="dtc_code" value="" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" placeholder="DTC Code">
						</div> <!-- /.form-group -->    

                        <!--div class="form-group">
							<div class="g-recaptcha" data-sitekey="6LefzxIUAAAAAO_HvcRh6e5xpoXdrj9dLdecBwpD"></div>
						</div--> <!-- /.form-group -->    
						
                    </div> <!-- /.col-md-6 dtc-section -->
                </div><!-- /.row -->
				
                <div id="result" class="row">

                </div><!-- /.row -->
				

            </div> <!-- /.col-md-12 dtc-section -->

        </div> <!-- /.panel-body -->

    </div> <!-- /.panel -->
    <input type="hidden" id="ajax-nonce" value="<?php echo wp_create_nonce( 'inno-tyrenonce' ); ?>" />
    <!-- SUBMIT FORM -->
    <div class="row hidden-xs hidden-sm">
        <p class="form-submit text-right col-md-3 pull-right">
            <input type="submit" value="<?php _e('SUBMIT', HATT_TEXTDOMAIN); ?>" class="wpcf7-form-control wpcf7-submit" style="margin-top: 0px; margin-bottom: 1.8em;">
        </p> <!-- /.form-submit -->
        <!-- </div> --> <!-- /.col-sm-3 -->
    </div> <!-- /.row -->

    <div class="row visible-xs" style="margin: -35px -15px -25px">
    	<br>
    	<!-- <button type="submit" class="gy-btn yellow-btn"><?php _e('SUBMIT', HATT_TEXTDOMAIN); ?></button> -->
        <p class="form-submit text-left col-md-3">
            <input type="submit" value="<?php _e('SUBMIT', HATT_TEXTDOMAIN); ?>" class="wpcf7-form-control wpcf7-submit" style="margin-top: 0px; padding-left: 25px !important; padding-bottom: 35px; border: 0px; font-size: 18px; color: #000;">
        </p> <!-- /.form-submit -->
    </div>

    <div class="row visible-sm" style="margin: -30px -50px -1px;">
    	<br>
    	<button type="submit" class="gy-btn yellow-btn"><?php _e('SUBMIT', HATT_TEXTDOMAIN); ?></button>
    </div>

</form>