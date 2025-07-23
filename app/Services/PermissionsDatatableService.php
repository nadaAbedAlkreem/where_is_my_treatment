<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;


class PermissionsDatatableService extends Controller
{
    public function handle( $request,$data )
    {
          return DataTables::of($data)
            ->addIndexColumn()

            ->filter(function ($query) use ($request) {
                if (!empty($request->get('search_permission')) ) {
                    $permission = $request->get('search_permission');
                     $query->where('name', 'like', '%' . $permission . '%');
                }
            })
              ->addColumn('assigned_to', function ($data) {

                   $html = '' ;
                  foreach ($data->roles as  $value)
                  {
                      switch ($value->name) {
                          case 'admin':
                              $html .= ' <a class="badge badge-light-primary fs-7 m-1">Administrator</a>';
                              break;
                          case 'pharmacy_owner' :
                              $html .= ' <a class="badge badge-light-warning fs-7 m-1">Pharmacy owner</a>';
                              break;

                          case 'employee' :
                              $html .= ' <a class="badge badge-light-danger fs-7 m-1">employee</a>';
                              break;

                      }
                   }

                  return $html;

              })
              ->addColumn('created_at', function ($data) {
                  if ($data->created_at) {
                      return $data->created_at->format('d M Y, g:i a');
                  }

                  return ' ';

              })
              ->rawColumns(['created_at' , 'assigned_to'])
              ->make(true);

    }




}
