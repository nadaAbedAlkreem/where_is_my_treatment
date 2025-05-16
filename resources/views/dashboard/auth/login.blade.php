@extends('dashboard.auth.layout')

@section('content_auth')
    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">تسجيل الدخول إلى اين دوائي </h1>
            <!--end::Title-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fs-6 fw-bolder text-dark">البريد الإلكتروني</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />
            <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mb-2">
                <!--begin::Label-->
                <label class="form-label fw-bolder text-dark fs-6 mb-0">كلمة المرور</label>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Input-->
            <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
            <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Submit button-->
            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                <span class="indicator-label">تسجيل الدخول</span>
                <span class="indicator-progress">يرجى الانتظار...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Submit button-->
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->

@endsection
