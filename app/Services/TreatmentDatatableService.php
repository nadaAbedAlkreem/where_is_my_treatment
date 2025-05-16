<?php

namespace App\Services;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\DataTables;
use App\Models\Admin;
use Illuminate\Support\Str;


class TreatmentDatatableService extends Controller
{
    public function handle($request, $data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
//                if (!empty($request->get('filter_column_type_user')) && $request->get('filter_column_type_user') != -1) {
//                    $role = $request->get('filter_column_type_user');
//                    $query->whereHas('roles', function ($roleQuery) use ($role) {
//                        $roleQuery->where('id', $role);
//                    });
//                }
                if (!empty($request->get('search_treatment'))) {
                    $treatment = $request->get('search_treatment');
                    $query->where(function ($query) use ($treatment) {
                        $query->where('name', 'like', '%' . $treatment . '%');

                    });
                }
            })
            ->addColumn('name', function ($data) {
                $imageUrl = asset($data['image']);

                return '
                                           	<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
 															<a >
																<div class="symbol-label">
																	<img src="'.$imageUrl.'" alt="Emma Smith" class="w-100" />
																</div>
															</a>
														</div>
														<!--end::Avatar-->
														<!--begin::User details-->
														<div class="d-flex flex-column">
															<a  class="text-gray-800 text-hover-primary mb-1">'.$data->name.'</a>
 														</div>';
            })
            ->addColumn('checkbox', function ($data) {
                return '
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input select-row" type="checkbox" name="ids[]" value="' . $data->id . '" id="checkbox_' . $data->id . '" />
                        <label for="checkbox_' . $data->id . '"></label>
                    </div>';
            })
            ->addColumn('created_at', function ($data) {
                if ($data->created_at) {
                    return $data->created_at->format('d M Y, g:i a');
                }

                return ' ';

            })
            ->addColumn('status', function ($data) {
                $current = $data->status_approved ;

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



            ->addColumn('action', function ($data)
            {
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
                                <div class="menu-item px-3">
                                    <a data-bs-toggle="modal" data-bs-target="#kt_modal_update_employee" data-id="'.$data->id.'"  class="menu-link px-3 updateRe">تعديل</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a   data-id="' . $data->id . '" class="deleteRecord  show_confirm menu-link px-3"  data-kt-categories-table-filter="delete_row">حذف</a>
                                </div>
                                <!--end::Menu item-->
                                   <!--begin::Menu item-->
                                <!--end::Menu item-->
                            </div>

                  ';

            })

            ->rawColumns(['action' ,'created_at'  ,'name' , 'status' ,'checkbox'])
            ->make(true);

    }


}
