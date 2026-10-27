(function () {
    'use strict';

    // Register form: product model > tyre size > rim size, limited to the sizes in the tyre catalogue.
    var dataNode = document.getElementById('dtc-register-sizes');
    var model = document.getElementById('product_model');
    var size = document.getElementById('tyre_size');
    var rim = document.getElementById('diameter');
    if (!dataNode || !model || !size || !rim) { return; }

    var map = JSON.parse(dataNode.textContent);

    function fill(select, values) {
        var placeholder = select.options[0];
        select.textContent = '';
        select.appendChild(placeholder);
        values.forEach(function (value) {
            var option = document.createElement('option');
            option.value = value;
            option.textContent = value;
            select.appendChild(option);
        });
        select.disabled = values.length === 0;
        // A single choice is selected for the customer.
        select.value = values.length === 1 ? values[0] : '';
        select.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function rimsFor(modelId, sizeValue) {
        return (map[modelId] && map[modelId][sizeValue]) || [];
    }

    function fillRims() {
        fill(rim, rimsFor(model.value, size.value).map(String));
    }

    function fillSizes() {
        fill(size, map[model.value] ? Object.keys(map[model.value]) : []);
    }

    model.addEventListener('change', fillSizes);
    size.addEventListener('change', fillRims);
})();
