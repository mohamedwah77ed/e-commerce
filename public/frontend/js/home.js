// ============================================
// SCROLL PROGRESS INDICATORS
// ============================================
function updateScrollProgress(track) {
    const section = track.closest('.nf-product-section');
    const thumb = section?.querySelector('.nf-scroll-progress-thumb');
    if (!thumb) return;

    const maxScroll = track.scrollWidth - track.clientWidth;
    if (maxScroll > 0) {
        const progress = (track.scrollLeft / maxScroll) * 100;
        thumb.style.width = `${Math.max(progress, 10)}%`;
        thumb.style.transform = `translateX(${track.scrollLeft}px)`;
    }
}

// Attach scroll listeners (مرة واحدة بس عند التحميل)
document.querySelectorAll('.nf-hero-categories__track, .nf-product-carousel, .nf-brands__track').forEach(track => {
    track.onscroll = () => updateScrollProgress(track);
});

// ============================================
// TOUCH/DRAG SCROLLING
// ============================================
document.querySelectorAll('.nf-product-carousel, .nf-hero-categories__track, .nf-brands__track').forEach(el => {
    let isDown = false;
    let startX;
    let scrollLeft;

    el.addEventListener('mousedown', (e) => {
        isDown = true;
        el.style.cursor = 'grabbing';
        startX = e.pageX - el.offsetLeft;
        scrollLeft = el.scrollLeft;
    });

    el.addEventListener('mouseleave', () => {
        isDown = false;
        el.style.cursor = 'grab';
    });

    el.addEventListener('mouseup', () => {
        isDown = false;
        el.style.cursor = 'grab';
    });

    el.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - el.offsetLeft;
        const walk = (x - startX) * 2;
        el.scrollLeft = scrollLeft - walk;
    });
});

// ============================================
// PRODUCT CAROUSEL INIT (بدون تراكم listeners)
// ============================================
function initProductCarousel(container) {
    const track = container.querySelector('.nf-product-track') || container;
    track.scrollLeft = 0;
    track.onscroll = () => updateScrollProgress(track); // onscroll مش بيتراكم
}

// ============================================
// BEST SELLERS TABS - AJAX
// ============================================
function switchTab(btn, categorySlug) {
    const section = btn.closest('.nf-product-section');
    const contentContainer = section.querySelector('.nf-product-carousel');
    const loader = section.querySelector('#bestSellersLoader');
    const progressThumb = section.querySelector('.nf-scroll-progress-thumb');

    // تحديث التاب النشط
    section.querySelectorAll('.nf-tab').forEach(tab => {
        tab.classList.remove('nf-tab--active');
        tab.setAttribute('aria-selected', 'false');
    });
    btn.classList.add('nf-tab--active');
    btn.setAttribute('aria-selected', 'true');

    // إظهار اللودر
    contentContainer.classList.add('d-none');
    if (loader) loader.classList.remove('d-none');

    // إعادة ضبط progress bar
    if (progressThumb) {
        progressThumb.style.width = '0%';
        progressThumb.style.transform = 'translateX(0)';
    }

    fetch(`/ajax/products-by-category?category=${encodeURIComponent(categorySlug)}&limit=10`)
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                contentContainer.innerHTML = data.html;
                initProductCarousel(contentContainer);
            } else {
                contentContainer.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                        <p>حدث خطأ أثناء تحميل المنتجات</p>
                    </div>`;
            }
        })
        .catch(() => {
            contentContainer.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-wifi-slash fa-2x mb-3"></i>
                    <p>تعذر الاتصال بالخادم</p>
                </div>`;
        })
        .finally(() => {
            if (loader) loader.classList.add('d-none');
            contentContainer.classList.remove('d-none');
        });
}

// ============================================
// APPLE TABS - AJAX
// ============================================
function switchAppleTab(btn, subCategory) {
    const section = btn.closest('.nf-product-section');
    const contentContainer = document.getElementById('appleContent');

    section.querySelectorAll('.nf-tab').forEach(tab => tab.classList.remove('nf-tab--active'));
    btn.classList.add('nf-tab--active');

    fetch(`/ajax/products-by-category?category=${encodeURIComponent(subCategory)}&brand=apple&limit=10`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                contentContainer.innerHTML = data.html;
                initProductCarousel(contentContainer);
            }
        })
        .catch(err => console.error(err));
}

