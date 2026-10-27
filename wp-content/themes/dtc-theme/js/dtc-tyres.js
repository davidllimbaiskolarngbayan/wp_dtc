(function () {
    'use strict';

    // Gallery: thumbnails, arrows and optional video.
    document.querySelectorAll('[data-dtc-gallery]').forEach(function (root) {
        var main = root.querySelector('[data-gallery-main]');
        var video = root.querySelector('[data-gallery-video]');
        var thumbs = Array.prototype.slice.call(root.querySelectorAll('[data-gallery-thumb], [data-gallery-video-thumb]'));
        var current = 0;

        function show(index) {
            if (!thumbs.length) { return; }
            current = (index + thumbs.length) % thumbs.length;
            var button = thumbs[current];
            thumbs.forEach(function (item) { item.classList.toggle('is-active', item === button); });
            if (button.hasAttribute('data-gallery-video-thumb')) {
                if (main) { main.hidden = true; }
                if (video) { video.hidden = false; video.play(); }
                return;
            }
            if (video) { video.pause(); video.hidden = true; }
            if (main) { main.src = button.getAttribute('data-gallery-thumb'); main.hidden = false; }
        }

        thumbs.forEach(function (button, index) { button.addEventListener('click', function () { show(index); }); });
        var prev = root.querySelector('[data-gallery-prev]');
        var next = root.querySelector('[data-gallery-next]');
        if (prev) { prev.addEventListener('click', function () { show(current - 1); }); }
        if (next) { next.addEventListener('click', function () { show(current + 1); }); }
    });

    // Sticky section nav: sit below the fixed site header and highlight the section in view.
    var pdpNav = document.querySelector('[data-pdp-nav]');
    if (pdpNav) {
        var header = document.querySelector('.navbar-fixed-top');
        var applyOffset = function () {
            var offset = header ? header.offsetHeight : 0;
            pdpNav.style.top = offset + 'px';
            document.documentElement.style.setProperty('--dtc-offset', (offset + pdpNav.offsetHeight) + 'px');
        };
        applyOffset();
        window.addEventListener('resize', applyOffset);

        var links = Array.prototype.slice.call(pdpNav.querySelectorAll('a[href^="#"]'));
        links.forEach(function (link) {
            link.addEventListener('click', function (event) {
                var target = document.querySelector(link.getAttribute('href'));
                if (target) {
                    event.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) { return; }
                    links.forEach(function (link) {
                        link.classList.toggle('is-active', link.getAttribute('href') === '#' + entry.target.id);
                    });
                });
            }, { rootMargin: '-30% 0px -60% 0px' });
            links.forEach(function (link) {
                var section = document.querySelector(link.getAttribute('href'));
                if (section) { observer.observe(section); }
            });
        }
    }

    // Full specs: choose a rim diameter, then a size, to see its specification table.
    var specs = document.querySelector('[data-dtc-specs]');
    var dataNode = document.getElementById('dtc-spec-data');
    if (specs && dataNode) {
        var data = JSON.parse(dataNode.textContent);
        var byId = {};
        data.forEach(function (item) { byId[item.id] = item; });
        var rimRadios = specs.querySelectorAll('[data-specs-rims] input');
        var sizeLabels = specs.querySelectorAll('[data-specs-sizes] .dtc-pill');
        var table = specs.querySelector('[data-specs-table]');
        var hint = specs.querySelector('[data-specs-hint]');

        var render = function (id) {
            var item = byId[id];
            table.textContent = '';
            if (!item) { table.hidden = true; hint.hidden = false; return; }
            Object.keys(item.rows).forEach(function (label) {
                var row = document.createElement('li');
                var key = document.createElement('span');
                var value = document.createElement('strong');
                key.textContent = label;
                value.textContent = item.rows[label];
                row.appendChild(key);
                row.appendChild(value);
                table.appendChild(row);
            });
            table.hidden = false;
            hint.hidden = true;
        };

        var filterSizes = function (rim) {
            var first = null;
            sizeLabels.forEach(function (label) {
                var visible = !rim || label.getAttribute('data-rim') === rim;
                label.hidden = !visible;
                var input = label.querySelector('input');
                if (visible && !first) { first = input; }
                if (!visible) { input.checked = false; }
            });
            return first;
        };

        rimRadios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                var first = filterSizes(radio.value);
                if (first) { first.checked = true; render(first.value); }
            });
        });
        sizeLabels.forEach(function (label) {
            label.querySelector('input').addEventListener('change', function (event) { render(event.target.value); });
        });

        if (rimRadios.length) {
            rimRadios[0].checked = true;
            var initial = filterSizes(rimRadios[0].value);
            if (initial) { initial.checked = true; render(initial.value); }
        }
    }

    // Archive: scrollable type navigation with arrows.
    var subnav = document.querySelector('.dtc-subnav');
    if (subnav) {
        var track = subnav.querySelector('[data-subnav]');
        var update = function () {
            var overflow = track.scrollWidth > track.clientWidth + 2;
            subnav.classList.toggle('has-overflow', overflow);
            subnav.classList.toggle('at-start', track.scrollLeft <= 2);
            subnav.classList.toggle('at-end', track.scrollLeft >= track.scrollWidth - track.clientWidth - 2);
        };
        subnav.querySelector('[data-subnav-prev]').addEventListener('click', function () { track.scrollBy({ left: -220, behavior: 'smooth' }); });
        subnav.querySelector('[data-subnav-next]').addEventListener('click', function () { track.scrollBy({ left: 220, behavior: 'smooth' }); });
        track.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        var active = track.querySelector('.is-active');
        if (active) { track.scrollLeft = Math.max(0, active.offsetLeft - 40); }
        update();
    }

    // Archive: load the next page of tyres in place, falling back to normal navigation.
    var grid = document.querySelector('[data-dtc-grid]');
    var more = document.querySelector('[data-dtc-loadmore]');
    if (grid && more) {
        more.addEventListener('click', function (event) {
            event.preventDefault();
            if (more.getAttribute('aria-busy') === 'true') { return; }
            more.setAttribute('aria-busy', 'true');
            more.textContent = 'Loading...';
            fetch(more.href, { credentials: 'same-origin' })
                .then(function (response) {
                    if (!response.ok) { throw new Error('Request failed'); }
                    return response.text();
                })
                .then(function (html) {
                    var doc = new DOMParser().parseFromString(html, 'text/html');
                    doc.querySelectorAll('[data-dtc-grid] > *').forEach(function (node) {
                        grid.appendChild(document.importNode(node, true));
                    });
                    var next = doc.querySelector('[data-dtc-loadmore]');
                    if (next) {
                        more.href = next.href;
                        more.textContent = 'Load More';
                        more.removeAttribute('aria-busy');
                    } else {
                        more.parentNode.remove();
                    }
                })
                .catch(function () { window.location.href = more.href; });
        });
    }
})();

