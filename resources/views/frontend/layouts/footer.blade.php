<style>
  /* ══════════ FOOTER STYLES (RTL & LTR Compatible) ══════════ */
.site-footer {
    background: #080c14;
    border-top: 1px solid rgba(255,255,255,.07);
    color: #64748b;
    margin-top: auto;
    padding-top: 3rem;
    position: relative;
    overflow: hidden;
}
.site-footer::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0,212,255,.3), transparent);
}

.site-footer h6 {
    color: #e2e8f0;
    font-weight: 800;
    font-size: .95rem;
    margin-bottom: 1rem;
    padding-bottom: .5rem;
    border-bottom: 2px solid transparent;
    border-image: linear-gradient(90deg, #00d4ff, #7c3aed) 1;
    display: inline-block;
}

.site-footer p,
.site-footer address {
    font-size: .87rem;
    line-height: 2;
    color: #64748b;
}

.footer-links { list-style: none; padding: 0; margin: 0; }
.footer-links li { margin-bottom: .4rem; }
.footer-links a {
    color: #64748b;
    text-decoration: none;
    font-size: .87rem;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
}
.footer-links a:hover {
    color: #00d4ff;
}
[dir="rtl"] .footer-links a:hover { padding-right: 4px; }
[dir="ltr"] .footer-links a:hover { padding-left: 4px; }

.footer-links a i {
    font-size: .65rem;
    color: #00d4ff;
    transition: transform .2s;
}
[dir="rtl"] .footer-links a:hover i { transform: translateX(-3px); }
[dir="ltr"] .footer-links a:hover i { transform: translateX(3px); }

.social-row { display: flex; gap: .6rem; margin-top: .75rem; }
.social-row a {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #141c2e;
    border: 1px solid rgba(255,255,255,.07);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    text-decoration: none;
    transition: all .25s;
    font-size: .9rem;
}
.social-row a:hover {
    background: rgba(0,212,255,.1);
    border-color: rgba(0,212,255,.2);
    color: #00d4ff;
    transform: translateY(-2px);
}

.payment-icons { display: flex; gap: .5rem; flex-wrap: wrap; margin-top: .75rem; }
.payment-icons span {
    background: #141c2e;
    color: #94a3b8;
    font-size: .72rem;
    font-weight: 700;
    padding: .3rem .7rem;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,.07);
    transition: all .2s;
}
.payment-icons span:hover {
    border-color: rgba(0,212,255,.2);
    color: #00d4ff;
}

