// ── Image Gallery ──
function changeImg(thumb, src) {
    if (!src) return;
    const mainImg = document.getElementById('mainImg');
    mainImg.style.opacity = '0';
    setTimeout(() => {
        mainImg.src = src;
        mainImg.style.opacity = '1';
    }, 150);
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}

// ── Image Zoom Effect ──
function initZoom() {
    const imgWrap = document.getElementById('mainImgWrap');
    const mainImg = document.getElementById('mainImg');
    if (!imgWrap || !mainImg) return;

    const lens = document.createElement('div');
    lens.className = 'zoom-lens';
    imgWrap.appendChild(lens);

    imgWrap.addEventListener('mousemove', function(e) {
        const rect = imgWrap.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        lens.style.left = x + 'px';
        lens.style.top = y + 'px';

        const scale = 2;
        const percentX = (x / rect.width) * 100;
        const percentY = (y / rect.height) * 100;

        mainImg.style.transform = `scale(${scale})`;
        mainImg.style.transformOrigin = `${percentX}% ${percentY}%`;
    });

    imgWrap.addEventListener('mouseleave', function() {
        mainImg.style.transform = 'scale(1)';
        mainImg.style.transformOrigin = 'center center';
    });
}

// ── Quantity Control ──
function changeQty(delta) {
    const input = document.getElementById('qtyInput');
    if (!input) return;

    let val = parseInt(input.value) + delta;
    const min = parseInt(input.min) || 1;
    const max = parseInt(input.max) || 99;

    if (val < min) val = min;
    if (val > max) val = max;

    input.value = val;

    // Update sticky bar quantity if exists
    const stickyQty = document.getElementById('stickyQty');
    if (stickyQty) stickyQty.value = val;
}

// ── Tabs ──
function openTab(id, btn) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

    const target = document.getElementById('tab-' + id);
    if (target) target.classList.add('active');

    if (btn) {
        btn.classList.add('active');
    } else {
        document.querySelectorAll('.tab-btn').forEach(b => {
            if (b.getAttribute('onclick')?.includes("'" + id + "'")) {
                b.classList.add('active');
            }
        });
    }

    sessionStorage.setItem('activeProductTab', id);
}

// ── Restore last active tab ──
function restoreTab() {
    const lastTab = sessionStorage.getItem('activeProductTab');
    if (lastTab) openTab(lastTab, null);
}

// ── Wishlist Toggle ──
function initWishlist() {
    const btn = document.getElementById('wishlistBtn');
    if (!btn) return;

    btn.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const icon = this.querySelector('i');
        const isActive = this.classList.toggle('active');

        if (icon) {
            icon.classList.toggle('far', !isActive);
            icon.classList.toggle('fas', isActive);
        }

        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(r => r.json())
        .then(data => {
            showToast(data.message || (isActive ? 'تمت الإضافة للمفضلة' : 'تمت الإزالة من المفضلة'), 'success');
        })
        .catch(() => {
            // Revert on error
            this.classList.toggle('active');
            if (icon) {
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
            }
            showToast('حدث خطأ، حاول مرة أخرى', 'error');
        });
    });
}

// ── Sticky Bar ──
function initStickyBar() {
    const stickyBar = document.getElementById('stickyBar');
    if (!stickyBar) return;

    const addToCartBtn = document.getElementById('mainAddToCart');
    if (!addToCartBtn) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            stickyBar.style.transform = entry.isIntersecting
                ? 'translateY(100%)'
                : 'translateY(0)';
        });
    }, { threshold: 0.1 });

    observer.observe(addToCartBtn);
}

// ── Copy Link ──
function copyLink() {
    const btn = document.getElementById('copyBtn');
    if (!btn) return;

    navigator.clipboard.writeText(window.location.href).then(() => {
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.style.color = 'var(--green)';
        btn.style.borderColor = 'var(--green)';

        showToast('تم نسخ الرابط', 'success');

        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-link"></i>';
            btn.style.color = '';
            btn.style.borderColor = '';
        }, 2000);
    }).catch(() => {
        showToast('لم يتم النسخ', 'error');
    });
}

