(function () {

    /* ── Animate price cards on load ── */
    document.querySelectorAll('.price-table tbody tr').forEach(function (row, i) {
        row.style.opacity   = '0';
        row.style.transform = 'translateY(10px)';
        row.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
        setTimeout(function () {
            row.style.opacity   = '1';
            row.style.transform = 'translateY(0)';
        }, 60 + i * 50);
    });

})();

/* ── Wishlist toggle ── */
function toggleWish(btn, productId) {
    btn.classList.toggle('saved');
    btn.textContent = btn.classList.contains('saved') ? '♥' : '♡';

    fetch('compare_price_entry.php?product_id=' + productId + '&wish=' + productId, {
        method: 'GET'
    }).catch(function () {});
}

/* ── Copy link to clipboard ── */
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function () {
        var btn  = document.querySelector('.sb-share');
        var orig = btn.innerHTML;
        btn.innerHTML = '✓ Copied!';
        setTimeout(function () { btn.innerHTML = orig; }, 2000);
    });
}