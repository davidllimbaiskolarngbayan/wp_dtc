<?php
/**
 * Contact Form 7 configuration for the public Contact Us form.
 */

if (!function_exists('dtc_contact_smtp_settings')) {
    function dtc_contact_smtp_settings()
    {
        static $settings = null;
        static $loaded = false;

        if ($loaded) {
            return $settings;
        }

        $loaded = true;
        $app_root = trailingslashit(dirname(untrailingslashit(ABSPATH))) . 'dtc';
        $autoload_path = $app_root . '/vendor/autoload.php';

        if (!is_readable($app_root . '/.env') || !is_readable($autoload_path)) {
            error_log('DTC SMTP configuration is unavailable: the sibling DTC .env or Composer autoloader is missing.');
            return null;
        }

        require_once $autoload_path;

        if (!class_exists('Dotenv\\Dotenv')) {
            error_log('DTC SMTP configuration is unavailable: phpdotenv could not be loaded.');
            return null;
        }

        \Dotenv\Dotenv::createMutable($app_root)->safeLoad();

        $get_env = static function ($key) {
            if (isset($_ENV[$key])) {
                return trim((string) $_ENV[$key]);
            }

            if (isset($_SERVER[$key])) {
                return trim((string) $_SERVER[$key]);
            }

            $value = getenv($key);

            return $value === false ? '' : trim((string) $value);
        };

        $mailer = strtolower($get_env('MAIL_MAILER'));
        $host = $get_env('MAIL_HOST');
        $port = filter_var($get_env('MAIL_PORT'), FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 65535],
        ]);
        $username = $get_env('MAIL_USERNAME');
        $password = $get_env('MAIL_PASSWORD');
        $from = $get_env('MAIL_FROM_ADDRESS');
        $encryption = strtolower($get_env('MAIL_ENCRYPTION'));

        if (
            $mailer !== 'smtp'
            || $host === ''
            || $port === false
            || $username === ''
            || $username === 'null'
            || $password === ''
            || $password === 'null'
            || !is_email($from)
        ) {
            error_log('DTC SMTP configuration is incomplete or invalid; Contact Form 7 mail will fail instead of using an unconfigured fallback.');
            return null;
        }

        if (!in_array($encryption, ['tls', 'ssl'], true)) {
            error_log('DTC SMTP encryption must be set to tls or ssl in the DTC .env file.');
            return null;
        }

        $settings = [
            'host' => $host,
            'port' => $port,
            'username' => $username,
            'password' => $password,
            'encryption' => $encryption,
            'from' => $from,
            'from_name' => $get_env('MAIL_FROM_NAME') ?: get_bloginfo('name'),
        ];

        return $settings;
    }
}

