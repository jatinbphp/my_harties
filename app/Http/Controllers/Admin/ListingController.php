<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use DataTables;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Gallery;
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
        $data['categories'] = Category::where('parent_id',0)->where('status','active')->orderBy('name')->pluck('name','id');
        $data['sub_categories'] = [];
        return view("admin.listings.create",$data);
    }

    public function store(ListingRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        if($photo = $request->file('main_image')){
            $input['main_image'] = $this->fileMove($photo,'listings');
        }
        $listing = Listing::create($input);

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'listings');
                Gallery::create([
                    'listing_id' => $listing->id,
                    'image' =>  $imageName,
                ]);
            }
        }

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
        $data['listing'] = Listing::with('listing_images')->where('id',$id)->first();
        $data['categories'] = Category::where('parent_id',0)->where('status','active')->orderBy('name')->pluck('name','id');
        $data['sub_categories'] = Category::where('parent_id',$data['listing']['category'])->where('status','active')->orderBy('name')->pluck('name','id');
        return view('admin.listings.edit',$data);
    }

    public function update(ListingRequest $request, Listing $listing)
    {
        $input = $request->all();
        if($photo = $request->file('main_image')){
            if (!empty($listing['main_image']) && file_exists($listing['main_image'])) {
                unlink($listing['main_image']);
            }
            $input['main_image'] = $this->fileMove($photo,'listings');
        }

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'listings');
                Gallery::create([
                    'listing_id' => $listing['id'],
                    'image' =>  $imageName,
                ]);
            }
        }

        $input['open_hours'] = isset($request->time) && !empty($request->time) ? json_encode($request->time) : [];
        $listing->update($input);

        \Session::flash('success','Listing has been updated successfully!');
        return redirect()->route('listings.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if(!empty($category)){
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

    public function removeImage(Request $request)
    {
        $image = Gallery::findOrFail($request['id']);
        if(!empty($image)){
            unlink($request['image']);
            $image->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function getSubCategories(Request $request){
        $categoryId = $request->input('categoryId');

        if(isset($categoryId) && (!empty($categoryId))){
            $sub_categories = Category::where('parent_id',$categoryId)->where('status','active')->orderBy('name')->get();
            return response()->json($sub_categories);
        }

    }
}
