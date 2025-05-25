<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CategoryDatatableService   extends Controller
{
    public function handle($request, $data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {

                if (!empty($request->get('search_category'))) {
                    $category = $request->get('search_category');

                    $query->where(function ($query) use ($category) {
                        $query->where('name', 'like', '%' . $category . '%');
                        $query->orWhere('description', 'like', '%' . $category . '%');
                    });
                }
            })
            ->addColumn('checkbox', function ($data) {
                $user = auth()->user();

                if ($user->can('delete', $data)) {
                    return '
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input select-row" type="checkbox" name="ids[]" value="' . $data->id . '" id="checkbox_' . $data->id . '" />
                            <label for="checkbox_' . $data->id . '"></label>
                        </div>';
                }

                 return '';
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

            ->addColumn('action', function ($data) {
                $user = auth()->user();
                $actions = '
        <a class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            الاجرائات
            <span class="svg-icon svg-icon-5 m-0">
                <!-- SVG Icon -->
            </span>
        </a>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
    ';

                // تعديل
                if ($user->can('update', $data)) {
                    $actions .= '
            <div class="menu-item px-3">
                <a data-bs-toggle="modal" data-bs-target="#kt_modal_update_category"
                   data-id="' . $data->id . '"
                   data-name="' . $data->name . '"
                   data-image="' . $data->image . '"
                   data-description="' . $data->description . '"
                   class="menu-link px-3 updateRe">تعديل</a>
            </div>';
                }

                // حذف
                if ($user->can('delete', $data)) {
                    $actions .= '
            <div class="menu-item px-3">
                <a data-id="' . $data->id . '"
                   class="deleteRecord show_confirm menu-link px-3"
                   data-kt-location-pharmacy-table-filter="delete_row">حذف</a>
            </div>';
                }

                $actions .= '</div>';

                return $actions;
            })
            ->addColumn('description', function ($data) {
                return '<div style="white-space: pre-wrap;">' . nl2br(e($data->description)) . '</div>';
            })

            ->addColumn('created_at', function ($data) {
                if ($data->created_at) {
                    return $data->created_at->format('d M Y, g:i a');
                }

                return ' ';

            })
            ->rawColumns(['action',  'description', 'name', 'checkbox', 'created_at'])
            ->make(true);

    }


}