// ── Add to Cart ──
function addToCart(e, productId) {
    e.preventDefault();
    const btn = e.currentTarget;
    const qty = document.getElementById('qtyInput')?.value || 1;
    const originalContent = btn.innerHTML;

    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جارٍ الإضافة...';
    btn.style.opacity = '0.7';
    btn.style.pointerEvents = 'none';

    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(r => {
        if (!r.ok) throw new Error('Network error');
        return r.json();
    })
    .then(data => {
        btn.innerHTML = '<i class="fas fa-check"></i> تمت الإضافة!';
        btn.style.opacity = '1';
        btn.style.background = 'linear-gradient(135deg, var(--green), #059669)';
        btn.style.color = '#fff';
        btn.style.pointerEvents = 'none';

        updateCartBadge(data.count || data.cart_count || 1);
        showToast(data.message || 'تمت إضافة المنتج للسلة', 'success');

        setTimeout(() => {
            btn.innerHTML = originalContent;
            btn.style.background = '';
            btn.style.color = '';
            btn.style.opacity = '1';
            btn.style.pointerEvents = '';
        }, 2500);
    })
    .catch(err => {
        console.error('Cart error:', err);
        btn.innerHTML = originalContent;
        btn.style.opacity = '1';
        btn.style.pointerEvents = '';

        showToast('حدث خطأ، جاري التحويل...', 'warning');

        setTimeout(() => {
            window.location.href = `/cart/add/${productId}?qty=${qty}`;
        }, 1000);
    });
}

// ── Update Cart Badge ──
function updateCartBadge(count) {
    const badge = document.getElementById('cartBadge');
    if (!badge) return;

    badge.textContent = count;
    badge.style.animation = 'none';
    badge.offsetHeight; // Trigger reflow
    badge.style.animation = 'pulse-badge 0.5s ease';

    const cartBtn = document.getElementById('cartBtn');
    if (cartBtn) {
        cartBtn.style.animation = 'bounce-cart 0.5s ease';
        setTimeout(() => cartBtn.style.animation = '', 500);
    }
}

// ── Get Cart Count on Page Load ──
function initCartCount() {
    fetch('/cart/count')
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                const badge = document.getElementById('cartBadge');
                if (badge) badge.textContent = data.count;
            }
        })
        .catch(() => {});
}

// ── Recently Viewed Products ──
function saveToRecentlyViewed(product) {
    let recent = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    recent = recent.filter(p => p.id !== product.id);
    recent.unshift(product);
    recent = recent.slice(0, 10);
    localStorage.setItem('recentlyViewed', JSON.stringify(recent));
}

function renderRecentlyViewed() {
    const container = document.getElementById('recentlyViewed');
    if (!container) return;

    const recent = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    if (recent.length === 0) {
        container.style.display = 'none';
        return;
    }

    const grid = container.querySelector('.recent-grid');
    if (!grid) return;

    grid.innerHTML = recent.map(p => `
        <a href="/product/${p.slug}" class="recent-item">
            <img src="${p.image || 'https://placehold.co/140x100/141c2e/64748b?text=منتج'}"
                 alt="${p.title}"
                 onerror="this.src='https://placehold.co/140x100/141c2e/64748b?text=منتج'">
            <div class="recent-info">
                <div class="recent-title">${p.title}</div>
                <div class="recent-price">${p.price} جنيه</div>
            </div>
        </a>
    `).join('');
}

// ── Toast Notification ──
function showToast(message, type = 'info') {
    const existing = document.querySelector('.pd-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = `pd-toast toast-${type}`;

    const icons = {
        success: 'check-circle',
        error: 'times-circle',
        info: 'info-circle',
        warning: 'exclamation-triangle'
    };

    const colors = {
        success: '#10b981',
        error: '#ef4444',
        info: '#00d4ff',
        warning: '#f59e0b'
    };

    toast.innerHTML = `
        <i class="fas fa-${icons[type] || 'info-circle'}" style="color: ${colors[type] || colors.info}"></i>
        <span>${message}</span>
    `;

    toast.style.cssText = `
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-100px);
        background: #0e1420;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: .75rem;
        color: #e2e8f0;
        font-weight: 600;
        font-size: .9rem;
        z-index: 10000;
        box-shadow: 0 10px 40px rgba(0,0,0,.4);
        transition: transform .4s cubic-bezier(.4,0,.2,1);
        font-family: 'Cairo', sans-serif;
    `;

    document.body.appendChild(toast);

    requestAnimationFrame(() => {
        toast.style.transform = 'translateX(-50%) translateY(0)';
    });

    setTimeout(() => {
        toast.style.transform = 'translateX(-50%) translateY(-100px)';
        setTimeout(() => toast.remove(), 400);
    }, 3000);
}

// ── Initialize Everything ──
document.addEventListener('DOMContentLoaded', function() {
    initZoom();
    initWishlist();
    initStickyBar();
    initCartCount();
    restoreTab();
    renderRecentlyViewed();

    const productData = document.getElementById('productData');
    if (productData) {
        saveToRecentlyViewed({
            id: productData.dataset.id,
            slug: productData.dataset.slug,
            title: productData.dataset.title,
            price: productData.dataset.price,
            image: productData.dataset.image
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const toast = document.querySelector('.pd-toast');
            if (toast) toast.remove();
        }
    });
});
