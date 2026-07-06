(function () {

    /* ── State ── */
    const selected = {}; // keyed by product_id
    window._shoppingSelected = selected;
    let panelCollapsed = false;
    let panelHidden    = false;

    /* ── DOM refs ── */
    const panel       = document.getElementById('checklist-panel');
    const panelBody   = document.getElementById('panel-body');
    const itemsList   = document.getElementById('checklist-items');
    const totalVal    = document.getElementById('panel-total-val');
    const countText   = document.getElementById('panel-count-text');
    const tbaNote     = document.getElementById('panel-tba-note');
    const fab         = document.getElementById('checklist-fab');
    const fabCount    = document.getElementById('checklist-fab-count');
    const collapseBtn = document.getElementById('panel-collapse-btn');
    const toast       = document.getElementById('cl-toast');

    /* ── Toggle a product card ── */
    window.toggleProduct = function (card) {
        const id    = card.dataset.productId;
        const brand = card.dataset.brand;
        const name  = card.dataset.name;
        const price = card.dataset.price !== '' ? parseFloat(card.dataset.price) : null;
        const img   = card.dataset.img;
        const store = card.dataset.store || '';

        if (selected[id]) {
            delete selected[id];
            showToast('Removed from list');
        } else {
            selected[id] = { id, brand, name, price, img, store };
            showToast('Added to list \u2713');
        }

        // Sync ALL cards with this product_id (appears in multiple sections)
        document.querySelectorAll('.product-card[data-product-id="' + id + '"]').forEach(function (c) {
            c.classList.toggle('is-selected', !!selected[id]);
        });

        render();
    };

    /* ── Render panel ── */
    function render() {
        const items = Object.values(selected);
        const count = items.length;

        countText.textContent = count + (count === 1 ? ' item selected' : ' items selected');
        fabCount.textContent  = count;

        if (count > 0 && !panelHidden) {
            panel.classList.add('is-visible');
            fab.classList.remove('is-visible');
        } else if (count > 0 && panelHidden) {
            fab.classList.add('is-visible');
            panel.classList.remove('is-visible');
        } else {
            panel.classList.remove('is-visible');
            fab.classList.remove('is-visible');
            panelHidden = false;
        }

        itemsList.innerHTML = '';
        let total  = 0;
        let hasTba = false;

        items.forEach(function (item) {
            const el = document.createElement('div');
            el.className = 'checklist-item';

            let priceHtml;
            if (item.price !== null) {
                total += item.price;
                priceHtml = '<span class="checklist-item-price">RM ' + item.price.toFixed(2) + '</span>';
            } else {
                hasTba = true;
                priceHtml = '<span class="checklist-item-price no-price">Price TBA</span>';
            }

            el.innerHTML =
                '<img class="checklist-item-img" src="' + esc(item.img) + '" alt="" onerror="this.style.display=\'none\'">' +
                '<div class="checklist-item-info">' +
                    '<div class="checklist-item-brand">' + esc(item.brand) + '</div>' +
                    '<div class="checklist-item-name">'  + esc(item.name)  + '</div>' +
                '</div>' +
                priceHtml +
                '<button class="checklist-remove-btn" title="Remove" onclick="removeItem(\'' + item.id + '\')">' +
                    '<svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M2 2l9 9M11 2L2 11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>' +
                '</button>';
            itemsList.appendChild(el);
        });

        totalVal.textContent  = total.toFixed(2);
        tbaNote.style.display = hasTba ? 'block' : 'none';
    }

    /* ── Remove single item ── */
    window.removeItem = function (id) {
        delete selected[id];
        document.querySelectorAll('.product-card[data-product-id="' + id + '"]').forEach(function (c) {
            c.classList.remove('is-selected');
        });
        render();
    };

    /* ── Clear all ── */
    window.clearAll = function () {
        Object.keys(selected).forEach(function (id) { delete selected[id]; });
        document.querySelectorAll('.product-card.is-selected').forEach(function (c) {
            c.classList.remove('is-selected');
        });
        render();
    };

    /* ── Collapse / expand panel ── */
    window.togglePanelCollapse = function () {
        panelCollapsed = !panelCollapsed;
        panelBody.classList.toggle('is-collapsed', panelCollapsed);
        collapseBtn.style.transform = panelCollapsed ? 'rotate(180deg)' : '';
    };

    /* ── FAB: restore panel ── */
    window.showPanel = function () {
        panelHidden = false;
        render();
    };

    /* ── Open receipt modal ── */
    window.openReceipt = function () {
        const items = Object.values(selected);
        if (!items.length) return;

        const backdrop = document.getElementById('receipt-backdrop');
        const list     = document.getElementById('receipt-items-list');
        const rTotal   = document.getElementById('receipt-total-val');
        const rFooter  = document.getElementById('receipt-footer-note');

        document.getElementById('receipt-date').textContent =
            new Date().toLocaleDateString('en-MY', { day: 'numeric', month: 'long', year: 'numeric' });

        list.innerHTML = '';
        let total  = 0;
        let hasTba = false;

        items.forEach(function (item, i) {
            const row = document.createElement('div');
            row.className = 'receipt-row';

            let priceHtml;
            if (item.price !== null) {
                total += item.price;
                priceHtml = '<span class="receipt-row-price">RM ' + item.price.toFixed(2) + '</span>';
            } else {
                hasTba = true;
                priceHtml = '<span class="receipt-row-price tba">Check in-store</span>';
            }

            row.innerHTML =
                '<span class="receipt-row-num">' + (i + 1) + '</span>' +
                '<div class="receipt-row-info">' +
                    '<div class="receipt-row-brand">' + esc(item.brand) + '</div>' +
                    '<div class="receipt-row-name">'  + esc(item.name)  + '</div>' +
                    (item.store ? '<div class="receipt-row-store">from ' + esc(item.store) + '</div>' : '') +
                '</div>' +
                priceHtml;
            list.appendChild(row);
        });

        rTotal.textContent = 'RM ' + total.toFixed(2);
        rFooter.textContent = hasTba
            ? '* Some prices are unavailable — please verify in-store. Prices shown are for reference only.'
            : 'Prices are for reference only and may vary at the physical store.';

        backdrop.classList.add('is-open');
    };

    window.closeReceipt = function () {
        document.getElementById('receipt-backdrop').classList.remove('is-open');
    };

    window.closeReceiptOutside = function (e) {
        if (e.target === document.getElementById('receipt-backdrop')) closeReceipt();
    };

    /* ── Toast ── */
    let toastTimer;
    function showToast(msg) {
        toast.textContent = msg;
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { toast.classList.remove('show'); }, 1800);
    }

    /* ── Escape HTML ── */
    function esc(str) {
        return (str || '').replace(/[&<>"']/g, function (m) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m];
        });
    }

})();

