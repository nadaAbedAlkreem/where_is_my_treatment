<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;



class TreatmentDatatableService extends Controller
{
    public function handle($request, $data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                 if (!empty($request->get('search_treatment') && $request->get('search_treatment')!= null)) {
                    $treatment = $request->get('search_treatment');
                     $query->where('name', 'like', '%' . $treatment . '%');

                 }
                if ($request->filled('filter_treatment_approved')) {
                    $approved = $request->get('filter_treatment_approved');
                    $query->where('status_approved',$approved );


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
                $user = auth()->user();

                if ($user->can('delete medicine' )) {
                    return '
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input select-row" type="checkbox" name="ids[]" value="' . $data->id . '" id="checkbox_' . $data->id . '" />
                        <label for="checkbox_' . $data->id . '"></label>
                    </div>';
                }

                 return '';
            })

            ->addColumn('created_at', function ($data) {
                if ($data->created_at) {
                    return $data->created_at->format('d M Y, g:i a');
                }

                return ' ';

            })
            ->addColumn('status', function ($data) {
                $current = $data->status_approved;

                $badgeClass = match ($current) {
                    'approved' => 'badge-light-success',
                    'pending' => 'badge-light-warning',
                    'not_approved' => 'badge-light-danger',
                    default => 'badge-light-secondary',
                };

                $displayText = match ($current) {
                    'approved' => 'معتمد',
                    'pending' => 'قيد الانتظار',
                    'not_approved' => 'مرفوض',
                    default => 'غير معروف',
                };

                $user = auth()->user();

                 if ($user && $user->hasRole('admin')) {
                    return <<<HTML
        <div class="dropdown">
            <div class="badge {$badgeClass} dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer;">
                {$displayText}
            </div>
            <div class="dropdown-menu">
                <a class="dropdown-item change-status" data-id="{$data->id}" data-status="approved">معتمد</a>
                <a class="dropdown-item change-status" data-id="{$data->id}" data-status="pending">قيد الانتظار</a>
                <a class="dropdown-item change-status" data-id="{$data->id}" data-status="not_approved">مرفوض</a>
            </div>
        </div>
        HTML;
                }

                 return <<<HTML
    <span class="badge {$badgeClass}">{$displayText}</span>
    HTML;
            })




            ->addColumn('action', function ($data) {
                $user = auth()->user();

                $actions = '
        <!--begin::Action-->
        <a class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">الاجراءات
            <span class="svg-icon svg-icon-5 m-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                </svg>
            </span>
        </a>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
    ';

                if ($user->can('edit medicine', $data)) {
                    $actions .= '
            <div class="menu-item px-3">
                <a data-bs-toggle="modal" data-bs-target="#kt_modal_update_treatment"
                   data-id="'.$data->id.'"
                   data-how_to_use="'.$data->how_to_use.'"
                   data-instructions="'.$data->instructions.'"
                   data-side_effects="'.$data->side_effects.'"
                   data-image="'.$data->image.'"
                   data-category_id="'.$data->category_id.'"
                   data-name="'.$data->name.'"
                   data-description="'.$data->description.'"
                   data-about_the_medicine="'.$data->about_the_medicine.'"
                   class="menu-link px-3 updateRe">تعديل</a>
            </div>';
                }

                if ($user->can('delete medicine', $data)) {
                    $actions .= '
            <div class="menu-item px-3">
                <a data-id="' . $data->id . '" class="deleteRecord show_confirm menu-link px-3" data-kt-location-pharmacy-table-filter="delete_row">حذف</a>
            </div>';
                }

                $actions .= '</div>'; // Close menu
                return $actions;
            })
            ->addColumn('category', function ($data)
            {
                return '<div class="badge badge-light fw-bolder">'.$data->category->name.'</div>' ;
            })

            ->rawColumns(['action' ,'category','created_at'  ,'name' , 'status' ,'checkbox'])
            ->make(true);

    }


}
