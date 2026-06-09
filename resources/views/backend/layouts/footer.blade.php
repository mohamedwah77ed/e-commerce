{{-- Footer --}}
<footer class="footer bg-white border-top py-3 mt-auto">
    <div class="container-fluid">
        <div class="row align-items-center">
            
            {{-- Copyright --}}
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <p class="mb-0 text-muted small">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Your App') }}. 
                    جميع الحقوق محفوظة.
                </p>
            </div>
            
            {{-- Links --}}
            <div class="col-md-6 text-center text-md-end">
                <ul class="list-inline mb-0 small">
                    <li class="list-inline-item">
                        <a href=" target="_blank" class="text-muted text-decoration-none">
                            <i class="bi bi-box-arrow-up-right small"></i> زيارة الموقع
                        </a>
                    </li>
                    <li class="list-inline-item ms-3">
                        <a href="#" class="text-muted text-decoration-none">المساعدة</a>
                    </li>
                    <li class="list-inline-item ms-3">
                        <a href="#" class="text-muted text-decoration-none">سياسة الخصوصية</a>
                    </li>
                    <li class="list-inline-item ms-3">
                        <a href="#" class="text-muted text-decoration-none">الشروط والأحكام</a>
                    </li>
                </ul>
            </div>
            
        </div>
        
        {{-- System Info --}}
        <div class="row mt-2">
            <div class="col-12 text-center">
                <small class="text-muted" style="font-size: 0.7rem;">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} | 
                    PHP v{{ PHP_VERSION }} | 
                    الوقت: {{ now()->format('Y-m-d H:i:s') }}
                </small>
            </div>
        </div>
    </div>
</footer>