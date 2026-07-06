// Auto-scroll to product section when a filter/search is active
document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);

    if (params.has('search') || params.has('problem') || params.has('type') || params.has('tone')) {
        const section = document.getElementById('productSection');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

// ── Toast notification ────────────────────────────────────────────────────────
(function injectToastStyles() {
    if (document.getElementById('wishlistToastStyles')) return;
    const style = document.createElement('style');
    style.id = 'wishlistToastStyles';
    style.textContent = `
        #wishlistToast {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(-14px);
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-width: 320px;
            max-width: 380px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            z-index: 9999;
            pointer-events: none;
        }
        #wishlistToast.wt-show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
            pointer-events: all;
        }
        .wt-top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 16px 12px;
        }
        .wt-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f5ece8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
        }
        .wt-text { flex: 1; }
        .wt-title {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        .wt-msg {
            margin: 0;
            font-size: 13px;
            color: #777;
            line-height: 1.45;
        }
        .wt-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #bbb;
            font-size: 18px;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
            transition: color 0.15s;
        }
        .wt-close:hover { color: #555; }
        .wt-footer {
            border-top: 1px solid #f0f0f0;
            display: flex;
        }
        .wt-btn {
            flex: 1;
            padding: 11px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: none;
            transition: background 0.15s;
        }
        .wt-btn:hover { background: #fafafa; }
        .wt-btn.wt-primary {
            color: #b87055;
            border-right: 1px solid #f0f0f0;
        }
        .wt-btn.wt-dismiss { color: #999; }
    `;
    document.head.appendChild(style);
})();

function showWishlistToast() {
    let toast = document.getElementById('wishlistToast');

    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'wishlistToast';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="wt-top">
                <div class="wt-avatar">&#9825;</div>
                <div class="wt-text">
                    <p class="wt-title">Save to wishlist</p>
                    <p class="wt-msg">You need to be logged in to favourite products.</p>
                </div>
                <button class="wt-close" id="wtClose" aria-label="Dismiss">&#x2715;</button>
            </div>
            <div class="wt-footer">
                <a href="login_signup.php" class="wt-btn wt-primary">Log in / Sign up</a>
                <button class="wt-btn wt-dismiss" id="wtDismiss">Maybe later</button>
            </div>
        `;
        document.body.appendChild(toast);

        document.getElementById('wtClose').addEventListener('click', hideWishlistToast);
        document.getElementById('wtDismiss').addEventListener('click', hideWishlistToast);
    }

    clearTimeout(toast._timer);
    toast.classList.add('wt-show');
    toast._timer = setTimeout(hideWishlistToast, 5000);
}

function hideWishlistToast() {
    const toast = document.getElementById('wishlistToast');
    if (toast) toast.classList.remove('wt-show');
}

// ── Wishlist Toggle ───────────────────────────────────────────────────────────
document.querySelectorAll('.wishlist-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var id = this.dataset.id;
        var el = this;

        fetch('wishlist_toggle.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + id
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.status === 'login') {
                showWishlistToast();
                return;
            }
            if (data.status === 'added') {
                el.innerHTML = '❤️';
            } else if (data.status === 'removed') {
                el.innerHTML = '🤍';
            }
        });
    });
});

// ── Product Slider ────────────────────────────────────────────────────────────
(function () {
    const ITEMS_PER_PAGE = 2;

    function perPage() {
        if (window.innerWidth <= 580)  return 1;
        if (window.innerWidth <= 1000) return 2;
        if (window.innerWidth <= 1200) return 3;
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
                dot.addEventListener('click', () => goTo(i));
                dotsEl.appendChild(dot);
            }
        }

        function updateDots() {
            dotsEl.querySelectorAll('.slider-dot')
                  .forEach((d, i) => d.classList.toggle('active', i === page));
        }

        function goTo(p) {
            const n = pages();
            page = Math.max(0, Math.min(p, n - 1));
            track.style.transform = `translateX(-${page * perPage() * cardWidth()}px)`;
            prevBtn.classList.toggle('disabled', page === 0);
            nextBtn.classList.toggle('disabled', page >= n - 1);
            updateDots();
        }

        prevBtn.addEventListener('click', () => goTo(page - 1));
        nextBtn.addEventListener('click', () => goTo(page + 1));

        // Touch / swipe
        let tx = 0;
        track.addEventListener('touchstart', e => { tx = e.touches[0].clientX; }, { passive: true });
        track.addEventListener('touchend',   e => {
            const dx = e.changedTouches[0].clientX - tx;
            if (Math.abs(dx) > 40) goTo(page + (dx < 0 ? 1 : -1));
        }, { passive: true });

        buildDots();
        goTo(0);

        window.addEventListener('resize', () => {
            buildDots();
            goTo(Math.min(page, pages() - 1));
        });
    }

    document.querySelectorAll('[data-slider]').forEach(initSlider);
})();