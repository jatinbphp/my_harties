<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use DataTables;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = "Sub Category";
        $data['search'] = $request['search'];

        if ($request->ajax()) {
            $data = Category::with('ParentCategory')->where('parent_id','!=',0)->where('level',2)->select();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return !empty($row['ParentCategory']) ? $row['ParentCategory']['name'] : '';
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'categories';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'sub_category';
                    $row['section_title'] = 'Sub Category';
                    return view('admin.common.action-buttons', $row);
                })

                ->rawColumns(['category','action'])
                ->make(true);
        }

        return view('admin.sub_category.index', $data);
    }

    public function create()
    {
        $data['menu'] = "Sub Category";
        $data['category'] = Category::where('parent_id',0)->where('status','active')->pluck('name','id')->prepend('Please Select','');
        return view("admin.sub_category.create",$data);
    }

    public function store(SubCategoryRequest $request)
    {
        $input = $request->all();
        $input['level'] = 2;
        $input['parent_id'] = $request['category'];
        Category::create($input);

        \Session::flash('success', 'Sub category has been inserted successfully!');
        return redirect()->route('sub_category.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['menu'] = "Sub Category";
        $data['sub_category'] = Category::where('id',$id)->first();
        $data['category'] = Category::where('parent_id',0)->where('status','active')->pluck('name','id')->prepend('Please Select','');
        return view('admin.sub_category.edit',$data);
    }

    public function update(SubCategoryRequest $request, Category $sub_category)
    {
        $input = $request->all();
        $input['parent_id'] = $request['category'];
        $sub_category->update($input);

        \Session::flash('success','Sub category has been updated successfully!');
        return redirect()->route('sub_category.index');
    }

    public function destroy($id)
    {
        $categorys = Category::findOrFail($id);
        if(!empty($categorys)){
            $categorys->delete();
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