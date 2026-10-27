(function () {
    'use strict';

    var mobile = window.matchMedia('(max-width: 767px)');

    if (window.jQuery) {
        // "Warranty" is a "#" parent link: clicking it opens its sub menu instead of navigating (desktop only).
        window.jQuery(function ($) {
            $('.nav-destop > li.menu-item-has-children > a[href="#"]').on('click', function (event) {
                if (mobile.matches) { return; }
                event.preventDefault();
                var item = $(this).parent();
                item.siblings().find('> ul.sub-menu').stop(true, false).slideUp(200);
                item.find('> ul.sub-menu').stop(true, false).slideDown(300);
            });
        });
    }
})();

(function () {
    'use strict';

    var header = document.querySelector('[data-dtc-header]');
    if (!header) { return; }

    var mobile = window.matchMedia('(max-width: 767px)');
    var burger = header.querySelector('[data-dtc-burger]');
    var closeBtn = header.querySelector('[data-dtc-close]');
    var topItems = Array.prototype.slice.call(header.querySelectorAll('.nav-destop > li.menu-item-has-children'));

    function collapseAll() {
        header.classList.remove('has-sub');
        topItems.forEach(function (item) {
            item.classList.remove('is-expanded');
            item.firstElementChild.setAttribute('aria-expanded', 'false');
            Array.prototype.forEach.call(item.querySelectorAll('.is-group-open'), function (group) { group.classList.remove('is-group-open'); });
        });
    }

    function setOpen(open) {
        header.classList.toggle('is-open', open);
        document.documentElement.classList.toggle('dtc-menu-open', open && mobile.matches);
        if (burger) { burger.setAttribute('aria-expanded', open ? 'true' : 'false'); }
        if (!open) { collapseAll(); }
    }

    if (burger) { burger.addEventListener('click', function () { setOpen(!header.classList.contains('is-open')); }); }
    if (closeBtn) { closeBtn.addEventListener('click', function () { setOpen(false); if (burger) { burger.focus(); } }); }
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && header.classList.contains('is-open')) { setOpen(false); if (burger) { burger.focus(); } }
    });
    // Leaving the mobile layout (rotate or resize) closes the panel.
    mobile.addEventListener('change', function () { setOpen(false); });

    // Accordion: tapping a top-level item with a sub menu opens it; its own page stays reachable as the first link.
    topItems.forEach(function (item) {
        var link = item.firstElementChild;
        var menu = item.querySelector(':scope > ul.sub-menu');
        if (!menu) { return; }
        link.setAttribute('aria-expanded', 'false');

        var href = link.getAttribute('href');
        if (href && href !== '#') {
            var all = document.createElement('li');
            var allLink = document.createElement('a');
            allLink.href = href;
            allLink.textContent = 'View all ' + link.textContent.trim().toLowerCase();
            all.className = 'dtc-menu-all';
            all.appendChild(allLink);
            menu.insertBefore(all, menu.firstChild);
        }

        link.addEventListener('click', function (event) {
            if (!mobile.matches) { return; }
            event.preventDefault();
            var expand = !item.classList.contains('is-expanded');
            collapseAll();
            if (expand) {
                item.classList.add('is-expanded');
                header.classList.add('has-sub');
                link.setAttribute('aria-expanded', 'true');
                header.querySelector('.dtc-header__nav').scrollTop = 0;
                // A section with a single group opens it straight away.
                var groups = item.querySelectorAll(':scope > ul.sub-menu > li.menu-item-has-children');
                if (groups.length === 1) { groups[0].classList.add('is-group-open'); }
            }
        });

        // Groups inside a section behave as a one-at-a-time accordion.
        Array.prototype.forEach.call(menu.querySelectorAll(':scope > li.menu-item-has-children'), function (group) {
            var heading = group.firstElementChild;
            heading.setAttribute('aria-expanded', 'false');
            heading.addEventListener('click', function (event) {
                if (!mobile.matches) { return; }
                event.preventDefault();
                var open = !group.classList.contains('is-group-open');
                Array.prototype.forEach.call(menu.querySelectorAll(':scope > li.is-group-open'), function (other) {
                    other.classList.remove('is-group-open');
                    other.firstElementChild.setAttribute('aria-expanded', 'false');
                });
                group.classList.toggle('is-group-open', open);
                heading.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        });
    });

    // Following any real link closes the panel.
    header.querySelector('.dtc-header__nav').addEventListener('click', function (event) {
        var anchor = event.target.closest ? event.target.closest('a') : null;
        if (anchor && mobile.matches && anchor.getAttribute('href') && anchor.getAttribute('href') !== '#' && !anchor.parentNode.classList.contains('menu-item-has-children')) {
            setOpen(false);
        }
    });

    var toggle = header.querySelector('[data-dtc-search-toggle]');
    var form = document.getElementById('dtc-search');
    if (toggle && form) {
        toggle.addEventListener('click', function () {
            form.hidden = !form.hidden;
            toggle.setAttribute('aria-expanded', form.hidden ? 'false' : 'true');
            if (!form.hidden) { form.querySelector('input').focus(); }
        });
    }
})();
