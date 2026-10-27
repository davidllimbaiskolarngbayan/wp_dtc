<div id="dtc-data" class="dtc-records">
    <h2 class="dtc-records__title"><?php _e('Your records', HATT_TEXTDOMAIN); ?></h2>
    <?php $max_claim_date = wp_date('Y-m-d', null, new DateTimeZone('Asia/Manila')); ?>
    <?php foreach ((array) $data as $entry) :
        $timestamp = strtotime((string) $entry->date_of_purchase);
        $expiry_timestamp = ! empty($entry->warranty_expiry_date) ? strtotime((string) $entry->warranty_expiry_date) : false;
        if ($expiry_timestamp && ($entry->warranty_status ?? '') === 'Expired') {
            $warranty_details = sprintf(
                __('Warranty coverage ended on %s.', HATT_TEXTDOMAIN),
                date('M d, Y', $expiry_timestamp)
            );
        } elseif ($expiry_timestamp && ! empty($entry->warranty_eligible)) {
            $warranty_details = sprintf(
                __('Warranty coverage is valid until %s.', HATT_TEXTDOMAIN),
                date('M d, Y', $expiry_timestamp)
            );
        } else {
            $warranty_details = $entry->warranty_reason ?? '';
        }
        $rows = [
            __('Tyre', HATT_TEXTDOMAIN)             => $entry->tyre,
            __('Quantity', HATT_TEXTDOMAIN)         => $entry->quantity,
            __('Purchase date', HATT_TEXTDOMAIN)    => $timestamp ? date('M d, Y', $timestamp) : '',
            __('Warranty status', HATT_TEXTDOMAIN)  => $entry->warranty_status ?? __('Needs review', HATT_TEXTDOMAIN),
            __('Warranty details', HATT_TEXTDOMAIN) => $warranty_details,
            __('Store', HATT_TEXTDOMAIN)            => $entry->store_name,
            __('Plate number', HATT_TEXTDOMAIN)     => $entry->plate_no,
            __('DTC Code', HATT_TEXTDOMAIN)  => $entry->dtc_card_no,
        ];
        $claims = isset($entry->claims) && is_array($entry->claims) ? $entry->claims : [];
        $open_claims = array_filter($claims, static fn ($claim) => ! empty($claim->is_open));
    ?>
        <article class="dtc-record">
            <dl>
                <?php foreach ($rows as $label => $value) : ?>
                    <div>
                        <dt><?php echo esc_html($label); ?></dt>
                        <dd><?php echo esc_html((string) $value); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
            <?php if ($claims) : ?>
                <section class="dtc-claim-history" aria-label="<?php esc_attr_e('Claim status and history', HATT_TEXTDOMAIN); ?>">
                    <h3><?php esc_html_e('Claim status and updates', HATT_TEXTDOMAIN); ?></h3>
                    <?php foreach ($claims as $claim) : ?>
                        <article class="dtc-claim-history__item">
                            <div class="dtc-claim-history__heading">
                                <strong><?php echo esc_html((string) $claim->claim_number); ?></strong>
                                <span class="dtc-claim-history__status"><?php echo esc_html((string) $claim->status); ?></span>
                            </div>
                            <p><?php esc_html_e('Submitted', HATT_TEXTDOMAIN); ?>: <?php echo esc_html((string) $claim->submitted_at); ?></p>
                            <?php if (! empty($claim->history) && is_array($claim->history)) : ?>
                                <ol>
                                    <?php foreach ($claim->history as $event) : ?>
                                        <li>
                                            <?php echo esc_html((string) (($event->event ?? '') === 'Additional information received' ? $event->event : $event->status)); ?>
                                            <time datetime="<?php echo esc_attr((string) $event->date); ?>"><?php echo esc_html((string) $event->date); ?></time>
                                            <?php if (! empty($event->customer_message)) : ?>
                                                <p class="dtc-claim-history__customer-message"><?php echo esc_html((string) $event->customer_message); ?></p>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ol>
                            <?php endif; ?>
                            <?php if ((string) $claim->status === 'Need More Info') : ?>
                                <form class="dtc-claim-response__form">
                                    <input type="hidden" name="security" value="<?php echo esc_attr(wp_create_nonce('inno-tyrenonce')); ?>">
                                    <input type="hidden" name="dtc_card_no" value="<?php echo esc_attr((string) $entry->dtc_card_no); ?>">
                                    <input type="hidden" name="claim_number" value="<?php echo esc_attr((string) $claim->claim_number); ?>">
                                    <label>
                                        <?php esc_html_e('Registered plate number', HATT_TEXTDOMAIN); ?>
                                        <input type="text" name="vehicle_reg_id" maxlength="20" autocomplete="off" required>
                                    </label>
                                    <label>
                                        <?php esc_html_e('Additional information', HATT_TEXTDOMAIN); ?>
                                        <textarea name="message" rows="3" maxlength="2000" required></textarea>
                                    </label>
                                    <button type="submit"><?php esc_html_e('Send information', HATT_TEXTDOMAIN); ?></button>
                                    <p class="dtc-claim-response__message" role="status" aria-live="polite"></p>
                                </form>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
            <?php if ($open_claims) : ?>
                <p class="dtc-claim-open-notice"><?php esc_html_e('An open claim already exists for this DTC card. To avoid duplicates, submit another claim only for a different issue or incident.', HATT_TEXTDOMAIN); ?></p>
            <?php endif; ?>
            <details class="dtc-claim">
                <summary><?php esc_html_e('File a claim', HATT_TEXTDOMAIN); ?></summary>
                <p><?php esc_html_e('This claim will be linked to the DTC Code shown above. Each claim is tracked separately.', HATT_TEXTDOMAIN); ?></p>
                <p><?php esc_html_e('Claim eligibility is based on when the issue happened, not when the claim is submitted. An issue that occurred during the warranty period may still be eligible after the warranty expires. Issues after expiry, or claims without an issue date, will require manual review.', HATT_TEXTDOMAIN); ?></p>
                <form class="dtc-claim__form" enctype="multipart/form-data">
                    <input type="hidden" name="security" value="<?php echo esc_attr(wp_create_nonce('inno-tyrenonce')); ?>">
                    <input type="hidden" name="idempotency_key" value="<?php echo esc_attr(wp_generate_uuid4()); ?>">
                    <input type="hidden" name="dtc_card_no" value="<?php echo esc_attr((string) $entry->dtc_card_no); ?>">
                    <label>
                        <?php esc_html_e('Claim subject', HATT_TEXTDOMAIN); ?>
                        <input type="text" name="subject" maxlength="120" required>
                    </label>
                    <label>
                        <?php esc_html_e('Date the issue happened', HATT_TEXTDOMAIN); ?>
                        <input type="date" name="incident_date" min="<?php echo esc_attr((string) $entry->date_of_purchase); ?>" max="<?php echo esc_attr($max_claim_date); ?>">
                        <small><?php esc_html_e('The issue date must be on or after the purchase date shown above. Leave blank only if the issue date is unknown; the claim will require manual review.', HATT_TEXTDOMAIN); ?></small>
                    </label>
                    <label>
                        <?php esc_html_e('Which tyre(s) are affected?', HATT_TEXTDOMAIN); ?>
                        <input type="text" name="affected_tyres" maxlength="160" placeholder="<?php esc_attr_e('e.g. front left, rear pair', HATT_TEXTDOMAIN); ?>">
                    </label>
                    <label>
                        <?php esc_html_e('Describe the issue', HATT_TEXTDOMAIN); ?>
                        <textarea name="description" rows="5" maxlength="5000" required></textarea>
                    </label>
                    <label>
                        <?php esc_html_e('Photo or document (optional, 1 file)', HATT_TEXTDOMAIN); ?>
                        <input type="file" name="attachments[]" accept=".jpg,.jpeg,.png,.webp,.pdf">
                        <small><?php esc_html_e('JPG, PNG, WEBP, or PDF; maximum 5 MB.', HATT_TEXTDOMAIN); ?></small>
                    </label>
                    <?php if ($open_claims) : ?>
                        <label class="dtc-claim__confirmation">
                            <input type="checkbox" name="different_issue_confirmed" value="1" required>
                            <?php esc_html_e('I confirm this is a different issue or incident from the open claim(s) above.', HATT_TEXTDOMAIN); ?>
                        </label>
                    <?php endif; ?>
                    <button type="submit"><?php esc_html_e('Submit claim', HATT_TEXTDOMAIN); ?></button>
                    <p class="dtc-claim__message" role="status" aria-live="polite"></p>
                </form>
            </details>
        </article>
    <?php endforeach; ?>
</div>
