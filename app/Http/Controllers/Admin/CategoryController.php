<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use DataTables;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = "Category";
        $data['search'] = $request['search'];

        if ($request->ajax()) {
            $data = Category::where('parent_id',0)->select();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('section', function($row){
                    return str_replace('_',' ',ucwords($row['section']));
                })
                ->editColumn('is_featured', function ($row) {
                    return ucwords($row['is_featured']);
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'categories';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'category';
                    $row['section_title'] = 'Category';
                    return view('admin.common.action-buttons', $row);
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin.category.index', $data);
    }

    public function create()
    {
        $data['menu'] = "Category";
        return view("admin.category.create",$data);
    }

    public function store(CategoryRequest $request)
    {
        $input = $request->all();
        $input['level'] = 1;

        if($photo = $request->file('image')){
            $input['image'] = $this->fileMove($photo,'category');
        }

        Category::create($input);

        \Session::flash('success', 'Category has been inserted successfully!');
        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        $data['menu'] = "Category";
        $data['category'] = Category::where('id',$id)->first();
        return view('admin.category.edit',$data);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $input = $request->all();

        if($photo = $request->file('image')){
            if (!empty($category['image']) && file_exists($category['image'])) {
                unlink($category['image']);
            }
            $input['image'] = $this->fileMove($photo,'category');
        }

        $category->update($input);

        \Session::flash('success','Category has been updated successfully!');
        return redirect()->route('category.index');
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

    public function getSubCategory(Request $request){
        return $category = Category::where('id',$request['category'])->where('status','active')->first();
        $data['option'] = [];
        if(!empty($category)){
            $subCategory = Category::where('parent_id',$request['category'])->where('status','active')->get();
            if(count($subCategory) > 0){
                $data['option'] = $subCategory;
            }
        }
        return $data;
    }
}
