(function () {
    'use strict';

    // Register form: the store list depends on the chosen province, using the stores in the catalogue.
    var dataNode = document.getElementById('dtc-register-stores');
    var province = document.getElementById('province');
    var store = document.getElementById('find_retailer');
    if (!dataNode || !province || !store) { return; }

    var map = JSON.parse(dataNode.textContent);
    var preselectedStore = dataNode.getAttribute('data-selected-store') || '';

    function updateStores() {
        var names = map[province.value] || [];
        var placeholder = store.options[0];
        store.textContent = '';
        store.appendChild(placeholder);
        names.forEach(function (name) {
            var option = document.createElement('option');
            option.value = name;
            option.textContent = name;
            store.appendChild(option);
        });
        store.disabled = names.length === 0;
        store.value = preselectedStore && names.indexOf(preselectedStore) !== -1
            ? preselectedStore
            : (names.length === 1 ? names[0] : '');
        preselectedStore = '';
        store.dispatchEvent(new Event('change', { bubbles: true }));
    }

    province.addEventListener('change', updateStores);
    if (province.value) { updateStores(); }
})();