/* ── Save to DB then Print ── */
window.saveAndPrint = function () {
    const items = Object.values(window._shoppingSelected || {});

    if (!items.length) {
        window.print();
        return;
    }

    const btn = document.querySelector('.receipt-print-btn');
    btn.disabled    = true;
    btn.textContent = 'Saving...';

    const formData = new FormData();
    formData.append('action', 'save_list');
    formData.append('items', JSON.stringify(items));

    fetch(window.location.href, { method: 'POST', body: formData })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            btn.disabled = false;
            btn.innerHTML = printBtnHTML();
            if (res.success) {
                window.print();
            } else {
                alert('Could not save list: ' + (res.message || 'Unknown error'));
            }
        })
        .catch(function () {
            btn.disabled = false;
            btn.innerHTML = printBtnHTML();
            window.print(); // still allow print even if save fails
        });
};

// ── Product Slider (shared with all_product) ──────────────────────────────────
(function () {
    const ITEMS_PER_PAGE = 2;

    function perPage() {
        if (window.innerWidth <= 580)  return 1;
        if (window.innerWidth <= 1000) return 2;
        return ITEMS_PER_PAGE;
    }

    function initSlider(wrapper) {
        const track   = wrapper.querySelector('.product-grid');
        const prevBtn = wrapper.querySelector('.prev-btn');
        const nextBtn = wrapper.querySelector('.next-btn');
        const dotsEl  = wrapper.querySelector('.slider-dots');
        const cards   = Array.from(track.children);
        const total   = cards.length;

        if (total === 0) return;

        let page = 0;

        function pages() {
            return Math.ceil(total / perPage());
        }

        function cardWidth() {
            const gap = 18;
            return cards[0].getBoundingClientRect().width + gap;
        }

        function buildDots() {
            dotsEl.innerHTML = '';
            const n = pages();
            if (n <= 1) { dotsEl.style.display = 'none'; return; }
            dotsEl.style.display = 'flex';
            for (let i = 0; i < n; i++) {
                const dot = document.createElement('span');
                dot.className = 'slider-dot' + (i === page ? ' active' : '');
                dot.addEventListener('click', function () { goTo(i); });
                dotsEl.appendChild(dot);
            }
        }

        function updateDots() {
            dotsEl.querySelectorAll('.slider-dot')
                  .forEach(function (d, i) { d.classList.toggle('active', i === page); });
        }

        function goTo(p) {
            const n = pages();
            page = Math.max(0, Math.min(p, n - 1));
            track.style.transform = 'translateX(-' + (page * perPage() * cardWidth()) + 'px)';
            prevBtn.classList.toggle('disabled', page === 0);
            nextBtn.classList.toggle('disabled', page >= n - 1);
            updateDots();
        }

        prevBtn.addEventListener('click', function () { goTo(page - 1); });
        nextBtn.addEventListener('click', function () { goTo(page + 1); });

        // Touch / swipe
        let tx = 0;
        track.addEventListener('touchstart', function (e) { tx = e.touches[0].clientX; }, { passive: true });
        track.addEventListener('touchend',   function (e) {
            const dx = e.changedTouches[0].clientX - tx;
            if (Math.abs(dx) > 40) goTo(page + (dx < 0 ? 1 : -1));
        }, { passive: true });

        buildDots();
        goTo(0);

        window.addEventListener('resize', function () {
            buildDots();
            goTo(Math.min(page, pages() - 1));
        });
    }

    document.querySelectorAll('[data-slider]').forEach(initSlider);
})();

function printBtnHTML() {
    return '<svg width="14" height="14" viewBox="0 0 14 14" fill="none">' +
           '<rect x="1" y="4" width="12" height="8" rx="1.5" stroke="white" stroke-width="1.4"/>' +
           '<path d="M4 4V2h6v2" stroke="white" stroke-width="1.4" stroke-linecap="round"/>' +
           '<rect x="3.5" y="7" width="7" height="3.5" rx="0.5" fill="white"/>' +
           '</svg> Print / Save';
}

