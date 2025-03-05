<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\ContactUs;

class ListYourBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'List Your Business';

        if ($request->ajax()) {
            return Datatables::of(ContactUs::where('type', 1)->orderBy('id','DESC'))
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })    
                ->addColumn('action', function($row){
                    $row['section_name'] = 'list-your-business';
                    $row['section_title'] = 'List Your Business';
                    return view('admin.common.action-buttons', $row);
                })            
                ->make(true);
        }

        return view('admin.list-your-business.index', $data);
    }

    public function destroy($id)
    {
        $listing = ContactUs::findOrFail($id);
        if(!empty($listing)){
            $listing->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