add_filter('wpcf7_contact_form_properties', function ($properties, $contact_form) {
    if (!$contact_form instanceof WPCF7_ContactForm || (int) $contact_form->id() !== 14) {
        return $properties;
    }

    $properties['form'] =
        '<header class="dtc-contact-heading">
            <p class="dtc-contact-eyebrow">We are here to help</p>
            <h1>Contact Us</h1>
            <p>Have a question or need assistance? Send us a message and our team will get back to you.</p>
        </header>
        <div class="dtc-contact-fields">
            <h2 class="dtc-contact-panel-title">Email Us</h2>
            <div class="dtc-contact-field"><label for="dtc-contact-first-name">FIRST NAME* [text* first-name id:dtc-contact-first-name autocomplete:given-name placeholder "First Name"]</label></div>
            <div class="dtc-contact-field"><label for="dtc-contact-last-name">LAST NAME* [text* last-name id:dtc-contact-last-name autocomplete:family-name placeholder "Last Name"]</label></div>
            <div class="dtc-contact-field"><label for="dtc-contact-phone">PHONE* [tel* phone id:dtc-contact-phone class:dtc-contact-digits autocomplete:tel minlength:11 maxlength:11 placeholder "Phone Number"]</label></div>
            <div class="dtc-contact-field"><label for="dtc-contact-postcode">POSTCODE* [text* postcode id:dtc-contact-postcode class:dtc-contact-digits autocomplete:postal-code minlength:4 maxlength:4 placeholder "Postcode"]</label></div>
            <div class="dtc-contact-field dtc-contact-field--full"><label for="dtc-contact-email">EMAIL* [email* your-email id:dtc-contact-email autocomplete:email placeholder "Email"]</label></div>
            <div class="dtc-contact-field dtc-contact-field--full"><label for="dtc-contact-subject">SUBJECT* [text* your-subject id:dtc-contact-subject placeholder "Type here"]</label></div>
            <div class="dtc-contact-field dtc-contact-field--full"><label for="dtc-contact-message">QUESTIONS OR COMMENTS* [textarea* your-message id:dtc-contact-message placeholder "Type Here"]</label></div>
            <div class="dtc-contact-field dtc-contact-field--full dtc-contact-consent">[acceptance privacy-policy] I have read and agree to the <button class="dtc-contact-privacy-link" type="button">Privacy Policy</button> [/acceptance]</div>
            <div class="dtc-contact-field dtc-contact-field--full dtc-contact-submit">[submit "Submit"]</div>
        </div>';

    $properties['messages']['validation_error'] = 'Please check the highlighted fields and correct the errors below.';
    $properties['messages']['invalid_email'] = 'Please enter a valid email address.';
    $properties['mail']['subject'] = 'Contact Us: [your-subject]';
    $properties['mail']['use_html'] = true;
    $properties['mail']['body'] = sprintf(
        '<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contact Us</title>
</head>
<body style="margin:0;padding:30px 12px;background:#fff;font-family:Arial,Helvetica,sans-serif;color:#15191d;">
<table role="presentation" width="100%%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
<tr><td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%%;max-width:600px;border:1px solid #e4e4e4;border-radius:4px;border-collapse:separate;">
<tr><td style="padding:38px 42px 36px;">
<table role="presentation" width="100%%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
<tr><td align="center" style="padding:0 0 16px;">
<img src="%1$s" width="280" alt="David Tyre Company" style="display:block;width:280px;max-width:100%%;height:auto;border:0;">
</td></tr>
<tr><td align="center" style="padding:0 0 2px;font-size:22px;line-height:28px;font-weight:bold;color:#111;">Contact Us</td></tr>
<tr><td style="border-bottom:1px solid #e3e6e8;font-size:1px;line-height:1px;">&nbsp;</td></tr>
</table>

<table role="presentation" width="100%%" cellpadding="0" cellspacing="0" border="0" style="margin-top:32px;border-collapse:separate;border-spacing:0;background:#f5f5f5;border-radius:14px;">
<tr>
<td colspan="2" style="padding:20px 20px 8px;font-size:16px;line-height:22px;font-weight:bold;color:#17191b;">Name</td>
</tr>
<tr>
<td colspan="2" style="padding:0 20px 14px 40px;font-size:16px;line-height:22px;color:#626a72;">[first-name] [last-name]</td>
</tr>
<tr>
<td width="50%%" valign="top" style="padding:10px 10px 14px 20px;">
<div style="font-size:16px;line-height:22px;font-weight:bold;color:#17191b;">Phone Number</div>
<div style="padding:5px 0 0 20px;font-size:16px;line-height:22px;color:#626a72;">[phone]</div>
</td>
<td width="50%%" valign="top" style="padding:10px 20px 14px 10px;">
<div style="font-size:16px;line-height:22px;font-weight:bold;color:#17191b;">Postcode</div>
<div style="padding:5px 0 0 20px;font-size:16px;line-height:22px;color:#626a72;">[postcode]</div>
</td>
</tr>
<tr><td colspan="2" style="padding:0 20px 20px;">
<div style="font-size:16px;line-height:22px;font-weight:bold;color:#17191b;">E-mail Address</div>
<div style="padding:5px 0 0 20px;font-size:16px;line-height:22px;color:#626a72;word-break:break-word;">[your-email]</div>
</td></tr>
</table>

<table role="presentation" width="100%%" cellpadding="0" cellspacing="0" border="0" style="margin-top:20px;border-collapse:separate;border-spacing:0;background:#f5f5f5;border-radius:14px;">
<tr><td width="165" valign="top" style="width:165px;padding:20px 0 8px 20px;font-size:16px;line-height:22px;font-weight:bold;color:#17191b;">Subject</td>
<td valign="top" style="padding:20px 20px 8px 0;font-size:16px;line-height:22px;color:#626a72;">[your-subject]</td></tr>
<tr><td width="165" valign="top" style="width:165px;padding:0 0 8px 20px;font-size:16px;line-height:22px;font-weight:bold;color:#17191b;">Questions or Comments</td>
<td valign="top" style="padding:0 20px 20px 0;font-size:16px;line-height:22px;color:#626a72;white-space:pre-wrap;">[your-message]</td></tr>
</table>

<table role="presentation" width="100%%" cellpadding="0" cellspacing="0" border="0" style="margin-top:34px;border-collapse:collapse;">
<tr><td style="border-top:1px solid #d9dde0;padding-top:5px;text-align:center;font-size:14px;line-height:20px;font-style:italic;color:#87909a;">This e-mail was sent from the contact form on David Tyre Company</td></tr>
</table>
</td></tr>
</table>
</td></tr>
</table>
</body>
</html>',
        'cid:dtc-contact-logo'
    );
    $properties['mail']['additional_headers'] = "Reply-To: [your-email]";

    $additional_settings = (string) $properties['additional_settings'];
    if (!preg_match('/^\s*acceptance_as_validation\s*:/mi', $additional_settings)) {
        $properties['additional_settings'] = trim($additional_settings . "\nacceptance_as_validation: on");
    }

    return $properties;
}, 20, 2);

