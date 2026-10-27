(function () {
    'use strict';

    document.querySelectorAll('[data-dtc-slider]').forEach(function (root) {
        var track = root.querySelector('.dtc-slider__track');
        var prev = root.querySelector('.dtc-slider__btn--prev');
        var next = root.querySelector('.dtc-slider__btn--next');
        var thumb = root.querySelector('.dtc-slider__thumb');
        if (!track) { return; }

        function step() {
            var slide = track.firstElementChild;
            return slide ? slide.getBoundingClientRect().width : track.clientWidth;
        }

        function atEnd() {
            return track.scrollLeft >= track.scrollWidth - track.clientWidth - 2;
        }

        function go(direction) {
            if (direction > 0 && atEnd()) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
                return;
            }
            track.scrollBy({ left: direction * step(), behavior: 'smooth' });
        }

        function updateButtons() {
            if (prev) { prev.disabled = track.scrollLeft <= 2; }
            if (thumb) {
                var ratio = Math.min(1, track.clientWidth / Math.max(1, track.scrollWidth));
                var room = Math.max(1, track.scrollWidth - track.clientWidth);
                thumb.style.width = (ratio * 100) + '%';
                thumb.style.left = ((1 - ratio) * (track.scrollLeft / room) * 100) + '%';
            }
        }

        // Mouse drag; touch already scrolls natively.
        var drag = null;
        var suppressClick = false;

        function nearestSlideLeft() {
            var inset = parseFloat(getComputedStyle(track).scrollPaddingLeft) || 0;
            var trackLeft = track.getBoundingClientRect().left + inset;
            var best = 0;
            var bestDistance = Infinity;
            Array.prototype.forEach.call(track.children, function (slide) {
                var left = slide.getBoundingClientRect().left - trackLeft + track.scrollLeft;
                var distance = Math.abs(left - track.scrollLeft);
                if (distance < bestDistance) { best = left; bestDistance = distance; }
            });
            return best;
        }

        function endDrag(event) {
            if (!drag) { return; }
            if (drag.active && track.hasPointerCapture(event.pointerId)) { track.releasePointerCapture(event.pointerId); }
            var moved = drag.active;
            drag = null;
            track.classList.remove('is-dragging');
            if (moved) {
                suppressClick = true;
                setTimeout(function () { suppressClick = false; }, 0);
                track.scrollTo({ left: nearestSlideLeft(), behavior: 'smooth' });
            }
        }

        track.addEventListener('pointerdown', function (event) {
            if (event.pointerType !== 'mouse' || event.button !== 0) { return; }
            drag = { x: event.clientX, left: track.scrollLeft, active: false };
        });
        track.addEventListener('pointermove', function (event) {
            if (!drag) { return; }
            var dx = event.clientX - drag.x;
            if (!drag.active) {
                if (Math.abs(dx) < 5) { return; }
                drag.active = true;
                track.classList.add('is-dragging');
                track.setPointerCapture(event.pointerId);
            }
            track.scrollLeft = drag.left - dx;
        });
        track.addEventListener('pointerup', endDrag);
        track.addEventListener('pointercancel', endDrag);
        track.addEventListener('click', function (event) {
            if (suppressClick) { event.preventDefault(); event.stopPropagation(); }
        }, true);
        track.addEventListener('dragstart', function (event) { event.preventDefault(); });

        if (prev) { prev.addEventListener('click', function () { go(-1); }); }
        if (next) { next.addEventListener('click', function () { go(1); }); }
        track.addEventListener('scroll', updateButtons, { passive: true });
        window.addEventListener('resize', updateButtons);
        updateButtons();

        var delay = parseInt(root.getAttribute('data-autoplay'), 10);
        var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (delay > 0 && !reduceMotion) {
            var paused = false;
            ['mouseenter', 'focusin', 'touchstart'].forEach(function (name) {
                root.addEventListener(name, function () { paused = true; }, { passive: true });
            });
            ['mouseleave', 'focusout'].forEach(function (name) {
                root.addEventListener(name, function () { paused = false; });
            });
            setInterval(function () { if (!paused && !document.hidden) { go(1); } }, delay);
        }
    });
})();