// ============================================
// LAPTOP TABS - AJAX
// ============================================
function switchLaptopTab(btn, type) {
    const section = btn.closest('.nf-product-section');
    const contentContainer = document.getElementById('laptopContent');

    section.querySelectorAll('.nf-tab').forEach(tab => tab.classList.remove('nf-tab--active'));
    btn.classList.add('nf-tab--active');

    const slugMap = { new: 'laptops', gaming: 'gaming', work: 'laptops', tablets: 'tablets' };
    const slug = slugMap[type] || type;

    fetch(`/ajax/products-by-category?category=${encodeURIComponent(slug)}&limit=10`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                contentContainer.innerHTML = data.html;
                initProductCarousel(contentContainer);
            }
        })
        .catch(err => console.error(err));
}

// ============================================
// HERO CAROUSEL
// ============================================
let currentHeroSlide = 0;
const heroSlides = document.querySelectorAll('.dp-hero-slide');
const heroDots = document.querySelectorAll('.dp-dot');

function goToHeroSlide(index) {
    heroSlides.forEach((slide, i) => slide.classList.toggle('active', i === index));
    heroDots.forEach((dot, i) => dot.classList.toggle('active', i === index));
    currentHeroSlide = index;
}

// Auto-play (مرة واحدة بس)
if (heroSlides.length > 1) {
    setInterval(() => {
        goToHeroSlide((currentHeroSlide + 1) % heroSlides.length);
    }, 5000);
}

// ============================================
// CATEGORY SCROLL PROGRESS
// ============================================
const catTrack = document.querySelector('.nf-hero-categories__track');
const catProgress = document.getElementById('catProgress');

if (catTrack && catProgress) {
    catTrack.addEventListener('scroll', () => {
        const maxScroll = catTrack.scrollWidth - catTrack.clientWidth;
        const progress = maxScroll > 0 ? (catTrack.scrollLeft / maxScroll) * 100 : 0;
        catProgress.style.width = `${Math.max(progress, 10)}%`;
    }, { passive: true });
}

// ============================================
// MORPH OFFERS ANIMATION
// ============================================
function initMorphContainers() {
    document.querySelectorAll('.nf-morph-container').forEach(container => {
        const items = JSON.parse(container.dataset.morphItems || '[]');
        if (items.length === 0) return;

        let currentIndex = 0;
        updateMorphItem(container, items[0]);

        setInterval(() => {
            currentIndex = (currentIndex + 1) % items.length;
            updateMorphItem(container, items[currentIndex]);
        }, 3000);
    });
}

function updateMorphItem(container, item) {
    const iconWrap = container.querySelector('.nf-morph-icon-wrap img');
    const textSpan = container.querySelector('.nf-morph-text');

    container.style.opacity = '0';
    container.style.transform = 'translateY(4px)';
    container.style.transition = 'all 0.2s ease';

    setTimeout(() => {
        if (iconWrap) { iconWrap.src = item.icon; iconWrap.alt = item.text; }
        if (textSpan) textSpan.textContent = item.text;
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
    }, 200);
}

// ============================================
// ADD TO CART
// ============================================
function addToCart(productId, qty = 1) {
    const btn = event.target.closest('.nf-btn-add-cart') || event.target;
    const originalContent = btn.innerHTML;

    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btn.style.opacity = '0.7';
    btn.style.pointerEvents = 'none';

    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ qty })
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = '<i class="fas fa-check"></i> ' + (data.message || 'تمت الإضافة');
        btn.style.background = 'var(--green)';
        btn.style.color = '#fff';

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
    .catch(() => {
        btn.innerHTML = originalContent;
        btn.style.opacity = '1';
        btn.style.pointerEvents = '';
        showToast('حدث خطأ، جاري التحويل...', 'warning');
        setTimeout(() => { window.location.href = `/cart/add/${productId}?qty=${qty}`; }, 1000);
    });
}

// ============================================
// CART BADGE
// ============================================
function updateCartBadge(count) {
    const badge = document.getElementById('cartBadge');
    if (!badge) return;

    badge.textContent = count;
    badge.style.animation = 'none';
    badge.offsetHeight;
    badge.style.animation = 'pulse-badge 0.5s ease';

    const cartBtn = document.getElementById('cartBtn');
    if (cartBtn) {
        cartBtn.style.animation = 'bounce-cart 0.5s ease';
        setTimeout(() => { cartBtn.style.animation = ''; }, 500);
    }
}

function showToast(msg, type = 'success') {
    if (window.toast) window.toast.show(msg, type);
}

// ============================================
// INIT
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    initMorphContainers();

    // Cart count
    fetch('/cart/count')
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                const badge = document.getElementById('cartBadge');
                if (badge) badge.textContent = data.count;
            }
        })
        .catch(() => {});
});
