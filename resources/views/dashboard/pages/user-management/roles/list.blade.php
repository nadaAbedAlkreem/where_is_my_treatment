@extends('dashboard.layout.app')

@section('content')


    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-fluid" id="kt_content_container">
            <!--begin::Row-->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                @if(!empty($roles))
                    @foreach($roles as $value)
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <!--begin::Card-->
                            <div class="card card-flush h-md-100">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>{{$value->name}}</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->

                                @if($value->name == 'admin')
                                    <!--begin::Card body-->
                                    <div class="card-body pt-1">
                                        <!--begin::Users--><!--begin::Permissions-->
                                        <div class="d-flex flex-column text-gray-600">
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>All Admin Controls</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Financial Summaries</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Payouts</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div>
                                            <div class='d-flex align-items-center py-2'>
                                                <span class='bullet bg-primary me-3'></span>
                                                <em>and 7 more...</em>
                                            </div>
                                        </div>
                                        <!--end::Permissions-->
                                    </div>
                                    <!--end::Card body-->
                                @endif


                                @if($value->name == 'pharmacy_owner')
                                    <!--begin::Card body-->
                                    <div class="card-body pt-1">
                                        <!--begin::Users-->
                                                                         <!--begin::Permissions-->
                                        <div class="d-flex flex-column text-gray-600">
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>All Admin Controls</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Financial Summaries</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Payouts</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div>
                                            <div class='d-flex align-items-center py-2'>
                                                <span class='bullet bg-primary me-3'></span>
                                                <em>and 7 more...</em>
                                            </div>
                                        </div>
                                        <!--end::Permissions-->
                                    </div>
                                    <!--end::Card body-->
                                @endif

                                @if($value->name == 'employee')
                                    <!--begin::Card body-->
                                    <div class="card-body pt-1">
                                        <!--begin::Users-->
                                                                   <!--begin::Permissions-->
                                        <div class="d-flex flex-column text-gray-600">
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>All Admin Controls</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Financial Summaries</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Payouts</div>
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div>
                                            <div class='d-flex align-items-center py-2'>
                                                <span class='bullet bg-primary me-3'></span>
                                                <em>and 7 more...</em>
                                            </div>
                                        </div>
                                        <!--end::Permissions-->
                                    </div>
                                    <!--end::Card body-->
                                @endif
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                    @endforeach

                @endif
            </div>
            <!--end::Row-->
            <!--begin::Modals-->

            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->

@endsection