add_action('phpmailer_init', function ($mailer) {
    if (!$mailer instanceof PHPMailer\PHPMailer\PHPMailer) {
        return;
    }

    $submission = class_exists('WPCF7_Submission') ? WPCF7_Submission::get_instance() : null;
    $contact_form = $submission ? $submission->get_contact_form() : null;
    if (!$contact_form instanceof WPCF7_ContactForm || (int) $contact_form->id() !== 14) {
        return;
    }

    $logo_path = get_template_directory() . '/images/dtc-logo-email.png';
    if (!is_readable($logo_path)) {
        error_log('Contact Us email logo is missing or unreadable: ' . $logo_path);
        return;
    }

    if (!$mailer->addEmbeddedImage($logo_path, 'dtc-contact-logo', 'dtc-logo-email.png', 'base64', 'image/png')) {
        error_log('Contact Us email logo could not be embedded: ' . $mailer->ErrorInfo);
    }
});

add_action('wp_footer', function () {
    if (!is_page('contact-us') && !is_page('contact')) {
        return;
    }

    $privacy_page = get_page_by_path('privacy-policy');
    if (!$privacy_page || $privacy_page->post_status !== 'publish') {
        error_log('Contact Us Privacy Policy modal could not render: the published Privacy Policy page is missing.');
        return;
    }

    $original_post = isset($GLOBALS['post']) ? $GLOBALS['post'] : null;
    $GLOBALS['post'] = $privacy_page;
    setup_postdata($privacy_page);
    $privacy_content = apply_filters('the_content', $privacy_page->post_content);
    wp_reset_postdata();
    if ($original_post) {
        $GLOBALS['post'] = $original_post;
        setup_postdata($original_post);
    }
    ?>
    <div id="dtc-contact-privacy-modal" class="dtc-privacy-modal" hidden>
        <div class="dtc-privacy-modal__dialog" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Privacy Policy', HATT_TEXTDOMAIN); ?>">
            <button class="dtc-privacy-modal__close" type="button" aria-label="<?php esc_attr_e('Close Privacy Policy', HATT_TEXTDOMAIN); ?>">&times;</button>
            <div class="dtc-privacy-modal__content" tabindex="0">
                <article class="dtc-legal-page__content">
                    <h1><?php echo esc_html(get_the_title($privacy_page)); ?></h1>
                    <?php echo $privacy_content; // WordPress-rendered published page content. ?>
                </article>
            </div>
        </div>
    </div>
    <?php
}, 20);

