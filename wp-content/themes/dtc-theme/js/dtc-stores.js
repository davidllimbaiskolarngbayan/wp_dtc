(function () {
    'use strict';

    var PH_CENTER = [12.8797, 121.774];
    var TILES = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
    var ATTRIBUTION = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
    var PAGE_SIZE = 10;

    function createMap(el) {
        if (!window.L) { return null; }
        var map = window.L.map(el, { scrollWheelZoom: false }).setView(PH_CENTER, 5);
        window.L.tileLayer(TILES, { maxZoom: 18, attribution: ATTRIBUTION }).addTo(map);
        // Wheel zoom only after the map is clicked, so the page can still scroll over it.
        map.on('click', function () { map.scrollWheelZoom.enable(); });
        map.on('mouseout', function () { map.scrollWheelZoom.disable(); });
        return map;
    }

    function pinIcon() {
        return window.L.divIcon({ className: 'dtc-pin', html: '<span></span>', iconSize: [30, 38], iconAnchor: [15, 38], popupAnchor: [0, -34] });
    }

    function popupContent(name, address, url) {
        var box = document.createElement('div');
        var title = document.createElement('strong');
        title.textContent = name;
        box.appendChild(title);
        if (address) {
            var line = document.createElement('div');
            line.textContent = address;
            box.appendChild(line);
        }
        if (url) {
            var link = document.createElement('a');
            link.href = url;
            link.textContent = 'View store';
            box.appendChild(link);
        }
        return box;
    }

    // Single store page: one marker.
    var single = document.querySelector('[data-store-map][data-lat]');
    if (single) {
        var singleMap = createMap(single);
        var lat = parseFloat(single.getAttribute('data-lat'));
        var lng = parseFloat(single.getAttribute('data-lng'));
        if (singleMap && isFinite(lat) && isFinite(lng)) {
            singleMap.setView([lat, lng], 15);
            window.L.marker([lat, lng], { icon: pinIcon(), title: single.getAttribute('data-name') || '' }).addTo(singleMap);
        }
        return;
    }

    var app = document.querySelector('[data-dtc-stores]');
    if (!app) { return; }

    var q = function (name) { return app.querySelector('[data-store-' + name + ']'); };
    var items = Array.prototype.slice.call(app.querySelectorAll('[data-store]'));
    var list = q('list');
    var controls = { search: q('search'), region: q('region'), province: q('province'), service: q('service'), distance: q('distance') };
    var count = q('count');
    var empty = q('empty');
    var pagination = q('pagination');
    var previous = q('previous');
    var next = q('next');
    var pageLabel = q('page');
    var nearBtn = q('near');
    var map = createMap(q('map'));
    var userMarker = null;
    var origin = null;
    var currentPage = 1;

    // Province options are rebuilt from this list as the region filter changes.
    function readOptions(select) {
        return Array.prototype.slice.call(select.options).slice(1).map(function (option) {
            return { value: option.value, label: option.textContent, parent: option.getAttribute('data-parent') || '' };
        });
    }
    var provinceOptions = readOptions(controls.province);

    function fillSelect(select, firstLabel, options) {
        select.textContent = '';
        var first = document.createElement('option');
        first.value = '';
        first.textContent = firstLabel;
        select.appendChild(first);
        options.forEach(function (item) {
            var option = document.createElement('option');
            option.value = item.value;
            option.textContent = item.label;
            select.appendChild(option);
        });
    }

    function refreshProvinces() {
        var region = controls.region.value;
        fillSelect(controls.province, 'All provinces', provinceOptions.filter(function (item) { return !region || item.parent === region; }));
        controls.province.disabled = !region;
    }

    items.forEach(function (item) {
        var lat = parseFloat(item.getAttribute('data-lat'));
        var lng = parseFloat(item.getAttribute('data-lng'));
        item.storeLatLng = (isFinite(lat) && isFinite(lng)) ? [lat, lng] : null;
        item.storeDistance = Infinity;
        item.storeOrder = items.indexOf(item);
        if (map && item.storeLatLng) {
            item.storeMarker = window.L.marker(item.storeLatLng, { icon: pinIcon(), title: item.getAttribute('data-name') });
            item.storeMarker.bindPopup(popupContent(item.getAttribute('data-name'), (item.querySelector('.dtc-store__address') || {}).textContent, item.getAttribute('data-url')));
            item.storeMarker.on('click', function () {
                items.forEach(function (other) { other.classList.toggle('is-active', other === item); });
                if (!item.hidden) { item.scrollIntoView({ block: 'nearest', behavior: 'smooth' }); }
            });
        }
    });

    function matches(item) {
        var text = controls.search.value.trim().toLowerCase();
        if (text && item.getAttribute('data-search').indexOf(text) === -1) { return false; }
        if (controls.region.value && item.getAttribute('data-region') !== controls.region.value) { return false; }
        if (controls.province.value && item.getAttribute('data-province') !== controls.province.value) { return false; }
        if (controls.service.value && item.getAttribute('data-services').split(' ').indexOf(controls.service.value) === -1) { return false; }
        var km = parseFloat(controls.distance.value);
        if (origin && isFinite(km) && !(item.storeDistance <= km)) { return false; }
        return true;
    }

    function fitTo(points) {
        if (!map) { return; }
        if (!points.length) { map.setView(PH_CENTER, 5); return; }
        map.fitBounds(window.L.latLngBounds(points), { padding: [40, 40], maxZoom: 13 });
    }

    function apply(refit) {
        var matched = items.filter(matches);
        if (origin) {
            matched.sort(function (a, b) { return a.storeDistance - b.storeDistance; });
        } else {
            matched.sort(function (a, b) { return a.storeOrder - b.storeOrder; });
        }
        var pageCount = Math.max(1, Math.ceil(matched.length / PAGE_SIZE));
        currentPage = Math.min(currentPage, pageCount);
        var start = (currentPage - 1) * PAGE_SIZE;
        var end = start + PAGE_SIZE;
        items.forEach(function (item) {
            var index = matched.indexOf(item);
            item.hidden = index < start || index >= end;
            if (item.storeMarker) {
                if (index !== -1) { item.storeMarker.addTo(map); } else { item.storeMarker.remove(); }
            }
        });
        matched.forEach(function (item) { list.appendChild(item); });

        count.textContent = matched.length + (matched.length === 1 ? ' result found' : ' results found');
        empty.hidden = matched.length !== 0;
        pagination.hidden = pageCount <= 1;
        previous.disabled = currentPage === 1;
        next.disabled = currentPage === pageCount;
        pageLabel.textContent = 'Page ' + currentPage + ' of ' + pageCount;
        if (refit !== false) {
            fitTo(matched.filter(function (item) { return item.storeLatLng; }).map(function (item) { return item.storeLatLng; }).concat(origin ? [origin] : []));
        }
    }

    function distanceKm(a, b) {
        var rad = Math.PI / 180;
        var dLat = (b[0] - a[0]) * rad;
        var dLng = (b[1] - a[1]) * rad;
        var h = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(a[0] * rad) * Math.cos(b[0] * rad) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
        return 6371 * 2 * Math.atan2(Math.sqrt(h), Math.sqrt(1 - h));
    }

    function resetPaging() { currentPage = 1; }

    controls.region.addEventListener('change', function () { refreshProvinces(); resetPaging(); apply(); });
    controls.province.addEventListener('change', function () { resetPaging(); apply(); });
    controls.service.addEventListener('change', function () { resetPaging(); apply(); });
    controls.search.addEventListener('input', function () { resetPaging(); apply(); });
    controls.distance.addEventListener('change', function () {
        resetPaging();
        // Picking a distance asks for the location first, since it is measured from the visitor.
        if (controls.distance.value && !origin) { locate(); return; }
        apply();
    });
    previous.addEventListener('click', function () {
        if (currentPage > 1) { currentPage--; apply(false); }
    });
    next.addEventListener('click', function () {
        currentPage++;
        apply(false);
    });

    items.forEach(function (item) {
        var focus = item.querySelector('[data-store-focus]');
        if (!focus) { return; }
        focus.addEventListener('click', function () {
            if (!map || !item.storeMarker) { return; }
            items.forEach(function (other) { other.classList.toggle('is-active', other === item); });
            map.setView(item.storeLatLng, 15);
            item.storeMarker.openPopup();
            q('map').scrollIntoView({ block: 'center', behavior: 'smooth' });
        });
    });

    nearBtn.addEventListener('click', locate);

    q('reset').addEventListener('click', function () {
        controls.search.value = '';
        controls.region.value = '';
        controls.service.value = '';
        controls.distance.value = '';
        refreshProvinces();
        resetPaging();
        apply();
    });

    function locate() {
        if (!navigator.geolocation) { count.textContent = 'Location is not available in this browser.'; controls.distance.value = ''; return; }
        nearBtn.disabled = true;
        nearBtn.textContent = 'Locating...';
        navigator.geolocation.getCurrentPosition(function (position) {
            origin = [position.coords.latitude, position.coords.longitude];
            nearBtn.disabled = false;
            nearBtn.textContent = 'Locate me';
            items.forEach(function (item) {
                item.storeDistance = item.storeLatLng ? distanceKm(origin, item.storeLatLng) : Infinity;
                var label = item.querySelector('[data-distance]');
                if (isFinite(item.storeDistance)) {
                    label.textContent = item.storeDistance.toFixed(item.storeDistance < 10 ? 1 : 0) + ' km away';
                    label.hidden = false;
                }
            });
            if (map) {
                if (userMarker) { userMarker.remove(); }
                userMarker = window.L.circleMarker(origin, { radius: 8, color: '#0b2a63', fillColor: '#fbbd00', fillOpacity: 1, weight: 3 }).addTo(map);
            }
            resetPaging();
            apply();
        }, function () {
            nearBtn.disabled = false;
            nearBtn.textContent = 'Locate me';
            controls.distance.value = '';
            count.textContent = 'We could not get your location. Choose a region instead.';
        }, { timeout: 10000 });
    }

    resetPaging();
    apply();
})();
