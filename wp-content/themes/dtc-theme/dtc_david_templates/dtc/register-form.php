<link rel="stylesheet" type="text/css" href="/wp-content/themes/dtc-theme/css/font-awesome.min.css">
<link rel="stylesheet" href="/wp-content/themes/dtc-theme/css/jquery-ui.css">
<?php

extract($dropdowns);
extract($data);
$promoSettings = dtc_efuel_promo_settings();

?>
<div id="dtc-register-wrapper" class="dtc">
    <div id="message" role="alert" aria-live="polite"></div>

    <form id="dtc-register-form" autocomplete="off" data-parsley-validate="" method="POST" enctype="multipart/form-data">
        <header class="dtc-form-heading">
            <p class="dtc-form-eyebrow">Warranty registration</p>
            <h1><?php _e('Register Your Tyres', HATT_TEXTDOMAIN); ?></h1>
            <p>Protect your purchase with David Tyre Company. Complete the details below to register your warranty.</p>
            <p class="dtc-register-help">Need help? <a href="<?php echo esc_url(home_url('/warranty-guide/')); ?>">Read the warranty guide</a> or <a href="<?php echo esc_url(function_exists('dtc_store_url') ? dtc_store_url() : home_url('/store/')); ?>">find a partner store</a>.</p>
        </header>

        <div class="dtc-panel">
            <h3 class="dtc-panel-header"><span class="dtc-panel-step" aria-hidden="true">01</span><?php _e('Your Details', HATT_TEXTDOMAIN); ?></h3>
            <div class="dtc-panel-body dtc-grid">
                <div class="dtc-section">
                    <p class="dtc-title-header"><?php _e('Your Name', HATT_TEXTDOMAIN); ?></p>
                    <input class="alphaonly" type="text" name="first_name" placeholder="* <?php _e('First Name', HATT_TEXTDOMAIN); ?>" required maxlength="100" autocomplete="given-name" aria-label="First name" data-parsley-required-message="Please enter your first name">
                    <input class="alphaonly" type="text" name="last_name" placeholder="* <?php _e('Last Name', HATT_TEXTDOMAIN); ?>" required maxlength="100" autocomplete="family-name" aria-label="Last name" data-parsley-required-message="Please enter your last name">
                </div>
                <div class="dtc-section">
                    <p class="dtc-title-header"><?php _e('Contact Details', HATT_TEXTDOMAIN); ?></p>
                    <input type="text" name="phone_no" id="phone_no" placeholder="* <?php _e('Phone / Tel. No', HATT_TEXTDOMAIN); ?>" required maxlength="30" pattern="[0-9+\-\s()]{6,30}" autocomplete="tel" aria-label="Phone number" data-parsley-required-message="Please enter your phone number">
                    <input type="email" name="email" placeholder="* <?php _e('Email (user@gmail.com)', HATT_TEXTDOMAIN); ?>" required autocomplete="email" aria-label="Email" data-parsley-required-message="Please enter your email address" data-parsley-type-message="Please enter a valid email address">
                    <p class="help-block">Your email is required for registration and claim follow-up updates. Please use an address you can access.</p>
                </div>
            </div>
        </div>

        <div class="dtc-panel">
            <h3 class="dtc-panel-header"><span class="dtc-panel-step" aria-hidden="true">02</span><?php _e('Purchase &amp; Tyre Details', HATT_TEXTDOMAIN); ?></h3>
            <div class="dtc-panel-body dtc-grid dtc-grid-3">
                <div class="dtc-section">
                    <p class="dtc-title-header"><?php _e('About your vehicle', HATT_TEXTDOMAIN); ?></p>
                    <input type="text" name="vehicle_reg_id" id="vehicle_reg_id"
                        placeholder="* <?php _e('Registration Plate Number', HATT_TEXTDOMAIN); ?>"
                        required
                        maxlength="14"
                        style="text-transform:uppercase"
                        pattern="[A-Z0-9]{1,14}"
                        aria-label="Registration plate number"
                        oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0,14);"
                        data-parsley-required-message="Please enter your registered plate number"
                        data-parsley-pattern="^[A-Z0-9]{1,14}$"
                        data-parsley-pattern-message="Only capital letters and numbers, max 14 characters">
                    <p id="plateNumErrorMsg" style="color: red; margin-bottom: 0;"></p>
                    <input type="text" name="brand" id="brand" maxlength="100" required placeholder="* <?php _e('Brand', HATT_TEXTDOMAIN); ?>" aria-label="Vehicle brand" style="margin-top:.75rem" data-parsley-required-message="Please enter your vehicle brand">
                    <input type="text" name="model" id="model" maxlength="100" required placeholder="* <?php _e('Model', HATT_TEXTDOMAIN); ?>" aria-label="Vehicle model" data-parsley-required-message="Please enter your vehicle model">
                    <input type="number" name="mileage" id="mileage" min="0" max="2000000" required placeholder="* <?php _e('Mileage', HATT_TEXTDOMAIN); ?>" aria-label="Mileage" data-parsley-required-message="Please enter your vehicle mileage">
                </div>

                <div class="dtc-section">
                    <p class="dtc-title-header"><?php _e('About your tyres', HATT_TEXTDOMAIN); ?></p>
                    <select name="product_model" id="product_model" required aria-label="Product model" data-parsley-required-message="Please select your tyre model">
                        <option value="">* <?php _e('Product Model', HATT_TEXTDOMAIN); ?></option>
                        <?php foreach ((array) $product_model as $key => $pm) { ?>
                            <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($pm); ?></option>
                        <?php } ?>
                    </select>
                    <select name="tyre_size" id="tyre_size" required disabled aria-label="Tyre size" data-parsley-required-message="Please select your tyre size">
                        <option value="">* <?php _e('Tyre Size', HATT_TEXTDOMAIN); ?></option>
                    </select>
                    <select id="diameter" name="diameter" class="rim-size" required disabled aria-label="Rim size" data-parsley-required-message="Please select the rim size of your tyre">
                        <option value="">* <?php _e('Rim Size', HATT_TEXTDOMAIN); ?></option>
                    </select>
                    <script type="application/json" id="dtc-register-sizes"><?php echo wp_json_encode((object) $size_map, JSON_HEX_TAG | JSON_HEX_AMP); ?></script>
                    <select id="qty" name="qty" required aria-label="Quantity" data-parsley-required-message="Please select the number of tyres purchased">
                        <option value="">* <?php _e('Quantity', HATT_TEXTDOMAIN); ?></option>
                        <?php for ($i = 1; $i <= 4; $i++) { ?>
                            <option value="<?php echo (int) $i; ?>"><?php echo (int) $i; ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="date_of_purchase" id="date_purchase_picker" required readonly placeholder="* <?php _e('Date of Purchase', HATT_TEXTDOMAIN); ?>" aria-label="Date of purchase" data-parsley-required-message="Please select the date of purchase">
                    <input type="text" name="receipt" id="receipt" maxlength="25" required placeholder="* <?php _e('Receipt Number', HATT_TEXTDOMAIN); ?>" aria-label="Receipt number" data-parsley-required-message="Please enter your receipt number">
                </div>

                <div class="dtc-section">
                    <p class="dtc-title-header"><?php _e('Store', HATT_TEXTDOMAIN); ?></p>
                    <select name="province" id="province" required aria-label="State or province" data-parsley-required-message="Please select the store province">
                        <option value="">* <?php _e('State / Province', HATT_TEXTDOMAIN); ?></option>
                        <?php foreach (array_keys($store_map) as $province_name) { ?>
                            <option value="<?php echo esc_attr($province_name); ?>" <?php selected($registration_store['province'] ?? '', $province_name); ?>><?php echo esc_html($province_name); ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" id="store_slug" name="store_slug" value="<?php echo esc_attr($store_slug ?? ''); ?>">
                    <input type="hidden" name="area" value="">
                    <input type="hidden" name="others_area" value="">
                    <input type="hidden" name="others_dealer" value="">
                    <select name="find_retailer" id="find_retailer" required disabled aria-label="Dealer or store name" data-parsley-required-message="Please select the store where you bought your tyres">
                        <option value="">* <?php _e('Dealer / Store name', HATT_TEXTDOMAIN); ?></option>
                    </select>
                    <script type="application/json" id="dtc-register-stores" data-selected-store="<?php echo esc_attr($registration_store['name'] ?? ''); ?>"><?php echo wp_json_encode((object) $store_map, JSON_HEX_TAG | JSON_HEX_AMP); ?></script>

                    <p class="dtc-title-header dtc-code-label"><?php _e('DTC Code', HATT_TEXTDOMAIN); ?></p>
                    <input type="text" name="dtc_card_no" id="dtc_card_no" maxlength="8" required autocomplete="off" placeholder="* <?php _e('DTC CODE', HATT_TEXTDOMAIN); ?>" aria-label="DTC Code" aria-describedby="dtc-card-message" data-parsley-required-message="Please enter your DTC Code">
                    <p id="dtc-card-message" class="dtc-field-message" role="status" aria-live="polite"></p>
                </div>
            </div>

            <div class="dtc-promo-registration" id="dtc-promo-registration" hidden>
                <input type="hidden" name="validpromo" id="valid-promo" value="0">
                <div class="dtc-promo-registration__banner">
                    <p class="dtc-promo-registration__eyebrow" id="dtc-promo-eyebrow">eFuel Voucher</p>
                    <h3 id="dtc-promo-title">Get a &#8369;<?php echo number_format_i18n($promoSettings['voucher_amount']); ?> eFuel voucher</h3>
                    <p id="dtc-promo-description">Buy four qualifying tyres with rim size <?php echo (int) $promoSettings['minimum_rim']; ?> inches or above. Eligible purchases must be made from <?php echo esc_html(mysql2date('F j, Y', $promoSettings['start_date'])); ?> to <?php echo esc_html(mysql2date('F j, Y', $promoSettings['end_date'])); ?> at a participating DTC store. Your registration and invoice will be reviewed before approval.</p>
                </div>
                <div class="dtc-promo-registration__fields">
                    <label for="promo-assisted-person">Assisted Person</label>
                    <input type="text" id="promo-assisted-person" name="promo[assisted_person]" maxlength="100" autocomplete="off" data-parsley-required-message="Please enter the assisted person's name">

                    <label class="dtc-promo-registration__file-label" for="promo-invoice">Upload your sales invoice or receipt</label>
                    <input type="file" id="promo-invoice" name="invoice" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf" data-parsley-required-message="Please upload your sales invoice or receipt">
                    <p class="dtc-promo-registration__help">Accepted: JPG, PNG, or PDF. Maximum file size: 5 MB.</p>

                    <label class="dtc-promo-registration__consent">
                        <input type="checkbox" id="promo-confirm" name="promo[confirm]" value="1" data-parsley-required-message="Please confirm your registration details match your sales invoice">
                        <span>I confirm that my registration details are accurate and match my sales invoice.</span>
                    </label>
                    <label class="dtc-promo-registration__consent">
                        <input type="checkbox" id="promo-terms" name="promo[terms]" value="1" data-parsley-required-message="Please acknowledge the promotion terms">
                        <span>I understand that voucher eligibility is subject to verification and the promotion terms.</span>
                    </label>
                </div>
            </div>

            <div class="dtc-panel-body dtc-consent">
                <label><input type="checkbox" id="tnc" name="tnc" value="1" required data-parsley-required-message="Please read and agree to the Terms &amp; Conditions and Privacy Policy"> <?php _e('I have read and agree with the Terms & Conditions and Privacy Policy.', HATT_TEXTDOMAIN); ?></label>
                <label><input type="checkbox" id="subscribe" name="subscribe" value="1" checked> <?php _e("Yes, I'd like to receive updates by email.", HATT_TEXTDOMAIN); ?></label>
            </div>
        </div>

        <input type="hidden" id="ajax-nonce" value="<?php echo esc_attr(wp_create_nonce('inno-tyrenonce')); ?>" />
        <input type="hidden" name="dtc_tyres" value="<?php echo esc_attr($data['ht_dtc_tyres']); ?>" />
        <input type="submit" value="<?php _e('SUBMIT', HATT_TEXTDOMAIN); ?>" class="dtc-btn"/>
    </form>
</div>
