<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use DataTables;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = "Listings";
        $data['search'] = $request['search'];

        if ($request->ajax()) {
            $data = Listing::select();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return !empty($row['Category']) ? $row['Category']['name'] : '';
                })
                ->addColumn('sub_category', function ($row) {
                    return !empty($row['SubCategory']) ? $row['SubCategory']['name'] : '';
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'listings';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'listings';
                    $row['section_title'] = 'Listings';
                    return view('admin.common.action-buttons', $row);
                })
                ->rawColumns(['category','action'])
                ->make(true);
        }

        return view('admin.listings.index', $data);
    }

    public function create()
    {
        $data['menu'] = "Listings";
        $data['category'] = Category::where('parent_id',0)->where('status','active')->orderBy('name')->pluck('name','id')->prepend('Please Select','');
        $data['sub_category'] = [];
        return view("admin.listings.create",$data);
    }

    public function store(ListingRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        if($photo = $request->file('image')){
            $input['image'] = $this->fileMove($photo,'listings');
        }
        Listing::create($input);

        \Session::flash('success', 'Listing has been inserted successfully!');
        return redirect()->route('listings.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['menu'] = "Listings";
        $data['listings'] = Listing::where('id',$id)->first();
        $data['category'] = Category::where('parent_id',0)->where('status','active')->orderBy('name')->pluck('name','id')->prepend('Please Select','');
        $data['sub_category'] = Category::where('parent_id',$data['listing']['category'])->where('status','active')->first();
        return view('admin.listings.edit',$data);
    }

    public function update(ListingRequest $request, Listing $listing)
    {
        $input = $request->all();
        if($photo = $request->file('image')){
            if (!empty($listing['image']) && file_exists($listing['image'])) {
                unlink($listing['image']);
            }
            $input['image'] = $this->fileMove($photo,'category');
        }
        $listing->update($input);

        \Session::flash('success','Listing has been updated successfully!');
        return redirect()->route('listings.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if(!empty($category)){
            $file_path=storage_path('app/public/'.$category->image);
            if (!empty($category['image']) && file_exists($category['image'])) {
                unlink($category['image']);
            }
            $category->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function assign(Request $request){
        $category = Category::findorFail($request['id']);
        $category['status'] = "active";
        $category->update($request->all());
    }

    public function unassign(Request $request){
        $category = Category::findorFail($request['id']);
        $category['status'] = "inactive";
        $category->update($request->all());
    }
}
