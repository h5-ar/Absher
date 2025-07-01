@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title', translate('تفاصيل الإشعار'))

@section('styles')
<style>
    :root {
        --primary-teal: #65B1AB;
        --light-teal: #E0F2F1;
        --dark-teal: #4A8F8A;
        --text-dark: #2D3748;
        --text-light: #F8F9FA;
    }

    .card-notification {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header-teal {
        background: linear-gradient(135deg, var(--primary-teal) 0%, var(--dark-teal) 100%);
        color: white;
        padding: 1.5rem;
        border-bottom: none;
    }

    .card-body-teal {
        background-color: #F9FAFB;
        padding: 2.5rem;
    }

    .content-card {
        border-left: 4px solid var(--primary-teal);
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        background: white;
    }

    .content-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(101, 177, 171, 0.15);
    }

    .content-card-header {
        background-color: var(--light-teal);
        color: var(--primary-teal);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(101, 177, 171, 0.2);
        font-weight: 600;
    }

    .content-card-body {
        padding: 1.5rem;
    }

    .company-info-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .company-info-item:last-child {
        border-bottom: none;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background-color: var(--light-teal);
        color: var(--primary-teal);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 1rem;
        font-size: 1.1rem;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.85rem;
        color: #6B7280;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.05rem;
    }

    .btn-teal {
        background-color: var(--primary-teal);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-teal:hover {
        background-color: var(--dark-teal);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(101, 177, 171, 0.4);
    }

    .btn-outline-teal {
        border: 2px solid var(--primary-teal);
        color: var(--primary-teal);
        background: transparent;
        font-weight: 600;
    }

    .btn-outline-teal:hover {
        background-color: var(--light-teal);
    }
</style>
@endsection

@section('content')
<x-Content.normal>
    <div class="card card-notification">
        <!-- Card Header -->
        <div class="card-header card-header-teal">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 font-weight-bold" style="font-size: 1.5rem;">
                    <i class="fas fa-bell mr-2"></i> {{ translate('تفاصيل الإشعار') }}
                </h3>
                <span class="badge bg-white text-teal" style="font-size: 1rem;">
                    {{ $notification->created_at->format('Y-m-d') }}
                </span>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body card-body-teal">
            <div class="row">
                <!-- معلومات الشركة - النسخة المحسنة -->
                <div class="col-lg-6 mb-4">
                    <div class="content-card h-100">
                        <div class="content-card-header d-flex align-items-center">
                            <i class="fas fa-building mr-2"></i>
                            <h4 class="mb-0">{{ translate('معلومات الشركة') }}</h4>
                        </div>
                        <div class="content-card-body">
                            <!-- اسم الشركة -->
                            <div class="company-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-signature"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('اسم الشركة') }}</div>
                                    <div class="info-value">
                                        {{ $notification->data['company']['name'] ?? translate('غير متوفر') }}
                                    </div>
                                </div>
                            </div>

                            <!-- هاتف الشركة -->
                            <div class="company-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('هاتف الشركة') }}</div>
                                    <div class="info-value">
                                        {{ $notification->data['company']['phone'] ?? translate('غير متوفر') }}
                                    </div>
                                </div>
                            </div>

                            <!-- بريد الشركة -->
                            <div class="company-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('البريد الإلكتروني') }}</div>
                                    <div class="info-value">
                                        {{ $notification->data['company']['email'] ?? translate('غير متوفر') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- معلومات المستخدم - النسخة المحسنة -->
                <div class="col-lg-6 mb-4">
                    <div class="content-card h-100">
                        <div class="content-card-header d-flex align-items-center">
                            <i class="fas fa-user-tie mr-2"></i>
                            <h4 class="mb-0">{{ translate('معلومات المستخدم') }}</h4>
                        </div>
                        <div class="content-card-body">
                            <!-- الاسم الكامل -->
                            <div class="company-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('الاسم الكامل') }}</div>
                                    <div class="info-value">
                                        {{ $notification->data['user']['first_name'] ?? '' }}
                                        {{ $notification->data['user']['last_name'] ?? '' }}
                                    </div>
                                </div>
                            </div>

                            <!-- البريد الإلكتروني -->
                            <div class="company-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-at"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('البريد الإلكتروني') }}</div>
                                    <div class="info-value">
                                        {{ $notification->data['user']['email'] ?? '' }}
                                    </div>
                                </div>
                            </div>

                            <!-- اسم المستخدم -->
                            <div class="company-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('اسم المستخدم') }}</div>
                                    <div class="info-value">
                                        {{ $notification->data['user']['username'] ?? '' }}
                                    </div>
                                </div>
                            </div>

                            <!-- الهاتف (إذا كان متوفرا في البيانات) -->
                            @isset($notification->data['user']['phone'])
                            <div class="company-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('الهاتف') }}</div>
                                    <div class="info-value">
                                        {{ $notification->data['user']['phone'] }}
                                    </div>
                                </div>
                            </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            <!-- تفاصيل الإشعار - النسخة المحسنة -->
            <div class="content-card">
                <div class="content-card-header d-flex align-items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <h4 class="mb-0">{{ translate('تفاصيل الإشعار') }}</h4>
                </div>
                <div class="content-card-body">
                    <div class="row">
                        <!-- سبب الإشعار -->
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="company-info-item" style="border-bottom: none; padding: 0;">
                                <div class="info-icon">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('سبب الإشعار') }}</div>
                                    <div class="info-value" style="font-size: 1.1rem;">
                                        {{ $notification->data['reason'] ?? translate('لا يوجد سبب محدد') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- وقت الإنشاء -->
                        <div class="col-md-6">
                            <div class="company-info-item" style="border-bottom: none; padding: 0;">
                                <div class="info-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('وقت الإنشاء') }}</div>
                                    <div class="info-value" style="font-size: 1.1rem;">
                                        {{ $notification->created_at->format('Y-m-d H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="company-info-item" style="border-bottom: none; padding: 0;">
                                <div class="info-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">{{ translate('وقت القراءه') }}</div>
                                    <div class="info-value" style="font-size: 1.1rem;">
                                        {{ $notification->read_at}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- أزرار التحكم -->
        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <a href="{{ route('super_admin.dashboard') }}" class="btn btn-outline-teal" style="padding: 0.75rem 2rem;">
                <i class="fas fa-arrow-right ml-2"></i> {{ translate('العودة ') }}
            </a>
        </div>
    </div>
    </div>
</x-Content.normal>
@endsection