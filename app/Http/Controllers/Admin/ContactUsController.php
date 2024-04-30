<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Contact Us';

        if ($request->ajax()) {
            return Datatables::of(ContactUs::all())
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'contactus';
                    $row['section_title'] = 'Contact Us';
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.contactus.index', $data);
    }
}
