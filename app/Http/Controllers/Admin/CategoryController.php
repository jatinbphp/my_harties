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
        Category::create($input);

        \Session::flash('success', 'Category has been inserted successfully!');
        return redirect()->route('category.index');
    }

    public function show($id)
    {
        //
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
        $category->update($input);

        \Session::flash('success','Category has been updated successfully!');
        return redirect()->route('category.index');
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
