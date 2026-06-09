@extends('backend.layouts.master')

@section('title', 'الإعدادات العامة')

@section('breadcrumb')
    <li class="breadcrumb-item active">الإعدادات العامة</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-gear-wide-connected text-primary me-2"></i>الإعدادات العامة
                </h4>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>يوجد أخطاء في البيانات:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Settings Form --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold">تعديل إعدادات الموقع</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Site Info Section --}}
                        <h6 class="text-primary fw-bold mb-3 pb-2 border-bottom">
                            <i class="bi bi-info-circle me-1"></i> معلومات الموقع
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">اسم الموقع <span class="text-danger">*</span></label>
                                <input type="text" name="site_name"
                                       class="form-control @error('site_name') is-invalid @enderror"
                                       value="{{ old('site_name', $settings['site_name'] ?? config('app.name')) }}"
                                       placeholder="أدخل اسم الموقع">
                                @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">البريد الإلكتروني للموقع</label>
                                <input type="email" name="site_email"
                                       class="form-control @error('site_email') is-invalid @enderror"
                                       value="{{ old('site_email', $settings['site_email'] ?? '') }}"
                                       placeholder="email@example.com">
                                @error('site_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">وصف الموقع</label>
                            <textarea name="site_description" rows="3"
                                      class="form-control @error('site_description') is-invalid @enderror"
                                      placeholder="أدخل وصف مختصر للموقع">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                            @error('site_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">الكلمات المفتاحية (SEO)</label>
                            <input type="text" name="site_keywords"
                                   class="form-control @error('site_keywords') is-invalid @enderror"
                                   value="{{ old('site_keywords', $settings['site_keywords'] ?? '') }}"
                                   placeholder="كلمة1, كلمة2, كلمة3">
                            <div class="form-text text-muted small">افصل بين الكلمات بفاصلة (,)</div>
                            @error('site_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Contact Info Section --}}
                        <h6 class="text-primary fw-bold mb-3 mt-4 pb-2 border-bottom">
                            <i class="bi bi-telephone me-1"></i> بيانات التواصل
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">رقم الهاتف</label>
                                <input type="text" name="site_phone"
                                       class="form-control @error('site_phone') is-invalid @enderror"
                                       value="{{ old('site_phone', $settings['site_phone'] ?? '') }}"
                                       placeholder="+20 1XX XXX XXXX">
                                @error('site_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">العنوان</label>
                                <input type="text" name="site_address"
                                       class="form-control @error('site_address') is-invalid @enderror"
                                       value="{{ old('site_address', $settings['site_address'] ?? '') }}"
                                       placeholder="أدخل عنوان الشركة">
                                @error('site_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Social Media Section --}}
                        <h6 class="text-primary fw-bold mb-3 mt-4 pb-2 border-bottom">
                            <i class="bi bi-share me-1"></i> وسائل التواصل الاجتماعي
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">
                                    <i class="bi bi-facebook text-primary me-1"></i> فيسبوك
                                </label>
                                <input type="url" name="facebook_url"
                                       class="form-control @error('facebook_url') is-invalid @enderror"
                                       value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                                       placeholder="https://facebook.com/...">
                                @error('facebook_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">
                                    <i class="bi bi-twitter-x text-dark me-1"></i> تويتر / X
                                </label>
                                <input type="url" name="twitter_url"
                                       class="form-control @error('twitter_url') is-invalid @enderror"
                                       value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}"
                                       placeholder="https://twitter.com/...">
                                @error('twitter_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">
                                    <i class="bi bi-instagram text-danger me-1"></i> إنستجرام
                                </label>
                                <input type="url" name="instagram_url"
                                       class="form-control @error('instagram_url') is-invalid @enderror"
                                       value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                                       placeholder="https://instagram.com/...">
                                @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">
                                    <i class="bi bi-whatsapp text-success me-1"></i> واتساب
                                </label>
                                <input type="url" name="whatsapp_number"
                                       class="form-control @error('whatsapp_number') is-invalid @enderror"
                                       value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}"
                                       placeholder="https://wa.me/...">
                                @error('whatsapp_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Site Options Section --}}
                        <h6 class="text-primary fw-bold mb-3 mt-4 pb-2 border-bottom">
                            <i class="bi bi-sliders me-1"></i> خيارات الموقع
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">العملة الافتراضية</label>
                                <select name="default_currency" class="form-select @error('default_currency') is-invalid @enderror">
                                    <option value="EGP" @selected(old('default_currency', $settings['default_currency'] ?? 'EGP') == 'EGP')>جنيه مصري (EGP)</option>
                                    <option value="USD" @selected(old('default_currency', $settings['default_currency'] ?? '') == 'USD')>دولار أمريكي (USD)</option>
                                    <option value="SAR" @selected(old('default_currency', $settings['default_currency'] ?? '') == 'SAR')>ريال سعودي (SAR)</option>
                                    <option value="AED" @selected(old('default_currency', $settings['default_currency'] ?? '') == 'AED')>درهم إماراتي (AED)</option>
                                </select>
                                @error('default_currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">حالة الموقع</label>
                                <select name="site_status" class="form-select @error('site_status') is-invalid @enderror">
                                    <option value="active" @selected(old('site_status', $settings['site_status'] ?? 'active') == 'active')>🟢 مفتوح</option>
                                    <option value="maintenance" @selected(old('site_status', $settings['site_status'] ?? '') == 'maintenance')>🔧 صيانة</option>
                                    <option value="closed" @selected(old('site_status', $settings['site_status'] ?? '') == 'closed')>🔴 مغلق</option>
                                </select>
                                @error('site_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">رسالة صيانة الموقع</label>
                            <textarea name="maintenance_message" rows="2"
                                      class="form-control @error('maintenance_message') is-invalid @enderror"
                                      placeholder="الموقع تحت الصيانة، سنعود قريباً...">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
                            @error('maintenance_message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Logo Section --}}
                        <h6 class="text-primary fw-bold mb-3 mt-4 pb-2 border-bottom">
                            <i class="bi bi-image me-1"></i> شعار الموقع
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">شعار الموقع (Logo)</label>
                                <input type="file" name="site_logo"
                                       class="form-control @error('site_logo') is-invalid @enderror"
                                       accept="image/*">
                                <div class="form-text text-muted small">الأبعاد المقترحة: 200×60 بكسل</div>
                                @error('site_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                @if(isset($settings['site_logo']) && $settings['site_logo'])
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                             alt="Site Logo"
                                             style="max-height: 60px;"
                                             class="img-thumbnail">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">أيقونة الموقع (Favicon)</label>
                                <input type="file" name="site_favicon"
                                       class="form-control @error('site_favicon') is-invalid @enderror"
                                       accept="image/*">
                                <div class="form-text text-muted small">الأبعاد المقترحة: 32×32 بكسل</div>
                                @error('site_favicon') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $settings['site_favicon']) }}"
                                             alt="Favicon"
                                             style="max-height: 32px;"
                                             class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                        </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