.footer-bottom {
    border-top: 1px solid rgba(255,255,255,.05);
    padding: 1.2rem 0;
    margin-top: 2rem;
    font-size: .8rem;
    color: #475569;
    text-align: center;
}
.footer-bottom a {
    color: #64748b;
    text-decoration: none;
    transition: color .2s;
}
.footer-bottom a:hover { color: #00d4ff; }

/* Contact icons colors */
.site-footer .fa-map-marker-alt { color: #ef4444; }
.site-footer .fa-phone { color: #10b981; }
.site-footer .fa-envelope { color: #f59e0b; }
.site-footer .fa-clock { color: #00d4ff; }
.site-footer .fa-lock { color: #10b981; }
</style>

<footer class="site-footer">
    <div class="container">
        <div class="row g-4">

            {{-- ▸ About --}}
            <div class="col-lg-4 col-md-6">
                <h6>{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</h6>
                <p style="font-size: .87rem; line-height: 2; color: #64748b;">
                    {{ app()->getLocale() == 'ar'
                        ? 'متجر إلكتروني متخصص في توفير أفضل المنتجات بأسعار منافسة، مع ضمان الجودة وسرعة التوصيل لجميع أنحاء مصر.'
                        : 'An online store specialized in providing the best products at competitive prices, with quality assurance and fast delivery across Egypt.' }}
                </p>
                <div class="social-row">
                    <a href="{{ $settings['facebook'] ?? '#' }}" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $settings['instagram'] ?? '#' }}" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $settings['whatsapp'] ?? '#' }}" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="{{ $settings['tiktok'] ?? '#' }}" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="{{ $settings['youtube'] ?? '#' }}" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            {{-- ▸ Quick Links --}}
            <div class="col-lg-2 col-md-6 col-sm-6">
                <h6>{{ app()->getLocale() == 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h6>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                    <li><a href="{{ url('/products') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'المنتجات' : 'Products' }}</a></li>
                    <li><a href="{{ url('/categories') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'الفئات' : 'Categories' }}</a></li>
                    <li><a href="{{ url('/offers') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'العروض' : 'Offers' }}</a></li>
                    <li><a href="{{ url('/about') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</a></li>
                    <li><a href="{{ url('/contact') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'تواصل معنا' : 'Contact Us' }}</a></li>
                </ul>
            </div>

            {{-- ▸ Customer Service --}}
            <div class="col-lg-2 col-md-6 col-sm-6">
                <h6>{{ app()->getLocale() == 'ar' ? 'خدمة العملاء' : 'Customer Service' }}</h6>
                <ul class="footer-links">
                    <li><a href="{{ url('/faq') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة' : 'FAQ' }}</a></li>
                    <li><a href="{{ url('/shipping') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'سياسة الشحن' : 'Shipping Policy' }}</a></li>
                    <li><a href="{{ url('/returns') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'الإرجاع والاستبدال' : 'Returns & Exchange' }}</a></li>
                    <li><a href="{{ url('/privacy') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a></li>
                    <li><a href="{{ url('/terms') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>{{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}</a></li>
                </ul>
            </div>

            {{-- ▸ Contact + Payment --}}
            <div class="col-lg-4 col-md-6">
                <h6>{{ app()->getLocale() == 'ar' ? 'تواصل معنا' : 'Contact Us' }}</h6>
                <address style="font-style:normal;">
                    <div><i class="fas fa-map-marker-alt me-2"></i>{{ app()->getLocale() == 'ar' ? 'القاهرة، جمهورية مصر العربية' : 'Cairo, Arab Republic of Egypt' }}</div>
                    <div>
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:{{ $settings['phone'] ?? '01000000000' }}" style="color:#94a3b8;text-decoration:none;">{{ $settings['phone'] ?? '01000000000' }}</a>
                    </div>
                    <div>
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:{{ $settings['email'] ?? 'info@store.com' }}" style="color:#94a3b8;text-decoration:none;">{{ $settings['email'] ?? 'info@store.com' }}</a>
                    </div>
                    <div><i class="fas fa-clock me-2"></i>{{ app()->getLocale() == 'ar' ? 'السبت – الخميس: 9ص – 9م' : 'Sat – Thu: 9AM – 9PM' }}</div>
                </address>

                <div class="mt-3">
                    <small style="color:#64748b; display:block; margin-bottom:.4rem;">
                        <i class="fas fa-lock me-1"></i> {{ app()->getLocale() == 'ar' ? 'وسائل الدفع الآمنة' : 'Secure Payment Methods' }}
                    </small>
                    <div class="payment-icons">
                        <span>VISA</span>
                        <span>MasterCard</span>
                        <span>Fawry</span>
                        <span>{{ app()->getLocale() == 'ar' ? 'كاش' : 'Cash' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>© {{ date('Y') }} {{ app()->getLocale() == 'ar' ? 'متجرنا الإلكتروني' : 'Our Online Store' }} — {{ app()->getLocale() == 'ar' ? 'جميع الحقوق محفوظة' : 'All Rights Reserved' }}</span>
            <span>
                <a href="{{ url('/privacy') }}">{{ app()->getLocale() == 'ar' ? 'الخصوصية' : 'Privacy' }}</a>
                &nbsp;·&nbsp;
                <a href="{{ url('/terms') }}">{{ app()->getLocale() == 'ar' ? 'الشروط' : 'Terms' }}</a>
            </span>
        </div>
    </div>
</footer>
