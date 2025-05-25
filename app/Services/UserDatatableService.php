<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;


class UserDatatableService extends Controller
{
    public function handle( $request,$data )
    {
          return DataTables::of($data)
            ->addIndexColumn()

            ->filter(function ($query) use ($request) {

            })

              ->rawColumns([ ])
              ->make(true);

    }




}
