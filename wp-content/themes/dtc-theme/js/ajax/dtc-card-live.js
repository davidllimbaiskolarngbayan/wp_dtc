// Registration form controller: live DTC card check (is_dtc_card_valid) and submit-button validation state.
jQuery(function ($) {
    'use strict';

    var $card = $('#dtc_card_no');
    var $message = $('#dtc-card-message');
    var $form = $('#dtc-register-form');
    var $submit = $form.find('input[type=submit]');
    var request = null;
    var pendingCode = '';
    var valid = false;     // the DTC Code was verified against the Laravel code list
    var attempted = false; // the visitor pressed SUBMIT at least once

    if (!$card.length || !$form.length) {
        return;
    }

    var instance = $form.parsley();

    // Browsers restore typed values on refresh/back; start every page view from a clean form.
    function resetForm() {
        $form[0].reset();
        instance.reset();
        $form.find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
        $message.removeClass('is-valid is-invalid').text('');
        $('#plateNumErrorMsg').text('');
        $submit.prop('disabled', false).removeClass('disable-dtc-button');
    }
    resetForm();
    $(window).on('pageshow', function (event) {
        if (event.originalEvent && event.originalEvent.persisted) {
            resetForm();
        }
    });

    function setState(state, text) {
        $card.removeClass('is-valid is-invalid');
        if (state) {
            $card.addClass(state);
        }
        $message.removeClass('is-valid is-invalid').addClass(state || '').text(text || '');
    }

    function plateOk() {
        return $.trim($('#plateNumErrorMsg').text()) === '';
    }

    function formOk() {
        return valid && plateOk() && instance.isValid();
    }

    // After the first attempt, the button is enabled only while every field is valid.
    function syncSubmit() {
        if (!attempted || $.trim($submit.val()) === 'Processing...') {
            return;
        }
        var ok = formOk();
        if ($submit.prop('disabled') === ok) {
            $submit.prop('disabled', !ok).toggleClass('disable-dtc-button', !ok);
        }
    }

    function check(code) {
        if (pendingCode === code && request) {
            return;
        }
        if (request) {
            request.abort();
            request = null;
        }
        pendingCode = code;
        setState('', 'Checking...');
        var currentRequest = $.ajax({
            type: 'POST',
            url: hatt_params.ajax_url,
            dataType: 'json',
            timeout: 10000,
            data: { action: 'is_dtc_card_valid', security: $('#ajax-nonce').val(), dtc_code: code }
        });
        request = currentRequest;
        currentRequest
            .done(function (response) {
                if (code !== $card.val()) {
                    return; // the visitor kept typing; a newer check is on its way
                }
                valid = !!(response && (response.status === 'valid' || (response.success && !response.status)));
                if (valid) {
                    setState('is-valid', 'Valid DTC Code.');
                } else if (response && response.status === 'used') {
                    setState('is-invalid', 'This DTC Code has already been used.');
                } else if (response && response.status === 'invalid') {
                    setState('is-invalid', 'DTC Code not found. Please check and enter a valid code.');
                } else {
                    setState('is-invalid', response && response.message ? response.message : 'Could not verify the DTC Code. Please try again.');
                }
                syncSubmit();
            })
            .fail(function (xhr, status) {
                if (status === 'abort') {
                    return;
                }
                if (code !== $card.val()) {
                    return;
                }
                valid = false;
                setState('is-invalid', 'Could not verify the DTC Code. Please try again.');
                syncSubmit();
            })
            .always(function () {
                if (request === currentRequest) {
                    request = null;
                }
            });
    }

    $card.on('input', function () {
        var code = (this.value = this.value.toUpperCase().replace(/[^A-Z0-9\-]/g, '').slice(0, 8));
        valid = false;

        if (code === '') {
            pendingCode = '';
            if (request) {
                request.abort();
                request = null;
            }
            setState('', '');
        } else if (code.length < 8) {
            pendingCode = '';
            if (request) {
                request.abort();
                request = null;
            }
            setState('', 'Enter the full DTC Code to verify it.');
        } else {
            check(code);
        }
        syncSubmit();
    });

    $card.on('blur', function () {
        var code = $.trim(this.value);
        if (code.length >= 8) {
            check(code);
        }
    });

    // Runs on click, before the form's submit event: show every error at once and hold the submission while any remain.
    $submit.on('click', function (event) {
        attempted = true;
        instance.validate();

        if (!formOk()) {
            event.preventDefault();
            event.stopImmediatePropagation();

            if ($card.val() === '') {
                setState('is-invalid', '');
            } else if (!valid && !$card.hasClass('is-invalid')) {
                setState('is-invalid', $card.val().length < 8 ? 'Please enter the full DTC Code.' : 'Please wait while the DTC Code is verified.');
            }
            syncSubmit();
        }
    });

    // Re-check on every edit; the theme's own scripts also toggle the button, so watch it and the plate message.
    $form.on('input change keyup', function () { setTimeout(syncSubmit, 0); });

    if (window.MutationObserver) {
        var observer = new MutationObserver(syncSubmit);
        observer.observe($submit[0], { attributes: true, attributeFilter: ['disabled', 'value'] });
        observer.observe(document.getElementById('plateNumErrorMsg'), { childList: true, characterData: true, subtree: true });
    }
});
