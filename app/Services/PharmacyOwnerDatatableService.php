<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;



class PharmacyOwnerDatatableService extends Controller
{
    public function handle($request, $data)
    {
         return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                 if (!empty($request->get('search_status_approved'))  && $request->get('search_status_approved') != null) {
                    $status = $request->get('search_status_approved');
                    $query->where('status_approved_for_pharmacy',  $status );

                }
                if ( !empty($request->get('search_status_user')) && $request->get('search_status_user') != null) {
                      $status = $request->get('search_status_user');
                        $query->where('status', $status );

                }
                if (!empty($request->get('filter_column_type_status')) && $request->get('filter_column_type_status') != -1) {
                    $status = $request->get('filter_column_type_status');
                    $query->where('status', $status);
                }
                if (!empty($request->get('search_pharmacy_owner'))) {
                    $pharmacy = $request->get('search_pharmacy_owner');
                    $query->where(function ($query) use ($pharmacy) {
                        $query->where('name', 'like', '%' . $pharmacy . '%');
                        $query->orWhere('email', 'like', '%' . $pharmacy . '%');
                        $query->orWhere('phone', 'like', '%' . $pharmacy . '%');
                    });
                }
            })
            ->addColumn('action', function ($data)
            {
                $status = ($data->status == 'blocked')? 'ازالة الحظر'  :  'حظر';
                return '
                      <!--begin::Action=-->
                            <a  class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"> الاجرائات
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-5 m-0">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
														</svg>
													</span>
                                <!--end::Svg Icon--></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->

                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a   data-id="' . $data->id . '" class="deleteRecord  show_confirm menu-link px-3"  data-kt-location-pharmacy-table-filter="delete_row">حذف</a>
                                </div>
                                <!--end::Menu item-->
                                   <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a   data-id="' . $data->id . '"  data-status="' . $data->status . '"  class="blockRecord  show_confirm_block menu-link px-3"  data-kt-location-pharmacy-table-filter="block_row">'.$status.'</a>
                                </div>
                                <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="' . url("admin/employee-management?filter_employee=" . $data->id) . '"  class="employeeRecord  show_confirm_block menu-link px-3"  data-kt-location-pharmacy-table-filter="block_row">عرض موظفينه</a>
                                </div>
                                <!--end::Menu item-->
                            </div>

                  ';

            })

            ->addColumn('status', function ($data) {
                $statusStyle = '' ;
                if($data->status == 'active')
                {
                    $statusStyle = '<div class="badge badge-light-success">Active</div>';
                }else
                {
                    $statusStyle = '<div class="badge badge-light-danger">Blocked</div>';

                }
                return   $statusStyle ;
            })
            ->addColumn('created_at', function ($data) {
                if ($data->created_at) {
                    return $data->created_at->format('d M Y, g:i a');
                }

                return ' ';

            })
            ->addColumn('status_approved_for_pharmacy', function ($data) {
                $current = $data->status_approved_for_pharmacy ;

                $badgeClass = match($current) {
                    'approved' => 'badge-light-success',
                    'pending' => 'badge-light-warning',
                    'reject' => 'badge-light-danger',
                    default => 'badge-light-secondary',
                };

                $displayText = match($current) {
                    'approved' => 'معتمد',
                    'pending' => 'قيد الانتظار',
                    'reject' => 'مرفوض',
                };

                return <<<HTML
                <div class="dropdown">
                    <div class="badge {$badgeClass} dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer;">
                        {$displayText}
                    </div>
                    <div class="dropdown-menu">
                        <a class="dropdown-item change-status" data-id="{$data->id}" data-status="approved">معتمد</a>
                        <a class="dropdown-item change-status" data-id="{$data->id}" data-status="pending">قيد الانتظار</a>
                        <a class="dropdown-item change-status" data-id="{$data->id}" data-status="reject">مرفوض</a>
                    </div>
                </div>
                HTML;

            })
            ->addColumn('email', function ($data)
            {
                return '
                           <div class="d-flex flex-column">
                                   <a href="' . url("admin/pharmacy-owner-management/view?id=" .$data->id ) . '" class="text-gray-800 text-hover-primary mb-1">'.$data->email.'</a>

                             </div>' ;
            })


            ->addColumn('checkbox', function ($data) {
                return '
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input select-row" type="checkbox" name="ids[]" value="' . $data->id . '" id="checkbox_' . $data->id . '" />
                        <label for="checkbox_' . $data->id . '"></label>
                    </div>';
            })
            ->rawColumns(['action' ,  'email','status_approved_for_pharmacy',  'status' , 'checkbox'  ,'employees', 'created_at'])
            ->make(true);

    }


}