(function () {
    'use strict';

    document.querySelectorAll('[data-dtc-range]').forEach(function (root) {
        var track = root.querySelector('[data-range-track]');
        var prev = root.querySelector('[data-range-prev]');
        var next = root.querySelector('[data-range-next]');
        if (!track || !prev || !next) { return; }

        function step() {
            var cell = track.firstElementChild;
            return cell ? cell.getBoundingClientRect().width + 24 : track.clientWidth;
        }

        function update() {
            prev.hidden = track.scrollLeft <= 8;
            next.hidden = track.scrollLeft >= track.scrollWidth - track.clientWidth - 8;
        }

        prev.addEventListener('click', function () { track.scrollBy({ left: -step(), behavior: 'smooth' }); });
        next.addEventListener('click', function () { track.scrollBy({ left: step(), behavior: 'smooth' }); });
        track.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        update();
    });
})();

// Find tyres: width > ratio > rim dropdowns that only offer sizes with tyres.
(function () {
    'use strict';

    var form = document.querySelector('[data-dtc-find]');
    var dataNode = document.getElementById('dtc-find-data');
    if (!form || !dataNode) { return; }

    // A refresh starts over with an empty finder; the link itself stays shareable.
    var navigation = window.performance && performance.getEntriesByType ? performance.getEntriesByType('navigation')[0] : null;
    if (navigation && navigation.type === 'reload' && window.location.search) {
        window.location.replace(window.location.pathname);
        return;
    }

    var sizes = JSON.parse(dataNode.textContent);
    var width = form.querySelector('[data-find-select="width"]');
    var ratio = form.querySelector('[data-find-select="ratio"]');
    var rim = form.querySelector('[data-find-select="rim"]');

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
        select.value = '';
        select.disabled = values.length === 0;
    }

    width.addEventListener('change', function () {
        fill(ratio, width.value && sizes[width.value] ? Object.keys(sizes[width.value]) : []);
        fill(rim, []);
    });
    ratio.addEventListener('change', function () {
        var rims = width.value && ratio.value && sizes[width.value] ? sizes[width.value][ratio.value] : null;
        fill(rim, rims || []);
    });

    var root = form.closest('.dtc-find');
    var submit = form.querySelector('.dtc-find__submit');
    var submitLabel = form.querySelector('[data-find-label]');
    var idleLabel = submitLabel ? submitLabel.textContent : '';
    var requestId = 0;

    function currentResults() { return document.getElementById('dtc-find-results'); }

    function setLoading(loading) {
        form.classList.toggle('is-loading', loading);
        form.setAttribute('aria-busy', loading ? 'true' : 'false');
        submit.disabled = loading;
        if (submitLabel) { submitLabel.textContent = loading ? 'Finding tyres...' : idleLabel; }
    }

    function showResults(html) {
        var fresh = new DOMParser().parseFromString(html, 'text/html').getElementById('dtc-find-results');
        var old = currentResults();
        if (old) { old.remove(); }
        if (!fresh) { return; }
        var node = document.importNode(fresh, true);
        root.appendChild(node);
        node.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Load the matching tyres in place so the page itself never reloads; fall back to a normal submit on failure.
    form.addEventListener('submit', function (event) {
        if (!(width.value && ratio.value && rim.value) || !window.fetch || !window.DOMParser) { return; }
        event.preventDefault();
        var id = ++requestId;
        var url = new URL(form.action, window.location.href).pathname + '?' + new URLSearchParams(new FormData(form)).toString();
        setLoading(true);
        fetch(url, { credentials: 'same-origin' })
            .then(function (response) {
                if (!response.ok) { throw new Error('Request failed'); }
                return response.text();
            })
            .then(function (html) {
                if (id !== requestId) { return; }
                showResults(html);
                setLoading(false);
            })
            .catch(function () {
                if (id === requestId) { form.submit(); }
            });
    });

    // Picking anything again clears the previous recommendations until the form is submitted.
    form.addEventListener('change', function () {
        requestId++;
        setLoading(false);
        var results = currentResults();
        if (results) { results.remove(); }
    });

    document.addEventListener('click', function (event) {
        var link = event.target.closest ? event.target.closest('[data-find-change]') : null;
        if (!link) { return; }
        event.preventDefault();
        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        width.focus({ preventScroll: true });
    });

    var initial = currentResults();
    if (initial) {
        initial.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
})();
