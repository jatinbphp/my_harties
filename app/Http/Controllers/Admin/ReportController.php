<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function listing_expiring(Request $request)
    {
        $data['menu'] = "Listings Expiring";

        if ($request->ajax()) {
            $data = Listing::select()->whereDate('expiry_date', '>=', Carbon::today())->whereDate('expiry_date', '<=', Carbon::today()->addDays(90));

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return !empty($row['Category']) ? $row['Category']['name'] : '';
                })
                ->addColumn('sub_category', function ($row) {
                    return !empty($row['SubCategory']) ? $row['SubCategory']['name'] : '';
                })
                ->editColumn('section', function ($row) {
                    return ucwords(str_replace("_", " ", $row['section']));
                })
                ->editColumn('is_featured', function ($row) {
                    return ucwords($row['is_featured']);
                })
                ->editColumn('has_special', function ($row) {
                    return ucwords($row['has_special']);
                })
                ->editColumn('status', function($row){
                    return ucwords(str_replace("_", " ", $row['status']));
                })
                ->make(true);
        }

        return view('admin.reports.listing_expiring', $data);
    }

    public function all_users(Request $request)
    {
        $data['menu'] = "All Users";

        if ($request->ajax()) {
            $data = User::where('id', '!=', Auth::user()->id)->select();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function($row){
                    return ucwords(str_replace("_", " ", $row['status']));
                })
                ->make(true);
        }

        return view('admin.reports.all_users', $data);
    }
}
