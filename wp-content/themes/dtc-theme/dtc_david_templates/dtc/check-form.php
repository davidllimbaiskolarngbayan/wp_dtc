<section class="dtc-check">
    <div class="dtc-check__grid">
        <div class="dtc-check__main">
            <p class="dtc-check__eyebrow"><?php _e('Warranty', HATT_TEXTDOMAIN); ?></p>
            <h1 class="dtc-check__title"><?php _e('Check your warranty', HATT_TEXTDOMAIN); ?></h1>
            <p class="dtc-check__lead"><?php _e('Enter the DTC Code or the plate number you registered with to see your tyres, warranty details, and claim status history.', HATT_TEXTDOMAIN); ?></p>

            <form id="dtc-check-registry-form" class="dtc-check__form" data-parsely-validate="" method="POST" novalidate>
                <label class="dtc-check__label" for="dtc_code"><?php _e('DTC card or plate number', HATT_TEXTDOMAIN); ?></label>
                <div class="dtc-check__row">
                    <input type="text" name="dtc_code" id="dtc_code" value="" maxlength="64" autocomplete="off" required placeholder="<?php esc_attr_e('e.g. 12345678 or ABC1234', HATT_TEXTDOMAIN); ?>" data-parsley-required-message="<?php esc_attr_e('Please enter your DTC card or plate number', HATT_TEXTDOMAIN); ?>">
                    <button type="submit" class="dtc-check__submit"><?php _e('Check', HATT_TEXTDOMAIN); ?></button>
                </div>
                <input type="hidden" id="ajax-nonce" value="<?php echo esc_attr(wp_create_nonce('inno-tyrenonce')); ?>" />
            </form>
            <p class="dtc-check__help">Need help with coverage or a claim? <a href="<?php echo esc_url(home_url('/warranty-guide/')); ?>">Read the warranty and claim guide</a> or <a href="<?php echo esc_url(home_url('/register-your-tyres/')); ?>">register your tyres</a>.</p>
            <div id="message"></div>
        </div>

        <figure class="dtc-check__figure" aria-hidden="true">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" focusable="false">
                <circle cx="200" cy="210" r="160" fill="#151821"/>
                <circle cx="200" cy="210" r="128" fill="#262b38"/>
                <circle cx="200" cy="210" r="96" fill="none" stroke="#323849" stroke-width="3"/>
                <path d="M200 66 L316 108 V214 C316 286 264 336 200 362 C136 336 84 286 84 214 V108 Z" fill="#0b2a63" stroke="#fbbd00" stroke-width="8" stroke-linejoin="round"/>
                <path d="M146 214 L186 254 L258 172" fill="none" stroke="#fff" stroke-width="22" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </figure>
    </div>

    <div id="result" class="dtc-check__results"></div>
</section>
