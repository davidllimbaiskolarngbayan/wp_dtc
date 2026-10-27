<?php

add_action('wp_ajax_nopriv_dtc_submit_claim', 'dtc_submit_claim');
add_action('wp_ajax_dtc_submit_claim', 'dtc_submit_claim');
add_action('wp_ajax_nopriv_dtc_customer_claim_response', 'dtc_customer_claim_response');
add_action('wp_ajax_dtc_customer_claim_response', 'dtc_customer_claim_response');

function dtc_customer_claim_response(): void
{
    check_ajax_referer('inno-tyrenonce', 'security');

    if (! defined('DTC_API_URL') || ! defined('DTC_API_KEY')) {
        wp_send_json_error(['message' => 'Claim updates are temporarily unavailable.'], 503);
    }

    $payload = [
        'dtc_card_no' => sanitize_text_field(wp_unslash($_POST['dtc_card_no'] ?? '')),
        'vehicle_reg_id' => sanitize_text_field(wp_unslash($_POST['vehicle_reg_id'] ?? '')),
        'claim_number' => sanitize_text_field(wp_unslash($_POST['claim_number'] ?? '')),
        'message' => sanitize_textarea_field(wp_unslash($_POST['message'] ?? '')),
    ];

    if (! $payload['dtc_card_no'] || ! $payload['vehicle_reg_id'] || ! $payload['claim_number'] || ! $payload['message']) {
        wp_send_json_error(['message' => 'Complete each field before sending your update.'], 422);
    }

    $response = wp_remote_post(dtc_theme_api_url('claims/respond'), [
        'timeout' => 20,
        'body' => $payload,
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error(['message' => 'We could not connect to the claims service. Please try again later.'], 502);
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    $responseStatus = wp_remote_retrieve_response_code($response);
    if ($responseStatus !== 200 || ($body['status'] ?? null) !== 'success') {
        $message = is_string($body['message'] ?? null)
            ? $body['message']
            : 'We could not send your update. Please check your details and try again.';
        wp_send_json_error(['message' => $message], in_array($responseStatus, [422, 429], true) ? $responseStatus : 502);
    }

    wp_send_json_success([
        'message' => sanitize_text_field($body['message'] ?? 'Your additional information was sent to our team.'),
    ]);
}

function dtc_submit_claim(): void
{
    check_ajax_referer('inno-tyrenonce', 'security');

    if (! defined('DTC_API_URL') || ! defined('DTC_API_KEY')) {
        wp_send_json_error(['message' => 'Claim submission is temporarily unavailable.'], 503);
    }

    $payload = [
        'idempotency_key' => sanitize_text_field(wp_unslash($_POST['idempotency_key'] ?? '')),
        'dtc_card_no' => sanitize_text_field(wp_unslash($_POST['dtc_card_no'] ?? '')),
        'subject' => sanitize_text_field(wp_unslash($_POST['subject'] ?? '')),
        'description' => sanitize_textarea_field(wp_unslash($_POST['description'] ?? '')),
        'incident_date' => sanitize_text_field(wp_unslash($_POST['incident_date'] ?? '')),
        'affected_tyres' => sanitize_text_field(wp_unslash($_POST['affected_tyres'] ?? '')),
    ];
    if (! empty($_POST['different_issue_confirmed'])) {
        $payload['different_issue_confirmed'] = 1;
    }

    if (! $payload['dtc_card_no'] || ! $payload['subject'] || ! $payload['description']) {
        wp_send_json_error(['message' => 'Please complete all fields with valid information.'], 422);
    }
    if (! preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $payload['idempotency_key'])) {
        wp_send_json_error(['message' => 'The claim form has expired. Refresh the page and try again.'], 422);
    }

    $multipart = dtc_claim_multipart_body($payload, $_FILES['attachments'] ?? []);
    if (is_wp_error($multipart)) {
        wp_send_json_error(['message' => $multipart->get_error_message()], 422);
    }

    $response = wp_remote_post(dtc_theme_api_url('claims'), [
        'timeout' => 20,
        'headers' => ['Content-Type' => 'multipart/form-data; boundary=' . $multipart['boundary']],
        'body' => $multipart['body'],
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error(['message' => 'We could not connect to the claims service. Please try again later.'], 502);
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (! in_array(wp_remote_retrieve_response_code($response), [200, 201], true) || ($body['status'] ?? null) !== 'success') {
        $message = is_string($body['message'] ?? null)
            ? $body['message']
            : 'We could not submit your claim. Check your registration details and try again.';
        $response_status = wp_remote_retrieve_response_code($response);
        $status = in_array($response_status, [403, 409, 422, 503], true) ? $response_status : 502;
        wp_send_json_error(['message' => $message], $status);
    }

    $email_notification = $body['email_notification'] ?? 'sent';
    $message = sprintf(
        __('Your claim was submitted and is awaiting review. Claim number: %s', 'dtc-theme'),
        sanitize_text_field($body['claim_number'] ?? '')
    );
    if ($email_notification === 'sent') {
        $message .= __(' A confirmation email was accepted by the mail server.', 'dtc-theme');
    } else {
        $message .= __(' You can check your claim status using your DTC Code and registered plate number.', 'dtc-theme');
    }

    wp_send_json_success([
        'claim_number' => sanitize_text_field($body['claim_number'] ?? ''),
        'message' => $message,
    ]);
}

function dtc_claim_multipart_body(array $fields, array $upload): array|WP_Error
{
    $boundary = wp_generate_password(32, false, false);
    $body = '';
    foreach ($fields as $name => $value) {
        $body .= '--' . $boundary . "\r\n";
        $body .= 'Content-Disposition: form-data; name="' . $name . '"' . "\r\n\r\n";
        $body .= (string) $value . "\r\n";
    }

    $allowed_mimes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'application/pdf' => 'pdf',
    ];
    $files = [];
    if (isset($upload['name']) && is_array($upload['name'])) {
        foreach ($upload['name'] as $index => $name) {
            if (($upload['error'][$index] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            if (($upload['error'][$index] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK || ! is_uploaded_file($upload['tmp_name'][$index] ?? '')) {
                return new WP_Error('invalid_claim_attachment', 'A claim attachment could not be read. Please try again.');
            }
            if (($upload['size'][$index] ?? 0) > 5 * MB_IN_BYTES) {
                return new WP_Error('claim_attachment_too_large', 'Each claim attachment must be 5 MB or smaller.');
            }
            if (count($files) >= 1) {
                return new WP_Error('too_many_claim_attachments', 'You can attach only one file.');
            }

            $tmp_name = $upload['tmp_name'][$index];
            $mime_type = function_exists('mime_content_type') ? mime_content_type($tmp_name) : '';
            if (! isset($allowed_mimes[$mime_type])) {
                return new WP_Error('invalid_claim_attachment_type', 'Attachments must be JPG, PNG, WEBP, or PDF files.');
            }
            $file_contents = file_get_contents($tmp_name);
            if ($file_contents === false) {
                return new WP_Error('claim_attachment_read_failed', 'A claim attachment could not be read. Please try again.');
            }
            $safe_name = sanitize_file_name((string) $name);
            $safe_name = substr($safe_name, 0, 180);
            $files[] = [
                'name' => $safe_name !== '' ? $safe_name : 'claim-attachment.' . $allowed_mimes[$mime_type],
                'type' => $mime_type,
                'contents' => $file_contents,
            ];
        }
    } elseif (isset($upload['error']) && $upload['error'] !== UPLOAD_ERR_NO_FILE) {
        return new WP_Error('invalid_claim_attachment', 'A claim attachment could not be read. Please try again.');
    }

    foreach ($files as $file) {
        $body .= '--' . $boundary . "\r\n";
        $body .= 'Content-Disposition: form-data; name="attachments[]"; filename="' . $file['name'] . '"' . "\r\n";
        $body .= 'Content-Type: ' . $file['type'] . "\r\n\r\n";
        $body .= $file['contents'] . "\r\n";
    }

    return [
        'boundary' => $boundary,
        'body' => $body . '--' . $boundary . "--\r\n",
    ];
}
