(function () {
    'use strict';

    var settings = window.dtcPromoRegistration;
    var form = document.getElementById('dtc-register-form');
    var panel = document.getElementById('dtc-promo-registration');
    var validPromo = document.getElementById('valid-promo');

    if (!settings || !form || !panel || !validPromo) {
        return;
    }

    var purchaseDate = document.getElementById('date_purchase_picker');
    var rimSize = document.getElementById('diameter');
    var quantity = document.getElementById('qty');
    var province = document.getElementById('province');
    var store = document.getElementById('find_retailer');
    var assistedPerson = document.getElementById('promo-assisted-person');
    var invoice = document.getElementById('promo-invoice');
    var confirmation = document.getElementById('promo-confirm');
    var terms = document.getElementById('promo-terms');
    var promoEyebrow = document.getElementById('dtc-promo-eyebrow');
    var promoTitle = document.getElementById('dtc-promo-title');
    var promoDescription = document.getElementById('dtc-promo-description');
    var requiredFields = [assistedPerson, invoice, confirmation, terms];
    var wasQualified = false;

    function selectedDateIso() {
        var parts = purchaseDate.value.split('/');
        if (parts.length !== 3) {
            return '';
        }

        var month = parseInt(parts[0], 10);
        var day = parseInt(parts[1], 10);
        var year = parseInt(parts[2], 10);
        var parsed = new Date(Date.UTC(year, month - 1, day));

        if (
            !month ||
            !day ||
            !year ||
            parsed.getUTCFullYear() !== year ||
            parsed.getUTCMonth() !== month - 1 ||
            parsed.getUTCDate() !== day
        ) {
            return '';
        }

        return [
            String(year).padStart(4, '0'),
            String(month).padStart(2, '0'),
            String(day).padStart(2, '0')
        ].join('-');
    }

    function formatPromoDate(isoDate) {
        var parts = isoDate.split('-');
        var date = new Date(Date.UTC(
            parseInt(parts[0], 10),
            parseInt(parts[1], 10) - 1,
            parseInt(parts[2], 10)
        ));
        return new Intl.DateTimeFormat('en', {
            month: 'long',
            day: 'numeric',
            year: 'numeric',
            timeZone: 'UTC'
        }).format(date);
    }

    function refreshPromotion() {
        var date = selectedDateIso();
        var campaign = (settings.campaigns || []).find(function (item) {
            return date && date >= item.start_date && date <= item.end_date;
        });
        var rim = parseInt(rimSize.value, 10) || 0;
        var tyres = parseInt(quantity.value, 10) || 0;
        var storeName = store.value;
        var eligible = Boolean(
            campaign &&
            rim >= settings.minimum_rim &&
            tyres === Number(settings.required_quantity) &&
            province.value &&
            storeName &&
            storeName !== 'OTHERS' &&
            storeName !== 'employee_purchase'
        );

        panel.hidden = !eligible;
        validPromo.value = eligible ? '1' : '0';
        if (campaign) {
            promoEyebrow.textContent = campaign.name;
            promoTitle.textContent = campaign.title;
            promoDescription.textContent = 'Buy four qualifying tyres with rim size ' + settings.minimum_rim +
                ' inches or above. Eligible purchases must be made from ' + formatPromoDate(campaign.start_date) +
                ' to ' + formatPromoDate(campaign.end_date) +
                ' at a participating DTC store. Your registration and invoice will be reviewed before approval.';
        }
        requiredFields.forEach(function (field) {
            field.required = eligible;
        });

        if (wasQualified && !eligible) {
            assistedPerson.value = '';
            invoice.value = '';
            confirmation.checked = false;
            terms.checked = false;
        }
        wasQualified = eligible;
    }

    [purchaseDate, rimSize, quantity, province, store].forEach(function (field) {
        field.addEventListener('change', refreshPromotion);
    });
    purchaseDate.addEventListener('input', refreshPromotion);
    form.addEventListener('reset', function () {
        window.setTimeout(refreshPromotion, 0);
    });

    refreshPromotion();
})();