add_action('wp_footer', function () {
    if (!is_page('contact-us') && !is_page('contact')) {
        return;
    }
    ?>
    <div id="dtc-contact-success-modal" class="dtc-contact-modal" hidden>
        <div class="dtc-contact-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="dtc-contact-success-title">
            <button class="dtc-contact-modal__close" type="button" aria-label="<?php esc_attr_e('Close confirmation', HATT_TEXTDOMAIN); ?>">&times;</button>
            <div class="dtc-contact-modal__body">
                <div class="dtc-contact-modal__message">
                    <div class="dtc-contact-modal__heading">
                        <span class="dtc-contact-modal__check" aria-hidden="true">
                            <svg viewBox="0 0 48 48" focusable="false">
                                <path d="M10 24.5 20 34l19-21" />
                            </svg>
                        </span>
                        <h2 id="dtc-contact-success-title">Thank you<br>for your enquiry!</h2>
                    </div>
                    <span class="dtc-contact-modal__accent" aria-hidden="true"></span>
                    <p>A member of our team will be in contact with you.</p>
                </div>
                <div class="dtc-contact-modal__brand">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/dtc-logo.svg?ver=' . filemtime(get_template_directory() . '/images/dtc-logo.svg')); ?>" alt="David Tyre Company">
                </div>
            </div>
        </div>
    </div>
    <?php
}, 21);

add_filter('wpcf7_validate', function ($result, $tags) {
    $contact_form = wpcf7_get_current_contact_form();
    if (!$contact_form instanceof WPCF7_ContactForm || (int) $contact_form->id() !== 14) {
        return $result;
    }

    $submission = WPCF7_Submission::get_instance();
    if (!$submission) {
        return $result;
    }

    foreach ($tags as $tag) {
        if (!in_array($tag->name, ['phone', 'postcode', 'your-email'], true)) {
            continue;
        }

        $value = $submission->get_posted_string($tag->name);
        if ($value === '') {
            continue;
        }

        if ($tag->name === 'your-email') {
            if (!is_email($value)) {
                $result->invalidate($tag, 'Please enter a valid email address.');
            }
            continue;
        }

        $pattern = $tag->name === 'phone' ? '/\A[0-9]{11}\z/' : '/\A[0-9]{4}\z/';
        if (!preg_match($pattern, $value)) {
            $message = $tag->name === 'phone'
                ? 'Please enter an 11-digit phone number using numbers only.'
                : 'Please enter a 4-digit postcode using numbers only.';
            $result->invalidate($tag, $message);
        }
    }

    return $result;
}, 10, 2);

add_filter('wpcf7_validation_error', function ($error, $name, $contact_form) {
    if (!$contact_form instanceof WPCF7_ContactForm || (int) $contact_form->id() !== 14) {
        return $error;
    }

    $submission = WPCF7_Submission::get_instance();
    $value = $submission ? $submission->get_posted_data($name) : '';
    $has_value = is_array($value) ? !empty($value) : trim((string) $value) !== '';

    $messages = [
        'first-name' => 'Please enter your first name.',
        'last-name' => 'Please enter your last name.',
        'phone' => $has_value ? 'Please enter an 11-digit phone number using numbers only.' : 'Please enter your phone number.',
        'postcode' => $has_value ? 'Please enter a 4-digit postcode using numbers only.' : 'Please enter your postcode.',
        'your-email' => $has_value ? 'Please enter a valid email address.' : 'Please enter your email address.',
        'your-subject' => 'Please enter a subject.',
        'your-message' => 'Please enter your question or comment.',
        'privacy-policy' => 'Please agree to the Privacy Policy.',
    ];

    if (!isset($messages[$name])) {
        return $error;
    }

    return sprintf(
        '<span class="wpcf7-not-valid-tip" aria-hidden="true">%s</span>',
        esc_html($messages[$name])
    );
}, 10, 3);

add_filter('wpcf7_mail_components', function ($components, $contact_form) {
    if (!$contact_form instanceof WPCF7_ContactForm || (int) $contact_form->id() !== 14) {
        return $components;
    }

    $components['recipient'] = 'davidlimba19@gmail.com';

    return $components;
}, 10, 3);